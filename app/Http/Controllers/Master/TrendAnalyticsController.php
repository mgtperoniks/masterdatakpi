<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdItem;
use App\Models\MdMachine;
use App\Models\MdDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrendAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $items = MdItem::active()->orderBy('code')->get(['code', 'name']);

        return view('master.trend_analytics.index', compact('items'));
    }

    /**
     * Generate 26-week Trend Report
     */
    public function generateReport(Request $request)
    {
        $itemCode = $request->get('item_code');
        $weeksCount = 26;
        $startDate = now()->subWeeks($weeksCount);

        // Fetch Production Data from bubut connection
        $productionData = DB::connection('bubut')
            ->table('production_logs')
            ->select(
                DB::raw('YEARWEEK(production_date, 1) as week_key'),
                DB::raw('SUM(actual_qty) as total_prod')
            )
            ->where('production_date', '>=', $startDate)
            ->when($itemCode, function ($q) use ($itemCode) {
                return $q->where('item_code', $itemCode);
            })
            ->groupBy('week_key')
            ->orderBy('week_key')
            ->get();

        // Fetch Reject Data from bubut connection
        $rejectData = DB::connection('bubut')
            ->table('reject_logs')
            ->select(
                DB::raw('YEARWEEK(reject_date, 1) as week_key'),
                DB::raw('SUM(reject_qty) as total_rej')
            )
            ->where('reject_date', '>=', $startDate)
            ->when($itemCode, function ($q) use ($itemCode) {
                return $q->where('item_code', $itemCode);
            })
            ->groupBy('week_key')
            ->orderBy('week_key')
            ->get();

        // Merge and prepare for Chart.js
        $weeks = [];
        $prodValues = [];
        $rejValues = [];

        // Create range of last 26 weeks
        for ($i = $weeksCount; $i >= 0; $i--) {
            $date = now()->subWeeks($i);
            $weekKey = $date->format('oW'); // ISO Year + Week
            $weeks[] = "W" . $date->format('W');

            $p = $productionData->where('week_key', $weekKey)->first();
            $r = $rejectData->where('week_key', $weekKey)->first();

            $prodValues[] = $p ? (int) $p->total_prod : 0;
            $rejValues[] = $r ? (int) $r->total_rej : 0;
        }

        return response()->json([
            'labels' => $weeks,
            'production' => $prodValues,
            'reject' => $rejValues,
            'avg_prod' => count($prodValues) > 0 ? array_sum($prodValues) / count($prodValues) : 0,
            'avg_rej' => count($rejValues) > 0 ? array_sum($rejValues) / count($rejValues) : 0,
        ]);
    }
}
