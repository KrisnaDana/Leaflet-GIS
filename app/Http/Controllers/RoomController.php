<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomFacility;
use App\Models\Image;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function create(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:20',
            'price' => 'required|numeric|min:0',
            'count' => 'required|integer|min:1',
            'facilities.*' => 'nullable',
            'description' => 'nullable|string|max:500',
            'images.0' => 'required|file|image|max:2048',
            'images.*' => 'nullable|file|image|max:2048',
        ]);
        $room = array(
            'hotel_id' => $id,
            'name' => $validated['name'],
            'price' => $validated['price'],
            'count' => $validated['count'],
        );
        if(!empty($validated['description'])){
            $room['description'] = $validated['description'];
        }
        Room::create($room);
        $room = Room::where('name', $validated['name'])->where('hotel_id', $id)->where('price', $validated['price'])->where('count', $validated['count'])->orderBy('id', 'desc')->first();
        if(!empty($validated['facilities'])){
            $room_facilities = [];
            for($i=0; $i < count($validated['facilities']); $i++){
                array_push($room_facilities, ['room_id' => $room->id, 'facility_id' => $validated['facilities'][$i], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
        }
        RoomFacility::insert($room_facilities);
        $filenames = [];
        for($i=0; $i < count($validated['images']); $i++){
            $image = $request->file('images')[$i];
            $filename = Str::slug($validated['name']) . '-' . time() . $i. '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/rooms');
            $image->move($path, $filename);
            array_push($filenames, $filename);
        }
        $images = [];
        $i = 0;
        foreach($filenames as $filename){
            if($i == 0){
                array_push($images, ['hotel_id' => $id, 'room_id' => $room->id, 'type' => 'Room', 'is_thumbnail' => 1, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }else{
                array_push($images, ['hotel_id' => $id, 'room_id' => $room->id, 'type' => 'Room', 'is_thumbnail' => 0, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            $i++;
        }
        Image::insert($images);
        return redirect()->route('index')->with(['toast_primary' => 'Create room successfully.']);
    }

    public function edit($id, Request $request){
        //
    }

    public function delete($id){
        //
    }
}
