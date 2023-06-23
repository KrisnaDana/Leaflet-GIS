<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\RoomFacility;
use Illuminate\Support\Str;
use App\Models\Image;
use Illuminate\Support\Facades\File;

class FacilityController extends Controller
{

    public function create(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50',
            'type' => 'required|in:Hotel,Room',
            'count' => 'required|numeric|min:0',
            'images.*' => 'nullable|file|image|max:2048'
        ]);
        $facility = array(
            'hotel_id' => $id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'count' => $validated['count']
        );
        Facility::create($facility);
        if(!empty($validated['images'])){
            $facility = Facility::where('name', $validated['name'])->where('hotel_id', $id)->where('type', $validated['type'])->where('count', $validated['count'])->orderBy('id', 'desc')->first();
            $filenames = [];
            for($i=0; $i < count($validated['images']); $i++){
                $image = $request->file('images')[$i];
                $filename = Str::slug($validated['name']) . '-' . time() . $i. '.' . $image->getClientOriginalExtension();
                $path = public_path('/images/facilities');
                $image->move($path, $filename);
                array_push($filenames, $filename);
            }
            $images = [];
            $i = 0;
            foreach($filenames as $filename){
                if($i == 0){
                    array_push($images, ['hotel_id' => $id, 'facility_id' => $facility->id, 'type' => 'Facility', 'is_thumbnail' => 1, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                }else{
                    array_push($images, ['hotel_id' => $id, 'facility_id' => $facility->id, 'type' => 'Facility', 'is_thumbnail' => 0, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                }
                $i++;
            }
            Image::insert($images);
        }
        return redirect()->route('index')->with(['toast_primary' => 'Create facility successfully.', 'create_facility' => $id]);
    }

    public function edit(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50',
            'type' => 'required|in:Hotel,Room',
            'count' => 'required|numeric|min:0',
            'images.*' => 'nullable|file|image|max:2048'
        ]);
        $facility = Facility::find($id);
        $facility->name = $validated['name'];
        $facility->type = $validated['type'];
        $facility->count = $validated['count'];
        if(!empty($validated['images'])){
            $filenames = [];
            for($i=0; $i < count($validated['images']); $i++){
                $image = $request->file('images')[$i];
                $filename = Str::slug($validated['name']) . '-' . time() . $i. '.' . $image->getClientOriginalExtension();
                $path = public_path('/images/facilities');
                $image->move($path, $filename);
                array_push($filenames, $filename);
            }
            $images = [];
            $facility_images = Image::where('facility_id', $facility->id)->get();
            if(count($facility_images)>0){
                foreach($filenames as $filename){
                    array_push($images, ['hotel_id' => $facility->hotel_id, 'facility_id' => $facility->id, 'type' => 'Facility', 'is_thumbnail' => 0, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                }
            }else{
                $i = 0;
                foreach($filenames as $filename){
                    if($i == 0){
                        array_push($images, ['hotel_id' => $facility->hotel_id, 'facility_id' => $facility->id, 'type' => 'Facility', 'is_thumbnail' => 1, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                    }else{
                        array_push($images, ['hotel_id' => $facility->hotel_id, 'facility_id' => $facility->id, 'type' => 'Facility', 'is_thumbnail' => 0, 'filename' => $filename, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                    }
                    $i++;
                }
            }
            Image::insert($images);
        }
        $facility->save();
        return redirect()->route('index')->with(['toast_primary' => 'Edit facility successfully.', 'edit_facility' => $id]);
    }

    public function thumbnail_image($id, $image_id){
        $old_thumbnail = Image::where('facility_id', $id)->where('type', "Facility")->where('is_thumbnail', 1)->first();
        $new_thumbnail = Image::find($image_id);
        if($new_thumbnail->is_thumbnail == 1){
            return redirect()->route('index')->with(['toast_danger' => 'That image is already thumbnail.', 'thumbnail_image_facility' => $id]);
        }
        $old_thumbnail->is_thumbnail = 0;
        $new_thumbnail->is_thumbnail = 1;
        $old_thumbnail->save();
        $new_thumbnail->save();
        return redirect()->route('index')->with(['toast_primary' => 'Set thumbnail of facility image successfully.', 'thumbnail_image_facility' => $id]);
    }

    public function delete_image($id, $image_id){
        $image = Image::find($image_id);
        $images = Image::where('facility_id', $id)->where('type', "Facility")->where('id', '!=', $image->id)->get();
        if(count($images) > 0 && $image->is_thumbnail == 1){
            $images[0]->is_thumbnail = 1;
            $images[0]->save();
        }
        File::delete(public_path('/images/facilities/').$image->filename);
        $image->delete();
        return redirect()->route('index')->with(['toast_primary' => 'Delete facility image successfully.', 'delete_image_facility' => $id]);
    }

    public function delete($id, $hotel_id){
        $images = Image::where('facility_id', $id)->where('type', "Facility")->get();
        $path = public_path('/images/facilities/');
        foreach($images as $image){
            File::delete($path.$image->filename);
            $image->delete();
        }
        $room_facilities = RoomFacility::where('facility_id', $id)->get();
        foreach($room_facilities as $room_facility){
            $room_facility->delete();
        }
        $facility = Facility::find($id);
        $facility->delete();
        return redirect()->route('index')->with(['toast_primary' => 'Delete facility successfully.', 'delete_facility' => $hotel_id]);
    }
}
