@extends('layouts.app')

@section('title', 'Feedback Report')

@section('content')
    @php
        use Illuminate\Support\Str;

        $percentage = fn($value) => $total ? round(($value / $total) * 100, 1) : 0;
        $trendValues = $trend->values();
        $trendPoints =
            $trendValues->count() > 1
                ? $trendValues
                    ->map(
                        fn($value, $index) => ($index / ($trendValues->count() - 1)) * 390 .
                            ',' .
                            (100 - ($value / 5) * 76 + 8),
                    )
                    ->implode(' ')
                : '0,84 390,84';
        $distribution = [
            [
                'label' => 'Very Satisfied',
                'value' => $feedbacks->where('overall_satisfaction', 1)->count(),
                'color' => '#08bd78',
            ],
            [
                'label' => 'Satisfied',
                'value' => $feedbacks->where('overall_satisfaction', 2)->count(),
                'color' => '#a9e4ce',
            ],
            ['label' => 'Neutral', 'value' => $neutral, 'color' => '#ffd65a'],
            [
                'label' => 'Dissatisfied',
                'value' => $feedbacks->where('overall_satisfaction', 4)->count(),
                'color' => '#ffad9f',
            ],
            [
                'label' => 'Very Dissatisfied',
                'value' => $feedbacks->where('overall_satisfaction', 5)->count(),
                'color' => '#ff6d6d',
            ],
        ];
        $donutTotal = max(1, $total);
        $donutOffset = 0;
    @endphp

    <div class="feedback-report">
        <div class="report-heading">
            <div class="report-period"><i class="bi bi-calendar3"></i><span>{{ $dateFrom->format('M d, Y') }} -
                    {{ $dateTo->format('M d, Y') }}</span></div>
        </div>
        <form class="feedback-toolbar" method="GET" action="{{ route('feedback') }}">
            <div class="filter-label"><i class="bi bi-sliders2"></i><span>Report period</span></div>
            <input class="form-control" type="date" name="date_from" value="{{ $dateFrom->format('Y-m-d') }}"
                aria-label="Start date">
            <input class="form-control" type="date" name="date_to" value="{{ $dateTo->format('Y-m-d') }}"
                aria-label="End date">
            <button class="btn btn-primary" type="submit"><i class="bi bi-filter me-1"></i>Apply</button>
        </form>
        <div class="feedback-grid">
            <div class="feedback-card">
                <div class="eyebrow">Overall Satisfaction Score</div>
                <div class="score-row"><strong>{{ $average('overall_satisfaction') }}</strong><span>/ 5</span></div>
                <div class="stars">{{ str_repeat('★', round($average('overall_satisfaction'))) }}<span
                        style="color:#dce1e5">{{ str_repeat('★', 5 - round($average('overall_satisfaction'))) }}</span>
                </div>
                <div class="delta">↗ Based on {{ $total }} responses</div>
            </div>
            <div class="feedback-card">
                <div class="eyebrow">Total Feedback Received</div>
                <h3>{{ number_format($total) }}</h3>
                <div class="delta">↗ All submitted feedback</div>
            </div>
            <div class="feedback-card"><span class="mood positive" aria-hidden="true"><i class="bi bi-emoji-smile-fill"></i></span>
                <div class="eyebrow">Positive Feedback</div>
                <h3>{{ number_format($positive) }}</h3><small>{{ $percentage($positive) }}% of total feedback</small>
                <div class="delta">↗ Ratings 1-2</div>
            </div>
            <div class="feedback-card"><span class="mood neutral" aria-hidden="true"><i class="bi bi-emoji-neutral-fill"></i></span>
                <div class="eyebrow">Neutral Feedback</div>
                <h3>{{ number_format($neutral) }}</h3><small>{{ $percentage($neutral) }}% of total feedback</small>
                <div class="delta">Ratings of 3</div>
            </div>
            <div class="feedback-card"><span class="mood negative" aria-hidden="true"><i class="bi bi-emoji-frown-fill"></i></span>
                <div class="eyebrow">Negative Feedback</div>
                <h3>{{ number_format($negative) }}</h3><small>{{ $percentage($negative) }}% of total feedback</small>
                <div class="delta down">Ratings 4-5</div>
            </div>
        </div>
        <div class="feedback-columns">
            <div class="feedback-card chart-panel">
                <h2 class="panel-title">Satisfaction Trend <span class="text-muted"></span></h2>
                <div class="panel-subtitle">Average satisfaction score over time</div>
                <div class="chart-wrap"><svg viewBox="0 0 390 100" preserveAspectRatio="none">
                        <polyline points="{{ $trendPoints }}" fill="none" stroke="#3e78ff" stroke-width="2"
                            vector-effect="non-scaling-stroke" />
                    </svg></div>
                <div class="chart-labels">
                    @foreach ($trend->keys() as $label)
                        <span>{{ $label }}</span>
                    @endforeach
                </div>
            </div>
            <div class="feedback-card distribution-panel">
                <h2 class="panel-title">Satisfaction Distribution <span class="text-muted"></span></h2>
                <div class="distribution">
                    <div class="donut"></div>
                    <div class="legend">
                        @foreach ($distribution as $item)
                            <div class="legend-row"><i
                                    style="background:{{ $item['color'] }}"></i>{{ $item['label'] }}<b>{{ $item['value'] }}
                                    ({{ $percentage($item['value']) }}%)</b></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="lower-grid">
            <div class="feedback-card">
                <h2 class="panel-title">Feedback by Category <span class="text-muted"></span></h2>
                <table class="category-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Avg. Satisfaction Score</th>
                            <th>Total Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categoryStats as $item)
                            <tr>
                                <td>{{ Str::limit($item['category'], 22) }}</td>
                                <td><span class="mini-stars">{{ str_repeat('★', round($item['average'])) }}</span></td>
                                <td>{{ $item['total'] }} ({{ $percentage($item['total']) }}%)</td>
                        </tr>@empty<tr>
                                <td colspan="3" class="empty-state">No feedback in this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="feedback-card">
                <h2 class="panel-title">Top Positive Feedback Themes <span class="text-muted"></span></h2>
                <ul class="theme-list">
                    @foreach ($themeStats->take(4) as $item)
                        <li><span class="theme-icon">↑</span>{{ $item['label'] }}<b>{{ $item['average'] }} / 5</b></li>
                    @endforeach
                </ul>
            </div>
            <div class="feedback-card">
                <h2 class="panel-title">Top Improvement Areas <span class="text-muted"></span></h2>
                <ul class="theme-list">
                    @foreach ($themeStats->sortBy('average')->take(4) as $item)
                        <li><span class="theme-icon warn">↓</span>{{ $item['label'] }}<b>{{ $item['average'] }} / 5</b>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="feedback-card feedback-table-panel">
            <h2 class="panel-title">Feedbacks <span class="text-muted"></span></h2>
            <table class="feedback-table">
                <thead>
                    <tr>
                        <th>Ticket Number</th>
                        <th>Category</th>
                        <th>Requester</th>
                        <th>Satisfaction</th>
                        <th>Feedback</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                        <tr>
                            <td><a
                                    href="{{ route('ticket.view', $feedback->ticket->ticket_id) }}">{{ $feedback->ticket->ticket_id }}</a>
                            </td>
                            <td>{{ $feedback->ticket->ticket_category }}</td>
                            <td>{{ trim($feedback->ticket->requestor_first_name . ' ' . $feedback->ticket->requestor_last_name) }}
                            </td>
                            <td class="mini-stars">{{ str_repeat('★', 6 - ($feedback->overall_satisfaction ?? 5)) }}</td>
                            <td>{{ Str::limit($feedback->additional_comments ?: 'No comment provided.', 55) }}</td>
                            <td>{{ $feedback->created_at->format('M d, Y g:i A') }}</td>
                    </tr>@empty<tr>
                            <td colspan="6" class="empty-state">No feedback submitted for the selected dates.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="feedback-pagination"><span>Showing {{ $feedbacks->count() }} of {{ $feedbacks->count() }}
                    feedbacks</span><span><span class="page-number active">1</span></span></div>
        </div>
    </div>

    
    <style>
        .feedback-report {
            --ink: #162033;
            --muted: #7d8794;
            --line: #e6e9ee;
            --navy: #0b2b73;
            color: var(--ink);
            font-size: 12px
        }

        .feedback-toolbar {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 14px;
            flex-wrap: wrap
        }

        .feedback-toolbar .form-control,
        .feedback-toolbar .btn {
            height: 38px;
            font-size: 11px;
            border-color: var(--line);
            border-radius: 4px
        }

        .feedback-toolbar .btn {
            font-weight: 600;
            padding: 0 15px
        }

        .feedback-toolbar .btn-primary {
            background: var(--navy);
            border-color: var(--navy)
        }

        .feedback-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin-bottom: 8px
        }

        .feedback-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 5px;
            padding: 12px;
            min-width: 0
        }

        .feedback-card .eyebrow {
            font-size: 9px;
            color: #68717d;
            margin-bottom: 5px
        }

        .feedback-card h3 {
            font-size: 18px;
            margin: 0 0 3px;
            font-weight: 700
        }

        .feedback-card small {
            font-size: 9px;
            color: #6c7784
        }

        .feedback-card .delta {
            font-size: 9px;
            color: #13a66f;
            margin-top: 4px
        }

        .feedback-card .delta.down {
            color: #ee6565
        }

        .stars {
            color: #f8ae4b;
            letter-spacing: 1px;
            font-size: 19px;
            line-height: 1
        }

        .score-row {
            display: flex;
            align-items: center;
            gap: 6px
        }

        .score-row strong {
            font-size: 18px
        }

        .score-row span {
            color: #7c8590
        }

        .mood {
            float: right;
            font-size: 19px
        }

        .mood.positive {
            color: #08bd78
        }

        .mood.neutral {
            color: #ff9e73
        }

        .mood.negative {
            color: #ff6d6d
        }

        .feedback-columns {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 8px;
            margin-bottom: 8px
        }

        .panel-title {
            font-size: 13px;
            font-weight: 600;
            margin: 0
        }

        .panel-subtitle {
            font-size: 9px;
            color: var(--muted);
            margin: 2px 0 8px
        }

        .chart-panel {
            height: 128px
        }

        .chart-wrap {
            height: 84px;
            position: relative;
            border-bottom: 1px solid #e5e7eb;
            background: repeating-linear-gradient(to bottom, transparent 0, transparent 20px, #eef0f2 21px)
        }

        .chart-wrap svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            overflow: visible
        }

        .chart-labels {
            display: flex;
            justify-content: space-between;
            font-size: 8px;
            color: #68717d;
            margin-top: 5px
        }

        .distribution {
            display: flex;
            align-items: center;
            gap: 18px;
            height: 88px
        }

        .donut {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            position: relative;

            background:conic-gradient(@foreach ($distribution as $item)
                    {{ $item['color'] }} {{ $donutOffset }}deg {{ $donutOffset += ($item['value'] / $donutTotal) * 360 }}deg,
                @endforeach
                #f3f4f6 0 360deg)
        }

        .donut:after {
            content: "";
            position: absolute;
            inset: 21px;
            background: #fff;
            border-radius: 50%
        }

        .legend {
            flex: 1
        }

        .legend-row {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 9px;
            margin: 4px 0
        }

        .legend-row i {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block
        }

        .legend-row b {
            margin-left: auto;
            font-weight: 600
        }

        .lower-grid {
            display: grid;
            grid-template-columns: 1fr 1.15fr 1.15fr;
            gap: 8px;
            margin-bottom: 8px
        }

        .category-table,
        .feedback-table {
            width: 100%;
            border-collapse: collapse
        }

        .category-table th,
        .category-table td {
            padding: 5px 0;
            border-bottom: 1px solid #f0f1f3;
            font-size: 9px;
            text-align: left
        }

        .category-table th {
            font-size: 8px;
            color: #727b86;
            font-weight: 500
        }

        .category-table td:not(:first-child),
        .category-table th:not(:first-child) {
            text-align: right
        }

        .mini-stars {
            color: #f8ae4b;
            letter-spacing: 0;
            font-size: 10px
        }

        .theme-list {
            margin: 8px 0 0;
            padding: 0;
            list-style: none
        }

        .theme-list li {
            display: flex;
            gap: 8px;
            padding: 5px 0;
            border-bottom: 1px solid #f0f1f3;
            font-size: 9px
        }

        .theme-list b {
            margin-left: auto;
            font-weight: 500;
            white-space: nowrap
        }

        .theme-icon {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #d9f6eb;
            color: #09a86d;
            font-size: 10px
        }

        .theme-icon.warn {
            background: #ffe0dc;
            color: #f27468
        }

        .feedback-table-panel {
            padding: 12px 0 0;
            overflow: hidden
        }

        .feedback-table-panel .panel-title {
            padding: 0 12px 8px
        }

        .feedback-table thead {
            background: #e8e8e8
        }

        .feedback-table th,
        .feedback-table td {
            padding: 6px 8px;
            font-size: 8px;
            white-space: nowrap;
            text-align: left
        }

        .feedback-table th {
            font-size: 8px;
            color: #303943
        }

        .feedback-table td {
            border-bottom: 1px solid #f0f1f3
        }

        .feedback-table a {
            color: #0959b2;
            font-weight: 600;
            text-decoration: none
        }

        .feedback-pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            color: #77808b;
            font-size: 8px
        }

        .page-number {
            border: 1px solid #dce1e6;
            background: #fff;
            padding: 3px 6px;
            margin-left: 3px;
            border-radius: 2px
        }

        .page-number.active {
            background: var(--navy);
            color: #fff
        }

        .empty-state {
            text-align: center;
            color: #8a939d;
            padding: 25px !important
        }

        @media(max-width:1100px) {
            .feedback-grid {
                grid-template-columns: repeat(3, 1fr)
            }

            .lower-grid {
                grid-template-columns: 1fr 1fr
            }

            .lower-grid .feedback-card:last-child {
                grid-column: span 2
            }
        }

        @media(max-width:700px) {

            .feedback-grid,
            .feedback-columns,
            .lower-grid {
                grid-template-columns: 1fr
            }

            .lower-grid .feedback-card:last-child {
                grid-column: auto
            }

            .feedback-toolbar {
                justify-content: stretch
            }

            .feedback-toolbar>* {
                flex: 1
            }

            .feedback-table-panel {
                overflow-x: auto
            }

            .feedback-table {
                min-width: 720px
            }
        }
   
        .feedback-report {
            max-width: 1500px;
            margin: 0 auto;
            padding: 2px 4px 28px
        }

        .report-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin: 2px 0 22px
        }

        .report-kicker {
            color: #147d6b;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 7px
        }

        .report-kicker i {
            margin-right: 5px
        }

        .report-heading h1 {
            color: #13213a;
            font-size: 25px;
            font-weight: 700;
            letter-spacing: 0;
            margin: 0 0 4px
        }

        .report-heading p {
            color: #718096;
            font-size: 12px;
            margin: 0
        }

        .report-period {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #526173;
            background: #fff;
            border: 1px solid #e3e8ef;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 11px;
            white-space: nowrap
        }

        .report-period i {
            color: #2463b5;
            font-size: 14px
        }

        .feedback-toolbar {
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            padding: 10px 12px;
            margin-bottom: 14px;
            background: #fff;
            border: 1px solid #e5eaf0;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(30, 50, 80, .04)
        }

        .filter-label {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #536276;
            font-size: 11px;
            font-weight: 600;
            margin-right: auto
        }

        .filter-label i {
            color: #2463b5;
            font-size: 14px
        }

        .feedback-toolbar .form-control {
            width: 145px;
            background: #fbfcfe;
            color: #26364d;
            padding: 0 10px
        }

        .feedback-toolbar .form-control:focus {
            border-color: #3d83d2;
            box-shadow: 0 0 0 3px rgba(61, 131, 210, .14)
        }

        .feedback-toolbar .btn {
            height: 36px;
            border-radius: 6px
        }

        .feedback-toolbar .btn-primary {
            background: #1457a6
        }

        .feedback-toolbar .btn-primary:hover {
            background: #0d4384
        }

        .feedback-toolbar .btn-outline-secondary {
            color: #536276
        }

        .feedback-toolbar .btn-outline-secondary:hover {
            background: #eef5fc;
            color: #1457a6;
            border-color: #bcd3ed
        }

        .feedback-card {
            border-radius: 8px;
            box-shadow: 0 3px 14px rgba(30, 50, 80, .035);
            transition: box-shadow .2s ease, transform .2s ease
        }

        .feedback-card:hover {
            box-shadow: 0 8px 22px rgba(30, 50, 80, .08);
            transform: translateY(-1px)
        }

        .feedback-grid {
            gap: 10px;
            margin-bottom: 10px
        }

        .feedback-grid .feedback-card {
            min-height: 132px;
            padding: 15px
        }

        .feedback-card .eyebrow {
            font-weight: 600;
            letter-spacing: .01em
        }

        .feedback-card h3 {
            font-size: 24px;
            color: #17243b
        }

        .feedback-card .delta {
            line-height: 1.4
        }

        .feedback-columns {
            gap: 10px;
            margin-bottom: 10px
        }

        .feedback-columns>.feedback-card,
        .lower-grid>.feedback-card {
            padding: 15px
        }

        .panel-title {
            color: #20304a;
            font-size: 13px
        }

        .panel-title .text-muted {
            font-size: 10px;
            color: #98a3b1 !important
        }

        .panel-subtitle {
            margin-top: 3px
        }

        .chart-panel {
            height: 156px
        }

        .chart-wrap {
            height: 96px;
            margin-top: 10px;
            border-radius: 4px
        }

        .distribution {
            height: 108px;
            gap: 22px
        }

        .donut {
            width: 92px;
            height: 92px;
            flex: 0 0 92px
        }

        .donut:after {
            inset: 24px
        }

        .legend-row {
            font-size: 10px;
            margin: 5px 0
        }

        .legend-row b {
            color: #33445b
        }

        .lower-grid {
            gap: 10px;
            margin-bottom: 10px
        }

        .category-table th,
        .category-table td {
            padding: 7px 0
        }

        .theme-list {
            margin-top: 10px
        }

        .theme-list li {
            align-items: center;
            padding: 7px 0
        }

        .theme-icon {
            flex: 0 0 16px
        }

        .feedback-table-panel {
            border-radius: 8px
        }

        .feedback-table-panel .panel-title {
            padding: 1px 15px 11px
        }

        .feedback-table thead {
            background: #f1f5f9
        }

        .feedback-table th {
            color: #526173;
            font-weight: 700;
            letter-spacing: .02em
        }

        .feedback-table td {
            padding: 9px 8px;
            color: #48576b
        }

        .feedback-table tbody tr {
            transition: background .15s ease
        }

        .feedback-table tbody tr:hover {
            background: #f7fbff
        }

        .feedback-table a:focus-visible,
        .page-number:focus-visible,
        .feedback-toolbar button:focus-visible {
            outline: 3px solid rgba(45, 126, 213, .28);
            outline-offset: 2px
        }

        .feedback-pagination {
            border-top: 1px solid #f0f2f5
        }

        .page-number {
            display: inline-block;
            min-width: 24px;
            text-align: center
        }

        .empty-state {
            padding: 34px !important
        }

        .feedback-report .text-muted {
            color: #91a0b1 !important
        }

        @media(max-width:900px) {
            .report-heading {
                align-items: flex-start;
                flex-direction: column;
                margin-bottom: 16px
            }

            .report-period {
                align-self: stretch;
                justify-content: center
            }

            .feedback-toolbar {
                justify-content: flex-start
            }

            .filter-label {
                width: 100%;
                margin-bottom: 2px
            }

            .feedback-toolbar .form-control {
                flex: 1;
                min-width: 130px
            }

            .feedback-toolbar .btn {
                flex: 0 0 auto
            }
        }

        @media(max-width:700px) {
            .feedback-report {
                padding: 0 0 22px
            }

            .report-heading h1 {
                font-size: 22px
            }

            .feedback-toolbar {
                align-items: stretch
            }

            .feedback-toolbar .form-control,
            .feedback-toolbar .btn {
                width: 100%;
                flex: 1 1 100%
            }

            .feedback-toolbar .btn {
                min-height: 38px
            }

            .feedback-grid .feedback-card {
                min-height: 0
            }

            .chart-panel {
                height: 145px
            }

            .distribution {
                height: auto;
                min-height: 110px;
                gap: 14px
            }

            .donut {
                width: 78px;
                height: 78px;
                flex-basis: 78px
            }

            .donut:after {
                inset: 21px
            }

            .legend-row {
                font-size: 9px
            }

            .lower-grid .feedback-card {
                padding: 13px
            }

            .feedback-table-panel {
                margin-left: 0;
                margin-right: 0
            }
        }
 
        .feedback-report {
            max-width: 1700px;
            padding: 8px 10px 40px;
            font-size: 14px
        }

        .report-heading {
            margin-bottom: 26px
        }

        .report-kicker {
            font-size: 12px;
            margin-bottom: 9px
        }

        .report-heading h1 {
            font-size: 32px;
            margin-bottom: 7px
        }

        .report-heading p {
            font-size: 14px
        }

        .report-period {
            padding: 12px 16px;
            font-size: 13px
        }

        .report-period i {
            font-size: 16px
        }

        .feedback-toolbar {
            gap: 12px;
            padding: 14px 16px;
            margin-bottom: 18px
        }

        .filter-label {
            font-size: 13px
        }

        .filter-label i {
            font-size: 16px
        }

        .feedback-toolbar .form-control {
            width: 170px;
            height: 42px;
            font-size: 13px
        }

        .feedback-toolbar .btn {
            height: 42px;
            font-size: 13px;
            padding: 0 18px
        }

        .feedback-grid {
            gap: 14px;
            margin-bottom: 14px
        }

        .feedback-grid .feedback-card {
            min-height: 166px;
            padding: 20px
        }

        .feedback-card {
            border-radius: 10px
        }

        .feedback-card .eyebrow {
            font-size: 12px;
            margin-bottom: 10px
        }

        .feedback-card h3 {
            font-size: 30px;
            margin-bottom: 8px
        }

        .feedback-card small {
            font-size: 12px
        }

        .feedback-card .delta {
            font-size: 12px;
            margin-top: 8px
        }

        .score-row {
            gap: 8px
        }

        .score-row strong {
            font-size: 30px
        }

        .score-row span {
            font-size: 14px
        }

        .stars {
            font-size: 25px;
            line-height: 1.2;
            margin: 8px 0
        }

        .mood {
            font-size: 23px
        }

        .feedback-columns {
            gap: 14px;
            margin-bottom: 14px
        }

        .feedback-columns>.feedback-card,
        .lower-grid>.feedback-card {
            padding: 20px
        }

        .panel-title {
            font-size: 17px
        }

        .panel-title .text-muted {
            font-size: 12px
        }

        .panel-subtitle {
            font-size: 12px;
            margin-top: 5px
        }

        .chart-panel {
            height: 210px
        }

        .chart-wrap {
            height: 132px;
            margin-top: 16px
        }

        .chart-labels {
            font-size: 11px;
            margin-top: 8px
        }

        .distribution {
            height: 145px;
            gap: 30px
        }

        .donut {
            width: 120px;
            height: 120px;
            flex-basis: 120px
        }

        .donut:after {
            inset: 31px
        }

        .legend-row {
            font-size: 12px;
            margin: 8px 0;
            gap: 7px
        }

        .legend-row i {
            width: 9px;
            height: 9px
        }

        .lower-grid {
            gap: 14px;
            margin-bottom: 14px
        }

        .category-table th,
        .category-table td {
            padding: 10px 0;
            font-size: 12px
        }

        .category-table th {
            font-size: 11px
        }

        .mini-stars {
            font-size: 13px
        }

        .theme-list {
            margin-top: 14px
        }

        .theme-list li {
            padding: 10px 0;
            font-size: 12px
        }

        .theme-list b {
            font-size: 12px
        }

        .theme-icon {
            width: 20px;
            height: 20px;
            flex-basis: 20px
        }

        .feedback-table-panel {
            padding-top: 18px
        }

        .feedback-table-panel .panel-title {
            padding: 0 20px 16px
        }

        .feedback-table th,
        .feedback-table td {
            padding: 12px 12px;
            font-size: 11px
        }

        .feedback-table th {
            font-size: 11px
        }

        .feedback-pagination {
            padding: 12px 20px;
            font-size: 11px
        }

        .page-number {
            min-width: 30px;
            padding: 6px 8px
        }

        @media(max-width:1100px) {
            .feedback-grid {
                grid-template-columns: repeat(3, 1fr)
            }
        }

        @media(max-width:900px) {
            .feedback-grid {
                grid-template-columns: repeat(2, 1fr)
            }

            .lower-grid {
                grid-template-columns: 1fr 1fr
            }

            .lower-grid .feedback-card:last-child {
                grid-column: span 2
            }
        }

        @media(max-width:700px) {
            .feedback-report {
                padding: 2px 0 28px
            }

            .report-heading h1 {
                font-size: 28px
            }

            .feedback-grid,
            .feedback-columns,
            .lower-grid {
                grid-template-columns: 1fr
            }

            .lower-grid .feedback-card:last-child {
                grid-column: auto
            }

            .feedback-toolbar {
                padding: 14px
            }

            .feedback-toolbar .form-control,
            .feedback-toolbar .btn {
                width: 100%;
                flex: 1 1 100%
            }

            .feedback-grid .feedback-card {
                min-height: 145px
            }

            .chart-panel {
                height: 190px
            }

            .distribution {
                justify-content: center;
                gap: 24px
            }

            .donut {
                width: 100px;
                height: 100px;
                flex-basis: 100px
            }

            .donut:after {
                inset: 26px
            }

            .feedback-table-panel {
                overflow-x: auto
            }

            .feedback-table {
                min-width: 780px
            }
        }

        .feedback-report {
            max-width: none;
            margin: 0;
            padding: 0 1.5rem 1.5rem;
            color: #1e293b;
            font-size: 14px
        }

        .report-heading {
            margin: 0 0 20px;
            padding: 0 2px;
            align-items: center
        }

        .report-kicker {
            color: #0b5ed7;
            font-size: 11px
        }

        .report-heading h1 {
            color: #062c52;
            font-size: 26px;
            font-weight: 700
        }

        .report-heading p {
            font-size: 13px;
            color: #64748b
        }

        .report-period {
            border-radius: 10px;
            padding: 10px 14px;
            color: #64748b;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .04)
        }

        .report-period i {
            color: #0b5ed7
        }

        .feedback-toolbar {
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .06)
        }

        .feedback-toolbar .form-control {
            border-radius: 10px
        }

        .feedback-toolbar .btn {
            border-radius: 10px
        }

        .feedback-toolbar .btn-primary {
            background: #062c52;
            border-color: #062c52
        }

        .feedback-toolbar .btn-primary:hover {
            background: #0b3b75;
            border-color: #0b3b75
        }

        .feedback-grid {
            gap: 16px;
            margin-bottom: 16px
        }

        .feedback-grid .feedback-card {
            min-height: 200px;
            padding: 22px 18px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .06)
        }

        .feedback-card {
            border-color: #edf2f7;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .06)
        }

        .feedback-card:hover {
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
            transform: translateY(-3px)
        }

        .feedback-card .eyebrow {
            color: #64748b;
            font-size: 12px
        }

        .feedback-card h3,
        .score-row strong {
            color: #0b3b75
        }

        .feedback-columns {
            gap: 16px;
            margin-bottom: 16px
        }

        .feedback-columns>.feedback-card,
        .lower-grid>.feedback-card {
            padding: 22px 24px
        }

        .chart-panel {
            height: 240px
        }

        .chart-wrap {
            height: 148px;
            margin-top: 18px
        }

        .distribution {
            height: 160px
        }

        .donut {
            width: 128px;
            height: 128px;
            flex-basis: 128px
        }

        .donut:after {
            inset: 33px
        }

        .panel-title {
            color: #062c52;
            font-size: 18px
        }

        .panel-subtitle {
            font-size: 12px;
            color: #64748b
        }

        .legend-row {
            font-size: 12px;
            margin: 8px 0
        }

        .lower-grid {
            gap: 16px;
            margin-bottom: 16px
        }

        .category-table th,
        .category-table td {
            padding: 11px 0
        }

        .theme-list li {
            padding: 11px 0
        }

        .feedback-table-panel {
            border-radius: 10px
        }

        .feedback-table-panel .panel-title {
            padding: 2px 24px 16px
        }

        .feedback-table th,
        .feedback-table td {
            padding: 12px 14px
        }

        .feedback-table thead {
            background: #f8fafc
        }

        .feedback-table tbody tr:hover {
            background: #f8fbff
        }

        .feedback-pagination {
            padding: 14px 24px
        }

        @media(max-width:991.98px) {
            .feedback-report {
                padding: 0 1rem 1.25rem
            }

            .feedback-grid {
                gap: 14px
            }

            .feedback-grid .feedback-card {
                min-height: 180px
            }

            .feedback-columns,
            .lower-grid {
                gap: 14px
            }
        }

        @media(max-width:767.98px) {
            .report-heading {
                margin-bottom: 16px
            }

            .report-heading h1 {
                font-size: 23px
            }

            .report-period {
                width: 100%;
                justify-content: center
            }

            .feedback-grid,
            .feedback-columns,
            .lower-grid {
                gap: 12px
            }

            .feedback-grid .feedback-card {
                min-height: 160px;
                padding: 20px 18px
            }

            .feedback-columns>.feedback-card,
            .lower-grid>.feedback-card {
                padding: 18px
            }

            .chart-panel {
                height: 205px
            }

            .chart-wrap {
                height: 125px
            }

            .distribution {
                height: 130px
            }

            .donut {
                width: 100px;
                height: 100px;
                flex-basis: 100px
            }

            .donut:after {
                inset: 26px
            }

            .feedback-table-panel .panel-title {
                padding-left: 18px;
                padding-right: 18px
            }

            .feedback-pagination {
                padding-left: 18px;
                padding-right: 18px
            }
        }
  
        .feedback-report {
            padding: 0 1rem 1.25rem;
            font-size: 12px
        }

        .report-heading {
            margin-bottom: 14px
        }

        .report-kicker {
            font-size: 9px;
            margin-bottom: 5px
        }

        .report-heading h1 {
            font-size: 22px;
            margin-bottom: 3px
        }

        .report-heading p {
            font-size: 11px
        }

        .report-period {
            padding: 8px 11px;
            font-size: 10px
        }

        .feedback-toolbar {
            gap: 8px;
            padding: 10px 12px;
            margin-bottom: 10px
        }

        .filter-label {
            font-size: 10px
        }

        .filter-label i {
            font-size: 13px
        }

        .feedback-toolbar .form-control {
            width: 135px;
            height: 34px;
            font-size: 10px
        }

        .feedback-toolbar .btn {
            height: 34px;
            font-size: 10px;
            padding: 0 13px
        }

        .feedback-grid {
            gap: 8px;
            margin-bottom: 8px
        }

        .feedback-grid .feedback-card {
            min-height: 145px;
            padding: 15px 14px;
            border-radius: 10px
        }

        .feedback-card .eyebrow {
            font-size: 10px;
            margin-bottom: 6px
        }

        .feedback-card h3,
        .score-row strong {
            font-size: 22px
        }

        .feedback-card small {
            font-size: 10px
        }

        .feedback-card .delta {
            font-size: 10px;
            margin-top: 5px
        }

        .stars {
            font-size: 19px;
            margin: 5px 0
        }

        .mood {
            font-size: 18px
        }

        .feedback-columns {
            gap: 8px;
            margin-bottom: 8px
        }

        .feedback-columns>.feedback-card,
        .lower-grid>.feedback-card {
            padding: 14px 16px
        }

        .panel-title {
            font-size: 14px
        }

        .panel-title .text-muted {
            font-size: 9px
        }

        .panel-subtitle {
            font-size: 10px
        }

        .chart-panel {
            height: 160px
        }

        .chart-wrap {
            height: 96px;
            margin-top: 10px
        }

        .chart-labels {
            font-size: 8px;
            margin-top: 5px
        }

        .distribution {
            height: 100px;
            gap: 16px
        }

        .donut {
            width: 82px;
            height: 82px;
            flex-basis: 82px
        }

        .donut:after {
            inset: 22px
        }

        .legend-row {
            font-size: 9px;
            margin: 5px 0;
            gap: 5px
        }

        .legend-row i {
            width: 7px;
            height: 7px
        }

        .lower-grid {
            gap: 8px;
            margin-bottom: 8px
        }

        .category-table th,
        .category-table td {
            padding: 7px 0;
            font-size: 9px
        }

        .category-table th {
            font-size: 8px
        }

        .mini-stars {
            font-size: 10px
        }

        .theme-list {
            margin-top: 8px
        }

        .theme-list li {
            padding: 7px 0;
            font-size: 9px
        }

        .theme-list b {
            font-size: 9px
        }

        .theme-icon {
            width: 16px;
            height: 16px;
            flex-basis: 16px
        }

        .feedback-table-panel {
            padding-top: 12px
        }

        .feedback-table-panel .panel-title {
            padding: 0 14px 10px
        }

        .feedback-table th,
        .feedback-table td {
            padding: 8px 9px;
            font-size: 8px
        }

        .feedback-table th {
            font-size: 8px
        }

        .feedback-pagination {
            padding: 9px 14px;
            font-size: 8px
        }

        .page-number {
            min-width: 24px;
            padding: 4px 6px
        }

        @media(max-width:1100px) {
            .feedback-grid {
                grid-template-columns: repeat(3, 1fr)
            }
        }

        @media(max-width:900px) {
            .feedback-grid {
                grid-template-columns: repeat(2, 1fr)
            }

            .lower-grid {
                grid-template-columns: 1fr 1fr
            }

            .lower-grid .feedback-card:last-child {
                grid-column: span 2
            }
        }

        @media(max-width:700px) {

            .feedback-grid,
            .feedback-columns,
            .lower-grid {
                grid-template-columns: 1fr
            }

            .lower-grid .feedback-card:last-child {
                grid-column: auto
            }

            .feedback-toolbar .form-control,
            .feedback-toolbar .btn {
                width: 100%;
                flex: 1 1 100%
            }

            .feedback-grid .feedback-card {
                min-height: 130px
            }

            .chart-panel {
                height: 145px
            }

            .chart-wrap {
                height: 84px
            }

            .distribution {
                min-height: 100px
            }

            .donut {
                width: 76px;
                height: 76px;
                flex-basis: 76px
            }

            .donut:after {
                inset: 20px
            }

            .feedback-table-panel {
                overflow-x: auto
            }

            .feedback-table {
                min-width: 720px
            }
        }

        .feedback-report {
            padding: 4px 1.25rem 2rem;
            font-size: 13px
        }

        .report-heading {
            margin-bottom: 18px
        }

        .report-kicker {
            font-size: 10px
        }

        .report-heading h1 {
            font-size: 26px;
            margin-bottom: 5px
        }

        .report-heading p {
            font-size: 12px
        }

        .report-period {
            padding: 10px 13px;
            font-size: 11px
        }

        .feedback-toolbar {
            gap: 10px;
            padding: 12px 14px;
            margin-bottom: 14px
        }

        .filter-label {
            font-size: 11px
        }

        .feedback-toolbar .form-control {
            width: 150px;
            height: 38px;
            font-size: 11px
        }

        .feedback-toolbar .btn {
            height: 38px;
            font-size: 11px;
            padding: 0 15px
        }

        .feedback-grid {
            gap: 11px;
            margin-bottom: 11px
        }

        .feedback-grid .feedback-card {
            min-height: 170px;
            padding: 18px 16px
        }

        .feedback-card .eyebrow {
            font-size: 11px;
            margin-bottom: 8px
        }

        .feedback-card h3,
        .score-row strong {
            font-size: 26px
        }

        .feedback-card small {
            font-size: 11px
        }

        .feedback-card .delta {
            font-size: 11px;
            margin-top: 7px
        }

        .stars {
            font-size: 22px;
            margin: 7px 0
        }

        .mood {
            font-size: 21px
        }

        .feedback-columns {
            gap: 11px;
            margin-bottom: 11px
        }

        .feedback-columns>.feedback-card,
        .lower-grid>.feedback-card {
            padding: 17px 19px
        }

        .panel-title {
            font-size: 16px
        }

        .panel-subtitle {
            font-size: 11px
        }

        .chart-panel {
            height: 190px
        }

        .chart-wrap {
            height: 120px;
            margin-top: 13px
        }

        .chart-labels {
            font-size: 10px;
            margin-top: 7px
        }

        .distribution {
            height: 125px;
            gap: 22px
        }

        .donut {
            width: 104px;
            height: 104px;
            flex-basis: 104px
        }

        .donut:after {
            inset: 27px
        }

        .legend-row {
            font-size: 10px;
            margin: 6px 0
        }

        .lower-grid {
            gap: 11px;
            margin-bottom: 11px
        }

        .category-table th,
        .category-table td {
            padding: 9px 0;
            font-size: 10px
        }

        .category-table th {
            font-size: 9px
        }

        .mini-stars {
            font-size: 11px
        }

        .theme-list {
            margin-top: 11px
        }

        .theme-list li {
            padding: 9px 0;
            font-size: 10px
        }

        .theme-list b {
            font-size: 10px
        }

        .theme-icon {
            width: 18px;
            height: 18px;
            flex-basis: 18px
        }

        .feedback-table-panel {
            padding-top: 15px
        }

        .feedback-table-panel .panel-title {
            padding: 1px 18px 13px
        }

        .feedback-table th,
        .feedback-table td {
            padding: 10px 11px;
            font-size: 9px
        }

        .feedback-table th {
            font-size: 9px
        }

        .feedback-pagination {
            padding: 11px 18px;
            font-size: 9px
        }

        .page-number {
            min-width: 27px;
            padding: 5px 7px
        }

        @media(max-width:700px) {
            .feedback-report {
                padding: 2px 0 1.5rem
            }

            .report-heading h1 {
                font-size: 24px
            }

            .feedback-grid .feedback-card {
                min-height: 145px;
                padding: 16px
            }

            .chart-panel {
                height: 170px
            }

            .chart-wrap {
                height: 105px
            }

            .distribution {
                height: 115px
            }

            .donut {
                width: 88px;
                height: 88px;
                flex-basis: 88px
            }

            .donut:after {
                inset: 23px
            }

            .feedback-table-panel {
                overflow-x: auto
            }

            .feedback-table {
                min-width: 740px
            }
        }

        .chart-panel {
            height: 220px;
            overflow: hidden;
        }

        .chart-labels {
            flex-shrink: 0;
        }

        @media(max-width:700px) {
            .chart-panel {
                height: 195px;
            }
        }

        .distribution-panel {
            display: flex;
            flex-direction: column;
        }

        .distribution-panel .distribution {
            flex: 1;
            height: auto;
            min-height: 125px;
            gap: 32px;
        }

        .distribution-panel .donut {
            width: 128px;
            height: 128px;
            flex-basis: 128px;
        }

        .distribution-panel .donut::after {
            inset: 33px;
        }

        .distribution-panel .legend-row {
            margin: 8px 0;
            font-size: 11px;
        }

        @media(max-width:700px) {
            .distribution-panel .distribution {
                min-height: 115px;
                gap: 20px;
            }

            .distribution-panel .donut {
                width: 96px;
                height: 96px;
                flex-basis: 96px;
            }

            .distribution-panel .donut::after {
                inset: 25px;
            }
        }

        .feedback-grid .feedback-card {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .feedback-grid .feedback-card .mood {
            position: absolute;
            top: 18px;
            right: 16px;
        }
    </style>

@endsection
