@extends('layouts.app')

@section('title', 'Programs')

@section('content')
<style>
    .program-management {
        --ink: #172a46;
        --muted: #718096;
        --line: #e7edf4;
    }

    .program-management .page-intro {
        padding: 30px 32px;
        border-radius: 18px;
        color: #fff;
        background: #102c50;
    }

    .program-management .eyebrow {
        color: #f7b08e;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    .program-management h1 {
        margin: 7px 0 5px;
        font-size: clamp(1.5rem, 3vw, 2.1rem);
        font-weight: 600;
    }

    .program-management .page-intro p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: .88rem;
    }

    .program-management .stat-card,
    .program-management .surface {
        border: 1px solid var(--line);
        border-radius: 14px;
        background: #fff;
    }

    .program-management .stat-card {
        height: 100%;
        padding: 18px;
    }

    .program-management .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 11px;
        color: #2c7a7b;
        background: #edf5f6;
    }

    .program-management .stat-icon.inactive {
        color: #b42318;
        background: #fcebea;
    }

    .program-management .stat-label {
        margin-top: 16px;
        color: var(--muted);
        font-size: .74rem;
    }

    .program-management .stat-value {
        color: var(--ink);
        font-size: 1.6rem;
        font-weight: 600;
        line-height: 1.1;
    }

    .program-management .surface {
        overflow: hidden;
    }

    .program-management .surface-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 22px 24px 16px;
    }

    .program-management .surface-heading h2 {
        margin: 0;
        color: var(--ink);
        font-size: 1rem;
        font-weight: 600;
    }

    .program-management .surface-heading p {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: .76rem;
    }

    .program-management .filter-bar,
    .program-management .add-bar {
        padding: 15px 24px;
        border-bottom: 1px solid var(--line);
        background: #f8fafc;
    }

    .program-management .form-control,
    .program-management .form-select {
        min-height: 40px;
        border-color: #dfe6ee;
        border-radius: 8px;
        font-size: .78rem;
    }

    .program-management .table {
        min-width: 760px;
        margin: 0;
    }

    .program-management .table th {
        padding: 14px 24px;
        border-bottom: 1px solid var(--line);
        color: #98a2b3;
        font-size: .67rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .program-management .table td {
        padding: 15px 24px;
        border-color: #f0f3f6;
        color: #44546a;
        font-size: .79rem;
        vertical-align: middle;
    }

    .program-management .program-name {
        color: var(--ink);
        font-weight: 600;
    }

    .program-management .program-code {
        color: var(--muted);
        font-size: .72rem;
    }

    .program-management .status-pill {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 99px;
        color: #238455;
        background: #e8f6ef;
        font-size: .67rem;
        font-weight: 600;
    }

    .program-management .status-pill.inactive {
        color: #b42318;
        background: #fcebea;
    }

    .program-management .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 24px;
        border-top: 1px solid var(--line);
        color: var(--muted);
        font-size: .74rem;
    }

    .program-management .pagination {
        margin: 0;
    }

    .program-management .pagination .page-link {
        margin-left: 3px;
        border: 0;
        border-radius: 7px;
        color: #65748a;
        font-size: .75rem;
    }

    .program-management .pagination .active .page-link {
        color: #fff;
        background: #173e5f;
    }

    @media (max-width: 575.98px) {
        .program-management .page-intro {
            padding: 23px;
        }

        .program-management .surface-heading,
        .program-management .filter-bar,
        .program-management .add-bar,
        .program-management .table-footer {
            padding-right: 16px;
            padding-left: 16px;
        }

        .program-management .table-footer {
            align-items: flex-start;
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<div class="program-management">
    <div class="page-intro mb-4">
        <span class="eyebrow">Workspace administration</span>
        <h1>Programs</h1>
        <p>Maintain the programs available for new service requests.</p>
    </div>

    @if (session('program_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('program_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Unable to save the program.</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-grid"></i></div>
                <div class="stat-label">Total programs</div>
                <div class="stat-value">{{ number_format($totalPrograms) }}</div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-check2-circle"></i></div>
                <div class="stat-label">Active programs</div>
                <div class="stat-value">{{ number_format($activePrograms) }}</div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-icon inactive"><i class="bi bi-slash-circle"></i></div>
                <div class="stat-label">Inactive programs</div>
                <div class="stat-value">{{ number_format($inactivePrograms) }}</div>
            </div>
        </div>
    </div>

    <section class="surface">
        <div class="surface-heading">
            <div>
                <h2>Program directory</h2>
                <p>Add, edit, or remove a program from new request forms.</p>
            </div>
            <span class="small text-muted d-none d-md-inline">{{ $programs->total() }} results</span>
        </div>

        <form class="add-bar" method="POST" action="{{ route('programs.store') }}">
            @csrf
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold mb-1" for="next_program_code">Program code</label>
                    <input class="form-control" id="next_program_code" value="{{ $nextProgramCode }}" disabled aria-describedby="program-code-help">
                </div>
                <div class="col-md-7">
                    <label class="form-label small fw-semibold mb-1" for="program">Program name</label>
                    <input class="form-control" id="program" name="program" value="{{ old('program') }}" placeholder="Enter program name" required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-dark w-100" type="submit">
                        <i class="bi bi-plus-lg me-1"></i>
                        Add program
                    </button>
                </div>
            </div>
        </form>

        <form class="filter-bar" method="GET" action="{{ route('programs.index') }}">
            <div class="row g-2">
                <div class="col-lg-7">
                    <input class="form-control" type="search" name="search" value="{{ $filters['search'] }}" placeholder="Search by code or program name">
                </div>
                <div class="col-sm-5 col-lg-4">
                    <select class="form-select" name="status">
                        <option value="">All status</option>
                        <option value="active" @selected($filters['status'] === 'active')>Active</option>
                        <option value="inactive" @selected($filters['status'] === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="col-sm-2 col-lg-1">
                    <button class="btn btn-dark w-100" type="submit" aria-label="Apply filters">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Status</th>
                        <th>Created by</th>
                        <th>Updated</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programs as $program)
                        <tr>
                            <td>
                                <div class="program-name">{{ $program->program }}</div>
                                <div class="program-code">{{ $program->program_id }}</div>
                            </td>
                            <td>
                                <span class="status-pill {{ $program->status === 'inactive' ? 'inactive' : '' }}">
                                    {{ ucfirst($program->status) }}
                                </span>
                            </td>
                            <td>{{ optional($program->creator)->name ?? 'Unknown' }}</td>
                            <td>{{ optional($program->updated_at)->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#editProgram{{ $program->id }}">
                                        <i class="bi bi-pencil me-1"></i>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('programs.status', $program) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm {{ $program->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }}" type="submit">
                                            <i class="bi {{ $program->status === 'active' ? 'bi-slash-circle' : 'bi-check-circle' }} me-1"></i>
                                            {{ $program->status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center py-5" colspan="5">
                                <i class="bi bi-grid-3x3-gap d-block fs-3 text-muted mb-2"></i>
                                No programs match the current filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($programs->hasPages())
            <div class="table-footer">
                <span>Showing {{ $programs->firstItem() }}-{{ $programs->lastItem() }} of {{ $programs->total() }} programs</span>
                {{ $programs->onEachSide(1)->links() }}
            </div>
        @endif
    </section>
</div>

@foreach ($programs as $program)
    <div class="modal fade" id="editProgram{{ $program->id }}" tabindex="-1" aria-labelledby="editProgramLabel{{ $program->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProgramLabel{{ $program->id }}">Edit program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('programs.update', $program) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="editProgramId{{ $program->id }}">Program code</label>
                            <input class="form-control" id="editProgramId{{ $program->id }}" value="{{ $program->program_id }}" disabled>
                            <div class="form-text">Program codes cannot be changed.</div>
                        </div>
                        <div>
                            <label class="form-label" for="editProgramName{{ $program->id }}">Program name</label>
                            <input class="form-control" id="editProgramName{{ $program->id }}" name="program" value="{{ $program->program }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-dark" type="submit">
                            <i class="bi bi-save me-1"></i>
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection
