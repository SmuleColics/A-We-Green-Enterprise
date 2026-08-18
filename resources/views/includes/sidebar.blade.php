<!-- Sidebar -->
<aside id="adminSidebar" class="offcanvas offcanvas-start d-flex flex-column" tabindex="-1"
    aria-labelledby="adminSidebarLabel">

    <!-- Brand -->
    <div class="px-3 pt-3 pb-3 border-bottom light-border d-flex align-items-center justify-content-between">
        <div class="d-flex gap-2 align-items-center">
            <img src="{{ asset(setting('company_logo_path', 'css/images/AWeGreen-Logo.svg')) }}" alt="" style="width:40px;">
            <span class="sb-logo-title d-block" id="adminSidebarLabel">{{ setting('company_name', 'A We Green Enterprise') }}</span>
        </div>
        <button type="button" id="sidebarClose" class="btn-close btn-close-white d-sm-none" aria-label="Close"></button>
    </div>

    @if (auth()->user()->isEmployee())

        <!-- Nav (Employee — trimmed to what the role can access) -->
        <nav class="sb-nav flex-grow-1 py-2 px-2 overflow-auto">

            <a href="{{ route('employee.dashboard') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('employee.dashboard')) active @endif">
                <span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>

            <a href="{{ route('employee.assessments') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('employee.assessments') || Request::routeIs('employee.requests')) active @endif">
                <span class="material-symbols-outlined">event_available</span>
                Assessments
            </a>

            <a href="{{ route('employee.quotations') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('employee.quotations*')) active @endif">
                <span class="material-symbols-outlined">request_quote</span>
                Quotations
            </a>

            <a href="{{ route('employee.tasks') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('employee.tasks*')) active @endif">
                <span class="material-symbols-outlined">task_alt</span>
                Tasks
            </a>

        </nav>

    @else

        <!-- Nav -->
        <nav class="sb-nav flex-grow-1 py-2 px-2 overflow-auto">

            <a href="{{ route('dashboard') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('dashboard')) active @endif">
                <span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>

            <a href="{{ route('assessments') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('assessments') ||
                        Request::routeIs('archive-assessments') ||
                        Request::routeIs('requests') ||
                        Request::routeIs('archive-requests') ||
                        Request::routeIs('assessments.form.*')) active @endif">
                <span class="material-symbols-outlined">event_available</span>
                Assessments
            </a>

            <a href="{{ route('quotations') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('quotations') || Request::routeIs('quotations.show') || Request::routeIs('archive-quotations') || Request::routeIs('proposals')) active @endif">
                <span class="material-symbols-outlined">request_quote</span>
                Quotations
            </a>

            <a href="{{ route('tasks') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('tasks') || Request::routeIs('archive-tasks')) active @endif">
                <span class="material-symbols-outlined">task_alt</span>
                Tasks
            </a>

            <a href="{{ route('projects') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('projects') || Request::routeIs('archive-projects') || Request::routeIs('projects.*') || Request::routeIs('project-tasks.*') || Request::routeIs('project-updates.*')) active @endif">
                <span class="material-symbols-outlined">folder</span>
                Projects
            </a>

            <a href="{{ route('checklists') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('checklists') || Request::routeIs('archive-checklists') || Request::routeIs('checklists.*')) active @endif">
                <span class="material-symbols-outlined">checklist</span>
                Checklists
            </a>

            <a href="{{ route('reports') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('reports')) active @endif">
                <span class="material-symbols-outlined">bar_chart_4_bars</span>
                Reports
            </a>

            <a href="{{ route('employees') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('employees') || Request::routeIs('archive-employees')) active @endif">
                <span class="material-symbols-outlined">badge</span>
                Employees
            </a>

            <a href="{{ route('clients') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('clients') || Request::routeIs('archive-clients')) active @endif">
                <span class="material-symbols-outlined">groups</span>
                Clients
            </a>

            <a href="{{ route('materials') }}"
                class="nav-link d-flex align-items-center gap-2 px-3 mb-1 @if (Request::routeIs('materials') || Request::routeIs('archive-materials')) active @endif">
                <span class="material-symbols-outlined">inventory_2</span>
                Materials
            </a>

        </nav>

    @endif

    <!-- Bottom Actions — same design for every role; Settings only shows for
         super_admin/admin since employee-side settings don't exist yet. -->
    <div class="px-2 py-2 border-top light-border">

        @if (auth()->user()->isSuperAdmin())
            <a href="{{ route('admin-settings') }}"
                class="sb-profile btn d-flex align-items-center gap-2 px-3 py-1 w-100 border-0 bg-transparent text-start mb-1 @if (Request::routeIs('admin-settings')) active @endif">
                <span class="material-symbols-outlined">settings</span>
                Settings
            </a>
        @elseif (auth()->user()->isAdmin())
            <a href="{{ route('admin.settings') }}"
                class="sb-profile btn d-flex align-items-center gap-2 px-3 py-1 w-100 border-0 bg-transparent text-start mb-1 @if (Request::routeIs('admin.settings')) active @endif">
                <span class="material-symbols-outlined">settings</span>
                Settings
            </a>
        @endif

        <a href="{{ route('admin-activity-logs') }}"
            class="sb-profile btn d-flex align-items-center gap-2 px-3 py-1 w-100 border-0 bg-transparent text-start mb-1 @if (Request::routeIs('admin-activity-logs')) active @endif">
            <span class="material-symbols-outlined">manage_history</span>
            Activity Logs
        </a>

        <!-- Profile Accordion -->
        <div class="sb-profile-group">
            <button
                class="sb-profile btn d-flex align-items-center gap-2 px-3 py-1 w-100 border-0 bg-transparent text-start"
                id="profileToggle" aria-expanded="{{ Request::routeIs('admin-profile') ? 'true' : 'false' }}">
                <span class="material-symbols-outlined">account_circle</span>
                <span class="flex-grow-1">Profile</span>
                <span class="material-symbols-outlined sb-chevron fs-18" id="profileChevron">expand_more</span>
            </button>

            <div id="profileMenu" class="sb-profile-menu"
                style="display:{{ Request::routeIs('admin-profile') ? 'block' : 'none' }};">
                <a href="{{ route('admin-profile') }}"
                    class="sb-profile-sub btn d-flex align-items-center gap-2 px-3 py-1 w-100 border-0 bg-transparent text-start @if (Request::routeIs('admin-profile')) active @endif">
                    <span class="material-symbols-outlined fs-18">manage_accounts</span>
                    View Profile
                </a>
                <form action="{{ route('logout') }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit"
                        class="sb-logout btn d-flex align-items-center gap-2 px-3 py-1 w-100 border-0 bg-transparent text-start">
                        <span class="material-symbols-outlined fs-18">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>

</aside>
