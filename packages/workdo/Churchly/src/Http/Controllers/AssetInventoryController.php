<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Workdo\Churchly\Entities\AssetInspection;
use Workdo\Churchly\Entities\AssetInventory;
use Workdo\Churchly\Entities\AssetMovement;
use Workdo\Churchly\Entities\AssetNotificationSetting;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;
use Workdo\Churchly\Entities\MaintenanceCategory;
use Workdo\Churchly\Exports\AssetInventoryExport;
use Workdo\Churchly\Services\AssetInventoryPdfGenerator;
use Workdo\Churchly\Services\AssetInventoryService;

class AssetInventoryController extends Controller
{
    private array $statusOptions = [
        'operational' => 'Operational',
        'in_maintenance' => 'In Maintenance',
        'retired' => 'Retired',
    ];

    private array $categoryOptions = [
        'Electrical',
        'HVAC',
        'IT Infrastructure',
        'Audio/Visual',
        'Vehicles',
        'Tools',
        'Furniture',
    ];

    private array $inspectionStatuses = [
        'ok' => 'Good',
        'attention' => 'Needs Attention',
        'critical' => 'Critical',
    ];

    private array $filterKeys = ['branch_id', 'department_id', 'category', 'status'];

    public function index(Request $request)
    {
        if ($response = $this->ensurePermission('asset inventory manage')) {
            return $response;
        }

        $filters = $this->resolveFilters($request);
        $query = AssetInventory::with(['branch', 'department', 'assignedTo'])->forWorkspace();
        $this->applyFilters($query, $filters);

        $assets = $query->latest('updated_at')->paginate(15)->withQueryString();
        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())->pluck('name', 'id');
        $departments = ChurchDepartment::where('workspace', getActiveWorkSpace())->pluck('name', 'id');
        $stats = $this->buildStats();

        return view('churchly::assets.index', [
            'assets' => $assets,
            'filters' => $filters,
            'branches' => $branches,
            'departments' => $departments,
            'statusOptions' => $this->statusOptions,
            'categoryOptions' => array_unique(array_merge(
                $this->categoryOptions,
                MaintenanceCategory::forWorkspace()->pluck('name')->toArray()
            )),
            'stats' => $stats,
        ]);
    }

    public function create()
    {
        if ($response = $this->ensurePermission('asset inventory create')) {
            return $response;
        }

        return view('churchly::assets.create', $this->formDependencies());
    }

    public function store(Request $request)
    {
        if ($response = $this->ensurePermission('asset inventory create')) {
            return $response;
        }

        $data = $this->validateAsset($request);

        if (empty($data['asset_code'])) {
            $data['asset_code'] = AssetInventoryService::generateAssetCode(getActiveWorkSpace());
        }

        $data['workspace_id'] = getActiveWorkSpace();
        $data['created_by'] = creatorId();
        $data['updated_by'] = creatorId();
        $data['status'] = $data['status'] ?? 'operational';
        $data['available_quantity'] = $data['available_quantity'] ?? $data['quantity'];

        AssetInventory::create($data);

        return redirect()->route('assets.index')->with('success', __('Asset saved.'));
    }

    public function show(AssetInventory $assetInventory)
    {
        $this->ensureWorkspace($assetInventory);

        if ($response = $this->ensurePermission('asset inventory view')) {
            return $response;
        }

        $movements = AssetMovement::forWorkspace()
            ->where('asset_inventory_id', $assetInventory->id)
            ->latest('moved_at')
            ->get();

        $inspections = AssetInspection::forWorkspace()
            ->where('asset_inventory_id', $assetInventory->id)
            ->latest('inspected_at')
            ->get();

        return view('churchly::assets.show', [
            'asset' => $assetInventory->load(['branch', 'department', 'assignedTo']),
            'movements' => $movements,
            'inspections' => $inspections,
            'inspectionStatuses' => $this->inspectionStatuses,
            'notificationSetting' => $this->getNotificationSetting(),
            'statusOptions' => $this->statusOptions,
        ]);
    }

    public function edit(AssetInventory $assetInventory)
    {
        $this->ensureWorkspace($assetInventory);

        if ($response = $this->ensurePermission('asset inventory edit')) {
            return $response;
        }

        return view('churchly::assets.edit', array_merge([
            'asset' => $assetInventory,
        ], $this->formDependencies()));
    }

    public function update(Request $request, AssetInventory $assetInventory)
    {
        $this->ensureWorkspace($assetInventory);

        if ($response = $this->ensurePermission('asset inventory edit')) {
            return $response;
        }

        $data = $this->validateAsset($request, $assetInventory->id);
        $data['updated_by'] = creatorId();
        $data['available_quantity'] = $data['available_quantity'] ?? $data['quantity'];
        $data['status'] = $data['status'] ?? $assetInventory->status;

        $assetInventory->update($data);

        return redirect()->route('assets.index')->with('success', __('Asset updated.'));
    }

    public function destroy(AssetInventory $assetInventory)
    {
        $this->ensureWorkspace($assetInventory);

        if ($response = $this->ensurePermission('asset inventory delete')) {
            return $response;
        }

        $assetInventory->delete();

        return redirect()->route('assets.index')->with('success', __('Asset removed.'));
    }

    public function dashboard()
    {
        if ($response = $this->ensurePermission('asset inventory manage')) {
            return $response;
        }

        $stats = $this->buildStats();
        $settings = $this->getNotificationSetting();

        $recentMovements = AssetMovement::forWorkspace()->latest('moved_at')->limit(6)->get();
        $recentInspections = AssetInspection::forWorkspace()->latest('inspected_at')->limit(6)->get();

        return view('churchly::assets.dashboard', [
            'stats' => $stats,
            'recentMovements' => $recentMovements,
            'recentInspections' => $recentInspections,
            'settings' => $settings,
        ]);
    }

    public function reports()
    {
        if ($response = $this->ensurePermission('asset inventory manage')) {
            return $response;
        }

        $categoryBreakdown = AssetInventory::forWorkspace()
            ->selectRaw('category, SUM(quantity) as total_quantity, SUM(available_quantity) as available_quantity')
            ->groupBy('category')
            ->orderByDesc('total_quantity')
            ->get();

        $branchBreakdown = AssetInventory::forWorkspace()
            ->selectRaw('branch_id, SUM(quantity) as total_quantity')
            ->groupBy('branch_id')
            ->orderByDesc('total_quantity')
            ->with('branch')
            ->get();

        $inspectionStatus = AssetInspection::forWorkspace()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        $movementSummary = AssetMovement::forWorkspace()
            ->selectRaw('asset_inventory_id, SUM(quantity) as total')
            ->groupBy('asset_inventory_id')
            ->orderByDesc('total')
            ->with('asset')
            ->limit(6)
            ->get();

        return view('churchly::assets.reports', [
            'categoryBreakdown' => $categoryBreakdown,
            'branchBreakdown' => $branchBreakdown,
            'inspectionStatus' => $inspectionStatus,
            'movementSummary' => $movementSummary,
        ]);
    }

    public function export(Request $request, string $format = 'excel')
    {
        if ($response = $this->ensurePermission('asset inventory manage')) {
            return $response;
        }

        $filters = $this->resolveFilters($request);
        $query = AssetInventory::with(['branch', 'department', 'assignedTo'])->forWorkspace();
        $this->applyFilters($query, $filters);
        $assets = $query->orderBy('updated_at')->get();

        $timestamp = now()->format('YmdHis');

        if ($format === 'excel') {
            return Excel::download(new AssetInventoryExport($assets), "asset-inventory-{$timestamp}.xlsx");
        }

        if ($format === 'pdf') {
            $pdf = (new AssetInventoryPdfGenerator())->generate($assets);
            return Response::make($pdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"asset-inventory-{$timestamp}.pdf\"",
            ]);
        }

        abort(404);
    }

    public function print(Request $request)
    {
        if ($response = $this->ensurePermission('asset inventory manage')) {
            return $response;
        }

        $filters = $this->resolveFilters($request);
        $query = AssetInventory::with(['branch', 'department', 'assignedTo'])->forWorkspace();
        $this->applyFilters($query, $filters);
        $assets = $query->orderBy('updated_at')->get();

        return view('churchly::assets.print', [
            'assets' => $assets,
            'filters' => $filters,
            'statusOptions' => $this->statusOptions,
            'categoryOptions' => array_unique(array_merge(
                $this->categoryOptions,
                MaintenanceCategory::forWorkspace()->pluck('name')->toArray()
            )),
        ]);
    }

    public function storeMovement(Request $request, AssetInventory $assetInventory)
    {
        $this->ensureWorkspace($assetInventory);

        if ($response = $this->ensurePermission('asset inventory manage')) {
            return $response;
        }

        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:191',
            'notes' => 'nullable|string',
            'from_branch_id' => 'nullable|exists:church_branches,id',
            'from_department_id' => 'nullable|exists:church_departments,id',
            'to_branch_id' => 'nullable|exists:church_branches,id',
            'to_department_id' => 'nullable|exists:church_departments,id',
            'moved_at' => 'nullable|date',
        ]);

        AssetMovement::create([
            'workspace_id' => getActiveWorkSpace(),
            'asset_inventory_id' => $assetInventory->id,
            'branch_id' => $assetInventory->branch_id,
            'department_id' => $assetInventory->department_id,
            'from_branch_id' => $data['from_branch_id'] ?? $assetInventory->branch_id,
            'from_department_id' => $data['from_department_id'] ?? $assetInventory->department_id,
            'to_branch_id' => $data['to_branch_id'] ?? $assetInventory->branch_id,
            'to_department_id' => $data['to_department_id'] ?? $assetInventory->department_id,
            'quantity' => $data['quantity'],
            'reason' => $data['reason'] ?? null,
            'notes' => $data['notes'] ?? null,
            'moved_at' => $data['moved_at'] ?? now(),
            'recorded_by' => Auth::id(),
            'created_by' => creatorId(),
            'updated_by' => creatorId(),
        ]);

        return redirect()->back()->with('success', __('Movement recorded.'));
    }

    public function storeInspection(Request $request, AssetInventory $assetInventory)
    {
        $this->ensureWorkspace($assetInventory);

        if ($response = $this->ensurePermission('asset inventory manage')) {
            return $response;
        }

        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->inspectionStatuses))],
            'findings' => 'nullable|string',
            'cost_incurred' => 'nullable|numeric|min:0',
            'inspected_at' => 'nullable|date',
            'next_inspection_date' => 'nullable|date|after_or_equal:inspected_at',
        ]);

        AssetInspection::create([
            'workspace_id' => getActiveWorkSpace(),
            'asset_inventory_id' => $assetInventory->id,
            'branch_id' => $assetInventory->branch_id,
            'department_id' => $assetInventory->department_id,
            'inspector_id' => Auth::id(),
            'status' => $data['status'],
            'findings' => $data['findings'] ?? null,
            'cost_incurred' => $data['cost_incurred'] ?? null,
            'inspected_at' => $data['inspected_at'] ?? now(),
            'next_inspection_date' => $data['next_inspection_date'] ?? null,
            'created_by' => creatorId(),
            'updated_by' => creatorId(),
        ]);

        return redirect()->back()->with('success', __('Inspection logged.'));
    }

    private function formDependencies(): array
    {
        return [
            'branches' => ChurchBranch::where('workspace', getActiveWorkSpace())->pluck('name', 'id'),
            'departments' => ChurchDepartment::where('workspace', getActiveWorkSpace())->pluck('name', 'id'),
            'assignableUsers' => User::where('workspace_id', getActiveWorkSpace())->pluck('name', 'id'),
            'statusOptions' => $this->statusOptions,
            'categoryOptions' => array_unique(array_merge(
                $this->categoryOptions,
                MaintenanceCategory::forWorkspace()->pluck('name')->toArray()
            )),
            'inspectionStatuses' => $this->inspectionStatuses,
        ];
    }

    private function resolveFilters(Request $request): array
    {
        return array_merge(array_fill_keys($this->filterKeys, null), $request->only($this->filterKeys));
    }

    private function applyFilters($query, array $filters)
    {
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (!empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        return $query;
    }

    private function validateAsset(Request $request, ?int $ignore = null): array
    {
        return $request->validate([
            'asset_name' => 'required|string|max:191',
            'asset_code' => [
                'nullable',
                'string',
                'max:64',
                Rule::unique('asset_inventories')
                    ->where('workspace_id', getActiveWorkSpace())
                    ->ignore($ignore),
            ],
            'asset_tag' => 'nullable|string|max:64',
            'category' => 'nullable|string|max:64',
            'asset_type' => 'nullable|string|max:64',
            'serial_number' => 'nullable|string|max:128',
            'location' => 'nullable|string|max:255',
            'condition' => 'nullable|string|max:64',
            'acquired_at' => 'nullable|date',
            'warranty_expires_at' => 'nullable|date|after_or_equal:acquired_at',
            'quantity' => 'required|integer|min:0',
            'available_quantity' => 'nullable|integer|min:0',
            'status' => ['nullable', Rule::in(array_keys($this->statusOptions))],
            'assigned_to' => 'nullable|exists:users,id',
            'branch_id' => 'nullable|exists:church_branches,id',
            'department_id' => 'nullable|exists:church_departments,id',
            'notes' => 'nullable|string',
        ]);
    }

    private function buildStats(): array
    {
        $assets = AssetInventory::forWorkspace();
        $settings = $this->getNotificationSetting();

        return [
            'total_items' => $assets->count(),
            'total_quantity' => $assets->sum('quantity'),
            'available_quantity' => $assets->sum('available_quantity'),
            'low_stock' => $assets
                ->whereColumn('available_quantity', '<=', 'quantity')
                ->where('available_quantity', '<=', $settings->low_stock_threshold ?? 5)
                ->count(),
            'movements' => AssetMovement::forWorkspace()->count(),
            'inspections' => AssetInspection::forWorkspace()->count(),
        ];
    }

    private function getNotificationSetting(): AssetNotificationSetting
    {
        $setting = AssetNotificationSetting::forWorkspace()->first();

        if (! $setting) {
            $setting = AssetNotificationSetting::create([
                'workspace_id' => getActiveWorkSpace(),
                'notification_methods' => ['email'],
                'low_stock_threshold' => 5,
                'inspection_reminder_days' => 7,
                'created_by' => creatorId(),
                'updated_by' => creatorId(),
            ]);
        }

        return $setting;
    }

    private function ensureWorkspace($model): void
    {
        if ($model->workspace_id !== getActiveWorkSpace()) {
            abort(404);
        }
    }

    private function userCanSkipPermissions(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return $user->hasRole('company') || $user->type === 'company';
    }

    private function ensurePermission(string $permission)
    {
        if ($this->userCanSkipPermissions() || Auth::user()->can($permission)) {
            return null;
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
