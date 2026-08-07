<?php

namespace App\Http\Controllers;

class ClientController extends Controller
{
    public function showPortal()
    {
        return view('client.portal');
    }

    public function showClientAssessment()
    {
        return view('client.assessments.client-assessment');
    }

    public function showClientAssessmentForm()
    {
        return view('client.assessments.assessment-form');
    }

    public function showClientQuotation()
    {
        return view('client.quotations.client-quotation');
    }

    public function showClientViewQuotation()
    {
        return view('client.quotations.quotation-view');
    }

    public function showClientProject()
    {
        return view('client.projects.client-project');
    }

    public function showProjectMonitoring()
    {
        return view('client.projects.project-monitoring');
    }

    public function showClientProfile()
    {
        return view('client.profile');
    }

    public function showClientSettings()
    {
        return view('client.settings');
    }

    public function showActivityLogs()
    {
        return view('client.activity-logs');
    }
}
