<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', \App\Livewire\Dashboard::class)->name('home');

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
    Route::get('/documents/{id}/pdf', [\App\Http\Controllers\DocumentController::class, 'getViewPdf'])->name('documents.pdf');

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

    // Silabus Routes
    Route::get('/documents/{document_id}/silabus', [\App\Http\Controllers\SilabusController::class, 'index'])->name('silabus.index');
    Route::get('/documents/{document_id}/silabus/create', [\App\Http\Controllers\SilabusController::class, 'create'])->name('silabus.create');
    Route::get('/documents/{document_id}/silabus/create/{unit_kompetensi_id}', [\App\Http\Controllers\SilabusController::class, 'createUnit'])->name('silabus.create.unit');
    Route::post('/documents/{document_id}/silabus', [\App\Http\Controllers\SilabusController::class, 'store'])->name('silabus.store');
    Route::post('/documents/{document_id}/silabus/{unit_kompetensi_id}', [\App\Http\Controllers\SilabusController::class, 'storeUnit'])->name('silabus.store.unit');
    Route::get('/documents/{document_id}/silabus/{unit_kompetensi_id}/edit', [\App\Http\Controllers\SilabusController::class, 'editUnit'])->name('silabus.edit.unit');
    Route::put('/documents/{document_id}/silabus/{unit_kompetensi_id}/edit', [\App\Http\Controllers\SilabusController::class, 'updateUnit'])->name('silabus.update.unit');
    Route::get('/documents/{document_id}/silabus/{id}/edit', [\App\Http\Controllers\SilabusController::class, 'edit'])->name('silabus.edit');
    Route::put('/documents/{document_id}/silabus/{id}', [\App\Http\Controllers\SilabusController::class, 'update'])->name('silabus.update');
    Route::delete('/documents/{document_id}/silabus/{unit_kompetensi_id}', [\App\Http\Controllers\SilabusController::class, 'destroy'])->name('silabus.destroy.unit');

    // Lesson Plans Routes
    Route::get('/documents/{document_id}/lesson-plans', [\App\Http\Controllers\LessonPlanController::class, 'index'])->name('lesson-plans.index');
    Route::get('/documents/{document_id}/lesson-plans/create', [\App\Http\Controllers\LessonPlanController::class, 'create'])->name('lesson-plans.create');
    Route::post('/documents/{document_id}/lesson-plans', [\App\Http\Controllers\LessonPlanController::class, 'store'])->name('lesson-plans.store');
    Route::get('/documents/{document_id}/lesson-plans/{id}/edit', [\App\Http\Controllers\LessonPlanController::class, 'edit'])->name('lesson-plans.edit');
    Route::put('/documents/{document_id}/lesson-plans/{id}', [\App\Http\Controllers\LessonPlanController::class, 'update'])->name('lesson-plans.update');
    Route::delete('/documents/{document_id}/lesson-plans/{id}', [\App\Http\Controllers\LessonPlanController::class, 'destroy'])->name('lesson-plans.destroy');

    // Equipment Routes
    Route::get('/documents/{document_id}/equipments', [\App\Http\Controllers\EquipmentController::class, 'index'])->name('equipments.index');
    Route::get('/documents/{document_id}/equipments/create', [\App\Http\Controllers\EquipmentController::class, 'create'])->name('equipments.create');
    Route::delete('/documents/{document_id}/equipments/all', [\App\Http\Controllers\EquipmentController::class, 'destroyAll'])->name('equipments.destroy-all');
    Route::post('/documents/{document_id}/equipments', [\App\Http\Controllers\EquipmentController::class, 'store'])->name('equipments.store');
    Route::delete('/documents/{document_id}/equipments/{equipment_id}/details/{detail_id}', [\App\Http\Controllers\EquipmentController::class, 'destroyDetail'])->name('equipments.destroy-detail');
    Route::get('/documents/{document_id}/equipments/{id}/edit', [\App\Http\Controllers\EquipmentController::class, 'edit'])->name('equipments.edit');
    Route::put('/documents/{document_id}/equipments/{id}', [\App\Http\Controllers\EquipmentController::class, 'update'])->name('equipments.update');
    Route::delete('/documents/{document_id}/equipments/{id}', [\App\Http\Controllers\EquipmentController::class, 'destroy'])->name('equipments.destroy');
   
    // Supply Routes
    Route::get('/documents/{document_id}/supplys', [\App\Http\Controllers\SupplyController::class, 'index'])->name('supplys.index');
    Route::get('/documents/{document_id}/supplys/create', [\App\Http\Controllers\SupplyController::class, 'create'])->name('supplys.create');
    Route::delete('/documents/{document_id}/supplys/all', [\App\Http\Controllers\SupplyController::class, 'destroyAll'])->name('supplys.destroy-all');
    Route::post('/documents/{document_id}/supplys', [\App\Http\Controllers\SupplyController::class, 'store'])->name('supplys.store');
    Route::delete('/documents/{document_id}/supplys/{supply_id}/details/{detail_id}', [\App\Http\Controllers\SupplyController::class, 'destroyDetail'])->name('supplys.destroy-detail');
    Route::get('/documents/{document_id}/supplys/{id}/edit', [\App\Http\Controllers\SupplyController::class, 'edit'])->name('supplys.edit');
    Route::put('/documents/{document_id}/supplys/{id}', [\App\Http\Controllers\SupplyController::class, 'update'])->name('supplys.update');
    Route::delete('/documents/{document_id}/supplys/{id}', [\App\Http\Controllers\SupplyController::class, 'destroy'])->name('supplys.destroy');
});
