<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function Profile()
    {
        return view('pages.profile');
    }
    public function UpdateName(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->name = $request->name;
        $user->save();
        return redirect()->back();
    }
    public function Update(Request $request)
    {


        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed',
        ]);


        if (Hash::check($request->current_password, Auth::user()->password)) {

            $user = User::find(auth()->id());
            $user->password = Hash::make($request->password);
            $user->save();


            return back()->with('success', 'Password updated successfully');
        } else {
            return back()->withErrors('Success');
        }
    }

    public function orders(){
        $orders = Order::where('user_id',auth()->id())->latest()->get();
        return view('pages.orders' ,compact('orders'));
    }
    public function singleOrder($id){
        $order = Order::find($id);
        if($order->user_id != auth()->id()) abort(403);
        return view('pages.singleorder' ,compact('order'));
    }
}
