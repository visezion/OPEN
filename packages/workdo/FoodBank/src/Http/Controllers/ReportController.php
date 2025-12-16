<?php

namespace Workdo\FoodBank\Http\Controllers;

use App\Http\Controllers\Controller;
use Workdo\FoodBank\Entities\FoodBankDistribution;
use Workdo\FoodBank\Entities\FoodBankDonor;
use Workdo\FoodBank\Entities\FoodBankInventory;
use Workdo\FoodBank\Helpers\FoodBankHelper;

class ReportController extends Controller
{
    public function index()
    {
        FoodBankHelper::ensurePermission('foodbank reports view');

        $summary = [
            'total_inventory' => FoodBankInventory::where('workspace_id', getActiveWorkSpace())->sum('quantity'),
            'donors' => FoodBankDonor::where('workspace_id', getActiveWorkSpace())->count(),
            'distributions' => FoodBankDistribution::where('workspace_id', getActiveWorkSpace())->count(),
        ];
        return view('foodbank::reports.index', compact('summary'));
    }
}
