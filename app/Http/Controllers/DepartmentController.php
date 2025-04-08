<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentGroup;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department = DB::table('department')
        ->join('department_group', 'department.group_id', '=', 'department_group.id') // Join to get classification description
        ->select(
            'department.*',
            'department.id AS department_id',
            'department_group.*',
        )
        ->where('department.status', 1) // Ensure filtering by active status
        ->get();

        return response()->json(['success' => true, 'data' => $department]);
    }


    public function group()
    {
        $groups = DepartmentGroup::where('status', 1)->get();

        return response()->json(['success' => true, 'data' => $groups]);
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

    public function checkGroupDuplicate(Request $request)
    {
        $exists = DB::table('department_group')
        ->whereRaw('LOWER(group_name) = ?', [strtolower($request->group_name)])
        ->where('status', 1)
        ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function checkDepartmentDuplicate(Request $request)
    {
        $exists = DB::table('department')
        ->whereRaw('LOWER(description) = ?', [strtolower($request->description)])
        ->where('status', 1)
        ->exists();

        return response()->json(['exists' => $exists]);
    }
    public function group_store(Request $request)
    {
        $request->validate([
			'group_name' => 'required|string|max:255',
		]);

		DepartmentGroup::create([
			
            'group_name' => $request->group_name,
			'headed_by' => 1,
			'created_by' => 1, 
			'updated_by' => 1, 
			'created_at' => now(), 
			'updated_at' => now(), 
		]);

		return response()->json(['success' => 'Group name added successfully!']);
    }

    public function store(Request $request)
    {
        $request->validate([
			'description' => 'required|string|max:255',
			'group' => 'required',
		]);

		Department::create([
			'description' => $request->description,
			'group_id' => $request->group,
			'headed_by' => 1,
			'created_by' => 1, 
			'updated_by' => 1, 
			'created_at' => now(), 
			'updated_at' => now(), 
		]);

		return response()->json(['success' => 'Department added successfully!']);
    }

    public function deactivate($id)
	{
		$updated = DB::table('department')
			->where('id', $id)
			->update([
				'status' => 0,
				'updated_by' => 1, 
				'updated_at' => now()
			]);

		if ($updated) {
			return response()->json(['success' => 'Department marked as inactive']);
		} else {
			return response()->json(['error' => 'Failed to update department'], 500);
		}
	}

    public function deactivateGroup($id)
	{
		$updated = DB::table('department_group')
			->where('id', $id)
			->update([
				'status' => 0,
				'updated_by' => 1, 
				'updated_at' => now()
			]);

		if ($updated) {
			return response()->json(['success' => 'Group marked as inactive']);
		} else {
			return response()->json(['error' => 'Failed to update group'], 500);
		}
	}

    public function editGroup($id)
	{
		$group = DB::table('department_group')->where('id', $id)->first();

		if ($group) {
			return response()->json($group);
		} else {
			return response()->json(['error' => 'Record not found'], 404);
		}
	}

    public function edit($id)
	{
		$department = DB::table('department')->where('id', $id)->first();

		if ($department) {
			return response()->json($department);
		} else {
			return response()->json(['error' => 'Record not found'], 404);
		}
	}

    public function updateGroup(Request $request, $id)
	{
        $request->validate([
			'group_name' => 'required|string|max:255',
		]);

		DB::table('department_group')
			->where('id', $id)
			->update([
				'group_name' => $request->group_name,
				'updated_by' => 1, // Change this if needed
				'updated_at' => now(),
			]);

		return response()->json(['success' => 'Group updated successfully']);
	}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
			'description' => 'required|string|max:255',
			'group' => 'required',
		]);

		DB::table('department')
			->where('id', $id)
			->update([
				'description' => $request->description,
				'group_id' => $request->group,
				'updated_by' => 1, // Change this if needed
				'updated_at' => now(),
			]);

		return response()->json(['success' => 'Department updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
