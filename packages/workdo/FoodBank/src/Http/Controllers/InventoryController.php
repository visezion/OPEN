<?php

namespace Workdo\FoodBank\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Workdo\FoodBank\Entities\FoodBankInventory;
use Workdo\FoodBank\Helpers\FoodBankHelper;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $this->ensurePermission('foodbank inventory manage');

        $items = FoodBankInventory::where('workspace_id', getActiveWorkSpace())
            ->latest('received_at')
            ->paginate(20);

        return view('foodbank::inventory.index', compact('items'));
    }

    public function create()
    {
        $this->ensurePermission('foodbank inventory create');

        return view('foodbank::inventory.create');
    }

    public function store(Request $request)
    {
        $this->ensurePermission('foodbank inventory create');

        $data = $request->validate([
            'item_name' => 'required|string',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit' => 'nullable|string',
            'received_at' => 'nullable|date',
            'pickup_location' => 'nullable|string',
            'delivery_details' => 'nullable|string',
        ]);

        $data['workspace_id'] = getActiveWorkSpace();
        $data['created_by'] = creatorId();
        $data['updated_by'] = creatorId();

        FoodBankInventory::create($data);

        return redirect()->route('foodbank.inventory.index')->with('success', __('Inventory logged.'));
    }

    private function ensureWorkspace(FoodBankInventory $inventory)
    {
        if ($inventory->workspace_id !== getActiveWorkSpace()) {
            abort(404);
        }
    }

    protected function ensurePermission(string $permission): void
    {
        FoodBankHelper::ensurePermission($permission);
    }
}
