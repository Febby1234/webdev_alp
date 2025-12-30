<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;

use App\Http\Controllers\Student\StudentDashboardController as StudentDashboardController;
use App\Http\Controllers\Student\RegistrationController as StudentRegistrationController;
use App\Http\Controllers\Student\DocumentController as StudentDocumentController;
use App\Http\Controllers\Student\PaymentController as StudentPaymentController;
use App\Http\Controllers\Student\ResultController as StudentExamController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;

use App\Http\Controllers\Interviewer\InterviewerDashboardController as InterviewerDashboardController;
use App\Http\Controllers\Interviewer\InterviewerExamResultController as InterviewerExamResultController;

use App\Http\Controllers\Admin\AdminDashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MajorController as AdminMajorController;
use App\Http\Controllers\Admin\BatchController as AdminBatchController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\DocumentVerificationController as AdminDocumentController;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

Route::get('/', [PublicController::class, 'welcome'])->name('home');
Route::prefix('info')->name('public.')->group(function () {
    Route::get('/jurusan', [PublicController::class, 'majors'])->name('majors');
    Route::get('/persyaratan', [PublicController::class, 'requirements'])->name('requirements');
    Route::get('/jadwal', [PublicController::class, 'schedules'])->name('schedules');
    Route::get('/pengumuman', [PublicController::class, 'announcements'])->name('announcements');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Registration
    Route::get('/registration/create', [StudentRegistrationController::class, 'create'])->name('registration.create');
    Route::post('/registration', [StudentRegistrationController::class, 'store'])->name('registration.store');
    Route::get('/registration', [StudentRegistrationController::class, 'show'])->name('registration.show');

    // Documents
    Route::get('/documents', [StudentDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/upload/{type}', [StudentDocumentController::class, 'upload'])->name('documents.upload');
    Route::post('/documents', [StudentDocumentController::class, 'store'])->name('documents.store');

    // Payments
    Route::get('/payments', [StudentPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/upload', [StudentPaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments', [StudentPaymentController::class, 'store'])->name('payments.store');

    // // Exams
    Route::get('/exams/schedule', [StudentExamController::class, 'schedule'])->name('exams.schedule');
    Route::get('/exams/results', [StudentExamController::class, 'results'])->name('exams.results');

    // Profile
    Route::get('/profile', [StudentProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:interviewer'])->prefix('interviewer')->name('interviewer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [InterviewerDashboardController::class, 'index'])->name('dashboard');

    // Exam Results
    Route::get('/exams', [InterviewerExamResultController::class, 'index'])->name('exams.index');
    Route::get('/exams/create/{registration}', [InterviewerExamResultController::class, 'create'])->name('exams.create');
    Route::post('/exams', [InterviewerExamResultController::class, 'store'])->name('exams.store');
    Route::get('/exams/{examResult}/edit', [InterviewerExamResultController::class, 'edit'])->name('exams.edit');
    Route::patch('/exams/{examResult}', [InterviewerExamResultController::class, 'update'])->name('exams.update');

    // View Participants
    Route::get('/participants/{registration}', [InterviewerExamResultController::class, 'show'])->name('participants.show');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Registrations
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{registration}', [AdminRegistrationController::class, 'show'])->name('registrations.show');
    Route::patch('/registrations/{registration}/status', [AdminRegistrationController::class, 'updateStatus'])->name('registrations.updateStatus');
    Route::delete('/registrations/{registration}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');

    // Majors
    Route::resource('majors', AdminMajorController::class);
    Route::post('/majors/{major}/toggle', [AdminMajorController::class, 'toggleActive'])->name('majors.toggle');

    // Batches
    Route::resource('batches', AdminBatchController::class);
    Route::post('/batches/{batch}/toggle', [AdminBatchController::class, 'toggleActive'])->name('batches.toggle');

    // Schedules
    Route::resource('schedules', AdminScheduleController::class);
    Route::get('/schedules/{schedule}/assign', [AdminScheduleController::class, 'assignForm'])->name('schedules.assign');
    Route::post('/schedules/{schedule}/assign', [AdminScheduleController::class, 'assignRegistrations'])->name('schedules.assign.store');

    // Users
    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.resetPassword');

    // Documents Verification
    Route::get('/documents', [AdminDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}', [AdminDocumentController::class, 'show'])->name('documents.show');
    Route::post('/documents/{document}/verify', [AdminDocumentController::class, 'verify'])->name('documents.verify');
    Route::post('/documents/{document}/reject', [AdminDocumentController::class, 'reject'])->name('documents.reject');

    // Payments Verification
    Route::get('/payments', [PaymentVerificationController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentVerificationController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/verify', [PaymentVerificationController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{payment}/reject', [PaymentVerificationController::class, 'reject'])->name('payments.reject');

    // Announcements
    // Route::resource('announcements', AdminAnnouncementController::class);

    // // Reports
    // Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    // Route::post('/reports/generate', [AdminReportController::class, 'generate'])->name('reports.generate');
    // Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});
