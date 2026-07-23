<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Province;
use App\Models\City;

class LocationController extends Controller
{
    public function regions(){
        return Region::orderBy('name')->get();

    }

    public function provinces($regionCode){
        return response()->json(
            Province::where('region_code', $regionCode)
            ->orderBy('name')
            ->get()
            );
    }

    public function cities($provinceCode){
        return response()->json(City::where('province_code', $provinceCode)
        ->orderBy('name')
        ->get()
        );
    }
}
