<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countries = Country::where('isRegion','0')->topCountries()->get();
        $faqs = Faq::all();
        $regions = Country::where('isRegion','1')->get();
        return view('home',compact('countries','faqs','regions'));
    }
    
  

    public function thankyou(){
        return view('pages.thankyou');
    }

}
