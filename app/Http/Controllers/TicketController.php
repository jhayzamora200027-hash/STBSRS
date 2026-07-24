<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Program;

class TicketController extends Controller
{
    public function index(){
        $programs = Program::orderBy('program_name')->get();

        return view('landingpage.home', compact('programs'));
    }
}
