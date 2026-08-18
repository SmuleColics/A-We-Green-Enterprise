<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Quotation;

class QuotationController extends Controller
{
    // Read-only, system-wide view of quotations — same data as the admin
    // Quotations page, without the archive/contract-upload actions.
    public function index()
    {
        $quotations = Quotation::with('assessment.client.user')->where('is_archived', false)->latest()->get();

        return view('employee.quotations', compact('quotations'));
    }

    public function show(Quotation $quotation)
    {
        $quotation->load('assessment.client.user', 'items.material', 'project');

        return view('employee.quotation-view', compact('quotation'));
    }

    public function print(Quotation $quotation)
    {
        $quotation->load('assessment.client.user', 'items.material');

        return view('print.quotation', compact('quotation'));
    }
}
