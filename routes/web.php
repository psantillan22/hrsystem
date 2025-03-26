<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\SubClassificationController;
use App\Http\Controllers\ItemMasterController;
use App\Http\Controllers\ItemSourceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
	return view('login');
});

Route::get('/dashboard', function () {
	return view('dashboard');
});

Route::get('/user/account-list', function () {
	return view('user-management/account-list');
});

Route::get('/user/permission', function () {
	return view('user-management/permission');
});

// File Maintenance
Route::get('/file-maintenance/item-data/classification-list', function () {
	return view('file-maintenance/item-data/classification-list');
});

Route::get('/file-maintenance/item-data/sub-classification-list', function () {
	return view('file-maintenance/item-data/sub-classification-list');
});

Route::get('/file-maintenance/item-data/item-master-list', function () {
	return view('file-maintenance/item-data/item-master-list');
});

Route::get('/file-maintenance/item-data/item-source-list', function () {
	return view('file-maintenance/item-data/item-source-list');
});

// Classification Module
Route::get('/classifications', [ClassificationController::class, 'index'])->name('classifications.index');
Route::get('/classifications/data', [ClassificationController::class, 'getClassifications'])->name('classifications.data');
Route::post('/classification/store', [ClassificationController::class, 'store']);
Route::get('/classification/{id}/edit', [ClassificationController::class, 'edit'])->name('classification.edit');
Route::put('/classification/{id}/update', [ClassificationController::class, 'update']);
Route::put('/classification/{id}/deactivate', [ClassificationController::class, 'deactivate']);
Route::post('/classification/check', [ClassificationController::class, 'checkDuplicate']);
Route::get('/classification/list', [ClassificationController::class, 'loadClassification']);


//Sub Classification Module
Route::get('/sub_classification', [SubClassificationController::class, 'index'])->name('sub_classifications.index');
Route::get('/sub_classification/data', [SubClassificationController::class, 'getSubClassifications'])->name('sub_classifications.data');
Route::post('/sub_classification/store', [SubClassificationController::class, 'store']);
Route::post('/sub_classification/check', [SubClassificationController::class, 'checkDuplicate']);
Route::get('/sub_classification/{id}/edit', [SubClassificationController::class, 'edit'])->name('sub_classifications.edit');
Route::put('/sub_classification/{id}/update', [SubClassificationController::class, 'update']);
Route::put('/sub_classification/{id}/deactivate', [SubClassificationController::class, 'deactivate']);
Route::get('/sub_classification/list', [SubClassificationController::class, 'loadSubClassification']);


//Item Master Data Module
Route::get('/item_master', [ItemMasterController::class, 'index'])->name('item_master.index');
Route::get('/item_master/data', [ItemMasterController::class, 'getItemMaster'])->name('item_master.data');
Route::post('/item_master/store', [ItemMasterController::class, 'store']);
Route::post('/item_master/check', [ItemMasterController::class, 'checkDuplicate']);
Route::get('/item_master/{id}/edit', [ItemMasterController::class, 'edit'])->name('item_master.edit');
Route::put('/item_master/{id}/update', [ItemMasterController::class, 'update']);
Route::put('/item_master/{id}/deactivate', [ItemMasterController::class, 'deactivate']);

//Source Data Module
Route::get('/item_source', [ItemSourceController::class, 'index'])->name('item_source.index');
Route::get('/item_source/data', [ItemSourceController::class, 'getItemSource'])->name('item_source.data');
Route::post('/item_source/store', [ItemSourceController::class, 'store']);
Route::post('/item_source/check', [ItemSourceController::class, 'checkDuplicate']);
Route::get('/item_source/{id}/edit', [ItemSourceController::class, 'edit'])->name('item_source.edit');
Route::put('/item_source/{id}/update', [ItemSourceController::class, 'update']);
Route::put('/item_source/{id}/deactivate', [ItemSourceController::class, 'deactivate']);
