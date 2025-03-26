<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Classification extends Model
{
	use HasFactory;

	protected $table = 'CLASSIFICATION';
	protected $primaryKey = 'IDNo';
	public $timestamps = false;
	protected $fillable = ['CLASSIFICATION', 'ENCODED_BY', 'ENCODED_DT'];
}
