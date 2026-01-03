<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;

use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\RegistrationController as StudentRegistrationController;
use App\Http\Controllers\Student\PersonalDetailController as StudentPersonalDetailController;
use App\Http\Controllers\Student\ParentDataController as StudentParentDataController;
use App\Http\Controllers\Student\SchoolOriginController as StudentSchoolOriginController;
use App\Http\Controllers\Student\DocumentController as StudentDocumentController;
use App\Http\Controllers\Student\PaymentController as StudentPaymentController;
use App\Http\Controllers\Student\ResultController as StudentResultController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;

use App\Http\Controllers\Interviewer\InterviewerDashboardController;
use App\Http\Controllers\Interviewer\InterviewerExamResultController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MajorController as AdminMajorController;
use App\Http\Controllers\Admin\BatchController as AdminBatchController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\DocumentVerificationController as AdminDocumentController;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// =====================
// PUBLIC ROUTES
// =====================
Route::get('/', [PublicController::class, 'welcome'])->name('home');
Route::prefix('info')->name('public.')->group(function () {
    Route::get('/jurusan', [PublicController::class, 'majors'])->name('majors');
    Route::get('/persyaratan', [PublicController::class, 'requirements'])->name('requirements');
    Route::get('/jadwal', [PublicController::class, 'schedules'])->name('schedules');
    Route::get('/pengumuman', [PublicController::class, 'announcements'])->name('announcements');
});

require __DIR__.'/auth.php';

// =====================
// STUDENT ROUTES
// =====================
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Registration
    Route::get('/registration/create', [StudentRegistrationController::class, 'create'])->name('registration.create');
    Route::post('/registration', [StudentRegistrationController::class, 'store'])->name('registration.store');
    Route::get('/registration', [StudentRegistrationController::class, 'show'])->name('registration.show');

    // Personal Detail (Biodata)
    Route::get('/personal', [StudentPersonalDetailController::class, 'edit'])->name('personal.edit');
    Route::post('/personal', [StudentPersonalDetailController::class, 'store'])->name('personal.store');
    Route::patch('/personal/{detail}', [StudentPersonalDetailController::class, 'update'])->name('personal.update');

    // Parent Data (Data Orang Tua)
    Route::get('/parents', [StudentParentDataController::class, 'edit'])->name('parents.edit');
    Route::post('/parents', [StudentParentDataController::class, 'store'])->name('parents.store');
    Route::patch('/parents/{parentData}', [StudentParentDataController::class, 'update'])->name('parents.update');

    // School Origin (Asal Sekolah)
    Route::get('/school', [StudentSchoolOriginController::class, 'edit'])->name('school.edit');
    Route::post('/school', [StudentSchoolOriginController::class, 'store'])->name('school.store');
    Route::patch('/school/{schoolOrigin}', [StudentSchoolOriginController::class, 'update'])->name('school.update');

    // Documents
    Route::get('/documents', [StudentDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/upload/{type}', [StudentDocumentController::class, 'create'])->name('documents.upload');
    Route::post('/documents', [StudentDocumentController::class, 'store'])->name('documents.store');
    Route::patch('/documents/{document}', [StudentDocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [StudentDocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/{document}/download', [StudentDocumentController::class, 'download'])->name('documents.download');

    // Payments
    Route::get('/payments', [StudentPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [StudentPaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [StudentPaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}/download', [StudentPaymentController::class, 'download'])->name('payments.download');

    // Exams (Schedule & Results)
    Route::get('/exams/schedule', [StudentResultController::class, 'schedule'])->name('exams.schedule');
    Route::get('/exams/results', [StudentResultController::class, 'results'])->name('exams.results');

    // Exam Card
    Route::get('/exam-card', [StudentDashboardController::class, 'examCard'])->name('exam.card');
    Route::get('/exam-card/download', [StudentDashboardController::class, 'downloadExamCard'])->name('exam.card.download');

    // Profile (Student specific)
    Route::get('/profile', [StudentProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
});

// =====================
// INTERVIEWER ROUTES
// =====================
Route::middleware(['auth', 'role:interviewer'])->prefix('interviewer')->name('interviewer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [InterviewerDashboardController::class, 'index'])->name('dashboard');

    // Participants - Daftar peserta
    Route::get('/participants', [InterviewerExamResultController::class, 'index'])->name('participants.index');

    // Participants - Detail & input nilai
    Route::get('/participants/{registration}', [InterviewerExamResultController::class, 'show'])->name('participants.show');

    // Participants - Simpan/update nilai
    Route::post('/participants/{registration}/score', [InterviewerExamResultController::class, 'score'])->name('participants.score');

    // Schedule - Jadwal interview
    Route::get('/schedule', [InterviewerExamResultController::class, 'scheduleIndex'])->name('schedule.index');
});

// =====================
// ADMIN ROUTES
// =====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Registrations
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/export', [AdminRegistrationController::class, 'export'])->name('registrations.export');
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
    Route::patch('/documents/{document}', [AdminDocumentController::class, 'update'])->name('documents.update');
    Route::get('/documents/{document}/download', [AdminDocumentController::class, 'download'])->name('documents.download');

    // Payments Verification
    Route::get('/payments', [PaymentVerificationController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentVerificationController::class, 'show'])->name('payments.show');
    Route::patch('/payments/{payment}', [PaymentVerificationController::class, 'update'])->name('payments.update');
    Route::get('/payments/{payment}/download', [PaymentVerificationController::class, 'download'])->name('payments.download');

    // Announcements
    Route::resource('announcements', AdminAnnouncementController::class);

    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/registrations', [AdminReportController::class, 'registrations'])->name('reports.registrations');
    Route::get('/reports/payments', [AdminReportController::class, 'payments'])->name('reports.payments');
    Route::get('/reports/exams', [AdminReportController::class, 'exams'])->name('reports.exams');
    Route::get('/reports/majors', [AdminReportController::class, 'majors'])->name('reports.majors');
});

// =====================
// GLOBAL PROFILE ROUTES (untuk admin & interviewer)
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});
