@extends('layouts.app')

@section('title', 'Users')

@section('content')

<style>
	.user-management {
		--ink: #172a46;
		--muted: #718096;
		--line: #e7edf4;
		--accent: #e66b45;
	}

	.user-management .page-intro {
		background: #102c50;
		border-radius: 18px;
		color: #fff;
		overflow: hidden;
		padding: 30px 32px;
		position: relative;
	}

	.user-management .eyebrow {
		color: #f7b08e;
		font-size: .68rem;
		font-weight: 700;
		letter-spacing: .16em;
		text-transform: uppercase;
	}

	.user-management .page-intro h1 {
		font-size: clamp(1.5rem, 3vw, 2.1rem);
		font-weight: 600;
		letter-spacing: 0;
		margin: 7px 0 5px;
	}

	.user-management .page-intro p {
		color: rgba(255, 255, 255, .72);
		font-size: .88rem;
		margin: 0;
	}

	.user-management .stat-card {
		background: #fff;
		border: 1px solid var(--line);
		border-radius: 14px;
		height: 100%;
		padding: 18px;
	}

	.user-management .stat-icon {
		align-items: center;
		background: #edf5f6;
		border-radius: 11px;
		color: #2c7a7b;
		display: flex;
		font-size: 1.1rem;
		height: 38px;
		justify-content: center;
		width: 38px;
	}

	.user-management .stat-icon--verified {
		background: #fff3ed;
		color: var(--accent);
	}

	.user-management .stat-icon--pending {
		background: #eef0fb;
		color: #5967ad;
	}

	.user-management .stat-label {
		color: var(--muted);
		font-size: .74rem;
		font-weight: 500;
		margin-top: 16px;
	}

	.user-management .stat-value {
		color: var(--ink);
		font-size: 1.6rem;
		font-weight: 600;
		line-height: 1.1;
	}

	.user-management .surface {
		background: #fff;
		border: 1px solid var(--line);
		border-radius: 14px;
		overflow: hidden;
	}

	.user-management .surface-heading {
		align-items: center;
		display: flex;
		justify-content: space-between;
		padding: 22px 24px 16px;
	}

	.user-management .view-tabs {
		border-bottom: 1px solid var(--line);
		margin-bottom: 20px;
	}

	.user-management .view-tabs .nav-link {
		border: 0;
		border-bottom: 2px solid transparent;
		color: var(--muted);
		font-size: .8rem;
		font-weight: 600;
		padding: 11px 16px;
	}

	.user-management .view-tabs .nav-link.active {
		background: transparent;
		border-bottom-color: #173e5f;
		color: #173e5f;
	}

	.user-management .surface-heading h2 {
		color: var(--ink);
		font-size: 1rem;
		font-weight: 600;
		margin: 0;
	}

	.user-management .surface-heading p {
		color: var(--muted);
		font-size: .76rem;
		margin: 4px 0 0;
	}

	.user-management .filter-bar {
		background: #f8fafc;
		border-bottom: 1px solid var(--line);
		padding: 15px 24px;
	}

	.user-management .filter-bar .form-control,
	.user-management .filter-bar .form-select {
		border-color: #dfe6ee;
		border-radius: 8px;
		font-size: .78rem;
		min-height: 40px;
	}

	.user-management .filter-bar .form-control:focus,
	.user-management .filter-bar .form-select:focus {
		border-color: #78aeb0;
		box-shadow: 0 0 0 .2rem rgba(44, 122, 123, .1);
	}

	.user-management .table {
		margin: 0;
		min-width: 720px;
	}

	.user-management .table th {
		background: #fff;
		border-bottom: 1px solid var(--line);
		color: #98a2b3;
		font-size: .67rem;
		font-weight: 600;
		letter-spacing: .08em;
		padding: 14px 24px;
		text-transform: uppercase;
	}

	.user-management .table td {
		border-color: #f0f3f6;
		color: #44546a;
		font-size: .79rem;
		padding: 15px 24px;
		vertical-align: middle;
	}

	.user-management .identity {
		align-items: center;
		display: flex;
		gap: 11px;
	}

	.user-management .avatar {
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

	.user-management .identity strong,
	.user-management .identity > div > span {
		display: block;
	}

	.user-management .identity strong {
		color: var(--ink);
		font-size: .81rem;
		font-weight: 600;
	}

	.user-management .identity > div > span {
		color: var(--muted);
		font-size: .7rem;
		margin-top: 2px;
	}

	.user-management .role-pill,
	.user-management .status-pill {
		border-radius: 99px;
		display: inline-block;
		font-size: .67rem;
		font-weight: 600;
		padding: 5px 9px;
	}

	.user-management .role-pill {
		background: #f0f3f8;
		color: #53657e;
	}

	.user-management .status-pill {
		background: #e8f6ef;
		color: #238455;
	}

	.user-management .status-pill.pending {
		background: #fff4df;
		color: #a66a18;
	}

	.user-management .status-pill.inactive {
		background: #fcebea;
		color: #b42318;
	}

	.user-management .table-footer {
		align-items: center;
		border-top: 1px solid var(--line);
		color: var(--muted);
		display: flex;
		font-size: .74rem;
		justify-content: space-between;
		padding: 15px 24px;
	}

	.user-management .pagination {
		margin: 0;
	}

	.user-management .pagination .page-link {
		border: 0;
		border-radius: 7px;
		color: #65748a;
		font-size: .75rem;
		margin-left: 3px;
	}

	.user-management .pagination .active .page-link {
		background: #173e5f;
		color: #fff;
	}

	@media (max-width: 575.98px) {
		.user-management .page-intro {
			padding: 23px;
		}

		.user-management .surface-heading,
		.user-management .filter-bar,
		.user-management .table-footer {
			padding-left: 16px;
			padding-right: 16px;
		}

		.user-management .table-footer {
			align-items: flex-start;
			flex-direction: column;
			gap: 10px;
		}
	}
</style>

<div class="user-management">
	<div class="page-intro mb-4">
		<span class="eyebrow">Workspace administration</span>
		<h1>User management</h1>
		<p>Keep your service team aligned with a clear view of every account.</p>
	</div>

	<div class="row g-3 mb-4">
		<div class="col-sm-4">
			<div class="stat-card">
				<div class="stat-icon"><i class="bi bi-people"></i></div>
				<div class="stat-label">Total accounts</div>
				<div class="stat-value">{{ number_format($totalUsers) }}</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="stat-card">
				<div class="stat-icon stat-icon--verified"><i class="bi bi-patch-check"></i></div>
				<div class="stat-label">Verified accounts</div>
				<div class="stat-value">{{ number_format($verifiedUsers) }}</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="stat-card">
				<div class="stat-icon stat-icon--pending"><i class="bi bi-hourglass-split"></i></div>
				<div class="stat-label">Pending approval</div>
				<div class="stat-value">{{ number_format($pendingUsers) }}</div>
			</div>
		</div>
	</div>

	<ul class="nav view-tabs" aria-label="User management views">
		<li class="nav-item">
			<a class="nav-link active" aria-current="page" href="{{ route('users.index') }}">
				<i class="bi bi-people me-1"></i> Directory
			</a>
		</li>
		@if(auth()->user()->usergroup === 'sysadmin')
			<li class="nav-item">
				<a class="nav-link" href="{{ route('users.approvals') }}">
					<i class="bi bi-person-check me-1"></i> Account approvals
				</a>
			</li>
		@endif
	</ul>

	<section class="surface">
		<div class="surface-heading">
			<div>
				<h2>Directory</h2>
				<p>Review account access and approval status.</p>
			</div>
			<span class="small text-muted d-none d-md-inline">{{ $users->total() }} results</span>
		</div>
		<form class="filter-bar" method="GET" action="{{ route('users.index') }}">
			<div class="row g-2">
				<div class="col-lg-6">
					<div class="position-relative">
						<i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
						<input class="form-control ps-5" type="search" name="search" value="{{ $filters['search'] }}" placeholder="Search by name or email">
					</div>
				</div>
				<div class="col-sm-5 col-lg-3">
					<select class="form-select" name="role">
						<option value="">All roles</option>
						@foreach($roles as $availableRole)
							<option value="{{ $availableRole }}" @selected($filters['role'] === $availableRole)>{{ ucfirst($availableRole) }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-5 col-lg-2">
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
				<thead><tr><th>User</th><th>Role</th><th>Status</th><th>Joined</th><th class="text-end">Action</th></tr></thead>
				<tbody>
					@forelse($users as $user)
						@php
							$displayName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->name;
							$initials = collect(explode(' ', $displayName))
								->filter()
								->take(2)
								->map(fn ($part) => strtoupper(substr($part, 0, 1)))
								->join('');
							$statusValue = strtolower((string) $user->status);
							$statusLabel = $statusValue !== '' ? ucfirst($statusValue) : 'Unknown';
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
							<td><span class="role-pill">{{ ucfirst($user->usergroup ?: 'Member') }}</span></td>
							<td><span class="status-pill {{ $statusValue === 'inactive' ? 'inactive' : '' }}">{{ $statusLabel }}</span></td>
							<td>{{ optional($user->created_at)->format('M d, Y') }}</td>
							<td class="text-end">
								@if(auth()->user()->usergroup === 'sysadmin' && !auth()->user()->is($user))
									<form method="POST" action="{{ route('users.status', $user) }}">
										@csrf
										@method('PATCH')
										<button class="btn btn-sm {{ $user->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }}" type="submit">
											<i class="bi {{ $user->status === 'active' ? 'bi-person-slash' : 'bi-person-check' }} me-1"></i>
											{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
										</button>
									</form>
								@endif
							</td>
						</tr>
					@empty
						<tr>
							<td class="text-center py-5" colspan="5">
								<i class="bi bi-person-x d-block fs-3 text-muted mb-2"></i>
								No users match the current filters.
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		@if($users->hasPages())
			<div class="table-footer">
				<span>Showing {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }} users</span>
				{{ $users->onEachSide(1)->links() }}
			</div>
		@endif
	</section>
</div>

@endsection