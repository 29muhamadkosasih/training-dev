<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('setting-apps', [\App\Http\Controllers\SettingAppController::class, 'index'])->name('setting_apps.index');
    Route::get('setting-apps/edit', [\App\Http\Controllers\SettingAppController::class, 'edit'])->name('setting_apps.edit');
    Route::put('setting-apps/update', [\App\Http\Controllers\SettingAppController::class, 'update'])->name('setting_apps.update');

    Route::get('/products', \App\Livewire\Product\Index::class)->name('products.index')->middleware('permission:products.index|products.delete|products.edit|products.create');
    Route::get('/permissions', \App\Livewire\Permission\Index::class)->name('permissions.index')->middleware('permission:permissions.index|permissions.delete|permissions.edit|permissions.create');
    Route::get('/users', \App\Livewire\User\Index::class)->name('users.index')->middleware('permission:users.index|users.delete|users.edit|users.create');

    Route::get('/roles', \App\Livewire\Role\Index::class)->name('roles.index')->middleware('permission:roles.index|roles.delete');
    Route::get('/roles/create', \App\Livewire\Role\Create::class)->name('roles.create')->middleware('permission:roles.create');
    Route::get('/roles/{id}/edit', \App\Livewire\Role\Edit::class)->name('roles.edit')->middleware('permission:roles.edit');


    Route::get('/schemes', \App\Livewire\Scheme\Index::class)->name('schemes.index')->middleware('permission:schemes.index');
    Route::get('/competencies', \App\Livewire\Competence\Index::class)->name('competencies.index')->middleware('permission:competencies.index');
    Route::get('/competencies-pdf/{id}', [\App\Http\Controllers\CompetenceController::class, 'getViewPdf'])->name('competencies.get.pdf');

    Route::get('/documents', \App\Livewire\Document\Index::class)->name('documents.index')->middleware('permission:documents.index');
    Route::get('/documents/create', \App\Livewire\Document\Create::class)->name('documents.create')->middleware('permission:documents.create');
    Route::get('/documents/{id}/show', \App\Livewire\Document\Show::class)->name('documents.show')->middleware('permission:documents.show');
    Route::post('/documents', [\App\Http\Controllers\DocumentController::class, 'store'])->name('document.store')->middleware('permission:documents.create');

    // General Information Routes
    Route::get('/documents/{document_id}/general-informations', [\App\Http\Controllers\GeneralInformationController::class, 'index'])->name('general-informations.index');
    Route::get('/documents/{document_id}/general-informations/create', [\App\Http\Controllers\GeneralInformationController::class, 'create'])->name('general-informations.create');
    Route::post('/documents/{document_id}/general-informations', [\App\Http\Controllers\GeneralInformationController::class, 'store'])->name('general-informations.store');
    Route::get('/documents/{document_id}/general-informations/{id}/edit', [\App\Http\Controllers\GeneralInformationController::class, 'edit'])->name('general-informations.edit');
    Route::put('/documents/{document_id}/general-informations/{id}', [\App\Http\Controllers\GeneralInformationController::class, 'update'])->name('general-informations.update');
    Route::delete('/documents/{document_id}/general-informations/{id}', [\App\Http\Controllers\GeneralInformationController::class, 'destroy'])->name('general-informations.destroy');

    // Curriculum Routes
    Route::get('/documents/{document_id}/curricula', [\App\Http\Controllers\CurriculumController::class, 'index'])->name('curricula.index');
    Route::get('/documents/{document_id}/curricula/create', [\App\Http\Controllers\CurriculumController::class, 'create'])->name('curricula.create');
    Route::post('/documents/{document_id}/curricula', [\App\Http\Controllers\CurriculumController::class, 'store'])->name('curricula.store');
    Route::get('/documents/{document_id}/curricula/{id}/edit', [\App\Http\Controllers\CurriculumController::class, 'edit'])->name('curricula.edit');
    Route::put('/documents/{document_id}/curricula/{id}', [\App\Http\Controllers\CurriculumController::class, 'update'])->name('curricula.update');
    Route::delete('/documents/{document_id}/curricula/{id}', [\App\Http\Controllers\CurriculumController::class, 'destroy'])->name('curricula.destroy');
});
