<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubClassification extends Model
{
	use HasFactory;

	protected $table = 'SUB_CLASSIFICATION'; // Ensure this matches your DB table name
	protected $primaryKey = 'IDNo';
	public $timestamps = false;
	protected $fillable = ['CLASSIFICATION_ID', 'SUB_CLASSIFICATION', 'ENCODED_BY', 'ENCODED_DT'];
}
