<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function showDashboard()
    {
        return view('admin.dashboard');
    }

    // ASSESSMENT
    public function showAssessments()
    {
        return view('admin.assessments.assessments');
    }

    public function showArchiveAssessments()
    {
        return view('admin.assessments.archive-assessments');
    }

    public function showAssessmentRequests()
    {
        return view('admin.assessments.requests');
    }

    public function showArchiveAssessmentRequests()
    {
        return view('admin.assessments.archive-requests');
    }

    // QUOTATION
    public function showQuotations()
    {
        return view('admin.quotations.quotations');
    }

    public function showArchiveQuotations()
    {
        return view('admin.quotations.archive-quotations');
    }

    public function showQuotationProposals()
    {
        return view('admin.quotations.proposals');
    }

    // TASKS
    // public function showTasks()
    // {
    //     return view('admin.tasks.tasks');
    // }

    public function showArchiveTasks()
    {
        return view('admin.tasks.archive-tasks');
    }

    // PROJECTS
    public function showArchiveProjects()
    {
        return view('admin.projects.archive-projects');
    }

    // CHECKLISTS

    public function showArchiveChecklists()
    {
        return view('admin.checklists.archive-checklists');
    }

    // REPORTS

    public function showReports()
    {
        return view('admin.reports.reports');
    }

    // EMPLOYEES

    public function showEmployees()
    {
        return view('admin.employees.employees');
    }

    public function showArchiveEmployees()
    {
        return view('admin.employees.archive-employees');
    }

    // CLIENTS

    public function showClients()
    {
        return view('admin.clients.clients');
    }

    public function showArchiveClients()
    {
        return view('admin.clients.archive-clients');
    }

    public function showArchiveMaterials()
    {
        return view('admin.materials.archive-materials');
    }

    // SYSTEM SETTINGS

    public function showAdminSettings()
    {
        return view('admin.admin-settings');
    }

    public function showAdminActivityLogs()
    {
        return view('admin.admin-activity-logs');
    }

    public function showAdminProfile()
    {
        return view('admin.admin-profile');
    }
}