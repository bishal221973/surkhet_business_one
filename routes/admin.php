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

    Route::prefix('payment-modes')->group(function () {
        Route::get('/', [App\Http\Controllers\PaymentModeController::class, 'index'])->name('paymentMode.index');
        Route::get('/create', [App\Http\Controllers\PaymentModeController::class, 'create'])->name('paymentMode.create');
        Route::post('store', [App\Http\Controllers\PaymentModeController::class, 'store'])->name('paymentMode.store');
        Route::get('edit/{id}', [App\Http\Controllers\PaymentModeController::class, 'edit'])->name('paymentMode.edit');
        Route::put('update/{id}', [App\Http\Controllers\PaymentModeController::class, 'update'])->name('paymentMode.update');
        Route::delete('destroy/{id}', [App\Http\Controllers\PaymentModeController::class, 'destroy'])->name('paymentMode.destroy');
    });

    Route::prefix('banks')->group(function () {
        Route::get('/', [App\Http\Controllers\BankController::class, 'index'])->name('bank.index');
        Route::get('/create', [App\Http\Controllers\BankController::class, 'create'])->name('bank.create');
        Route::post('store', [App\Http\Controllers\BankController::class, 'store'])->name('bank.store');
        Route::get('edit/{id}', [App\Http\Controllers\BankController::class, 'edit'])->name('bank.edit');
        Route::put('update/{id}', [App\Http\Controllers\BankController::class, 'update'])->name('bank.update');
        Route::delete('destroy/{id}', [App\Http\Controllers\BankController::class, 'destroy'])->name('bank.destroy');
    });

    Route::prefix('expense-head')->group(function () {
        Route::get('/', [App\Http\Controllers\ExpenseCategoryController::class, 'index'])->name('expenseCategory.index');
        Route::get('/create', [App\Http\Controllers\ExpenseCategoryController::class, 'create'])->name('expenseCategory.create');
        Route::post('store', [App\Http\Controllers\ExpenseCategoryController::class, 'store'])->name('expenseCategory.store');
        Route::get('edit/{id}', [App\Http\Controllers\ExpenseCategoryController::class, 'edit'])->name('expenseCategory.edit');
        Route::put('update/{id}', [App\Http\Controllers\ExpenseCategoryController::class, 'update'])->name('expenseCategory.update');
        Route::delete('destroy/{id}', [App\Http\Controllers\ExpenseCategoryController::class, 'destroy'])->name('expenseCategory.destroy');
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

Route::prefix('projects')->group(function () {
    Route::get('/', [App\Http\Controllers\ProjectController::class, 'index'])->name('project.index');
    Route::get('/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('project.create');
    Route::post('store', [App\Http\Controllers\ProjectController::class, 'store'])->name('project.store');
    Route::get('edit/{id}', [App\Http\Controllers\ProjectController::class, 'edit'])->name('project.edit');
    Route::put('update/{id}', [App\Http\Controllers\ProjectController::class, 'update'])->name('project.update');
    Route::delete('destroy/{id}', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('project.destroy');
});

Route::prefix('invoices')->group(function () {
    Route::get('/', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/create', [App\Http\Controllers\InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('store', [App\Http\Controllers\InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('edit/{id}', [App\Http\Controllers\InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('update/{id}', [App\Http\Controllers\InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('destroy/{id}', [App\Http\Controllers\InvoiceController::class, 'destroy'])->name('invoice.destroy');
});

Route::prefix('payments')->group(function () {
    Route::get('/', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
    Route::get('/create', [App\Http\Controllers\PaymentController::class, 'create'])->name('payment.create');
    Route::post('store', [App\Http\Controllers\PaymentController::class, 'store'])->name('payment.store');
    Route::get('edit/{id}', [App\Http\Controllers\PaymentController::class, 'edit'])->name('payment.edit');
    Route::put('update/{id}', [App\Http\Controllers\PaymentController::class, 'update'])->name('payment.update');
    Route::delete('destroy/{id}', [App\Http\Controllers\PaymentController::class, 'destroy'])->name('payment.destroy');
});

Route::prefix('expense')->group(function () {
    Route::get('/', [App\Http\Controllers\ExpenseController::class, 'index'])->name('expense.index');
    Route::get('/create', [App\Http\Controllers\ExpenseController::class, 'create'])->name('expense.create');
    Route::post('store', [App\Http\Controllers\ExpenseController::class, 'store'])->name('expense.store');
    Route::get('edit/{id}', [App\Http\Controllers\ExpenseController::class, 'edit'])->name('expense.edit');
    Route::put('update/{id}', [App\Http\Controllers\ExpenseController::class, 'update'])->name('expense.update');
    Route::delete('destroy/{id}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('expense.destroy');
});


Route::prefix('income')->group(function () {
    Route::get('/', [App\Http\Controllers\IncomeController::class, 'index'])->name('income.index');
    Route::get('/create', [App\Http\Controllers\IncomeController::class, 'create'])->name('income.create');
    Route::post('store', [App\Http\Controllers\IncomeController::class, 'store'])->name('income.store');
    Route::get('edit/{id}', [App\Http\Controllers\IncomeController::class, 'edit'])->name('income.edit');
    Route::put('update/{id}', [App\Http\Controllers\IncomeController::class, 'update'])->name('income.update');
    Route::delete('destroy/{id}', [App\Http\Controllers\IncomeController::class, 'destroy'])->name('income.destroy');
});


