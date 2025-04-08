<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Position extends Model
{
	use HasFactory;

	protected $table = 'position';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = ['position_name', 'job_description', 'status','created_by', 'updated_by', 'created_at', 'updated_at'];
}
