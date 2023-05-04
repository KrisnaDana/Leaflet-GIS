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

    public function api_route(){
        return response()->json(["message" => "This is API route.", 200]); 
    }

    public function index()
    {
        $hotels = DB::table('hotel_temp')->get();
        return $hotels;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'create_hotel_name' => 'required|string|min:1|max:50',
            'create_hotel_address' => 'required|string|min:1|max:100',
            'create_hotel_phone' => 'required|numeric|digits_between:1,20',
            'create_hotel_room' => 'required|numeric|digits_between:1,10',
            'create_hotel_star' => 'required|numeric|min:1|max:5',
            'create_hotel_description' => 'required|string|min:1|max:2000',
            'create_hotel_lat' => 'required',
            'create_hotel_lng' => 'required',
        ]);
        DB::table('hotel_temp')->insert([
            'name' => $validated['create_hotel_name'],
            'address' => $validated['create_hotel_address'],
            'phone' => $validated['create_hotel_phone'],
            'room' => $validated['create_hotel_room'],
            'star' => $validated['create_hotel_star'],
            'description' => $validated['create_hotel_description'],
            'lat' => $validated['create_hotel_lat'],
            'lng' => $validated['create_hotel_lng'],
        ]);
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
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'update_hotel_name' => 'required_without:update_hotel_lat,update_hotel_lng|string|min:1|max:50',
            'update_hotel_address' => 'required_without:update_hotel_lat,update_hotel_lng|string|min:1|max:100',
            'update_hotel_phone' => 'required_without:update_hotel_lat,update_hotel_lng|numeric|digits_between:1,20',
            'update_hotel_room' => 'required_without:update_hotel_lat,update_hotel_lng|numeric|digits_between:1,10',
            'update_hotel_star' => 'required_without:update_hotel_lat,update_hotel_lng|numeric|min:1|max:5',
            'update_hotel_description' => 'required_without:update_hotel_lat,update_hotel_lng|string|min:1|max:2000',
            'update_hotel_lat' => 'required_with:update_hotel_lng|numeric',
            'update_hotel_lng' => 'required_with:update_hotel_lat|numeric'
        ]);
        if(!empty($request->update_hotel_lat) && !empty($request->update_hotel_lng)){
            DB::table('hotel_temp')->where('id', $id)->update([
                'lat' => $request->update_hotel_lat,
                'lng' => $request->update_hotel_lng,
            ]);
        }else{
            DB::table('hotel_temp')->where('id', $id)->update([
                'name' => $validated['update_hotel_name'],
                'address' => $validated['update_hotel_address'],
                'phone' => $validated['update_hotel_phone'],
                'room' => $validated['update_hotel_room'],
                'star' => $validated['update_hotel_star'],
                'description' => $validated['update_hotel_description'],
            ]);
        }
        return response()->json(["message" => "Hotel updated successfully.", 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('hotel_temp')->where('id', $id)->delete();
        return response()->json(["message" => "Hotel deleted successfully.", 200]);
    }
}
