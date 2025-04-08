<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
	use HasFactory;

	protected $table = 'department';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = ['description', 'group_id', 'headed_by', 'status','created_by', 'updated_by', 'created_at', 'updated_at'];
}
