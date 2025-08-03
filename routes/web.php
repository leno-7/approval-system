<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\SupportServiceApprovalPdfController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    
});

Route::get('/support-approval/{approval}/preview', [SupportServiceApprovalPdfController::class, 'preview'])->name('support-approval.preview');


Route::get('/support-approval/{approval}/pdf', [SupportServiceApprovalPdfController::class, 'download'])
    ->name('support-approval.pdf'); // <-- هنا اسم الـ route