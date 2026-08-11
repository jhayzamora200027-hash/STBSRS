<?php

namespace App\Http\Controllers;
use App\Models\Program;
use App\Models\Region;
use App\Models\Agency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LandingpageController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }

        $regions = Region::orderBy('name')->get();
        $programs = Program::orderBy('program')->get();
        $agencies = Agency::orderBy('group_name')->get();

        return view('landingpage.home', compact('regions','programs','agencies'));
    }
}
