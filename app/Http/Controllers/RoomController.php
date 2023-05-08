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
            'description' => 'nullable|string|max:500',
            'images.0' => 'required|file|image|max:2048',
            'images.*' => 'nullable|file|image|max:2048',
        ]);
        $room = array(
            'name' => $validated['name'],
            'price' => $validated['price'],
            'count' => $validated['count'],
        );
        if(!empty($validated['description'])){
            $room['description'] = $validated['description'];
        }
    }

    public function edit($id, Request $request){
        //
    }

    public function delete($id){
        //
    }
}
