<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AssetAssignmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\InventoryStockController;
use App\Http\Controllers\Api\ItemAssetController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\StockIssuanceController;
use App\Http\Controllers\Api\StockReceivalController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ── Public routes ────────────────────────────────────────────────────────────
Route::post('/register',            [AuthController::class, 'register']);
Route::post('/login',               [AuthController::class, 'login']);
Route::post('/verify-code',         [AuthController::class, 'verifyCode']);
Route::post('/resend-verification', [AuthController::class, 'resendCode']);

// ── Protected routes (Sanctum token required) ────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::get('/user',      fn(Request $request) => $request->user());
    Route::post('/logout',   [AuthController::class, 'logout']);

    // Account settings (authenticated user's own profile)
    Route::put('/account', [AccountController::class, 'update']);

    // ── Reference / lookup resources ─────────────────────────────────────────
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('categories',  CategoryController::class);
    Route::apiResource('units',       UnitController::class);
    Route::apiResource('suppliers',   SupplierController::class);

    // ── Item definitions ──────────────────────────────────────────────────────
    Route::apiResource('items', ItemController::class);

    // ── People ────────────────────────────────────────────────────────────────
    Route::apiResource('users',     UserController::class);
    Route::apiResource('employees', EmployeeController::class);

    // ── Fixed-asset management ────────────────────────────────────────────────
    // Custom actions MUST be declared before apiResource to avoid {itemAsset} swallowing them
    Route::post('item-assets/{itemAsset}/assign', [ItemAssetController::class, 'assign']);
    Route::post('item-assets/{itemAsset}/return', [ItemAssetController::class, 'returnAsset']);
    Route::apiResource('item-assets', ItemAssetController::class);

    // Asset assignment history (read + update notes/status + delete closed records)
    Route::apiResource('asset-assignments', AssetAssignmentController::class)
        ->only(['index', 'show', 'update', 'destroy']);

    // ── Consumable stock management ───────────────────────────────────────────
    // Stock levels per item per department
    Route::get('inventory-stocks',               [InventoryStockController::class, 'index']);
    Route::get('inventory-stocks/{item}/{department}', [InventoryStockController::class, 'show']);
    Route::post('inventory-stocks/adjust',       [InventoryStockController::class, 'adjust']);

    // Receive new consumable stock (creates StockReceival + increments InventoryStock)
    Route::apiResource('stock-receivals', StockReceivalController::class)
        ->only(['index', 'show', 'store']);

    // Issue consumable stock to person/department (creates StockIssuance + decrements InventoryStock)
    Route::apiResource('stock-issuances', StockIssuanceController::class)
        ->only(['index', 'show', 'store']);
});
