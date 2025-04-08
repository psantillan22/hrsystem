<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DepartmentGroup extends Model
{
	use HasFactory;

	protected $table = 'department_group';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = ['group_name', 'headed_by', 'status','created_by', 'updated_by', 'created_at', 'updated_at'];
}
