<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InferenceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $admin = $request->user();
        $institutionId = $admin->institution_id;

        $usersQuery = User::where('institution_id', $institutionId);
        $totalUsers = $usersQuery->count();
        $activeUsers = $usersQuery->clone()
            ->whereHas('inferenceRecords', fn ($q) => $q->where('created_at', '>=', now()->subDays(7)))
            ->count();

        $recordsQuery = InferenceRecord::whereHas('user', fn ($q) => $q->where('institution_id', $institutionId));
        $totalSessions = $recordsQuery->clone()->distinct('visitor_session_id')->count('visitor_session_id');
        $totalRecords = $recordsQuery->clone()->count();

        $avgProbability = $recordsQuery->clone()
            ->whereNotNull('predicted_probability')
            ->avg('predicted_probability');

        // Distribución de niveles
        $records = $recordsQuery->clone()
            ->whereNotNull('predicted_probability')
            ->select('predicted_probability')
            ->get();

        $levels = ['low' => 0, 'moderate' => 0, 'high' => 0];
        foreach ($records as $r) {
            $pct = round($r->predicted_probability * 100);
            if ($pct > 65) $levels['high']++;
            elseif ($pct > 40) $levels['moderate']++;
            else $levels['low']++;
        }
        $levelsTotal = array_sum($levels) ?: 1;

        // Actividad últimos 14 días
        $dailyActivity = $recordsQuery->clone()
            ->where('inference_records.created_at', '>=', now()->subDays(13)->startOfDay())
            ->selectRaw('DATE(inference_records.created_at) as date, COUNT(*) as total')
            ->groupByRaw('DATE(inference_records.created_at)')
            ->orderBy('date')
            ->pluck('total', 'date');

        $activityChart = collect();
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $activityChart->put($date, $dailyActivity->get($date, 0));
        }

        // Usuarios con stats
        $users = User::where('institution_id', $institutionId)
            ->where('role', '!=', 'admin')
            ->withCount('inferenceRecords')
            ->withAvg('inferenceRecords', 'predicted_probability')
            ->with(['inferenceRecords' => fn ($q) => $q->latest()->limit(1)])
            ->orderByDesc('inference_records_count')
            ->get();

        return view('admin.dashboard', compact(
            'admin',
            'totalUsers',
            'activeUsers',
            'totalSessions',
            'totalRecords',
            'avgProbability',
            'levels',
            'levelsTotal',
            'activityChart',
            'users',
        ));
    }

    public function userDetail(Request $request, User $user)
    {
        $admin = $request->user();

        if ($user->institution_id !== $admin->institution_id) {
            abort(403);
        }

        $records = $user->inferenceRecords()
            ->orderByDesc('created_at')
            ->paginate(20);

        $avgProbability = $user->inferenceRecords()
            ->whereNotNull('predicted_probability')
            ->avg('predicted_probability');

        return view('admin.user-detail', compact('user', 'records', 'avgProbability'));
    }
}
