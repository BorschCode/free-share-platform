<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', IndexController::class)->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // ----------------------------------------------------
    // Item Routes
    Route::get('items', [ItemController::class, 'index'])->name('items.index');

    // Other item routes use the controller
    Route::post('items', [ItemController::class, 'store'])->name('items.store');
    Route::get('items/create', [ItemController::class, 'create'])->name('items.create');
    Route::get('items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::put('items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::patch('items/{item}', [ItemController::class, 'update']);
    Route::delete('items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    // ----------------------------------------------------


// Votes
    Route::post('items/{item}/vote', [VoteController::class, 'store'])
        ->name('items.vote');

    Route::delete('items/{item}/vote', [VoteController::class, 'destroy'])
        ->name('items.vote.remove');
// Comments
    Route::post('items/{item}/comments', [CommentController::class, 'store'])
        ->name('items.comments.store');

    Route::delete('items/{item}/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('items.comments.destroy');

    // Existing Settings Routes
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
