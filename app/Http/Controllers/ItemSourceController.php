<?php

namespace App\Http\Controllers;

use App\Models\ItemSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class ItemSourceController extends Controller
{
	// Returns the Blade view
	public function index()
	{
		return view('item_source'); // Make sure 'Item Source.blade.php' exists
	}

	// Returns JSON data for DataTables
	public function getItemSource(Request $request)
	{
		try {
			$item_source = DB::table('ITEM_SOURCE')->where('ACTIVE', 1)->get(); // Fetch from database

			return response()->json([
				'draw' => intval($request->input('draw', 1)),
				'recordsTotal' => count($item_source),
				'recordsFiltered' => count($item_source),
				'data' => $item_source,
			]);
		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function store(Request $request)
	{
		$request->validate([
			'ITEM_SOURCE' => 'required|string|max:255',
		]);

		ItemSource::create([
			'ITEM_SOURCE' => $request->ITEM_SOURCE,
			'ENCODED_BY' => 1, // Assuming user is authenticated
			'ENCODED_DT' => Carbon::now(),
		]);

		return response()->json(['success' => 'Item Source added successfully!']);
	}

	public function edit($id)
	{
		$item_source = DB::table('ITEM_SOURCE')->where('IDNo', $id)->first();

		if ($item_source) {
			return response()->json($item_source);
		} else {
			return response()->json(['error' => 'Record not found'], 404);
		}
	}
	public function update(Request $request, $id)
	{
		$request->validate([
			'ITEM_SOURCE' => 'required|string|max:255'
		]);

		DB::table('ITEM_SOURCE')
			->where('IDNo', $id)
			->update([
			'ITEM_SOURCE' => $request->ITEM_SOURCE,
				'EDITED_BY' => 1, // Change this if needed
				'EDITED_DT' => now(),
			]);

		return response()->json(['success' => 'Item Source updated successfully']);
	}

	public function deactivate($id)
	{
		$updated = DB::table('ITEM_SOURCE')
			->where('IDNo', $id)
			->update([
				'ACTIVE' => 0,
				'EDITED_BY' => 1, // Change to the authenticated user if available
				'EDITED_DT' => now()
			]);

		if ($updated) {
			return response()->json(['success' => 'Item Source marked as inactive']);
		} else {
			return response()->json(['error' => 'Failed to update item source'], 500);
		}
	}

	public function checkDuplicate(Request $request)
	{
		$exists = DB::table('ITEM_SOURCE')
			->whereRaw('LOWER(ITEM_SOURCE) = ?', [strtolower($request->ITEM_SOURCE)])
			->exists();

		return response()->json(['exists' => $exists]);
	}

	// public function loadClassification()
	// {
	// 	$data = Classification::where('ACTIVE', 1)->orderBy('CLASSIFICATION', 'asc')->get(); // Fetch all classification data
	// 	return response()->json($data);
	// }
}
