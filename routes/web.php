<?php

use App\Http\Controllers\Admin\AssessmentFormController;
use App\Http\Controllers\Admin\AssessmentRequestController;
use App\Http\Controllers\Admin\AssessmentScheduleController;
use App\Http\Controllers\Admin\ChecklistController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ProjectTaskController;
use App\Http\Controllers\Admin\ProjectUpdateController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\AssessmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Employee\TaskController as EmployeeTaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'showLandingPage'])
    ->name('landing-page');

// ==========================================================
// ADMIN SIDE
// Accessible by secretary, admin, and super_admin
// ==========================================================
Route::middleware(['auth', 'role:secretary,admin,super_admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])
        ->name('dashboard');

    // Archive assessments
    Route::get('/archive-assessments', [AssessmentScheduleController::class, 'archivedPage'])
        ->name('archive-assessments');

    // Archive assessment requests
    Route::get('/archive-requests', [AssessmentRequestController::class, 'archived'])
        ->name('archive-requests');

    // Admin assessment requests (secondary view)
    Route::get('/archiverequest', [AssessmentRequestController::class, 'archived'])
        ->name('archive-request');

    // Quotations
    Route::get('/quotations', [QuotationController::class, 'adminIndex'])
        ->name('quotations');

    // Archive quotations
    Route::get('/archive-quotations', [QuotationController::class, 'archivedPage'])
        ->name('archive-quotations');

    // Quotation proposal
    Route::get('/proposals', [QuotationController::class, 'adminIndex'])
        ->name('proposals');

    // Archive projects
    Route::get('/archive-projects', [AdminController::class, 'showArchiveProjects'])
        ->name('archive-projects');

    // Archive checklists
    Route::get('/archive-checklists', [AdminController::class, 'showArchiveChecklists'])
        ->name('archive-checklists');

    // Reports
    Route::get('/reports/checklist', [ReportController::class, 'checklist'])
        ->name('reports.checklist');
    Route::get('/reports/tasks', [ReportController::class, 'tasks'])
        ->name('reports.tasks');

    Route::get('/reports', [AdminController::class, 'showReports'])
        ->name('reports');

    // Archive employees
    Route::get('/archive-employees', [EmployeeController::class, 'archivedPage'])
        ->name('archive-employees');

    // Archive clients
    Route::get('/archive-clients', [AdminClientController::class, 'archivedPage'])
        ->name('archive-clients');

    // Archive materials
    Route::get('/archive-materials', [MaterialController::class, 'archivedPage'])
        ->name('archive-materials');

    // Admin settings
    Route::get('/admin-settings', [AdminController::class, 'showAdminSettings'])
        ->name('admin-settings');

    // Admin activity logs
    Route::get('/admin-activity-logs', [AdminController::class, 'showAdminActivityLogs'])
        ->name('admin-activity-logs');

    // Admin profile
    Route::get('/admin-profile', [AdminController::class, 'showAdminProfile'])
        ->name('admin-profile');
});

// ==========================================================
// EMPLOYEE SIDE
// ==========================================================
// Currently disabled
//
// Route::middleware(['auth', 'role:employee'])->group(function () {
//     Route::get('/emp-assessments', [EmployeeController::class, 'showEmpAssessments'])
//         ->name('emp-assessments');
// });

// ==========================================================
// CLIENT SIDE
// Accessible by client only
// ==========================================================
Route::middleware(['auth', 'role:client'])->group(function () {

    // Portal
    Route::get('/portal', [ClientController::class, 'showPortal'])
        ->name('portal');

    // Assessment
    Route::get('/client-assessment', [ClientController::class, 'showClientAssessment'])
        ->name('client-assessment');

    // Assessment form
    Route::get('/assessment-form', [ClientController::class, 'showClientAssessmentForm'])
        ->name('assessment-form');

    // View assessment details
    Route::get('/client-assessment/{assessment}', [ClientController::class, 'showAssessmentDetails'])
        ->name('client-assessment.show');
    Route::get('/client-assessment/{assessment}/print', [ClientController::class, 'printAssessment'])
        ->name('client-assessment.print');

    // Quotations
    Route::get('/client-quotation', [QuotationController::class, 'clientIndex'])
        ->name('client-quotation');

    // View quotation
    Route::get('/quotation-view/{quotation}', [QuotationController::class, 'clientShow'])
        ->name('quotation-view');
    Route::get('/client-quotation/{quotation}/print', [QuotationController::class, 'clientPrint'])
        ->name('client-quotation.print');
    Route::post('/quotation-view/{quotation}/approve', [QuotationController::class, 'approve'])
        ->name('client-quotation.approve');
    Route::post('/quotation-view/{quotation}/request-revision', [QuotationController::class, 'requestRevision'])
        ->name('client-quotation.request-revision');

    // View project list
    Route::get('/client-project', [ClientController::class, 'showClientProject'])
        ->name('client-project');

    // View project monitoring
    Route::get('/project-monitoring/{project}', [ClientController::class, 'showProjectMonitoring'])
        ->name('project-monitoring');

    // View profile
    Route::get('/profile', [ClientController::class, 'showClientProfile'])
        ->name('profile');

    // View settings
    Route::get('/settings', [ClientController::class, 'showClientSettings'])
        ->name('settings');

    // View activity logs
    Route::get('/activity-logs', [ClientController::class, 'showActivityLogs'])
        ->name('activity-logs');
});

// ==========================================================
// HOME PAGE SIDE
// Public — no authentication required
// ==========================================================

// Sign in
Route::get('/sign-in', [HomeController::class, 'showSignIn'])
    ->name('sign-in');

// Register
Route::get('/register', [HomeController::class, 'showRegister'])
    ->name('register');

// Forgot password
Route::get('/forgot-password', [HomeController::class, 'showForgotPassword'])
    ->name('forgot-password');

// Reset password
Route::get('/reset-password', [HomeController::class, 'showResetPassword'])
    ->name('reset-password');

// ==========================================================
// AUTH ACTIONS
// ==========================================================

// Register
Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Sign in
Route::post('/sign-in', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('sign-in.store');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Forgot password
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    ->middleware('throttle:3,1')
    ->name('forgot-password.store');

// Reset password
Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->middleware('throttle:5,1')
    ->name('reset-password.update');

// ==========================================================
// NOTIFICATIONS
// ==========================================================
Route::middleware('auth')->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead'])
        ->name('notifications.read-all');

    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])
        ->name('notifications.read');
});

// ==========================================================
// CLIENT BACKEND ROUTES
// ==========================================================
Route::middleware(['auth', 'role:client'])->group(function () {

    // Assessment availability
    Route::get('/assessment/availability', [AssessmentController::class, 'availability'])
        ->name('assessment.availability');

    // Submit assessment
    Route::post('/assessment', [AssessmentController::class, 'store'])
        ->name('assessment.store');

    // Cancel assessment
    Route::patch('/assessment/{assessment}/cancel', [AssessmentController::class, 'cancel'])
        ->name('assessment.cancel');
});

// ==========================================================
// ADMIN ASSESSMENT REQUEST ROUTES
// Accessible by admin and super_admin
// ==========================================================
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {

    // Assessment requests
    Route::get('/requests', [AssessmentRequestController::class, 'index'])
        ->name('requests');

    // Confirm assessment
    Route::patch('/requests/{assessment}/confirm', [AssessmentRequestController::class, 'confirm'])
        ->name('requests.confirm');

    // Decline assessment
    Route::patch('/requests/{assessment}/decline', [AssessmentRequestController::class, 'decline'])
        ->name('requests.decline');

    // Archive assessment request
    Route::patch('/requests/{assessment}/archive', [AssessmentRequestController::class, 'archive'])
        ->name('requests.archive');

    // Restore an archived assessment request
    Route::patch('/requests/{assessment}/unarchive', [AssessmentRequestController::class, 'unarchive'])
        ->name('requests.unarchive');
});

// ==========================================================
// ADMIN EMPLOYEE ROUTES
// Accessible by admin and super_admin
// ==========================================================
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index'])
        ->name('employees');

    Route::post('/employees', [EmployeeController::class, 'store'])
        ->name('employees.store');

    Route::patch('/employees/{staff}', [EmployeeController::class, 'update'])
        ->name('employees.update');

    Route::patch('/employees/{staff}/archive', [EmployeeController::class, 'archive'])
        ->name('employees.archive');

    Route::patch('/employees/{staff}/unarchive', [EmployeeController::class, 'unarchive'])
        ->name('employees.unarchive');
});

// ==========================================================
// ADMIN TASK ROUTES
// ==========================================================
Route::middleware(['auth', 'role:admin,super_admin'])
    ->prefix('admin')
    ->group(function () {

        // Task list
        Route::get('/tasks', [TaskController::class, 'index'])
            ->name('tasks');

        // Task details
        Route::get('/tasks/{task}/details', [TaskController::class, 'show'])
            ->name('admin.tasks.show');

        // Create task
        Route::post('/tasks/create', [TaskController::class, 'create'])
            ->name('admin.tasks.create');

        // Update task
        Route::post('/tasks/{task}/update', [TaskController::class, 'update'])
            ->name('admin.tasks.update');

        // Archive task (replaces the old hard-delete)
        Route::post('/tasks/{task}/archive', [TaskController::class, 'archive'])
            ->name('admin.tasks.archive');

        // Restore an archived task
        Route::post('/tasks/{task}/unarchive', [TaskController::class, 'unarchive'])
            ->name('admin.tasks.unarchive');

        // Archived tasks page (admin/super_admin only)
        Route::get('/tasks-archive', [TaskController::class, 'archivedPage'])
            ->name('archive-tasks');
    });

// ==========================================================
// ADMIN ASSESSMENT ROUTES
// ==========================================================
Route::middleware(['auth', 'role:admin,secretary,super_admin'])->group(function () {
    Route::get('/quotations/{quotation}', [QuotationController::class, 'adminShow'])->name('quotations.show');
    Route::get('/assessments', [AssessmentScheduleController::class, 'index'])->name('assessments');
    Route::patch('/assessments/{assessment}/archive', [AssessmentScheduleController::class, 'archive'])->name('assessments.archive');
    Route::patch('/assessments/{assessment}/unarchive', [AssessmentScheduleController::class, 'unarchive'])->name('assessments.unarchive');
    Route::get('/assessments/{assessment}/form', [AssessmentFormController::class, 'edit'])
        ->name('assessments.form.edit');

    Route::put('/assessments/{assessment}/form', [AssessmentFormController::class, 'update'])
        ->name('assessments.form.update');
    Route::get('/assessments/{assessment}/form/print', [AssessmentFormController::class, 'print'])
        ->name('assessments.form.print');
    Route::get('/quotations/{quotation}/print', [QuotationController::class, 'print'])
        ->name('quotations.print');
    Route::patch('/quotations/{quotation}/archive', [QuotationController::class, 'archive'])
        ->name('quotations.archive');
    Route::patch('/quotations/{quotation}/unarchive', [QuotationController::class, 'unarchive'])
        ->name('quotations.unarchive');
    Route::post('/quotations/{quotation}/upload-contract', [QuotationController::class, 'uploadContract'])
        ->name('quotations.upload-contract');

    Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects');
    Route::get('/projects/{project}', [AdminProjectController::class, 'show'])->name('projects.show');
    Route::put('/projects/{project}', [AdminProjectController::class, 'update'])->name('projects.update');
    Route::patch('/projects/{project}/archive', [AdminProjectController::class, 'archive'])->name('projects.archive');

    Route::post('/projects/{project}/tasks', [ProjectTaskController::class, 'store'])->name('project-tasks.store');
    Route::put('/project-tasks/{task}', [ProjectTaskController::class, 'update'])->name('project-tasks.update');
    Route::patch('/project-tasks/{task}/archive', [ProjectTaskController::class, 'archive'])->name('project-tasks.archive');
    Route::post('/project-tasks/{task}/unarchive', [ProjectTaskController::class, 'unarchive'])->name('project-tasks.unarchive');
    Route::get('/projects/{project}/tasks/archived', [ProjectTaskController::class, 'archivedPage'])->name('project-tasks.archived');

    Route::post('/projects/{project}/updates', [ProjectUpdateController::class, 'store'])->name('project-updates.store');
    Route::post('/project-updates/{update}/archive', [ProjectUpdateController::class, 'archive'])->name('project-updates.archive');
    Route::post('/project-updates/{update}/unarchive', [ProjectUpdateController::class, 'unarchive'])->name('project-updates.unarchive');
    Route::get('/projects/{project}/updates/archived', [ProjectUpdateController::class, 'archivedPage'])->name('project-updates.archived');

    Route::get('/checklists', [ChecklistController::class, 'index'])->name('checklists');
    Route::get('/checklists/{project}', [ChecklistController::class, 'edit'])->name('checklists.edit');
    Route::put('/checklists/{project}', [ChecklistController::class, 'update'])->name('checklists.update');
    Route::get('/checklists/{project}/print', [ChecklistController::class, 'print'])->name('checklists.print');

    Route::get('/employees/{employee}/availability', [EmployeeController::class, 'availability'])->name('employees.availability');
});

// ==========================================================
// ADMIN MATERIALS ROUTES
// ==========================================================
Route::middleware(['auth', 'role:admin,secretary,super_admin'])->group(function () {
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::put('/materials/{material}', [MaterialController::class, 'update'])
        ->name('materials.update');
    Route::patch('/materials/{material}/archive', [MaterialController::class, 'archive'])->name('materials.archive');
    Route::post('/materials/{material}/unarchive', [MaterialController::class, 'unarchive'])->name('materials.unarchive');
});

// ==========================================================
// ADMIN CLIENT ROUTES
// ==========================================================
Route::middleware(['auth', 'role:secretary,admin,super_admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/clients', [AdminClientController::class, 'index'])->name('clients');
        Route::post('/clients', [AdminClientController::class, 'store'])->name('clients.store');
        Route::get('/clients/{client}/details', [AdminClientController::class, 'show'])->name('clients.show');
        Route::post('/clients/{client}/update', [AdminClientController::class, 'update'])->name('clients.update');
        Route::post('/clients/{client}/archive', [AdminClientController::class, 'archive'])->name('clients.archive');
        Route::post('/clients/{client}/unarchive', [AdminClientController::class, 'unarchive'])->name('clients.unarchive');
    });

// ==========================================================
// EMPLOYEE ROUTES
// ==========================================================
Route::middleware(['auth', 'employee'])
    ->prefix('employee')
    ->name('employee.')
    ->group(function () {

        // Employee task list
        Route::get('/tasks', [EmployeeTaskController::class, 'index'])
            ->name('tasks');

        // Employee task details
        Route::get('/tasks/{task}', [EmployeeTaskController::class, 'show'])
            ->name('tasks.show');

        // Employee update task
        Route::post('/tasks/{task}/update', [EmployeeTaskController::class, 'update'])
            ->name('tasks.update');
    });
