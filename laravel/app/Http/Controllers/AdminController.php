<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
             
    function __construct()
    {
        
    }
    
    /**
     * Display a Dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	return view('admin.dashboard');		
    }
	
    
}
