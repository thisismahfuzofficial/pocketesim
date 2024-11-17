<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products(Country $country)
    {
        $plans = $country->plans->where('status', 'active')->sortBy('price');
        
        return view('pages.products', compact('country', 'plans'));
    }
}
