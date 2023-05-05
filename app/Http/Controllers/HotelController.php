<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Facility;
use App\Models\Room;
use App\Models\RoomFacility;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    public function index(){
        if(Auth::guard('user')->check()){
            $user = Auth::guard('user')->user();
        }else{
            $user = null;
        }
        $hotels = Hotel::all();
        $facilities =  Facility::all();
        $rooms = Room::all();
        $room_facilities = RoomFacility::all();
        $images = Image::all();
        return view('leaflet', compact('user', 'hotels', 'facilities', 'rooms', 'room_facilities', 'images'));
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50',
            'address' => 'required|string|min:1|max:100',
            'star' => 'required|in:1,2,3,4,5',
            'phone' => 'required|numeric|digits_between:3,20',
            'email' => 'required|string|email:rfc,dns',
            'description' => 'nullable|string|max:500',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
        $hotel = array(
            'name' => $validated['name'],
            'address' => $validated['address'],
            'star' => $validated['star'],
            'phone' => $validated['phone'],
            'email' => $validated['email']
        );
        if(!empty($validated['description'])){
            $hotel['description'] = $validated['description'];
        }
        Hotel::create($hotel);
        return redirect()->route('index')->with(['toast_primary' => 'Create hotel successfully.']);

    }

    public function edit($id, Request $request){
        //
    }

    public function edit_location($id, Request $request){
        //
    }

    public function delete($id){
        //
    }
}
