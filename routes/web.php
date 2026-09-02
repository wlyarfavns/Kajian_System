<?php

use Illuminate\Support\Facades\Route;

// --- Controllers ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KajianController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\ProfileController;

// Organizer Controllers
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\KajianController as OrganizerKajianController;
use App\Http\Controllers\Organizer\MosqueController as OrganizerMosqueController;
use App\Http\Controllers\Organizer\ParticipantController as OrganizerParticipantController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KajianController as AdminKajianController;
use App\Http\Controllers\Admin\OrganizerController as AdminOrganizerController;
use App\Http\Controllers\Admin\MosqueController as AdminMosqueController;
use App\Http\Controllers\Admin\SpeakerController as AdminSpeakerController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Public & User Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);

Route::get('/kajian', [KajianController::class, 'index'])->name('kajian.index');
Route::get('/kajian/{kajian:slug}', [KajianController::class, 'show'])->name('kajian.show');

Route::middleware('auth')->group(function () {
    Route::post('/kajian/{kajian}/join', [AttendanceController::class, 'store']);
    Route::delete('/kajian/{kajian}/join', [AttendanceController::class, 'destroy']);
    Route::post('/kajian/{kajian}/favorite', [FavoriteController::class, 'toggle']);
    
    Route::get('/kajian-saya', [AttendanceController::class, 'index']);
    Route::get('/tersimpan', [FavoriteController::class, 'index']);
    
    Route::get('/checkin/{uuid}', [CheckinController::class, 'store']);
    
    // Breeze Profile Route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Organizer Routes
|--------------------------------------------------------------------------
*/
Route::prefix('organizer')->middleware(['auth', 'role:organizer'])->group(function () {
    // Unverified Page
    Route::get('/pending', function () {
        if (auth()->user()->organizer?->is_verified) {
            return redirect('/organizer');
        }
        return view('organizer.unverified');
    })->name('organizer.pending');

    // Verified Organizer Routes
    Route::middleware([\App\Http\Middleware\EnsureOrganizerIsVerified::class])->group(function () {
        Route::get('/', [OrganizerDashboardController::class, 'index']);
        
        Route::resource('kajian', OrganizerKajianController::class)->names('organizer.kajian');
        Route::get('/kajian/{kajian}/peserta', [OrganizerParticipantController::class, 'index']);
        
        Route::resource('mosque', OrganizerMosqueController::class)->only(['index'])->names('organizer.mosque');
        
        // Notifications
        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Organizer\NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/read-all', [\App\Http\Controllers\Organizer\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

        Route::get('/profile', [App\Http\Controllers\Organizer\ProfileController::class, 'edit'])->name('organizer.profile.edit');
        Route::put('/profile', [App\Http\Controllers\Organizer\ProfileController::class, 'update'])->name('organizer.profile.update');
        Route::get('/peserta', [\App\Http\Controllers\Organizer\ParticipantController::class, 'globalIndex'])->name('organizer.peserta.global');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index']);
    
    Route::resource('category', AdminCategoryController::class)->names('admin.category');
    Route::resource('speaker', AdminSpeakerController::class)->names('admin.speaker');
    Route::resource('mosque', AdminMosqueController::class)->names('admin.mosque');
    Route::resource('kajian', AdminKajianController::class)->names('admin.kajian');
    Route::post('kajian/{kajian}/verify', [AdminKajianController::class, 'verify'])->name('admin.kajian.verify');
    Route::post('kajian/{kajian}/reject', [AdminKajianController::class, 'reject'])->name('admin.kajian.reject');
    
    Route::resource('organizer', AdminOrganizerController::class)->names('admin.organizer');
    Route::post('organizer/{organizer}/verify', [AdminOrganizerController::class, 'verify'])->name('admin.organizer.verify');
    
    Route::resource('user', AdminUserController::class)->names('admin.user');
});

/*
|--------------------------------------------------------------------------
| Socialite / Google Auth
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
