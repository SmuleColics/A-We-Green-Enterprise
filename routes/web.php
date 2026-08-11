<?php

use App\Http\Controllers\Admin\AssessmentRequestController;
use App\Http\Controllers\Admin\EmployeeController;
// CLIENT BACKEND CONTROLLER
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\AssessmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Employee\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'showLandingPage'])
    ->name('landing-page');

// ========== ADMIN SIDE ==========
// Accessible by secretary, admin, super_admin
Route::middleware(['auth', 'role:secretary,admin,super_admin'])->group(function () {

    // dashboard
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');

    // assessments
    Route::get('/assessments', [AdminController::class, 'showAssessments'])->name('assessments');

    // archive assessments
    Route::get('/archive-assessments', [AdminController::class, 'showArchiveAssessments'])->name('archive-assessments');

    // archive assessment requests
    Route::get('/archive-requests', [AdminController::class, 'showArchiveAssessmentRequests'])->name('archive-requests');

    // admin assessment requests (secondary view)
    Route::get('/archiverequest', [AdminController::class, 'showArchiveAssessmentRequests'])->name('archive-request');

    // assessment form
    Route::get('/forms', [AdminController::class, 'showAssessmentForms'])->name('form');

    // quotations
    Route::get('/quotations', [AdminController::class, 'showQuotations'])->name('quotations');

    // archive quotations
    Route::get('/archive-quotations', [AdminController::class, 'showArchiveQuotations'])->name('archive-quotations');

    // quotation proposal
    Route::get('/proposals', [AdminController::class, 'showQuotationProposals'])->name('proposals');

    // tasks
    Route::get('/tasks', [AdminController::class, 'showTasks'])->name('tasks');

    // archive tasks
    Route::get('/archive-tasks', [AdminController::class, 'showArchiveTasks'])->name('archive-tasks');

    // projects
    Route::get('/projects', [AdminController::class, 'showProjects'])->name('projects');

    // archive projects
    Route::get('/archive-projects', [AdminController::class, 'showArchiveProjects'])->name('archive-projects');

    // project monitoring
    Route::get('/monitoring', [AdminController::class, 'showMonitoring'])->name('monitoring');

    // checklists
    Route::get('/checklists', [AdminController::class, 'showChecklists'])->name('checklists');

    // archive checklists
    Route::get('/archive-checklists', [AdminController::class, 'showArchiveChecklists'])->name('archive-checklists');

    // reports
    Route::get('/reports', [AdminController::class, 'showReports'])->name('reports');

    // archive employees
    Route::get('/archive-employees', [AdminController::class, 'showArchiveEmployees'])->name('archive-employees');

    // clients
    Route::get('/clients', [AdminController::class, 'showClients'])->name('clients');

    // archive clients
    Route::get('/archive-clients', [AdminController::class, 'showArchiveClients'])->name('archive-clients');

    // materials
    Route::get('/materials', [AdminController::class, 'showMaterials'])->name('materials');

    // archive materials
    Route::get('/archive-materials', [AdminController::class, 'showArchiveMaterials'])->name('archive-materials');

    // admin-settings
    Route::get('/admin-settings', [AdminController::class, 'showAdminSettings'])->name('admin-settings');

    // admin activity logs
    Route::get('/admin-activity-logs', [AdminController::class, 'showAdminActivityLogs'])->name('admin-activity-logs');

    // admin profile
    Route::get('/admin-profile', [AdminController::class, 'showAdminProfile'])->name('admin-profile');

});

// ========== EMPLOYEE SIDE ==========
// Accessible by client only
// Route::middleware(['auth', 'role:employee'])->group(function () {
//     Route::get('/emp-assessments', [EmployeeController::class, 'showE,mpAssessments'])->name('emp-assessments');
// });

// ========== CLIENT SIDE ==========
// Accessible by client only
Route::middleware(['auth', 'role:client'])->group(function () {

    // portal
    Route::get('/portal', [ClientController::class, 'showPortal'])->name('portal');

    // assessment
    Route::get('/client-assessment', [ClientController::class, 'showClientAssessment'])->name('client-assessment');

    // assessment form
    Route::get('/assessment-form', [ClientController::class, 'showClientAssessmentForm'])->name('assessment-form');

    // quotations
    Route::get('/client-quotation', [ClientController::class, 'showClientQuotation'])->name('client-quotation');

    // view quotations
    Route::get('/quotation-view', [ClientController::class, 'showClientViewQuotation'])->name('quotation-view');

    // view project list
    Route::get('/client-project', [ClientController::class, 'showClientProject'])->name('client-project');

    // view project monitoring
    Route::get('/project-monitoring', [ClientController::class, 'showProjectMonitoring'])->name('project-monitoring');

    // view profile
    Route::get('/profile', [ClientController::class, 'showClientProfile'])->name('profile');

    // view settings
    Route::get('/settings', [ClientController::class, 'showClientSettings'])->name('settings');

    // view activity logs
    Route::get('/activity-logs', [ClientController::class, 'showActivityLogs'])->name('activity-logs');

});

// ========== HOME PAGE SIDE ==========
// Public — no auth required
// sign in
Route::get('/sign-in', [HomeController::class, 'showSignIn'])->name('sign-in');

// register
Route::get('/register', [HomeController::class, 'showRegister'])->name('register');

// forgot password
Route::get('/forgot-password', [HomeController::class, 'showForgotPassword'])->name('forgot-password');

// reset password
Route::get('/reset-password', [HomeController::class, 'showResetPassword'])->name('reset-password');

// ========== AUTH ACTIONS (form submissions) ==========
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/sign-in', [AuthController::class, 'login'])->name('sign-in.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot-password.store');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.update');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ========== NOTIFICATIONS ==========
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
});

// CLIENT SIDE BACKEND ROUTES
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/assessment/availability', [AssessmentController::class, 'availability'])->name('assessment.availability');
    Route::post('/assessment', [AssessmentController::class, 'store'])->name('assessment.store');
    Route::patch('/assessment/{assessment}/cancel', [AssessmentController::class, 'cancel'])->name('assessment.cancel');
});

// ADMIN SIDE BACKEND ROUTES
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    // ASSESSMENT REQUEST
    Route::get('/requests', [AssessmentRequestController::class, 'index'])->name('requests');
    Route::patch('/requests/{assessment}/confirm', [AssessmentRequestController::class, 'confirm'])->name('requests.confirm');
    Route::patch('/requests/{assessment}/decline', [AssessmentRequestController::class, 'decline'])->name('requests.decline');
    Route::patch('/requests/{assessment}/archive', [AssessmentRequestController::class, 'archive'])->name('requests.archive');
});

Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::patch('/employees/{staff}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::patch('/employees/{staff}/archive', [EmployeeController::class, 'archive'])->name('employees.archive');
});

// ──────────────────────────────────────────
// EMPLOYEE ROUTES
// ──────────────────────────────────────────
Route::middleware(['auth', 'employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/update', [TaskController::class, 'update'])->name('tasks.update');
});

// Also add this global route (if not already present)
Route::get('/tasks', function () {
    return redirect()->route('employee.tasks');
})->name('tasks')->middleware('auth');
