<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Type;
use App\Range;
use App\Prize;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ApiController;

class PrizeController extends Controller
{
 
    private $user;
    private $cash;
    private $product;
    private $banking;
    
    private $checkTime;
    
    function __construct(UserController $user, CashController $cash, ProductController $product, ApiController $banking)
    {
        $this->middleware('auth',['prizeGeneration']);
        
        $this->user = $user;        
        $this->cash = $cash;        
        $this->product = $product;
        
        $this->banking = $banking;
        
        $this->checkTime = 3; //minutes
    }
        
    public function prizeGeneration()
    {
	if(Auth::user()->role == 'admin')         
            return response()->json('Admin can not get a prize!', 422);
        
        $isAvalible = $this->checkTime();
        if($isAvalible)
            return response()->json('New Prize avalible after '. $isAvalible .' !', 422);
            
        $avalibleTypes = $this->getAvaliblePrizesTypes();
        
        if(empty($avalibleTypes))         
            return response()->json('Sorry, but there are no prizes available!', 422);
        
        $typeKey = rand(0, count($avalibleTypes)-1);
        
        $response['type'] = $avalibleTypes[$typeKey]->type;
        
        switch ($response['type']){
            case 'point':
                $response['prize'] = $this->generatePointPrize($avalibleTypes[$typeKey]);
                break;
            case 'cash':
                $response['prize'] = $this->generateCashPrize($avalibleTypes[$typeKey]);
                break;
            default :
                $response['prize'] = $this->generateProductPrize($avalibleTypes[$typeKey]);
                break;
        }
        
        if(!$response['prize']['id'])
            return response()->json('Sorry, but we could not generate a prize for you. Try again...', 422);
        
        return response()->json($response);
    }
    
    private function checkTime(){
        $lastPrize = Prize::where('user_id',Auth::user()->id)->latest('id')->first();
        
        if($lastPrize && strtotime($lastPrize->created_at)+$this->checkTime*60 > time())
            return date('H:i:s', strtotime($lastPrize->created_at)+$this->checkTime*60 - time());
        
        return null;
    }

        public function getAvaliblePrizesTypes()
    {
	$avalibleTypes = Type::select('type','id')->where('show',true)->get();       
        $avalible = [];
        
        foreach($avalibleTypes as $row){
            if($row->type == 'point'){
                $avalible[] = $row;
                continue;
            }
                            
            $Model = '\\App\\' . ucfirst($row->type);               
            if($Model::where('avalible','>',0)->count() > 0){                
                $avalible[] = $row;
                continue;
            }
            
        }
        
        return $avalible;
    }
    
    private function generatePointPrize($type)
    {
        $ranges = $this->getAvalibleRanges($type, false);
        $prize['amount'] = rand($ranges['min'], $ranges['max']);
        $prize['name'] = 'pts';
        $prize['action'] = [];        
        $prize['id'] = $this->setUserPrize(['type_id' => $type->id, 'value' => $prize['amount']], true);
        
        if($prize['id']){
            $this->user->updateAmount($prize['amount']);
        }
        
        return $prize;
    }
    
    private function generateCashPrize($type)
    {
        $ranges = $this->getAvalibleRanges($type);
        $prize['amount'] = rand($ranges['min'], $ranges['max']);
        $prize['name'] = '$';
        $prize['action'] = ['confirm','change','discard'];
        $prize['id'] = $this->setUserPrize(['type_id' => $type->id, 'value' => $prize['amount']]);
                
        if($prize['id']){
            $checkCash = $this->cash->updateAmount(-1*$prize['amount'], true);
            if(isset($checkCash['error'])){
                $this->destroyUserPrize($prize['id']);
                $prize['id'] = null;
            }
        }
        
        return $prize;
    }
    
    private function generateProductPrize($type)
    {
        $Model = '\\App\\' . ucfirst($type->type);            
        $products = $Model::where('avalible','>',0)->get();        
        $productKey = rand(0, count($products)-1);
        
        $prize['amount'] = 1;
        $prize['name'] = $products[$productKey]->name;
        $prize['action'] = ['confirm','discard'];        
        $prize['id'] = $this->setUserPrize(['type_id' => $type->id, 'value' => $products[$productKey]->id]);
                
        if($prize['id']){
            $checkProduct = $this->product->updateAmount($products[$productKey]->id, -1*$prize['amount'], true);
            if(isset($checkProduct['error'])){
                $this->destroyUserPrize($prize['id']);
                $prize['id'] = null;
            }            
        }

        return $prize;
    }
    
    private function getAvalibleRanges($type, $needAvalible = true)
    {
        $rangesSeted = Range::where('type_id',$type->id)->first();        
        $ranges = $rangesSeted ? ['min' => $rangesSeted->min, 'max' => $rangesSeted->max] : ['min' => 1, 'max' => 1];
        
        if($needAvalible){
            $Model = '\\App\\' . ucfirst($type->type);            
            $maxAvalible = $Model::select('avalible')->where('avalible','>',0)->first();
            
            if ($maxAvalible->avalible <= $ranges['min']) {
                $ranges = ['min' => $maxAvalible->avalible, 'max' => $maxAvalible->avalible];            
            }elseif ($maxAvalible->avalible <= $ranges['max']) {
                $ranges['max'] = $maxAvalible->avalible;            
            }
        }
        
        return $ranges;
    }
    
    private function setUserPrize($values, $status=false)
    {
        $values['user_id'] = Auth::user()->id;
        $prize = Prize::create($values);
        if(!$prize)
            return null;
        
        if($status){
            $prize->status = 'success';
            $prize->save(); 
        }
        
        return $prize->id;
    }
    
    private function destroyUserPrize($prizeID)
    {
        Prize::where('id',$prizeID)->delete();        
        
    }
    
    public function prizeDiscard(Request $request) {
                
        $prize = Prize::where('id', $request->get('id'))->with('type')->first();                
        if(!$prize)
            return response()->json('Sorry, but this prize not found!', 422);
        
        if(!Auth::check() || Auth::user()->id != $prize->user_id )
            return response()->json('Sorry, but you not have permittions!', 422);
                
        if($prize->type->type == 'product'){
            $this->product->updateAmount($prize->value, 1, true);
        }elseif($prize->type->type == 'cash'){
            $this->cash->updateAmount($prize->value, true);
        }
        
        $prize->status = 'discard';
        $prize->description = 'Discarded by User';
        $prize->save();
        
        return response()->json(['success' => 'ok']);  
    }
    
    public function prizeConfirm(Request $request) {
        $prize = Prize::where('id', $request->get('id'))->with(['type','user'])->first();                
        if(!$prize)
            return response()->json('Sorry, but this prize not found!', 422);
        
        if(!Auth::check() || Auth::user()->id != $prize->user_id )
            return response()->json('Sorry, but you not have permittions!', 422);

        $prize->description = 'Confirmd by User';
        $prize->save();        
        
        if($prize->type->type == 'cash'){
            $params = [
                'currency'  => 'USD',
                'amount'    => $prize->value,
                'name'      => $prize->user->name,
                'to'        => $prize->user->banking
            ];
            $response = $this->banking->callBanking($params,'transfer');
            if(isset($response['success'])){
                $prize->description .= ' PAIDED';
                $prize->status = 'success';                
                $prize->save();        
            }else{                
                $prize->status = 'faild';                
                $prize->save();
            }
        }
                
        return response()->json(['success' => 'ok']); 
    }
    
    public function prizeChange(Request $request) {
        $prize = Prize::where('id', $request->get('id'))->with('type')->first();                
        if(!$prize)
            return response()->json('Sorry, but this prize not found!', 422);
        
        if(!Auth::check() || Auth::user()->id != $prize->user_id )
            return response()->json('Sorry, but you not have permittions!', 422);
                
        $cashToPoints = $this->cash->getCashToPoiunts();
        $type = Type::where('type','point')->first();        
        if($prize->type->type != 'cash' || !$cashToPoints || !$type)
            return response()->json('Sorry, but your prize not converted!', 422);
       
        $this->cash->updateAmount($prize->value, true);
                
        $prize->description = 'Change '.$prize->value.' to pts by User';
        $prize->value = $prize->value*$cashToPoints;
        $prize->type_id = $type->id;
        $prize->status = 'success';        
        $prize->save();
        
        $this->user->updateAmount($prize->value);
        
        return response()->json(['success' => 'ok']); 
    }
    
}
