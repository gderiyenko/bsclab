<?php

use App\Http\Controllers\ActController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FirmController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Log\ActLogController;
use App\Http\Controllers\Log\AuthLogController;
use App\Http\Controllers\Log\ContractLogController;
use App\Http\Controllers\Log\FirmLogController;
use App\Http\Controllers\Log\InvoiceLogController;
use App\Http\Controllers\Log\PaymentLogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        Route::post('register', [AuthController::class, 'register']);
        // Login User
        Route::post('login', [AuthController::class, 'login']);

        // Refresh the JWT Token
        Route::get('refresh', [AuthController::class, 'refresh']);

        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user', [AuthController::class, 'user']);
            // Logout user from application
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });
});

Route::group(['middleware' => ['auth', 'checkUserRole:admin,accountant,worker']], function () {
    Route::prefix('firms')->group(function () {
        Route::get('/', [FirmController::class, 'index']);
        Route::get('/noActs', [FirmController::class, 'noActs']);
        Route::get('show/{id}', [FirmController::class, 'show']);
    });

    Route::prefix('contracts')->group(function () {
        Route::get('/', [ContractController::class, 'index']);
        Route::get('show/{id}', [ContractController::class, 'show']);
    });

    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index']);
        Route::get('show/{id}', [InvoiceController::class, 'show']);
    });

    Route::prefix('acts')->group(function () {
        Route::get('/', [ActController::class, 'index']);
        Route::get('show/{id}', [ActController::class, 'show']);
    });

    Route::prefix('files')->group(function () {
        Route::get('show/{id}', [FileController::class, 'show']);
    });

    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index']);
        Route::get('show/{id}', [PaymentController::class, 'show']);
    });

    Route::prefix('templates')->group(function () {
        Route::get('/', [TemplateController::class, 'index']);
        Route::get('show/{type}', [TemplateController::class, 'show']);
        Route::post('download/{id}', [TemplateController::class, 'download']);
    });

    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index']);
    });
});

Route::group(['middleware' => ['auth', 'checkUserRole:admin']], function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('create', [UserController::class, 'create']);
        Route::get('edit/{id}', [UserController::class, 'edit']);
        Route::post('update/{id}', [UserController::class, 'update']);
        Route::delete('delete/{id}', [UserController::class, 'destroy']);
        Route::get('log', [AuthLogController::class, 'index']);
    });

    Route::prefix('firms')->group(function () {
        Route::delete('delete/{id}', [FirmController::class, 'destroy']);
    });

    Route::prefix('contracts')->group(function () {
        Route::delete('delete/{id}', [ContractController::class, 'destroy']);
    });

    Route::prefix('invoices')->group(function () {
        Route::delete('delete/{id}', [InvoiceController::class, 'destroy']);
    });

    Route::prefix('acts')->group(function () {
        Route::delete('delete/{id}', [ActController::class, 'destroy']);
    });

    Route::prefix('files')->group(function () {
        Route::delete('delete/{id}', [FileController::class, 'destroy']);
    });

    Route::prefix('payments')->group(function () {
        Route::delete('delete/{id}', [PaymentController::class, 'destroy']);
    });

    Route::prefix('services')->group(function () {
        Route::delete('delete/{id}', [ServiceController::class, 'destroy']);
    });
});

Route::group(['middleware' => ['auth', 'checkUserRole:admin,accountant']], function () {
    Route::prefix('firms')->group(function () {
        Route::post('create', [FirmController::class, 'create']);
        Route::get('edit/{id}', [FirmController::class, 'edit']);
        Route::post('update/{id}', [FirmController::class, 'update']);
    });

    Route::prefix('contracts')->group(function () {
        Route::post('{id}/create', [ContractController::class, 'create']);
        Route::get('edit/{id}', [ContractController::class, 'edit']);
        Route::post('update/{id}', [ContractController::class, 'update']);
    });

    Route::prefix('invoices')->group(function () {
        Route::post('{id}/create', [InvoiceController::class, 'create']);
        Route::get('edit/{id}', [InvoiceController::class, 'edit']);
        Route::post('update/{id}', [InvoiceController::class, 'update']);
    });

    Route::prefix('acts')->group(function () {
        Route::post('{id}/create', [ActController::class, 'create']);
        Route::get('edit/{id}', [ActController::class, 'edit']);
        Route::post('update/{id}', [ActController::class, 'update']);
    });

    Route::prefix('files')->group(function () {
        Route::post('upload', [FileController::class, 'store']);
        Route::post('valid', [FileController::class, 'valid']);
    });

    Route::prefix('payments')->group(function () {
        Route::post('{id}/create', [PaymentController::class, 'create']);
        Route::get('edit/{id}', [PaymentController::class, 'edit']);
        Route::post('update/{id}', [PaymentController::class, 'update']);
    });

    Route::prefix('templates')->group(function () {
        Route::post('create', [TemplateController::class, 'create']);
        Route::get('edit/{id}', [TemplateController::class, 'edit']);
        Route::post('update/{id}', [TemplateController::class, 'update']);
        Route::delete('delete/{id}', [TemplateController::class, 'destroy']);
        Route::post('docx-create', [TemplateController::class, 'docxCreate']);
    });

    Route::prefix('services')->group(function () {
        Route::post('create', [ServiceController::class, 'create']);
        Route::get('edit/{id}', [ServiceController::class, 'edit']);
        Route::post('update/{id}', [ServiceController::class, 'update']);
    });

    Route::get('firmsLog/show/{firmId}', [FirmLogController::class, 'show']);
    Route::get('contractsLog/show/{contractId}', [ContractLogController::class, 'show']);
    Route::get('invoicesLog/show/{invoiceId}', [InvoiceLogController::class, 'show']);
    Route::get('paymentsLog/show/{paymentId}', [PaymentLogController::class, 'show']);
    Route::get('actsLog/show/{actId}', [ActLogController::class, 'show']);
});
