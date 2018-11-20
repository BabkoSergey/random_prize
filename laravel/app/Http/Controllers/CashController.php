<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Cash;

class CashController extends Controller
{
                
    function __construct()
    {
        $this->middleware('auth');        
    }
         
    public function getCashToPoiunts()
    {
	
        $cash = Cash::where('avalible','>',0)->first();
        
        if(!$cash)
            return null;            
        
        return $cash->cach_to_point;
    }
    
    public function updateAmount($amount, $reserved = false)
    {
	
        $cash = Cash::where('avalible','>',0)->first();
        
        if(!$cash)
            return ['error' => 'Cash not set!'];            
        
        if($cash->avalible + $amount < 0)
            return ['error' => 'Sorry, there are not enough cash in the system!'];            
        
        $cash->avalible += $amount;
        
        if($reserved)
            $cash->reserved += -1*$amount;
        
        $cash->save();
        
        return ['success' => 'ok'];
    }
    
}
