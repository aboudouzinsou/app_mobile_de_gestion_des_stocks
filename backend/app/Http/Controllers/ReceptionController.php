<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receptions = Reception::all();
        return response()->json($receptions);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $reception = new Reception($request->all());
        $reception->save();
        return response()->json($reception, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $reception = Reception::find($id);
    if ($reception) {
        return response()->json($reception);
    } else {
        return response()->json(['message' => 'Reception not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $reception = Reception::find($id);
        if ($reception) {
            $reception->fill($request->all());
            $reception->save();
            return response()->json($reception);
        } else {
            return response()->json(['message' => 'Reception not found'], 404);
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
    $reception = Reception::find($id);
    if ($reception) {
        $reception->delete();
        return response()->json(['message' => 'Reception deleted']);
    } else {
        return response()->json(['message' => 'Reception not found'], 404);
    }
}
}