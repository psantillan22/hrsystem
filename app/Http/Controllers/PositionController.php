<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $position = Position::where('status', 1)->get();

        return response()->json(['success' => true, 'data' => $position]);
    }

    public function checkPositionDuplicate(Request $request)
    {
        $exists = DB::table('position')
        ->whereRaw('LOWER(position_name) = ?', [strtolower($request->position_name)])
        ->where('status', 1)
        ->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
			'position_name' => 'required|string|max:255',
		]);

		Position::create([
			'position_name' => $request->position_name,
			'position_description' => $request->job_description,
			'created_by' => 1, 
			'updated_by' => 1, 
			'created_at' => now(), 
			'updated_at' => now(), 
		]);

		return response()->json(['success' => 'Position added successfully!']);
    }

    public function deactivate($id)
	{
		$updated = DB::table('position')
			->where('id', $id)
			->update([
				'status' => 0,
				'updated_by' => 1, 
				'updated_at' => now()
			]);

		if ($updated) {
			return response()->json(['success' => 'Position marked as inactive']);
		} else {
			return response()->json(['error' => 'Failed to update department'], 500);
		}
	}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
	{
		$position = DB::table('position')->where('id', $id)->first();

		if ($position) {
			return response()->json($position);
		} else {
			return response()->json(['error' => 'Record not found'], 404);
		}
	}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
			'position_name' => 'required|string|max:255',
			'job_description' => 'required',
		]);

		DB::table('position')
			->where('id', $id)
			->update([
				'position_name' => $request->position_name,
				'position_description' => $request->job_description,
				'updated_by' => 1, // Change this if needed
				'updated_at' => now(),
			]);

		return response()->json(['success' => 'Position updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
