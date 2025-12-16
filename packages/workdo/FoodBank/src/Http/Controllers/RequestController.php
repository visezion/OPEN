<?php

namespace Workdo\FoodBank\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Workdo\FoodBank\Entities\FoodBankRequest;
use Workdo\FoodBank\Helpers\FoodBankHelper;

class RequestController extends Controller
{
    protected array $statusOptions = [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'distributed' => 'Distributed',
    ];

    protected array $deliveryOptions = [
        'pickup' => 'Pickup',
        'delivery' => 'Delivery',
    ];

    public function index(Request $request)
    {
        FoodBankHelper::ensurePermission('foodbank request manage');
        $filters = $request->only(['status', 'delivery_preference', 'search']);

        $base = $this->workspaceFilter(FoodBankRequest::query());

        if (!empty($filters['status'])) {
            $base->where('status', $filters['status']);
        }

        if (!empty($filters['delivery_preference'])) {
            $base->where('delivery_preference', $filters['delivery_preference']);
        }

        if (!empty($filters['search'])) {
            $base->where(function ($query) use ($filters) {
                $query->where('requester_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        $stats = [
            'pending' => $this->workspaceFilter(FoodBankRequest::query())->where('status', 'pending')->count(),
            'approved' => $this->workspaceFilter(FoodBankRequest::query())->where('status', 'approved')->count(),
            'rejected' => $this->workspaceFilter(FoodBankRequest::query())->where('status', 'rejected')->count(),
            'total' => $this->workspaceFilter(FoodBankRequest::query())->count(),
        ];

        $requests = $base->latest('updated_at')->paginate(15)->withQueryString();

        return view('foodbank::requests.index', [
            'requests' => $requests,
            'filters' => $filters,
            'statusOptions' => $this->statusOptions,
            'deliveryOptions' => $this->deliveryOptions,
            'stats' => $stats,
        ]);
    }

    public function create()
    {
        FoodBankHelper::ensurePermission('foodbank request create');

        return view('foodbank::requests.form', [
            'requestEntry' => null,
            'statusOptions' => $this->statusOptions,
            'deliveryOptions' => $this->deliveryOptions,
        ]);
    }

    public function store(Request $request)
    {
        FoodBankHelper::ensurePermission('foodbank request create');

        $data = $this->validatePayload($request);
        $data['workspace_id'] = getActiveWorkSpace();
        $data['status'] = $data['status'] ?? 'pending';
        $data['created_by'] = creatorId();
        $data['updated_by'] = creatorId();
        $data['notify_channels'] = array_values($data['notify_channels'] ?? []);
        $data['marital_status'] = FoodBankHelper::normalizeMaritalStatus($data['marital_status'] ?? null);

        $requestEntry = FoodBankRequest::create($data);
        $this->notifyChannels($requestEntry, __('Request registered'), $requestEntry->status);

        return redirect()->route('foodbank.requests.show', $requestEntry)->with('success', __('Request created.'));
    }

    public function show(FoodBankRequest $requestEntry)
    {
        FoodBankHelper::ensurePermission('foodbank request manage');
        $this->ensureWorkspace($requestEntry);

        return view('foodbank::requests.show', [
            'requestEntry' => $requestEntry,
            'statusOptions' => $this->statusOptions,
            'deliveryOptions' => $this->deliveryOptions,
        ]);
    }

    public function edit(FoodBankRequest $requestEntry)
    {
        FoodBankHelper::ensurePermission('foodbank request edit');
        $this->ensureWorkspace($requestEntry);

        return view('foodbank::requests.form', [
            'requestEntry' => $requestEntry,
            'statusOptions' => $this->statusOptions,
            'deliveryOptions' => $this->deliveryOptions,
        ]);
    }

    public function update(Request $request, FoodBankRequest $requestEntry)
    {
        FoodBankHelper::ensurePermission('foodbank request edit');
        $this->ensureWorkspace($requestEntry);

        $data = $this->validatePayload($request);
        $data['updated_by'] = creatorId();
        $data['notify_channels'] = array_values($data['notify_channels'] ?? []);
        $data['marital_status'] = FoodBankHelper::normalizeMaritalStatus($data['marital_status'] ?? null);

        $requestEntry->update($data);
        $this->notifyChannels($requestEntry, __('Request updated'), $requestEntry->status);

        return redirect()->route('foodbank.requests.show', $requestEntry)->with('success', __('Request updated.'));
    }

    public function destroy(FoodBankRequest $requestEntry): RedirectResponse
    {
        FoodBankHelper::ensurePermission('foodbank request delete');
        $this->ensureWorkspace($requestEntry);

        $requestEntry->delete();

        return redirect()->route('foodbank.requests.index')->with('success', __('Request deleted.'));
    }

    public function approve(FoodBankRequest $requestEntry): RedirectResponse
    {
        FoodBankHelper::ensurePermission('foodbank request approve');
        $this->ensureWorkspace($requestEntry);

        $requestEntry->update([
            'status' => 'approved',
            'approved_by' => creatorId(),
            'approved_at' => now(),
            'updated_by' => creatorId(),
        ]);

        $this->notifyChannels($requestEntry, __('Request approved'), 'approved');

        return redirect()->route('foodbank.requests.show', $requestEntry)->with('success', __('Request approved.'));
    }

    public function reject(FoodBankRequest $requestEntry): RedirectResponse
    {
        FoodBankHelper::ensurePermission('foodbank request approve');
        $this->ensureWorkspace($requestEntry);

        $requestEntry->update([
            'status' => 'rejected',
            'updated_by' => creatorId(),
        ]);

        $this->notifyChannels($requestEntry, __('Request rejected'), 'rejected');

        return redirect()->route('foodbank.requests.show', $requestEntry)->with('success', __('Request rejected.'));
    }

    protected function validatePayload(Request $request): array
    {
        return $request->validate([
            'requester_name' => 'required|string',
            'occupation' => 'nullable|string',
            'marital_status' => 'nullable|in:single,married,other',
            'family_size' => 'nullable|integer|min:1',
            'children_count' => 'nullable|integer|min:0',
            'dietary_requirements' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'needs_description' => 'nullable|string',
            'pickup_location' => 'nullable|string',
            'delivery_preference' => 'nullable|in:pickup,delivery',
            'delivery_address' => 'nullable|string',
            'delivery_map' => 'nullable|string',
            'delivery_lat' => 'nullable|numeric',
            'delivery_lng' => 'nullable|numeric',
            'notify_channels' => 'nullable|array',
            'notify_channels.*' => 'in:email,whatsapp,sms',
            'status' => 'nullable|in:pending,approved,rejected,distributed',
        ]);
    }

    protected function workspaceFilter($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }

    protected function ensureWorkspace(FoodBankRequest $requestEntry): void
    {
        $user = auth()->user();

        if (!empty($user) && in_array($user->type, ['company', 'super admin'])) {
            return;
        }

        if ($requestEntry->workspace_id !== getActiveWorkSpace()) {
            abort(403, __('Permission denied.'));
        }
    }

    protected function notifyChannels(FoodBankRequest $requestEntry, string $message, string $status): void
    {
        try {
            $channels = $requestEntry->notify_channels ?? [];
            if (empty($channels)) {
                return;
            }
            Log::info('Food Bank notification', [
                'request_id' => $requestEntry->id,
                'status' => $status,
                'channels' => $channels,
                'message' => $message,
            ]);
        } catch (\Throwable $exception) {
            Log::error('Food Bank notification failed', ['error' => $exception->getMessage()]);
        }
    }
}
