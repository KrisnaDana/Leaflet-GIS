<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomFacility;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    public function create(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:App\Models\Room,name',
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
            RoomFacility::insert($room_facilities);
        }
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
        return redirect()->route('index')->with(['toast_primary' => 'Create room successfully.', 'create_room' => $id]);
    }

    public function edit($id, Request $request){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:App\Models\Room,name,'.$id,
            'price' => 'required|numeric|min:0',
            'count' => 'required|integer|min:1',
            'facilities.*' => 'nullable',
            'description' => 'nullable|string|max:500',
            'images.*' => 'nullable|file|image|max:2048',
        ]);
        $room = Room::find($id);
        $room->name = $validated['name'];
        $room->price = $validated['price'];
        $room->count = $validated['count'];
        if(!empty($validated['description'])){
            $room->description = $validated['description'];
        }else{
            $room->description = null;
        }
        $room_facilities = RoomFacility::where('room_id', $id)->get();
        if(!empty($validated['facilities'])){
            if(!empty($room_facilities)){
                $room_facilities->each->delete();
            }
            $room_facilities = [];
            for($i=0; $i < count($validated['facilities']); $i++){
                array_push($room_facilities, ['room_id' => $id, 'facility_id' => $validated['facilities'][$i], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            RoomFacility::insert($room_facilities);
        }else{
            if(!empty($room_facilities)){
                $room_facilities->each->delete();
            }
        }
        if(!empty($validated['images'])){
            $filenames = [];
            for($i=0; $i < count($validated['images']); $i++){
                $image = $request->file('images')[$i];
                $filename = Str::slug($validated['name']) . '-' . time() . $i. '.' . $image->getClientOriginalExtension();
                $path = public_path('/images/rooms');
                $image->move($path, $filename);
                array_push($filenames, $filename);
            }
            $images = [];
            foreach($filenames as $filename){
                array_push($images, ['hotel_id' => $room->hotel_id, 'room_id' => $id, 'type' => 'Room', 'is_thumbnail' => 0, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            Image::insert($images);
        }
        $room->save();
        return redirect()->route('index')->with(['toast_primary' => 'Edit room successfully.', 'edit_room' => $id]);
    }

    public function thumbnail_image($id, $image_id){
        $old_thumbnail = Image::where('room_id', $id)->where('type', "Room")->where('is_thumbnail', 1)->first();
        $new_thumbnail = Image::find($image_id);
        if($new_thumbnail->is_thumbnail == 1){
            return redirect()->route('index')->with(['toast_danger' => 'That image is already thumbnail.', 'thumbnail_image_room' => $id]);
        }
        $old_thumbnail->is_thumbnail = 0;
        $new_thumbnail->is_thumbnail = 1;
        $old_thumbnail->save();
        $new_thumbnail->save();
        return redirect()->route('index')->with(['toast_primary' => 'Set thumbnail of room image successfully.', 'thumbnail_image_room' => $id]);
    }

    public function delete_image($id, $image_id){
        $image = Image::find($image_id);
        if($image->is_thumbnail == 1){
            return redirect()->route('index')->with(['toast_danger' => 'Delete thumbnail image is not allowed.', 'delete_image_room' => $id]);
        }
        File::delete(public_path('/images/rooms/').$image->filename);
        $image->delete();
        return redirect()->route('index')->with(['toast_primary' => 'Delete room image successfully.', 'delete_image_room' => $id]);
    }

    public function delete($id, $hotel_id){
        $images = Image::where('room_id', $id)->get();
        $path = public_path('/images/rooms/');
        foreach($images as $image){
            File::delete($path.$image->filename);
            $image->delete();
        }
        $room_facilities = RoomFacility::where('room_id', $id)->get();
        foreach($room_facilities as $room_facility){
            $room_facility->delete();
        }
        $room = Room::find($id);
        $room->delete();
        return redirect()->route('index')->with(['toast_primary' => 'Delete room successfully.', 'delete_room' => $hotel_id]);
    }
}
