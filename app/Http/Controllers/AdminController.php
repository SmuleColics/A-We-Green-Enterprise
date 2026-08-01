<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

  public function showAssessmentRequests()
  {
    return view('admin.assessments.requests');
  }

  public function showAssessmentForms()
  {
    return view('admin.assessments.forms');
  }

  // QUOTATION
  public function showQuotations()
  {
    return view('admin.quotations.quotations');
  }

  public function showQuotationProposals()
  {
    return view('admin.quotations.proposals');
  }

  public function showTasks()
  {
    return view('admin.tasks.tasks');
  }

  public function showProjects()
  {
    return view('admin.projects.projects');
  }

  public function showMonitoring()
  {
    return view('admin.projects.monitoring');
  }

  public function showChecklists()
  {
    return view('admin.checklists.checklists');
  }

  public function showReports()
  {
    return view('admin.reports.reports');
  }

  public function showEmployees()
  {
    return view('admin.employees.employees');
  }

  public function showClients()
  {
    return view('admin.clients.clients');
  }

  public function showMaterials()
  {
    return view('admin.materials.materials');
  }

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
