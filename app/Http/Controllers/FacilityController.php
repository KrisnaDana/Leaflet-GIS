<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\RoomFacility;

class FacilityController extends Controller
{

    public function create(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50',
            'type' => 'required|in:Hotel,Room',
            'count' => 'required|numeric|min:0'
        ]);
        $facility = array(
            'hotel_id' => $id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'count' => $validated['count']
        );
        Facility::create($facility);
        return redirect()->route('index')->with(['toast_primary' => 'Create facility successfully.', 'create_facility' => $id]);
    }

    public function edit(Request $request, $id, $hotel_id){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50',
            'type' => 'required|in:Hotel,Room',
            'count' => 'required|numeric|min:0'
        ]);
        $facility = Facility::find($id);
        $facility->name = $validated['name'];
        $facility->type = $validated['type'];
        $facility->count = $validated['count'];
        $facility->save();
        return redirect()->route('index')->with(['toast_primary' => 'Edit facility successfully.', 'edit_facility' => $hotel_id]);
    }

    public function delete($id, $hotel_id){
        $room_facilities = RoomFacility::where('facility_id', $id)->get();
        foreach($room_facilities as $room_facility){
            $room_facility->delete();
        }
        $facility = Facility::find($id);
        $facility->delete();
        return redirect()->route('index')->with(['toast_primary' => 'Delete facility successfully.', 'delete_facility' => $hotel_id]);
    }
}
