<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Faq;
use App\Models\Order;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function Destination(Request $request)
    {

        if ($request->view == 'all') {
            $countries = Country::ActiveCountry()->where('isRegion','0')->get();
        } else {
            $countries = Country::ActiveCountry()->where('isRegion','0')->paginate(40);
        }
        $regions = Country::ActiveCountry()->where('isRegion','1')->get();
        return view('pages.destinations', compact('countries','regions'));
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        $countries = Country::where('name', 'LIKE', "%{$query}%")->where('status', 'active')->paginate(40);
        
        $regions = Country::ActiveCountry()->where('name', 'LIKE', "%{$query}%")->where('isRegion','1')->get();
        return view('pages.destinations', compact('countries','regions'));
    }


    public function PartnerUs()
    {

        $faqs = Faq::all();
        return view('pages.partner-with-us', compact('faqs'));
    }
    public function AboutUs()
    {
        $faqs = Faq::all();
        return view('pages.about-us', compact('faqs'));
    }
}
