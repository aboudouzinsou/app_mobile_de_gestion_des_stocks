<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $client = new Client($request->all());
        $client->save();
        return response()->json($client, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $client = Client::find($id);
    if ($client) {
        return response()->json($client);
    } else {
        return response()->json(['message' => 'Client not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $client = Client::find($id);
        if ($client) {
            $client->fill($request->all());
            $client->save();
            return response()->json($client);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
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
    $client = Client::find($id);
    if ($client) {
        $client->delete();
        return response()->json(['message' => 'Client deleted']);
    } else {
        return response()->json(['message' => 'Client not found'], 404);
    }
}
}