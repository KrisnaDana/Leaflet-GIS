<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = DB::table('hotels')->get();
        return response()->json($hotels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50',
            'address' => 'required|string|min:1|max:100',
            'phone' => 'required|numeric|digits_between:1,20',
            'lat' => 'required',
            'lng' => 'required',
        ]);
        DB::table('hotels')->insert($validated);
        return response()->json(["message" => "Hotel created successfully.", 200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, string $lng = '', string $lat = '')
    {
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
        return response()->json(["message" => "Hotel updated successfully.", 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('hotels')->where('id', $id)->delete();
        return response()->json(["message" => "Hotel deleted successfully.", 200]);
    }
}
