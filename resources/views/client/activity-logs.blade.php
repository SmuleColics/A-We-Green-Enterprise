@extends('layouts.client')

@section('title', 'Activity Logs')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/client/activity-logs.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Activity Logs</h2>
            <p>A history of your requests, quotations, and project updates.</p>
        </div>

        <div class="main-content">
            <div class="activity-logs-wrap">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="mb-3 btn-group filter-btn-group" role="group" id="activityFilterGroup">
                            <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Assessment">Assessment</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Quotation">Quotation</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Project">Projects</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Account">Account</button>
                        </div>

                        <div class="table-responsive">
                            <table id="activityTable" class="table table-hover mb-0 small w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 small green-text">Type</th>
                                        <th class="border-0 small green-text">Activity</th>
                                        <th class="border-0 small green-text">Details</th>
                                        <th class="border-0 small green-text">Status</th>
                                        <th class="border-0 small green-text">Date</th>
                                        <th class="border-0 small green-text">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr data-type="Assessment">
                                        <td><span class="activity-type-icon"><span class="material-symbols-outlined">calendar_month</span></span></td>
                                        <td class="fw-semibold">Site assessment scheduled</td>
                                        <td>CCTV installation — Brgy. Olaes, GMA Cavite</td>
                                        <td><span class="badge bg-success rounded-pill">Confirmed</span></td>
                                        <td data-order="2026-03-15">Mar 15, 2026 · 10:00 AM</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('client-assessment') }}" class="btn btn-sm btn-outline-success" title="View">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr data-type="Quotation">
                                        <td><span class="activity-type-icon"><span class="material-symbols-outlined">receipt_long</span></span></td>
                                        <td class="fw-semibold">Quotation #QT-2026-002 received</td>
                                        <td>Solar Setup — ₱120,000.00</td>
                                        <td><span class="badge bg-warning text-dark rounded-pill">Awaiting Review</span></td>
                                        <td data-order="2026-03-11">Mar 11, 2026</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('client-quotation') }}" class="btn btn-sm btn-outline-success" title="View">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr data-type="Project">
                                        <td><span class="activity-type-icon"><span class="material-symbols-outlined">folder_open</span></span></td>
                                        <td class="fw-semibold">Project milestone updated</td>
                                        <td>CCTV Installation — 65% complete</td>
                                        <td><span class="badge bg-primary rounded-pill">In Progress</span></td>
                                        <td data-order="2026-03-12">Mar 12, 2026</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('client-project') }}" class="btn btn-sm btn-outline-success" title="View">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr data-type="Account">
                                        <td><span class="activity-type-icon"><span class="material-symbols-outlined">person</span></span></td>
                                        <td class="fw-semibold">Profile information updated</td>
                                        <td>Contact number changed</td>
                                        <td><span class="badge bg-secondary rounded-pill">—</span></td>
                                        <td data-order="2026-03-11">Mar 11, 2026</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr data-type="Assessment">
                                        <td><span class="activity-type-icon"><span class="material-symbols-outlined">inbox</span></span></td>
                                        <td class="fw-semibold">Assessment request submitted</td>
                                        <td>Public address system — Municipal Plaza</td>
                                        <td><span class="badge bg-warning text-dark rounded-pill">Under Review</span></td>
                                        <td data-order="2026-03-10">Mar 10, 2026</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('client-assessment') }}" class="btn btn-sm btn-outline-success" title="View">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr data-type="Quotation">
                                        <td><span class="activity-type-icon"><span class="material-symbols-outlined">check_circle</span></span></td>
                                        <td class="fw-semibold">Quotation #QT-2025-089 approved</td>
                                        <td>Solar Setup — ₱210,000.00</td>
                                        <td><span class="badge bg-success rounded-pill">Approved</span></td>
                                        <td data-order="2025-11-20">Nov 20, 2025</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('client-quotation') }}" class="btn btn-sm btn-outline-success" title="View">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr data-type="Account">
                                        <td><span class="activity-type-icon"><span class="material-symbols-outlined">login</span></span></td>
                                        <td class="fw-semibold">Account created</td>
                                        <td>Welcome to A We Green Enterprise Client Portal</td>
                                        <td><span class="badge bg-secondary rounded-pill">—</span></td>
                                        <td data-order="2025-10-05">Oct 5, 2025</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/admin/activity-table.js') }}"></script>
@endsection