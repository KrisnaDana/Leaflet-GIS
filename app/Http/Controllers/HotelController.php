<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Facility;
use App\Models\Room;
use App\Models\RoomFacility;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
            'address' => 'required|string|min:1|max:200',
            'phone' => 'required|string|min:1|max:20',
            'email' => 'required|string|email:rfc,dns',
            'star' => 'required|in:1,2,3,4,5',
            'description' => 'nullable|string|max:1000',
            'images.0' => 'required|file|image|max:2048',
            'images.*' => 'nullable|file|image|max:2048',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
        $hotel = array(
            'name' => $validated['name'],
            'address' => $validated['address'],
            'star' => $validated['star'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
        );
        if(!empty($validated['description'])){
            $hotel['description'] = $validated['description'];
        }
        Hotel::create($hotel);
        $hotel = Hotel::where('name', $validated['name'])->where('lat', $validated['lat'])->where('lng', $validated['lng'])->orderBy('id', 'desc')->first();
        $filenames = [];
        for($i=0; $i < count($validated['images']); $i++){
            $image = $request->file('images')[$i];
            $filename = Str::slug($validated['name']) . '-' . time() . $i. '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/hotels');
            $image->move($path, $filename);
            array_push($filenames, $filename);
        }
        $images = [];
        $i = 0;
        foreach($filenames as $filename){
            if($i == 0){
                array_push($images, ['hotel_id' => $hotel->id, 'type' => 'Hotel', 'is_thumbnail' => 1, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }else{
                array_push($images, ['hotel_id' => $hotel->id, 'type' => 'Hotel', 'is_thumbnail' => 0, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            $i++;
        }
        Image::insert($images);
        return redirect()->route('index')->with(['toast_primary' => 'Create hotel successfully.']);
    }

    public function edit($id, Request $request){
        //
    }

    public function edit_location($id, Request $request){
        //
    }

    public function delete($id){
        $images = Image::where('hotel_id', $id)->get();
        $hotel_path = public_path('/images/hotels/');
        $room_path = public_path('/images/rooms/');
        foreach($images as $image){
            if($image->room_id != 0){
                File::delete($room_path.$image->filename);
            }else{
                File::delete($hotel_path.$image->filename);
            }
            $image->delete();
        }
        $rooms = Room::where('hotel_id', $id)->get();
        foreach($rooms as $room){
            $room_facilities = RoomFacility::where('room_id', $room->id)->get();
            foreach($room_facilities as $room_facility){
                $room_facility->delete();
            }
            $room->delete();
        }
        $facilities = Facility::where('hotel_id', $id)->get();
        foreach($facilities as $facility){
            $facility->delete();
        }
        $hotel = Hotel::find($id);
        $hotel->delete();
        return redirect()->route('index')->with(['toast_primary' => 'Delete hotel successfully.']);
    }
}
