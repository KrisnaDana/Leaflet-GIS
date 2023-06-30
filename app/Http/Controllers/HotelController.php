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
    public function index(Request $request){
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
        $mode = "";
        if($request->mode == "hotel"){
            $mode = "hotel";
        }else if($request->mode == "routing"){
            $mode = "routing";
        }else{
            $mode = "view";
        }
        if(isset($request->routing_hotel)){
            $routing_hotel = $request->routing_hotel;
        }else{
            $routing_hotel = null;
        }
        return view('leaflet', compact('user', 'hotels', 'facilities', 'rooms', 'room_facilities', 'images', 'mode', 'routing_hotel'));
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50',
            'address' => 'required|string|min:1|max:200',
            'phone' => 'required|string|min:1|max:20',
            'email' => 'required|string|email:rfc,dns',
            'star' => 'required|in:1,2,3,4,5',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|file|image|max:1024',
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
        if(!empty($validated['icon'])){
            $image = $request->file('icon');
            $filename = Str::slug($validated['name']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/hotel_icons');
            $image->move($path, $filename);
            $hotel['icon'] = 'images/hotel_icons/'.$filename;
        }else{
            $hotel['icon'] = 'images/hotel.png';
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

    public function edit(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50',
            'address' => 'required|string|min:1|max:200',
            'phone' => 'required|string|min:1|max:20',
            'email' => 'required|string|email:rfc,dns',
            'star' => 'required|in:1,2,3,4,5',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|file|image|max:1024',
            'images.*' => 'nullable|file|image|max:2048',
        ]);
        $hotel = Hotel::find($id);
        $hotel->name = $validated['name'];
        $hotel->address = $validated['address'];
        $hotel->phone = $validated['phone'];
        $hotel->email = $validated['email'];
        $hotel->star = $validated['star'];
        if(!empty($validated['description'])){
            $hotel->description = $validated['description'];
        }else{
            $hotel->description = null;
        }
        if(!empty($validated['icon'])){
            if($hotel->icon != "images/hotel.png"){
                File::delete(public_path('/').$hotel->icon);
            }
            $image = $request->file('icon');
            $filename = Str::slug($validated['name']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/hotel_icons');
            $image->move($path, $filename);
            $hotel->icon = 'images/hotel_icons/'.$filename;
        }
        if(!empty($validated['images'])){
            $filenames = [];
            for($i=0; $i < count($validated['images']); $i++){
                $image = $request->file('images')[$i];
                $filename = Str::slug($validated['name']) . '-' . time() . $i. '.' . $image->getClientOriginalExtension();
                $path = public_path('/images/hotels');
                $image->move($path, $filename);
                array_push($filenames, $filename);
            }
            $images = [];
            foreach($filenames as $filename){
                array_push($images, ['hotel_id' => $hotel->id, 'type' => 'Hotel', 'is_thumbnail' => 0, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            Image::insert($images);
        }
        $hotel->save();
        return redirect()->route('index')->with(['toast_primary' => 'Edit hotel successfully.', 'edit_hotel' => $id]);
    }

    public function thumbnail_image($id, $image_id){
        $old_thumbnail = Image::where('hotel_id', $id)->where('type', "Hotel")->where('is_thumbnail', 1)->first();
        $new_thumbnail = Image::find($image_id);
        if($new_thumbnail->is_thumbnail == 1){
            return redirect()->route('index')->with(['toast_danger' => 'That image is already thumbnail.', 'thumbnail_image_hotel' => $id]);
        }
        $old_thumbnail->is_thumbnail = 0;
        $new_thumbnail->is_thumbnail = 1;
        $old_thumbnail->save();
        $new_thumbnail->save();
        return redirect()->route('index')->with(['toast_primary' => 'Set thumbnail of hotel image successfully.', 'thumbnail_image_hotel' => $id]);
    }

    public function delete_image($id, $image_id){
        $image = Image::find($image_id);
        if($image->is_thumbnail == 1){
            return redirect()->route('index')->with(['toast_danger' => 'Delete thumbnail image is not allowed.', 'delete_image_hotel' => $id]);
        }
        File::delete(public_path('/images/hotels/').$image->filename);
        $image->delete();
        return redirect()->route('index')->with(['toast_primary' => 'Delete hotel image successfully.', 'delete_image_hotel' => $id]);
    }

    public function edit_location(Request $request, $id){
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
        $hotel = Hotel::find($id);
        $hotel->lat = $validated['lat'];
        $hotel->lng = $validated['lng'];
        $hotel->save();
        return redirect()->route('index')->with(['toast_primary' => 'Edit hotel location successfully.']);
    }

    public function delete($id){
        $images = Image::where('hotel_id', $id)->get();
        $hotel_path = public_path('/images/hotels/');
        $room_path = public_path('/images/rooms/');
        $facility_path = public_path('/images/facilities/');
        foreach($images as $image){
            if($image->room_id != 0){
                File::delete($room_path.$image->filename);
            }elseif($image->facility_id != 0){
                File::delete($facility_path.$image->filename);
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
        if($hotel->icon != "images/hotel.png"){
            File::delete(public_path('/').$hotel->icon);
        }
        $hotel->delete();
        return redirect()->route('index')->with(['toast_primary' => 'Delete hotel successfully.']);
    }
}
