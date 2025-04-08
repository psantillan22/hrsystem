<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SalaryGradeAmount extends Model
{
	use HasFactory;

	protected $table = 'salary_grade_amount';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = ['sg_id', 'tranche', 'step', 'amount', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}
