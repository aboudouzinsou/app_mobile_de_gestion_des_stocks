<?php

namespace App\Http\Controllers;

use App\Models\Stocker;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StockerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockers = Stocker::all();
        return response()->json($stockers);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $stocker = new Stocker($request->all());
        $stocker->save();
        return response()->json($stocker, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $stocker = Stocker::find($id);
    if ($stocker) {
        return response()->json($stocker);
    } else {
        return response()->json(['message' => 'Stocker not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $stocker = Stocker::find($id);
        if ($stocker) {
            $stocker->fill($request->all());
            $stocker->save();
            return response()->json($stocker);
        } else {
            return response()->json(['message' => 'Stocker not found'], 404);
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
    $stocker = Stocker::find($id);
    if ($stocker) {
        $stocker->delete();
        return response()->json(['message' => 'Stocker deleted']);
    } else {
        return response()->json(['message' => 'Stocker not found'], 404);
    }
}
}