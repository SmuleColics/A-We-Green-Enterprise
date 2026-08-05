<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home-page.landing-page');
});

// ========== ADMIN SIDE ==========
// DISPLAYING OF ADMIN BLADES
//dashboard
Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');

//assessments
Route::get('/assessments', [AdminController::class, 'showAssessments'])->name('assessments');

//archive assessments
Route::get('/archive-assessments', [AdminController::class, 'showArchiveAssessments'])->name('archive-assessments');

//assessment request
Route::get('/requests', [AdminController::class, 'showAssessmentRequests'])->name('requests');

//assessment request
Route::get('/archive-requests', [AdminController::class, 'showArchiveAssessmentRequests'])->name('archive-requests');

//admin assessment request
Route::get('/archiverequest', [AdminController::class, 'showAssessmentRequests'])->name('requests');

//assessment form
Route::get('/forms', [AdminController::class, 'showAssessmentForms'])->name('form');

//quotations
Route::get('/quotations', [AdminController::class, 'showQuotations'])->name('quotations');

//archive quotations
Route::get('/archive-quotations', [AdminController::class, 'showArchiveQuotations'])->name('archive-quotations');

//quotation proposal
Route::get('/proposals', [AdminController::class, 'showQuotationProposals'])->name('proposals');

//tasks
Route::get('/tasks', [AdminController::class, 'showTasks'])->name('tasks');

//archive tasks
Route::get('/archive-tasks', [AdminController::class, 'showArchiveTasks'])->name('archive-tasks');

//projects
Route::get('/projects', [AdminController::class, 'showProjects'])->name('projects');

//archive projects
Route::get('/archive-projects', [AdminController::class, 'showArchiveProjects'])->name('archive-projects');

//project monitoring
Route::get('/monitoring', [AdminController::class, 'showMonitoring'])->name('monitoring');

//checklists
Route::get('/checklists', [AdminController::class, 'showChecklists'])->name('checklists');

//archive checklists
Route::get('/archive-checklists', [AdminController::class, 'showArchiveChecklists'])->name('archive-checklists');

//reports
Route::get('/reports', [AdminController::class, 'showReports'])->name('reports');

//employees
Route::get('/employees', [AdminController::class, 'showEmployees'])->name('employees');

//archive employees
Route::get('/archive-employees', [AdminController::class, 'showArchiveEmployees'])->name('archive-employees');

//clients
Route::get('/clients', [AdminController::class, 'showClients'])->name('clients');

//archive clients
Route::get('/archive-clients', [AdminController::class, 'showArchiveClients'])->name('archive-clients');

//materials
Route::get('/materials', [AdminController::class, 'showMaterials'])->name('materials');

//archive materials
Route::get('/archive-materials', [AdminController::class, 'showArchiveMaterials'])->name('archive-materials');

//admin-settings
Route::get('/admin-settings', [AdminController::class, 'showAdminSettings'])->name('admin-settings');

//admin-settings
Route::get('/admin-activity-logs', [AdminController::class, 'showAdminActivityLogs'])->name('admin-activity-logs');

//admin-profile
Route::get('/admin-profile', [AdminController::class, 'showAdminProfile'])->name('admin-profile');


// ========== CLIENT SIDE ==========
// DISPLAYING OF CLIENT BLADES

//portal
Route::get('/portal', [ClientController::class, 'showPortal'])->name('portal');

//assessment
Route::get('/client-assessment', [ClientController::class, 'showClientAssessment'])->name('client-assessment');

//assessment form
Route::get('/assessment-form', [ClientController::class, 'showClientAssessmentForm'])->name('assessment-form');

//quotations
Route::get('/client-quotation', [ClientController::class, 'showClientQuotation'])->name('client-quotation');

//view quotations
Route::get('/quotation-view', [ClientController::class, 'showClientViewQuotation'])->name('quotation-view');

//view project list
Route::get('/client-project', [ClientController::class, 'showClientProject'])->name('client-project');

//view project monitoring
Route::get('/project-monitoring', [ClientController::class, 'showProjectMonitoring'])->name('project-monitoring');

//view profile
Route::get('/profile', [ClientController::class, 'showClientProfile'])->name('profile');

//view settings
Route::get('/settings', [ClientController::class, 'showClientSettings'])->name('settings');

//view activity logs
Route::get('/activity-logs', [ClientController::class, 'showActivityLogs'])->name('activity-logs');

// ========== HOME PAGE SIDE ==========
// DISPLAYING OF LANDING PAGE + REGISTER + SIGN IN
Route::get('/landing-page', [HomeController::class, 'showLandingPage'])->name('landing-page');

//sign in
Route::get('/sign-in', [HomeController::class, 'showSignIn'])->name('sign-in');

//register
Route::get('/register', [HomeController::class, 'showRegister'])->name('register');

//forgot password
Route::get('/forgot-password', [HomeController::class, 'showForgotPassword'])->name('forgot-password');

//forgot password
Route::get('/reset-password', [HomeController::class, 'showResetPassword'])->name('reset-password');