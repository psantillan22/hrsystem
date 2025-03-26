<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Builder\FallbackBuilder;

class ItemMaster extends Model
{
	use HasFactory;

	protected $table = 'ITEM';
	protected $primaryKey = 'IDNo';
	protected $fillable = ['SUB_CLASSIFICATION_ID', 'DESCRIPTION', 'MODEL', 'COLOR', 'DIMENSION', 'ENCODED_BY', 'ENCODED_DT'];

	public $timestamps = false;
}
