<?php

namespace Workdo\FoodBank\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Workdo\FoodBank\Entities\FoodBankDonor;
use Workdo\FoodBank\Helpers\FoodBankHelper;

class DonorController extends Controller
{
    public function index()
    {
        $this->ensurePermission('foodbank donor manage');

        $donors = FoodBankDonor::where('workspace_id', getActiveWorkSpace())
            ->latest()
            ->paginate(20);

        return view('foodbank::donors.index', compact('donors'));
    }

    public function create()
    {
        $this->ensurePermission('foodbank donor create');

        $defaults = FoodBankHelper::getDefaultContact();
        return view('foodbank::donors.create', compact('defaults'));
    }

    public function store(Request $request)
    {
        $this->ensurePermission('foodbank donor create');

        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'preferred_pickup' => 'nullable|string',
            'preferred_delivery' => 'nullable|string',
        ]);

        $data['workspace_id'] = getActiveWorkSpace();
        $data['created_by'] = creatorId();
        $data['updated_by'] = creatorId();

        FoodBankDonor::create($data);

        return redirect()->route('foodbank.donors.index')->with('success', __('Donor saved.'));
    }

    public function edit(FoodBankDonor $donor)
    {
        $this->ensurePermission('foodbank donor edit');

        $this->ensureWorkspace($donor);
        return view('foodbank::donors.edit', compact('donor'));
    }

    public function update(Request $request, FoodBankDonor $donor)
    {
        $this->ensureWorkspace($donor);

        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'preferred_pickup' => 'nullable|string',
            'preferred_delivery' => 'nullable|string',
        ]);

        $this->ensurePermission('foodbank donor edit');
        $data['updated_by'] = creatorId();
        $donor->update($data);

        return redirect()->route('foodbank.donors.index')->with('success', __('Donor updated.'));
    }

    public function destroy(FoodBankDonor $donor)
    {
        $this->ensurePermission('foodbank donor delete');

        $this->ensureWorkspace($donor);
        $donor->delete();
        return redirect()->route('foodbank.donors.index')->with('success', __('Donor removed.'));
    }

    protected function ensurePermission(string $permission): void
    {
        FoodBankHelper::ensurePermission($permission);
    }

    private function ensureWorkspace($model): void
    {
        if ($model->workspace_id !== getActiveWorkSpace()) {
            abort(404);
        }
    }
}
