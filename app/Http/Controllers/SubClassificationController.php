<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubClassification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubClassificationController extends Controller
{
	public function index()
	{
		return view('sub_classifications'); // Make sure 'classifications.blade.php' exists
	}

	// Returns JSON data for DataTables
	public function getSubClassifications(Request $request)
	{
		try {
			$sub_classifications = DB::table('SUB_CLASSIFICATION')
				->join('CLASSIFICATION', 'SUB_CLASSIFICATION.CLASSIFICATION_ID', '=', 'CLASSIFICATION.IDNo') // Join to get classification description
				->select(
					'SUB_CLASSIFICATION.IDNo',
					'CLASSIFICATION.CLASSIFICATION as CLASSIFICATION_ID', // Fetch classification description
					'SUB_CLASSIFICATION.SUB_CLASSIFICATION'
				)
				->where('SUB_CLASSIFICATION.ACTIVE', 1) // Ensure filtering by active status
				->get();

			return response()->json([
				'draw' => intval($request->input('draw', 1)),
				'recordsTotal' => count($sub_classifications),
				'recordsFiltered' => count($sub_classifications),
				'data' => $sub_classifications,
			]);
		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function store(Request $request)
	{
		$request->validate([
			'CLASSIFICATION_ID' => 'required|integer|max:99999999999',
			'SUB_CLASSIFICATION' => 'required|string|max:255', // Adjust max length
		]);

		SubClassification::create([
			'CLASSIFICATION_ID' => $request->CLASSIFICATION_ID,
			'SUB_CLASSIFICATION' => $request->SUB_CLASSIFICATION,
			'ENCODED_BY' => 1, // Assuming user is authenticated
			'ENCODED_DT' => Carbon::now(),
		]);

		return response()->json(['success' => 'Sub Classification added successfully!']);
	}

	public function checkDuplicate(Request $request)
	{
		$exists = DB::table('SUB_CLASSIFICATION')
			->where('CLASSIFICATION_ID', $request->CLASSIFICATION_ID) // Check classification ID
			->whereRaw('LOWER(SUB_CLASSIFICATION) = ?', [strtolower($request->SUB_CLASSIFICATION)]) // Check sub-classification case-insensitively
			->exists();

		return response()->json(['exists' => $exists]);
	}

	public function edit($id)
	{
		$sub_classification = DB::table('SUB_CLASSIFICATION')->where('IDNo', $id)->first();

		if ($sub_classification) {
			return response()->json($sub_classification);
		} else {
			return response()->json(['error' => 'Record not found'], 404);
		}
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'CLASSIFICATION_ID' => 'required|integer|max:99999999999',
			'SUB_CLASSIFICATION' => 'required|string|max:255', // Adjust max length
		]);

		DB::table('SUB_CLASSIFICATION')
			->where('IDNo', $id)
			->update([
				'CLASSIFICATION_ID' => $request->CLASSIFICATION_ID,
				'SUB_CLASSIFICATION' => $request->SUB_CLASSIFICATION,
				'EDITED_BY' => 1, // Assuming user is authenticated
				'EDITED_DT' => Carbon::now(),
			]);

		return response()->json(['success' => 'Sub Classification updated successfully']);
	}

	public function deactivate($id)
	{
		$updated = DB::table('SUB_CLASSIFICATION')
			->where('IDNo', $id)
			->update([
				'ACTIVE' => 0,
				'EDITED_BY' => 1, // Change to the authenticated user if available
				'EDITED_DT' => now()
			]);

		if ($updated) {
			return response()->json(['success' => 'Sub Classification marked as inactive']);
		} else {
			return response()->json(['error' => 'Failed to update sub classification'], 500);
		}
	}

	// public function loadClassification()
	// {
	// 	$data = Classification::where('ACTIVE', 1)->orderBy('CLASSIFICATION', 'asc')->get(); // Fetch all classification data
	// 	return response()->json($data);
	// }

	public function loadSubClassification()
	{
		$data = DB::table('vw_SUB_CLASSIFICATION')->where('ACTIVE', 1)->orderBy('SUB_CLASSIFICATION', 'asc')->get(); // Fetch all sub classification data
		return response()->json($data);
	}

	public function getClassification($id)
	{
		$subClassification = SubClassification::with('classification')->find($id);

		if ($subClassification && $subClassification->classification) {
			return response()->json([
				'classification' => $subClassification->classification->classification
			]);
		} else {
			return response()->json(['error' => 'Sub Classification not found.'], 404);
		}
	}
}
