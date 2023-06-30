<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class leafletController extends Controller
{
    public function index(Request $request): View {
        $mode = '';
        if($request->mode == 'hotel'){
            $mode == 'hotel';
        }else if($request->mode == 'routing'){
            $mode == 'routing';
        }else{
            $mode = 'view';
        }
        $hotels = DB::table('hotel_temp')->get();
        if(Auth::guard('user')->check()){
            $user = Auth::guard('user')->user();
        }else{
            $user = null;
        }

        dd($mode);
        return view('leaflet', compact('hotels', 'user', 'mode'));
    }

    public function create(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50',
            'address' => 'required|string|min:1|max:100',
            'phone' => 'required|numeric|digits_between:1,20',
            'lat' => 'required',
            'lng' => 'required',
        ]);
        DB::table('hotels')->insert($validated);
        return redirect()->route('index');
    }

    public function edit(Request $request, $id): RedirectResponse {
        $validated = $request->validate([
            'update_name' => 'required|string|min:1|max:50',
            'update_address' => 'required|string|min:1|max:100',
            'update_phone' => 'required|numeric|digits_between:1,20',
            'update_lat' => 'required',
            'update_lng' => 'required',
        ]);
        DB::table('hotels')->where('id', $id)->update([
            'name' => $request->update_name,
            'address' => $request->update_address,
            'phone' => $request->update_phone,
            'lat' => $request->update_lat,
            'lng' => $request->update_lng
        ]);
        return redirect()->route('index');
    }

    public function delete($id){
        DB::table('hotels')->where('id', $id)->delete();
        return redirect()->route('index');
    }

    public function edit_location($id, $lat, $lng){
        DB::table('hotels')->where('id', $id)->update([
            'lat' => $lat,
            'lng' => $lng
        ]);
        return "done";
    }
}
