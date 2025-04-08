<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SalaryGrade extends Model
{
	use HasFactory;

	protected $table = 'salary_grade';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = ['description', 'salary_type', 'date_start', 'date_end', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}
