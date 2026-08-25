@extends('layouts.app')

@section('title', 'Account Approvals')

@section('content')
<style>
    .approval-page {
        --ink: #172a46;
        --muted: #718096;
        --line: #e7edf4;
    }

    .approval-page .page-intro {
        background: #102c50;
        border-radius: 18px;
        color: #fff;
        padding: 30px 32px;
    }

    .approval-page .eyebrow {
        color: #f7b08e;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    .approval-page h1 {
        font-size: clamp(1.5rem, 3vw, 2.1rem);
        font-weight: 600;
        margin: 7px 0 5px;
    }

    .approval-page .page-intro p {
        color: rgba(255, 255, 255, .72);
        font-size: .88rem;
        margin: 0;
    }

    .approval-page .view-tabs {
        border-bottom: 1px solid var(--line);
        margin-bottom: 20px;
    }

    .approval-page .view-tabs .nav-link {
        border: 0;
        border-bottom: 2px solid transparent;
        color: var(--muted);
        font-size: .8rem;
        font-weight: 600;
        padding: 11px 16px;
    }

    .approval-page .view-tabs .nav-link.active {
        background: transparent;
        border-bottom-color: #173e5f;
        color: #173e5f;
    }

    .approval-page .surface {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        overflow: hidden;
    }

    .approval-page .surface-heading {
        align-items: center;
        display: flex;
        justify-content: space-between;
        padding: 22px 24px 16px;
    }

    .approval-page .surface-heading h2 {
        color: var(--ink);
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }

    .approval-page .surface-heading p {
        color: var(--muted);
        font-size: .76rem;
        margin: 4px 0 0;
    }

    .approval-page .table {
        margin: 0;
        min-width: 680px;
    }

    .approval-page .table th {
        border-bottom: 1px solid var(--line);
        color: #98a2b3;
        font-size: .67rem;
        letter-spacing: .08em;
        padding: 14px 24px;
        text-transform: uppercase;
    }

    .approval-page .table td {
        border-color: #f0f3f6;
        color: #44546a;
        font-size: .79rem;
        padding: 15px 24px;
        vertical-align: middle;
    }

    .approval-page .identity {
        align-items: center;
        display: flex;
        gap: 11px;
    }

    .approval-page .avatar {
        align-items: center;
        background: #e8f1f2;
        border-radius: 10px;
        color: #276b6d;
        display: inline-flex;
        flex: 0 0 36px;
        font-size: .72rem;
        font-weight: 700;
        height: 36px;
        justify-content: center;
        width: 36px;
    }

    .approval-page .identity strong,
    .approval-page .identity span {
        display: block;
    }

    .approval-page .identity strong {
        color: var(--ink);
        font-size: .81rem;
        font-weight: 600;
    }

    .approval-page .identity span {
        color: var(--muted);
        font-size: .7rem;
        margin-top: 2px;
    }

    .approval-page .table-footer {
        align-items: center;
        border-top: 1px solid var(--line);
        color: var(--muted);
        display: flex;
        font-size: .74rem;
        justify-content: space-between;
        padding: 15px 24px;
    }

    @media (max-width: 575.98px) {
        .approval-page .page-intro {
            padding: 23px;
        }

        .approval-page .surface-heading,
        .approval-page .table-footer {
            padding-left: 16px;
            padding-right: 16px;
        }

        .approval-page .table-footer {
            align-items: flex-start;
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<div class="approval-page">
    

    <div class="page-intro mb-4">
        <span class="eyebrow">Sysadmin controls</span>
        <h1>Account approvals</h1>
        <p>Review new accounts before granting access to the service workspace.</p>
    </div>

    <ul class="nav view-tabs" aria-label="User management views">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="bi bi-people me-1"></i> Directory
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('users.approvals') }}">
                <i class="bi bi-person-check me-1"></i> Account approvals
            </a>
        </li>
    </ul>

    @if(session('approval_success'))
        <div class="alert alert-success" role="alert">{{ session('approval_success') }}</div>
    @endif

    <section class="surface">
        <div class="surface-heading">
            <div>
                <h2>Waiting for approval</h2>
                <p>Only a sysadmin can approve these accounts.</p>
            </div>
            <span class="small text-muted d-none d-md-inline">{{ $pendingUsers->total() }} accounts</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Registered</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingUsers as $user)
                        @php
                            $displayName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->name;
                            $initials = collect(explode(' ', $displayName))
                                ->filter()
                                ->take(2)
                                ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                ->join('');
                        @endphp
                        <tr>
                            <td>
                                <div class="identity">
                                    <span class="avatar">{{ $initials }}</span>
                                    <div>
                                        <strong>{{ $displayName }}</strong>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ ucfirst($user->usergroup ?: 'Member') }}</td>
                            <td>{{ optional($user->created_at)->format('M d, Y') }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('users.approve', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success" type="submit">
                                        <i class="bi bi-check2 me-1"></i> Approve
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center py-5" colspan="4">
                                <i class="bi bi-person-check d-block fs-3 text-success mb-2"></i>
                                All accounts have been approved.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pendingUsers->hasPages())
            <div class="table-footer">
                <span>Showing {{ $pendingUsers->firstItem() }}-{{ $pendingUsers->lastItem() }} of {{ $pendingUsers->total() }} accounts</span>
                {{ $pendingUsers->onEachSide(1)->links() }}
            </div>
        @endif
    </section>
</div>
@endsection
