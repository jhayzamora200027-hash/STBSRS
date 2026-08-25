<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketFeedback;
use Illuminate\Support\Carbon;

class FeedBackController extends Controller
{
    public function index(Request $request)
    {
        $dateTo = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : now()->endOfDay();
        $dateFrom = $request->date_from
            ? Carbon::parse($request->date_from)->startOfDay()
            : $dateTo->copy()->subDays(27)->startOfDay();

        $feedbacks = TicketFeedback::with('ticket')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->latest()
            ->get();

        $ratings = [
            'timeliness' => 'Timeliness',
            'professionalism' => 'Professionalism',
            'quality_of_resolution' => 'Quality of Resolution',
            'ease_of_process' => 'Ease of Process',
            'communication' => 'Communication',
        ];
        $ratingValues = fn (string $field) => $feedbacks->pluck($field)->filter(fn ($value) => $value !== null);
        $average = fn (string $field) => $ratingValues($field)->isNotEmpty()
            ? round(6 - $ratingValues($field)->avg(), 1)
            : 0;
        $total = $feedbacks->count();
        $positive = $feedbacks->where('overall_satisfaction', '<=', 2)->count();
        $neutral = $feedbacks->where('overall_satisfaction', 3)->count();
        $negative = $feedbacks->where('overall_satisfaction', '>=', 4)->count();

        $categoryStats = $feedbacks->groupBy(fn ($feedback) => $feedback->ticket->ticket_category ?? 'Uncategorized')
            ->map(fn ($items, $category) => [
                'category' => $category,
                'average' => round(6 - $items->avg('overall_satisfaction'), 1),
                'total' => $items->count(),
            ])->sortByDesc('total')->take(4)->values();

        $themeStats = collect($ratings)->map(fn ($label, $field) => [
            'label' => $label,
            'average' => $average($field),
            'total' => $ratingValues($field)->count(),
        ])->sortByDesc('average')->values();

        $trend = $feedbacks->groupBy(fn ($feedback) => $feedback->created_at->format('M d'))
            ->map(fn ($items) => round(6 - $items->avg('overall_satisfaction'), 1))
            ->take(12);

        return view('authpage.dashboard.feedback', compact(
            'feedbacks', 'dateFrom', 'dateTo', 'ratings', 'average', 'total',
            'positive', 'neutral', 'negative', 'categoryStats', 'themeStats', 'trend'
        ));
    }
}
