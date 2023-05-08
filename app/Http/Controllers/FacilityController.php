<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;

class FacilityController extends Controller
{

    public function create(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:20',
            'type' => 'required|in:Hotel,Room',
            'count' => 'required|numeric|min:1'
        ]);
        $facility = array(
            'hotel_id' => $id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'count' => $validated['count']
        );
        Facility::create($facility);
        return redirect()->route('index')->with(['toast_primary' => 'Create facility successfully.']);
    }

    public function edit($id, Request $request){
        //
    }

    public function delete($id){
        //
    }
}
