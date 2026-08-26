@extends('layouts.app')

@section('title', 'My Requests')

@section('content')

<style>
/* ===================================================
   PAGE
=================================================== */

body{
    background:#f5f7fb;
    color:#1f2937;
    font-family:Inter,system-ui,-apple-system,sans-serif;
}

.container-fluid{
    max-width:1450px;
}


/* ===================================================
   HEADER
=================================================== */

.guest-ticket-header{
    background:#fff;
    border:1px solid #edf1f7;
    border-radius:10px;
    padding:28px 34px;
    box-shadow:0 8px 30px rgba(15,23,42,.04);
    position:relative;
    overflow:hidden;
}


.guest-ticket-header h2{
    font-size:2rem;
    font-weight:700;
    margin-bottom:4px;
}

.guest-ticket-header p{
    margin:0;
    color:#6b7280;
}

.guest-ticket-email{
    background:#eef4ff;
    color:#0d47a1;
    border-radius:999px;
    padding:12px 20px;
    font-weight:600;
    display:flex;
    align-items:center;
}


/* ===================================================
   SUMMARY
=================================================== */

.summary-card{

    background:#fff;

    border:1px solid #edf1f7;

    border-radius:10px;

    padding:22px;

    display:flex;

    align-items:center;

    gap:18px;

    transition:.25s;

    height:100%;

    box-shadow:0 4px 20px rgba(0,0,0,.03);

}

.summary-card:hover{

    transform:translateY(-4px);

    box-shadow:0 18px 35px rgba(0,0,0,.08);

}

.summary-icon{

    width:62px;

    height:62px;

    border-radius:18px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:26px;

}

.summary-icon.total{

    background:#e8f1ff;

    color:#0d6efd;

}

.summary-icon.progress{

    background:#dbeafe;

    color:#2563eb;

}

.summary-icon.review{

    background:#fff3cd;

    color:#d97706;

}

.summary-icon.completed{

    background:#dcfce7;

    color:#16a34a;

}

.summary-icon.rejected{

    background:#fee2e2;

    color:#dc2626;

}

.summary-label{

    color:#6b7280;

    font-size:.8rem;

    margin-bottom:2px;

}

.summary-value{

    font-size:2rem;

    font-weight:700;

    line-height:1;

}




.ticket-table-card{

    background:#fff;

    border-radius:10px;

    overflow:hidden;

    border:1px solid #edf1f7;

    box-shadow:0 10px 30px rgba(0,0,0,.05);

}

.ticket-toolbar{

    padding:22px;

    border-bottom:1px solid #eef2f7;

    background:#fafbfd;

}

.search-box{

    position:relative;

}

.search-box i{

    position:absolute;

    left:18px;

    top:50%;

    transform:translateY(-50%);

    color:#9ca3af;

}

.search-box input{

    padding-left:45px;

}

.form-control,

.form-select{

    border-radius:12px;

    border:1px solid #dbe2ea;

    height:48px;

    box-shadow:none;

}

.form-control:focus,

.form-select:focus{

    border-color:#3b82f6;

    box-shadow:0 0 0 .15rem rgba(59,130,246,.15);

}

.btn-light{

    border-radius:12px;

    border:1px solid #dbe2ea;

    height:48px;

    font-weight:600;

    background:#fff;

}

.btn-light:hover{

    background:#f5f7fb;

}


/* ===================================================
   TABLE
=================================================== */

.ticket-table{

    margin:0;

}

.ticket-table thead{

    background:#f8fafc;

}

.ticket-table th{

    border:none;

    color:#6b7280;

    font-size:.82rem;

    font-weight:700;

    padding:18px 24px;

    white-space:nowrap;

}

.ticket-table td{

    border-top:1px solid #f1f5f9;

    padding:20px 24px;

    vertical-align:middle;

}

.ticket-table tbody tr{

    transition:.2s;

}

.ticket-table tbody tr:hover{

    background:#f8fbff;

}

.ticket-id{

    color:#0d47a1;

    font-weight:700;

    font-size:.95rem;

}


/* ===================================================
   STATUS BADGES
=================================================== */

.status-badge{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 14px;

    border-radius:999px;

    font-size:.75rem;

    font-weight:700;

    letter-spacing:.2px;

}

.status-pending{

    background:#fff3cd;

    color:#9a6700;

}

.status-review{

    background:#ede9fe;

    color:#6d28d9;

}

.status-acknowledged{

    background:#dbeafe;

    color:#1d4ed8;

}

.status-inprogress,

.status-in_progress{

    background:#dbeafe;

    color:#1d4ed8;

}

.status-evaluation{

    background:#fff7d6;

    color:#b45309;

}

.status-completed{

    background:#dcfce7;

    color:#15803d;

}

.status-resolved{

    background:#dcfce7;

    color:#15803d;

}

.status-returned{

    background:#fee2e2;

    color:#b91c1c;

}

.status-rejected{

    background:#fee2e2;

    color:#b91c1c;

}


/* ===================================================
   BUTTON
=================================================== */

.ticket-action-btn{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    white-space:nowrap;

    border:none;

    border-radius:10px;

    padding:.5rem 1rem;

    font-size:.82rem;

    font-weight:600;

    color:#fff;

    background:#0d6efd;

    box-shadow:0 6px 14px rgba(37,99,235,.18);

    transition:.2s ease;

}

.ticket-action-btn:hover{

    background:#0b5ed7;

    color:#fff;

    transform:translateY(-1px);

    box-shadow:0 10px 20px rgba(37,99,235,.24);

}

.ticket-action-btn i{

    font-size:1rem;

}


/* ===================================================
   EMPTY STATE
=================================================== */

.empty-state{

    padding:80px 20px;

}

.empty-state img{

    opacity:.85;

}

.empty-state h5{

    margin-top:10px;

    font-weight:700;

}


/* ===================================================
   PAGINATION
=================================================== */

.pagination{

    margin:0;

    justify-content:flex-end;

}

.page-link{

    border:none;

    margin:0 3px;

    border-radius:10px !important;

    color:#4b5563;

    min-width:38px;

    text-align:center;

}

.page-link:hover{

    background:#eef4ff;

    color:#0d6efd;

}

.page-item.active .page-link{

    background:#0d6efd;

    color:#fff;

}


/* ===================================================
   SCROLLBAR
=================================================== */

.table-responsive::-webkit-scrollbar{

    height:8px;

}

.table-responsive::-webkit-scrollbar-thumb{

    background:#d6dbe4;

    border-radius:20px;

}

.table-responsive::-webkit-scrollbar-track{

    background:#f4f6f9;

}


/* ===================================================
   MOBILE
=================================================== */

@media(max-width:991px){

    .guest-ticket-header{

        padding:24px;

    }

    .guest-ticket-email{

        width:100%;

        justify-content:center;

    }

    .summary-card{

        padding:18px;

    }

    .summary-value{

        font-size:1.6rem;

    }

    .ticket-toolbar{

        padding:18px;

    }

    .ticket-table td,

    .ticket-table th{

        padding:15px;

    }

}

@media(max-width:576px){

    .guest-ticket-header h2{

        font-size:1.6rem;

    }

    .summary-icon{

        width:52px;

        height:52px;

        font-size:22px;

    }

}
</style>
<div class="p-4">

    <div class="container-fluid py-4">
        <div class="guest-ticket-header mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <nav class="small mb-2">
                        <a href={{url('/')}} class="text-decoration-none text-secondary">
                            Home
                        </a>
                            <span class="mx-2 text-muted">/</span>
                            <span class="fw-semibold text-dark">
                            My Requests
                        </span>
                    </nav>
                        <h2 class="fw-bold mb-1">
                        My Requests
                    </h2>
                        <p class="text-muted mb-0">
                        View and monitor all service requests submitted using
                        <strong>{{ $email }}</strong>
                        </p>
                    </div>
                    <div class="guest-ticket-email">
                        <i class="bi bi-envelope-paper-heart me-2"></i>
                        {{ $email }}
                    </div>
                </div>
            </div>
     
        <div class="row g-3 mb-4">
                <div class="col-xl col-lg-4 col-md-6">
                    <div class="summary-card">
                        <div class="summary-icon total">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>
                        <div>
                            <div class="summary-label">
                            All Requests
                        </div>
                            <div class="summary-value">
                            {{ $tickets->count() }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl col-lg-4 col-md-6">
                    <div class="summary-card">
                        <div class="summary-icon progress">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                        <div>
                            <div class="summary-label">
                            In Progress
                        </div>
                            <div class="summary-value">
                            {{ $tickets->where('ticket_status','inprogress')->count() }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl col-lg-4 col-md-6">
                    <div class="summary-card">
                        <div class="summary-icon review">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                        <div>
                            <div class="summary-label">
                            For Review
                        </div>
                            <div class="summary-value">
                            {{ $tickets->where('ticket_status','review')->count() }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl col-lg-4 col-md-6">
                    <div class="summary-card">
                        <div class="summary-icon completed">
                        <i class="bi bi-check-circle"></i>
                    </div>
                        <div>
                            <div class="summary-label">
                            Completed
                        </div>
                            <div class="summary-value">
                            {{ $tickets->whereIn('ticket_status',['resolved','completed'])->count() }}
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl col-lg-4 col-md-6">
                    <div class="summary-card">
                        <div class="summary-icon rejected">
                        <i class="bi bi-x-circle"></i>
                    </div>
                        <div>
                            <div class="summary-label">
                            Rejected
                        </div>
                            <div class="summary-value">
                            {{ $tickets->where('ticket_status','rejected')->count() }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ticket-table-card">
                {{-- Toolbar --}}
            <div class="ticket-toolbar">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-5">
                            <div class="search-box">
                                <i class="bi bi-search"></i>

                                <div class="ps-4 flex-grow-1">
                                    <input
                                        id="ticketSearchInput"
                                        type="text"
                                        class="form-control"
                                        placeholder="Search by Ticket Number, Purpose, Program..."
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <select id="ticketStatusFilter" class="form-select">
                                <option value="">All Status</option>
                                @foreach($tickets->pluck('ticket_status')->unique()->filter() as $statusOption)
                                <option value="{{ strtolower($statusOption) }}">{{ ucwords(str_replace('_',' ',$statusOption)) }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <input
                            id="ticketDateFilter"
                            type="date"
                            class="form-control"
                        >
                        </div>
                        <div class="col-lg-3 text-lg-end">
                            <button id="ticketFilterResetBtn" class="btn btn-light">
                                <i class="bi bi-x-circle me-2"></i>
                                Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
       
            @if($tickets->count())
                <div class="table-responsive">
                    <table class="table align-middle ticket-table">
                        <thead>
                        <tr>
                            <th>Ticket No.</th>
                            <th>Purpose</th>
                            <th>Program</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                            <th>Updated</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody id="ticketTableBody">
                        @foreach($tickets as $ticket)
                            <tr
                            data-search="{{ strtolower($ticket->ticket_id.' '.$ticket->purpose_of_request.' '.optional($ticket->programDetails)->program) }}"
                            data-status="{{ strtolower($ticket->ticket_status) }}"
                            data-date="{{ optional($ticket->created_at)->format('Y-m-d') }}"
                        >
                                <td>
                                <div class="ticket-id">
  
                                    {{ $ticket->ticket_id }}
                                  </div>
                                 <small class="text-muted">
                                      {{ optional($ticket->created_at)->format('M d, Y h:i A') }}
                                  </small>
                              </td>
                             <td>
                                  {{ $ticket->purpose_of_request }}
                              </td>
                              <td>
                                  {{ optional($ticket->programDetails)->program }}
                              </td>
    
                            <td>
    
                                <span class="status-badge status-{{ strtolower($ticket->ticket_status) }}">
    
                                    {{ ucwords(str_replace('_',' ',$ticket->ticket_status)) }}
    
                                </span>
    
                            </td>
    
                            <td>
    
                                {{ optional($ticket->created_at)->format('M d, Y') }}
    
                            </td>
    
                            <td>
    
                                {{ optional($ticket->updated_at)->format('M d, Y') }}
    
                            </td>
    
                            <td class="text-center">
    
                                <a
                                    href="{{ route('guest.ticket.view', ['ticket_id' => $ticket->ticket_id, 'source' => 'email']) }}"
                                    class="ticket-action-btn"
                                >
    
                                    <i class="bi bi-eye"></i>
                                    View Details
    
                                </a>
    
                            </td>
    
                        </tr>
    
                    @endforeach
    
                    </tbody>
    
                </table>
    
                <div id="ticketNoMatch" class="empty-state py-5 text-center d-none">
                    <img
                        src="{{ asset('images/icons/norecentact.png') }}"
                        width="70"
                        class="mb-3"
                    >
                    <h5 class="fw-bold">No Matching Requests</h5>
                    <p class="text-muted mb-0">Try adjusting your search or filters.</p>
                </div>
    
            </div>
    
            @else
    
            <div class="empty-state py-5 text-center">
    
                <img
                    src="{{ asset('images/icons/norecentact.png') }}"
                    width="70"
                    class="mb-3"
                >
    
                <h5 class="fw-bold">
    
                    No Requests Found
    
                </h5>
    
                <p class="text-muted mb-0">
    
                    We couldn't find any service requests associated with this email.
    
                </p>
    
            </div>
    
            @endif
    
    
            {{-- Pagination --}}
    
            @if($tickets->count())
    
            <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
    
                <small class="text-muted" id="ticketPageInfo"></small>
    
                <ul class="pagination mb-0" id="ticketPagination"></ul>
    
            </div>
    
            @endif
    
        </div>
    
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('ticketSearchInput');
    const statusFilter = document.getElementById('ticketStatusFilter');
    const dateFilter = document.getElementById('ticketDateFilter');
    const resetBtn = document.getElementById('ticketFilterResetBtn');
    const tableBody = document.getElementById('ticketTableBody');
    const noMatch = document.getElementById('ticketNoMatch');
    const pageInfo = document.getElementById('ticketPageInfo');
    const pagination = document.getElementById('ticketPagination');
    if (!tableBody) return;

    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const pageSize = 5;
    let currentPage = 1;

    function getFilteredRows() {
        const term = (searchInput?.value || '').trim().toLowerCase();
        const status = statusFilter?.value || '';
        const date = dateFilter?.value || '';

        return rows.filter(row => {
            const matchesTerm = !term || row.dataset.search.includes(term);
            const matchesStatus = !status || row.dataset.status === status;
            const matchesDate = !date || row.dataset.date === date;
            return matchesTerm && matchesStatus && matchesDate;
        });
    }

    function renderPagination(totalPages) {
        if (!pagination) return;
        pagination.innerHTML = '';
        if (totalPages <= 1) return;

        function addItem(label, page, opts = {}) {
            const li = document.createElement('li');
            li.className = 'page-item' + (opts.disabled ? ' disabled' : '') + (opts.active ? ' active' : '');
            const link = document.createElement('a');
            link.className = 'page-link';
            link.href = '#';
            link.textContent = label;
            if (!opts.disabled && !opts.active) {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    currentPage = page;
                    render();
                });
            }
            li.appendChild(link);
            pagination.appendChild(li);
        }

        addItem('Prev', currentPage - 1, { disabled: currentPage === 1 });
        for (let p = 1; p <= totalPages; p++) {
            addItem(String(p), p, { active: p === currentPage });
        }
        addItem('Next', currentPage + 1, { disabled: currentPage === totalPages });
    }

    function render() {
        const filtered = getFilteredRows();
        const totalPages = Math.max(1, Math.ceil(filtered.length / pageSize));
        currentPage = Math.min(currentPage, totalPages);

        const start = (currentPage - 1) * pageSize;
        const pageRows = filtered.slice(start, start + pageSize);

        rows.forEach(row => row.classList.add('d-none'));
        pageRows.forEach(row => row.classList.remove('d-none'));

        if (noMatch) noMatch.classList.toggle('d-none', filtered.length !== 0);

        if (pageInfo) {
            pageInfo.textContent = filtered.length
                ? `Showing ${start + 1}-${Math.min(start + pageRows.length, filtered.length)} of ${filtered.length} request(s)`
                : 'No requests to show';
        }

        renderPagination(totalPages);
    }

    function applyFilters() {
        currentPage = 1;
        render();
    }

    searchInput?.addEventListener('input', applyFilters);
    statusFilter?.addEventListener('change', applyFilters);
    dateFilter?.addEventListener('change', applyFilters);
    resetBtn?.addEventListener('click', function () {
        if (searchInput) searchInput.value = '';
        if (statusFilter) statusFilter.value = '';
        if (dateFilter) dateFilter.value = '';
        applyFilters();
    });

    render();
});

// Auto sign-out 30 minutes after OTP verification, matching the server-side session window
document.addEventListener('DOMContentLoaded', function () {
    const expiresAtMs = new Date('{{ $expiresAt->toIso8601String() }}').getTime();
    const warnBeforeMs = 5 * 60 * 1000;
    let warned = false;

    function redirectExpired() {
        window.location.href = '/';
    }

    function tick() {
        const remainingMs = expiresAtMs - Date.now();

        if (remainingMs <= 0) {
            redirectExpired();
            return;
        }

        if (!warned && remainingMs <= warnBeforeMs) {
            warned = true;
            const minutesLeft = Math.max(1, Math.round(remainingMs / 60000));
            if (typeof Swal !== 'undefined' && Swal.fire) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Session expiring soon',
                    text: `Your verified session will expire in about ${minutesLeft} minute(s). Please finish viewing your requests.`,
                    confirmButtonColor: '#062c52'
                });
            }
        }

        setTimeout(tick, 15000);
    }

    setTimeout(redirectExpired, Math.max(0, expiresAtMs - Date.now()));
    tick();
});
</script>
@include('partials.govph_footer')
@endsection

