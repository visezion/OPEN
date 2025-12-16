<?php

namespace Workdo\FoodBank\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Workdo\FoodBank\Entities\FoodBankDistribution;
use Workdo\FoodBank\Entities\FoodBankDonor;
use Workdo\FoodBank\Entities\FoodBankInventory;
use Workdo\FoodBank\Entities\FoodBankRequest;
use Workdo\FoodBank\Helpers\FoodBankHelper;

class FoodBankController extends Controller
{
    public function dashboard()
    {
        FoodBankHelper::ensurePermission('foodbank reports view');

        $totals = [
            'donors' => FoodBankDonor::where('workspace_id', getActiveWorkSpace())->count(),
            'inventory_items' => FoodBankInventory::where('workspace_id', getActiveWorkSpace())->sum('quantity'),
            'pending_requests' => FoodBankRequest::where('workspace_id', getActiveWorkSpace())->where('status', 'pending')->count(),
            'distributed' => FoodBankDistribution::where('workspace_id', getActiveWorkSpace())->where('status', 'complete')->count(),
        ];

        $requestBreakdown = FoodBankRequest::select('status', DB::raw('count(*) as total'))
            ->where('workspace_id', getActiveWorkSpace())
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $recentRequests = FoodBankRequest::where('workspace_id', getActiveWorkSpace())
            ->latest()
            ->take(5)
            ->get();

        $recentDonors = FoodBankDonor::where('workspace_id', getActiveWorkSpace())->latest()->take(5)->get();
        $publicRequestLink = FoodBankHelper::publicRequestUrl();
        $publicDonateLink = FoodBankHelper::publicDonateUrl();

        return view('foodbank::dashboard.index', compact(
            'totals',
            'requestBreakdown',
            'recentRequests',
            'recentDonors',
            'publicRequestLink',
            'publicDonateLink'
        ));
    }
}
