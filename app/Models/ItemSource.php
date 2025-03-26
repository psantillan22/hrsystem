<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ItemSource extends Model
{
	use HasFactory;

	protected $table = 'ITEM_SOURCE';
	protected $primaryKey = 'IDNo';
	public $timestamps = false;
	protected $fillable = ['ITEM_SOURCE', 'ENCODED_BY', 'ENCODED_DT'];
}
