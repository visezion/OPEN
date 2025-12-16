<?php

namespace Workdo\FoodBank\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Workdo\FoodBank\Entities\FoodBankDistribution;
use Workdo\FoodBank\Entities\FoodBankInventory;
use Workdo\FoodBank\Entities\FoodBankRequest;
use Workdo\FoodBank\Helpers\FoodBankHelper;

class DistributionController extends Controller
{
    public function index()
    {
        $this->ensurePermission('foodbank distribution manage');

        $records = FoodBankDistribution::with(['request', 'inventory'])
            ->where('workspace_id', getActiveWorkSpace())
            ->latest()
            ->paginate(20);

        return view('foodbank::distributions.index', compact('records'));
    }

    public function create()
    {
        $this->ensurePermission('foodbank distribution create');

        $requests = FoodBankRequest::where('workspace_id', getActiveWorkSpace())
            ->where('status', 'approved')
            ->get();
        $inventory = FoodBankInventory::where('workspace_id', getActiveWorkSpace())->get();
        return view('foodbank::distributions.create', compact('requests', 'inventory'));
    }

    public function store(Request $request)
    {
        $this->ensurePermission('foodbank distribution create');

        $data = $request->validate([
            'request_id' => 'required|exists:foodbank_requests,id',
            'inventory_id' => 'nullable|exists:foodbank_inventory,id',
            'quantity_distributed' => 'required|integer|min:1',
            'method' => 'required|in:pickup,delivery',
            'delivery_address' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        $data['workspace_id'] = getActiveWorkSpace();
        $data['status'] = 'complete';
        $data['handled_by'] = creatorId();
        $data['created_by'] = creatorId();
        $data['updated_by'] = creatorId();

        FoodBankDistribution::create($data);

        FoodBankRequest::where('id', $data['request_id'])->update([
            'status' => 'distributed',
            'distributed_at' => now(),
            'updated_by' => creatorId(),
        ]);

        return redirect()->route('foodbank.distributions.index')->with('success', __('Distribution logged.'));
    }

    protected function ensurePermission(string $permission): void
    {
        FoodBankHelper::ensurePermission($permission);
    }
}
