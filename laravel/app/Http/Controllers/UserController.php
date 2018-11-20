<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\User;

class UserController extends Controller
{
                
    function __construct()
    {
        $this->middleware('auth');        
    }
    
    public function getAmount($id=null)
    {
	if(!$id)
            $id = Auth::user()->id;
        
        $user = User::find($id);
        
        if(!$user)
            return response()->json('User not found!', 422);
        
        return response()->json(['amount' => $user->amount]);
    }
    
    public function updateAmount($amount, $id=null)
    {
	if(!$id)
            $id = Auth::user()->id;
        
        $user = User::find($id);
        
        if(!$user)
            return ['error' => 'User not found!'];            
        
        if($user->amount + $amount < 0)
            return ['error' => 'Sorry, there are not enough points in the account!'];            
        
        $user->amount += $amount;
        $user->save();
        
        return ['amount' => $user->amount];
    }
    
}
