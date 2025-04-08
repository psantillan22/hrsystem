<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalaryGrade;
use App\Models\SalaryGradeAmount;
use Illuminate\Support\Facades\DB;

class SalaryGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sg = SalaryGrade::where('status', 1)->get();

        return response()->json(['success' => true, 'data' => $sg]);
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
			'description' => 'required|string|max:255',
			'salary_type' => 'required',
			'date_start' => 'required',
			'date_end' => 'required',
		]);

		SalaryGrade::create([
			'description' => $request->description,
			'salary_type' => $request->salary_type,
			'date_start' => $request->date_start,
			'date_end' => $request->date_end,
			'created_by' => 1, 
			'updated_by' => 1, 
			'created_at' => now(), 
			'updated_at' => now(), 
		]);

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
    public function edit(string $id)
    {
        $sg = DB::table('salary_grade')->where('id', $id)->first();

		if ($sg) {
			return response()->json($sg);
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
			'description' => 'required|string|max:255',
			'salary_type' => 'required',
			'date_start' => 'required',
			'date_end' => 'required',
		]);

		DB::table('salary_grade')
			->where('id', $id)
			->update([
				'description' => $request->description,
				'salary_type' => $request->salary_type,
				'date_start' => $request->date_start,
				'date_end' => $request->date_end,
				'updated_by' => 1, // Change this if needed
				'updated_at' => now(),
			]);

		return response()->json(['success' => 'Salary Grade updated successfully']);
    }

    public function deactivate($id)
	{
		$updated = DB::table('salary_grade')
			->where('id', $id)
			->update([
				'status' => 0,
				'updated_by' => 1, 
				'updated_at' => now()
			]);

		if ($updated) {
			return response()->json(['success' => 'Salary Grade marked as inactive']);
		} else {
			return response()->json(['error' => 'Failed to update department'], 500);
		}
	}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
