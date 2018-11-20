<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Product;

class ProductController extends Controller
{
                
    function __construct()
    {
        $this->middleware('auth');        
    }
            
    public function updateAmount($prodictId, $amount, $reserved = false)
    {
	
        $product = Product::find($prodictId);
        
        if(!$product)
            return ['error' => 'Product not found!'];            
        
        if($product->avalible + $amount < 0)
            return ['error' => 'Sorry, there are not enough this product!'];            
        
        $product->avalible += $amount;
        
        if($reserved)
            $product->reserved += -1*$amount;
        
        $product->save();
        
        return ['success' => 'ok'];
    }
    
}
