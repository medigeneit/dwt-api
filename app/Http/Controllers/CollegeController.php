<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function index(){
       
        return response([
            'colleges' => College::get(['id','name']),
        ]);
    }
}
