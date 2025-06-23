<?php

namespace App\Http\Controllers\Admin;
use App\Models\Telephone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
       
            $pageTitle="Dashboard";
            $telephones=Telephone::all();
            return view('admin.telephones.lists',compact('pageTitle','telephones'));
    
    }
}
