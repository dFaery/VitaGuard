<?php

use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    #region API ROUTES (TEMPORARY)
    #endregion

    #region VIEW ROUTES     
    Route::get('admin/home', [HomeController::class, 'adminIndex'])->name('admin.home');
    #endregion
});