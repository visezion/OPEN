<?php

namespace Workdo\FoodBank\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Workdo\FoodBank\Entities\FoodBankDonor;
use Workdo\FoodBank\Entities\FoodBankInventory;
use Workdo\FoodBank\Entities\FoodBankRequest;
use Workdo\FoodBank\Helpers\FoodBankHelper;

class PublicController extends Controller
{
    public function requestForm(?string $token = null)
    {
        $token = $token ?: FoodBankHelper::publicToken();
        if (!FoodBankHelper::validatePublicToken($token)) {
            abort(404);
        }

        return view('foodbank::public.request', [
            'token' => $token,
        ]);
    }

    public function donateForm(?string $token = null)
    {
        $token = $token ?: FoodBankHelper::publicToken();
        if (!FoodBankHelper::validatePublicToken($token)) {
            abort(404);
        }

        $workspaceId = FoodBankHelper::workspaceForToken($token);
        $adminStats = null;
        if ($user = auth()->user()) {
            if ($user->can('foodbank donor manage')) {
                $adminStats = [
                    'donors' => FoodBankDonor::where('workspace_id', $workspaceId)->count(),
                    'inventory_items' => FoodBankInventory::where('workspace_id', $workspaceId)->sum('quantity'),
                    'pending_requests' => FoodBankRequest::where('workspace_id', $workspaceId)->where('status', 'pending')->count(),
                    'publicRequestLink' => FoodBankHelper::publicRequestUrl(),
                    'publicDonateLink' => FoodBankHelper::publicDonateUrl(),
                ];
            }
        }

        return view('foodbank::public.donate', [
            'token' => $token,
            'adminStats' => $adminStats,
        ]);
    }

    public function submitRequest(Request $request, ?string $token = null)
    {
        $token = $token ?: FoodBankHelper::publicToken();
        if (!FoodBankHelper::validatePublicToken($token)) {
            abort(404);
        }

        $data = $request->validate([
            'requester_name' => 'required|string',
            'occupation' => 'nullable|string',
            'marital_status' => 'nullable|in:single,married,other',
            'family_size' => 'nullable|integer|min:1',
            'children_count' => 'nullable|integer|min:0',
            'dietary_requirements' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'needs_description' => 'nullable|string',
            'quantity_needed' => 'nullable|integer|min:1',
            'pickup_location' => 'nullable|string',
            'delivery_preference' => 'nullable|string',
            'delivery_address' => 'nullable|string',
            'delivery_map' => 'nullable|url',
            'delivery_lat' => 'nullable|numeric',
            'delivery_lng' => 'nullable|numeric',
            'notify_channels' => 'nullable|array',
            'notify_channels.*' => 'in:email,whatsapp,sms',
        ]);

        $workspaceId = FoodBankHelper::workspaceForToken($token);

        $data['workspace_id'] = $workspaceId;
        $data['status'] = 'pending';
        $data['created_by'] = creatorId() ?: 0;
        $data['updated_by'] = creatorId() ?: 0;
        $data['notify_channels'] = array_values($data['notify_channels'] ?? []);
        $data['marital_status'] = FoodBankHelper::normalizeMaritalStatus($data['marital_status'] ?? null);
        $data['quantity_needed'] = $data['quantity_needed'] ?? max(1, (int) ($data['family_size'] ?? 1));
        $data['needs_description'] = $data['needs_description'] ?? __('Requesting food assistance for :family members', [
            'family' => $data['family_size'] ?? 1,
        ]);

        if (($data['delivery_preference'] ?? '') === 'delivery') {
            $data['address'] = $data['delivery_address'] ?? null;
        } else {
            $data['pickup_location'] = __('Community aid centre, 14 Hope Street');
            $data['address'] = null;
        }

        FoodBankRequest::create($data);

        return view('foodbank::public.thankyou', [
            'mode' => 'request',
            'token' => $token,
        ]);
    }

    public function submitDonate(Request $request, ?string $token = null)
    {
        $token = $token ?: FoodBankHelper::publicToken();
        if (!FoodBankHelper::validatePublicToken($token)) {
            abort(404);
        }

        $data = $request->validate([
            'item_name' => 'required|string',
            'category' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit' => 'nullable|string',
            'description' => 'nullable|string',
            'pickup_location' => 'nullable|string',
            'delivery_details' => 'nullable|string',
            'notify_channels' => 'nullable|array',
            'notify_channels.*' => 'in:email,whatsapp,sms',
        ]);

        $workspaceId = FoodBankHelper::workspaceForToken($token);

        $data['workspace_id'] = $workspaceId;
        $data['created_by'] = creatorId() ?: 0;
        $data['updated_by'] = creatorId() ?: 0;
        $data['received_at'] = now();
        $data['notify_channels'] = array_values($data['notify_channels'] ?? []);

        FoodBankInventory::create($data);

        return view('foodbank::public.thankyou', [
            'mode' => 'donation',
            'token' => $token,
        ]);
    }
}
