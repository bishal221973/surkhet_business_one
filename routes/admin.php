<?php

// use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('setting')->group(function () {
    Route::get('organizational-setting', [App\Http\Controllers\OrganizationController::class, 'index'])->name('organization.setting');
    Route::post('organizational-setting', [App\Http\Controllers\OrganizationController::class, 'save'])->name('organization.setting.store');

    Route::get('email-setting', [App\Http\Controllers\EmailSettingController::class, 'index'])->name('email.setting');
    Route::post('email-setting', [App\Http\Controllers\EmailSettingController::class, 'save'])->name('email.setting.store');
    Route::post('send-demo-email', [App\Http\Controllers\EmailSettingController::class, 'demoMail'])->name('email.setting.demo.mail');
    Route::get('my-profile', [App\Http\Controllers\UserController::class, 'myProfile'])->name('user.my.profile');
    Route::put('my-profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('user.profile.update');

    Route::prefix('fiscal-year')->group(function () {
        Route::get('/', [App\Http\Controllers\FiscalyearController::class, 'index'])->name('fiscalyear.index');
        Route::post('store', [App\Http\Controllers\FiscalyearController::class, 'store'])->name('fiscalyear.store');
        Route::get('edit/{id}', [App\Http\Controllers\FiscalyearController::class, 'edit'])->name('fiscalyear.edit');
        Route::put('update/{id}', [App\Http\Controllers\FiscalyearController::class, 'update'])->name('fiscalyear.update');
        Route::delete('destroy/{id}', [App\Http\Controllers\FiscalyearController::class, 'destroy'])->name('fiscalyear.destroy');
    });
});


Route::prefix('human-resource')->group(function () {
    Route::prefix('role')->group(function () {
        Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('role.index');
        Route::post('store', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');
        Route::get('edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit');
        Route::put('update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('role.update');
        Route::delete('destroy/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('role.destroy');
    });

    Route::prefix('permission')->group(function () {
        Route::get('/{roleId}', [App\Http\Controllers\PermissionController::class, 'index'])->name('permission.index');
        Route::post('store', [App\Http\Controllers\PermissionController::class, 'store'])->name('permission.store');
        Route::get('edit/{id}', [App\Http\Controllers\PermissionController::class, 'edit'])->name('permission.edit');
        Route::put('update/{id}', [App\Http\Controllers\PermissionController::class, 'update'])->name('permission.update');
        Route::delete('destroy/{id}', [App\Http\Controllers\PermissionController::class, 'destroy'])->name('permission.destroy');
    });

    Route::prefix('employee')->group(function () {
        Route::get('/', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.index');
        Route::post('store', [App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.store');
        Route::get('edit/{employee}', [App\Http\Controllers\EmployeeController::class, 'edit'])->name('employee.edit');
        Route::put('update/{employee}', [App\Http\Controllers\EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('destroy/{employee}', [App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employee.destroy');
        Route::post('/employee/status-toggle', [App\Http\Controllers\EmployeeController::class, 'toggleStatus'])
            ->name('employee.status.toggle');

    });
});


Route::prefix('clients')->group(function () {
    Route::get('/', [App\Http\Controllers\ClientController::class, 'index'])->name('client.index');
    Route::post('store', [App\Http\Controllers\ClientController::class, 'store'])->name('client.store');
    Route::get('edit/{id}', [App\Http\Controllers\ClientController::class, 'edit'])->name('client.edit');
    Route::put('update/{id}', [App\Http\Controllers\ClientController::class, 'update'])->name('client.update');
    Route::delete('destroy/{id}', [App\Http\Controllers\ClientController::class, 'destroy'])->name('client.destroy');
});
