<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\ClassificationController;
// use App\Http\Controllers\SubClassificationController;
// use App\Http\Controllers\ItemMasterController;
// use App\Http\Controllers\ItemSourceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryGradeController;

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

// FILE MAINTENANCE

// DEPARTMENT
Route::get('/file-maintenance/department/list', function () {
	return view('file-maintenance/department/department-list');
});

Route::get('/file-maintenance/department/group', function () {
	return view('file-maintenance/department/department-group');
});

Route::get('/department/group', [DepartmentController::class, 'group'])->name('department.group');
Route::post('/department/group/check', [DepartmentController::class, 'checkGroupDuplicate']);
Route::post('/department/group/store', [DepartmentController::class, 'group_store']);
Route::put('/department/group/{id}/deactivate', [DepartmentController::class, 'deactivateGroup']);
Route::get('/department/group/{id}/edit', [DepartmentController::class, 'editGroup'])->name('department.editGroup');
Route::put('/department/group/{id}/update', [DepartmentController::class, 'updateGroup']);

Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
Route::post('/department/store', [DepartmentController::class, 'store']);
Route::post('/department/check', [DepartmentController::class, 'checkDepartmentDuplicate']);
Route::put('/department/{id}/deactivate', [DepartmentController::class, 'deactivate']);
Route::get('/department/{id}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
Route::put('/department/{id}/update', [DepartmentController::class, 'update']);

// POSITION
Route::get('/file-maintenance/position', function () {
	return view('file-maintenance/position/position');
});

Route::get('/position', [PositionController::class, 'index']);
Route::post('/position/store', [PositionController::class, 'store']);
Route::post('/position/check', [PositionController::class, 'checkPositionDuplicate']);
Route::put('/position/{id}/deactivate', [PositionController::class, 'deactivate']);
Route::get('/position/{id}/edit', [PositionController::class, 'edit'])->name('position.edit');
Route::put('/position/{id}/update', [PositionController::class, 'update']);

// SALARY GRADE
Route::get('/file-maintenance/salary-grade', function () {
	return view('file-maintenance/salary-grade/salary-grade');
});

Route::get('/salary-grade', [SalaryGradeController::class, 'index']);
Route::post('/salary-grade/store', [SalaryGradeController::class, 'store']);
Route::get('/salary-grade/{id}/edit', [SalaryGradeController::class, 'edit']);
Route::put('/salary-grade/{id}/update', [SalaryGradeController::class, 'update']);
Route::put('/salary-grade/{id}/deactivate', [SalaryGradeController::class, 'deactivate']);



// Route::get('/user/permission', function () {
// 	return view('user-management/permission');
// });

// // File Maintenance
// Route::get('/file-maintenance/item-data/classification-list', function () {
// 	return view('file-maintenance/item-data/classification-list');
// });

// Route::get('/file-maintenance/item-data/sub-classification-list', function () {
// 	return view('file-maintenance/item-data/sub-classification-list');
// });

// Route::get('/file-maintenance/item-data/item-master-list', function () {
// 	return view('file-maintenance/item-data/item-master-list');
// });

// Route::get('/file-maintenance/item-data/item-source-list', function () {
// 	return view('file-maintenance/item-data/item-source-list');
// });

// // Classification Module
// Route::get('/classifications', [ClassificationController::class, 'index'])->name('classifications.index');
// Route::get('/classifications/data', [ClassificationController::class, 'getClassifications'])->name('classifications.data');
// Route::post('/classification/store', [ClassificationController::class, 'store']);
// Route::get('/classification/{id}/edit', [ClassificationController::class, 'edit'])->name('classification.edit');
// Route::put('/classification/{id}/update', [ClassificationController::class, 'update']);
// Route::put('/classification/{id}/deactivate', [ClassificationController::class, 'deactivate']);
// Route::post('/classification/check', [ClassificationController::class, 'checkDuplicate']);
// Route::get('/classification/list', [ClassificationController::class, 'loadClassification']);


// //Sub Classification Module
// Route::get('/sub_classification', [SubClassificationController::class, 'index'])->name('sub_classifications.index');
// Route::get('/sub_classification/data', [SubClassificationController::class, 'getSubClassifications'])->name('sub_classifications.data');
// Route::post('/sub_classification/store', [SubClassificationController::class, 'store']);
// Route::post('/sub_classification/check', [SubClassificationController::class, 'checkDuplicate']);
// Route::get('/sub_classification/{id}/edit', [SubClassificationController::class, 'edit'])->name('sub_classifications.edit');
// Route::put('/sub_classification/{id}/update', [SubClassificationController::class, 'update']);
// Route::put('/sub_classification/{id}/deactivate', [SubClassificationController::class, 'deactivate']);
// Route::get('/sub_classification/list', [SubClassificationController::class, 'loadSubClassification']);


// //Item Master Data Module
// Route::get('/item_master', [ItemMasterController::class, 'index'])->name('item_master.index');
// Route::get('/item_master/data', [ItemMasterController::class, 'getItemMaster'])->name('item_master.data');
// Route::post('/item_master/store', [ItemMasterController::class, 'store']);
// Route::post('/item_master/check', [ItemMasterController::class, 'checkDuplicate']);
// Route::get('/item_master/{id}/edit', [ItemMasterController::class, 'edit'])->name('item_master.edit');
// Route::put('/item_master/{id}/update', [ItemMasterController::class, 'update']);
// Route::put('/item_master/{id}/deactivate', [ItemMasterController::class, 'deactivate']);

// //Source Data Module
// Route::get('/item_source', [ItemSourceController::class, 'index'])->name('item_source.index');
// Route::get('/item_source/data', [ItemSourceController::class, 'getItemSource'])->name('item_source.data');
// Route::post('/item_source/store', [ItemSourceController::class, 'store']);
// Route::post('/item_source/check', [ItemSourceController::class, 'checkDuplicate']);
// Route::get('/item_source/{id}/edit', [ItemSourceController::class, 'edit'])->name('item_source.edit');
// Route::put('/item_source/{id}/update', [ItemSourceController::class, 'update']);
// Route::put('/item_source/{id}/deactivate', [ItemSourceController::class, 'deactivate']);
