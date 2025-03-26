<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ItemMasterController extends Controller
{
	// Returns the Blade view
	public function index()
	{
		return view('item_master'); // Make sure 'item-master.blade.php' exists
	}

	// Returns JSON data for DataTables
	public function getItemMaster(Request $request)
	{
		try {
			$classifications = DB::table('vw_ITEM')->where('ACTIVE', 1)->get(); // Fetch from database

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
			'SUB_CLASSIFICATION_ID' => 'required|integer|max:99999999999',
			'DESCRIPTION' => 'required|string|max:255', // Adjust max length
			'MODEL' => 'nullable|string|max:255', // Adjust max length
			'COLOR' => 'nullable|string|max:255', // Adjust max length
			'DIMENSION' => 'nullable|string|max:255', // Adjust max length
		]);

		ItemMaster::create([
			'SUB_CLASSIFICATION_ID' => $request->SUB_CLASSIFICATION_ID,
			'DESCRIPTION' => $request->DESCRIPTION,
			'MODEL' => $request->MODEL,
			'COLOR' => $request->COLOR,
			'DIMENSION' => $request->DIMENSION,
			'ENCODED_BY' => 1, // Assuming user is authenticated
			'ENCODED_DT' => Carbon::now(),
		]);

		return response()->json(['success' => 'Item have been added successfully!']);
	}

	public function checkDuplicate(Request $request)
	{
		$exists = DB::table('ITEM')
			->where([
				['SUB_CLASSIFICATION_ID', $request->SUB_CLASSIFICATION_ID],
				[DB::raw('LOWER(DESCRIPTION)'), strtolower($request->DESCRIPTION)],
				['MODEL', $request->MODEL],
				['COLOR', $request->COLOR],
				['DIMENSION', $request->DIMENSION],
			])
			->exists();

		return response()->json(['exists' => $exists]);
	}

	public function edit($id)
	{
		$item_master = DB::table('ITEM')->where('IDNo', $id)->first();

		if ($item_master) {
			return response()->json($item_master);
		} else {
			return response()->json(['error' => 'Record not found'], 404);
		}
	}

	public function update(Request $request, $id)
	{

		$request->validate([
			'SUB_CLASSIFICATION_ID' => 'required|integer|max:99999999999',
			'DESCRIPTION' => 'required|string|max:255', // Adjust max length
			'MODEL' => 'nullable|string|max:255', // Adjust max length
			'COLOR' => 'nullable|string|max:255', // Adjust max length
			'DIMENSION' => 'nullable|string|max:255', // Adjust max length
		]);

		DB::table('ITEM')
			->where('IDNo', $id)
			->update([
				'SUB_CLASSIFICATION_ID' => $request->SUB_CLASSIFICATION_ID,
				'MODEL' => $request->MODEL,
				'DESCRIPTION' => $request->DESCRIPTION,
				'COLOR' => $request->COLOR,
				'DIMENSION' => $request->DIMENSION,
				'EDITED_BY' => 1, // Assuming user is authenticated
				'EDITED_DT' => Carbon::now(),
			]);

		return response()->json(['success' => 'Item updated successfully']);
	}

	public function deactivate($id)
	{
		$updated = DB::table('ITEM')
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
}
