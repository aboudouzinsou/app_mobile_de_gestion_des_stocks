<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personnels = Personnel::all();
        return response()->json($personnels);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $personnel = new Personnel($request->all());
        $personnel->save();
        return response()->json($personnel, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $personnel = Personnel::find($id);
    if ($personnel) {
        return response()->json($personnel);
    } else {
        return response()->json(['message' => 'Personnel not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $personnel = Personnel::find($id);
        if ($personnel) {
            $personnel->fill($request->all());
            $personnel->save();
            return response()->json($personnel);
        } else {
            return response()->json(['message' => 'Personnel not found'], 404);
        }
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Remove the specified resource from storage.
 */
public function destroy($id)
{
    $personnel = Personnel::find($id);
    if ($personnel) {
        $personnel->delete();
        return response()->json(['message' => 'Personnel deleted']);
    } else {
        return response()->json(['message' => 'Personnel not found'], 404);
    }
}
}