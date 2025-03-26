<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class ClassificationController extends Controller
{
	// Returns the Blade view
	public function index()
	{
		return view('classifications'); // Make sure 'classifications.blade.php' exists
	}

	// Returns JSON data for DataTables
	public function getClassifications(Request $request)
	{
		try {
			$classifications = DB::table('CLASSIFICATION')->where('ACTIVE', 1)->get(); // Fetch from database

			return response()->json([
				'draw' => intval($request->input('draw', 1)),
				'recordsTotal' => count($classifications),
				'recordsFiltered' => count($classifications),
				'data' => $classifications,
			]);
		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function store(Request $request)
	{
		$request->validate([
			'CLASSIFICATION' => 'required|string|max:255',
		]);

		Classification::create([
			'CLASSIFICATION' => $request->CLASSIFICATION,
			'ENCODED_BY' => 1, // Assuming user is authenticated
			'ENCODED_DT' => Carbon::now(),
		]);

		return response()->json(['success' => 'Classification added successfully!']);
	}

	public function edit($id)
	{
		$classification = DB::table('CLASSIFICATION')->where('IDNo', $id)->first();

		if ($classification) {
			return response()->json($classification);
		} else {
			return response()->json(['error' => 'Record not found'], 404);
		}
	}
	public function update(Request $request, $id)
	{
		$request->validate([
			'CLASSIFICATION' => 'required|string|max:255'
		]);

		DB::table('CLASSIFICATION')
			->where('IDNo', $id)
			->update([
				'CLASSIFICATION' => $request->CLASSIFICATION,
				'EDITED_BY' => 1, // Change this if needed
				'EDITED_DT' => now(),
			]);

		return response()->json(['success' => 'Classification updated successfully']);
	}

	public function deactivate($id)
	{
		$updated = DB::table('CLASSIFICATION')
			->where('IDNo', $id)
			->update([
				'ACTIVE' => 0,
				'EDITED_BY' => 1, // Change to the authenticated user if available
				'EDITED_DT' => now()
			]);

		if ($updated) {
			return response()->json(['success' => 'Classification marked as inactive']);
		} else {
			return response()->json(['error' => 'Failed to update classification'], 500);
		}
	}

	public function checkDuplicate(Request $request)
	{
		$exists = DB::table('CLASSIFICATION')
			->whereRaw('LOWER(CLASSIFICATION) = ?', [strtolower($request->CLASSIFICATION)])
			->exists();

		return response()->json(['exists' => $exists]);
	}

	public function loadClassification()
	{
		$data = Classification::where('ACTIVE', 1)->orderBy('CLASSIFICATION', 'asc')->get(); // Fetch all classification data
		return response()->json($data);
	}

}
