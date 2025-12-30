<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// PUBLIC CONTROLLERS
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PublicScheduleController;

// STUDENT CONTROLLERS
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\RegistrationController as StudentRegistrationController;
use App\Http\Controllers\Student\PersonalDetailController;
use App\Http\Controllers\Student\ParentDataController;
use App\Http\Controllers\Student\SchoolOriginController;
use App\Http\Controllers\Student\DocumentController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\ResultController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MajorController as AdminMajorController;
use App\Http\Controllers\Admin\BatchController as AdminBatchController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\DocumentVerificationController;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Admin\AnnouncementManagementController;
use App\Http\Controllers\Admin\InterviewerManagementController;
use App\Http\Controllers\Admin\ExamFinalizationController;

// INTERVIEWER CONTROLLERS
use App\Http\Controllers\Interviewer\DashboardController as InterviewerDashboardController;
use App\Http\Controllers\Interviewer\ExamResultController as InterviewerExamResultController;


// PUBLIC ROUTES
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/majors', [MajorController::class, 'index'])->name('majors.index');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

// public schedule
Route::get('/schedule', [PublicScheduleController::class, 'index'])->name('schedule.public');

// public requirements
Route::get('/requirements', [LandingController::class, 'requirements'])->name('requirements');

Auth::routes();


// STUDENT ROUTES
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    Route::get('/register', [StudentRegistrationController::class, 'index'])->name('register');

    Route::get('/personal', [PersonalDetailController::class, 'edit'])->name('personal.edit');
    Route::post('/personal', [PersonalDetailController::class, 'store'])->name('personal.store');

    Route::get('/parents', [ParentDataController::class, 'edit'])->name('parents.edit');
    Route::post('/parents', [ParentDataController::class, 'store'])->name('parents.store');

    Route::get('/school', [SchoolOriginController::class, 'edit'])->name('school.edit');
    Route::post('/school', [SchoolOriginController::class, 'store'])->name('school.store');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents', [DocumentController::class, 'upload'])->name('documents.upload');

    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');

    Route::get('/result', [ResultController::class, 'index'])->name('result.index');
    Route::get('/exam-card', [StudentDashboardController::class, 'examCard'])->name('exam.card');
});


// ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('majors', AdminMajorController::class);
    Route::resource('batches', AdminBatchController::class);
    Route::resource('schedules', AdminScheduleController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('registrations', AdminRegistrationController::class);
    Route::resource('interviewers', InterviewerManagementController::class);

    // Registration Routes
    Route::post('/registrations/bulk-update-status', [AdminRegistrationController::class, 'bulkUpdateStatus'])->name('registrations.bulk-update-status');
    Route::get('/registrations/export', [AdminRegistrationController::class, 'export'])->name('registrations.export');

    Route::get('/documents', [DocumentVerificationController::class, 'index'])->name('documents.index');
    Route::patch('/documents/{id}', [DocumentVerificationController::class, 'update'])->name('documents.update');

    Route::get('/payments', [PaymentVerificationController::class, 'index'])->name('payments.index');
    Route::patch('/payments/{id}', [PaymentVerificationController::class, 'update'])->name('payments.update');

    Route::resource('announcements', AnnouncementManagementController::class)->except('index');

    // Exam Finalization Routes
    Route::prefix('exam-finalization')->name('exam-finalization.')->group(function () {
        Route::get('/', [ExamFinalizationController::class, 'index'])->name('index');
        Route::get('/{registration}', [ExamFinalizationController::class, 'show'])->name('show');
        Route::post('/{registration}', [ExamFinalizationController::class, 'finalize'])->name('finalize');
        Route::post('/bulk-finalize', [ExamFinalizationController::class, 'bulkFinalize'])->name('bulk-finalize');
        Route::get('/report', [ExamFinalizationController::class, 'report'])->name('report');
        Route::get('/export-report', [ExamFinalizationController::class, 'exportReport'])->name('export-report');
    });
});


// INTERVIEWER ROUTES
Route::middleware(['auth', 'role:interviewer'])->prefix('interviewer')->name('interviewer.')->group(function () {
    Route::get('/dashboard', [InterviewerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/exam-results', [InterviewerExamResultController::class, 'index'])->name('exam.index');
    Route::post('/exam-results', [InterviewerExamResultController::class, 'store'])->name('exam.store');
});

Route::get('/home', [LandingController::class, 'index'])->name('redirect.home');
