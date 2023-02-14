<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CaseController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FamilyCompositionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskTypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CaseVersionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\HealthCheckController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('tasks/export', [TaskController::class, 'export']);

Route::get('reports/export', [ReportController::class, 'export']);
Route::get('reports/export/{report}', [ReportController::class, 'exportReport']);
Route::get('reports/export-pdf/{report}', [ReportController::class, 'exportPdfReport']);

Route::get('metrics/export', [MetricsController::class, 'export']);
Route::get('metrics/export/{metrics}', [MetricsController::class, 'exportMetrics']);
Route::get('health', [HealthCheckController::class, 'healthCheck']);

Route::group(['middleware' => 'auth:api'], function () {

    // Users
    Route::resource('users', UserController::class)->names([
        'index'
    ]);

    // BICases
    Route::resource('cases', CaseController::class)->names([
        'index', 'show', 'store', 'update', 'destroy'
    ]);
    Route::post('cases/check', [CaseController::class, 'check']);
    Route::put('cases/restore/{id}', [CaseController::class, 'restore']);
    Route::post('cases/init', [CaseController::class, 'init']);
    Route::get('cases/guid/{guid}', [CaseController::class, 'getByGUID']);

    // CaseVersions
    Route::resource('case-versions', CaseVersionController::class)->names([
        'index'
    ]);
    Route::put('case-versions/update/{hash}', [CaseVersionController::class, 'update']);

    // Files
    Route::post('files/upload', [FileController::class, 'upload']);
    Route::post('files/case/upload', [FileController::class, 'caseFileUpload']);

    // Products
    Route::resource('products', ProductController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    // Categories
    Route::resource('categories', CategoryController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    // Sections
    Route::resource('sections', SectionController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    Route::post('/catalog/link', [CatalogController::class, 'link']);
    Route::get('/catalog/tree', [CatalogController::class, 'getTree']);

    //  Family Composition
    Route::resource('family-compositions', FamilyCompositionController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    // Metrics
    Route::resource('metrics', MetricsController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    //  Tasks
    Route::get('tasks/creators', [TaskController::class, 'creators']);
    Route::get('tasks/executors', [TaskController::class, 'executors']);
    Route::resource('tasks', TaskController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    //  Task types
    Route::resource('task-types', TaskTypeController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    Route::post('/catalog/link', [CatalogController::class, 'link']);
    Route::get('/catalog/tree', [CatalogController::class, 'getTree']);
    Route::get('catalog/categories', [CatalogController::class, 'categories']);
    Route::get('/sections/{id}/categories', [SectionController::class, 'withCategories']);

    // REPORTS
    Route::get('reports/authors', [ReportController::class, 'authors']);
    Route::resource('reports', ReportController::class)->names([
        'index', 'show', 'store', 'update', 'destroy'
    ]);
    Route::post('/reports/init', [ReportController::class, 'init']);
});


Route::get('files/{caseHash}/{fileHash}', [FileController::class, 'get']);

Route::get('files/{fileHash}', [FileController::class, 'downloadPlugin']);
