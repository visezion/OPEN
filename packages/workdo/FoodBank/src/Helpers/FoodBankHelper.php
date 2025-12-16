<?php

namespace Workdo\FoodBank\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Workdo\FoodBank\Entities\FoodBankDonor;
use Workdo\FoodBank\Entities\FoodBankPublicToken;

class FoodBankHelper
{
    public static function getDefaultContact(): array
    {
        if (class_exists('\Workdo\Churchly\Entities\ChurchMember')) {
            $member = \Workdo\Churchly\Entities\ChurchMember::where('workspace', getActiveWorkSpace())
                ->orderBy('id')
                ->first();

            if ($member) {
                return [
                    'name' => $member->name,
                    'phone' => $member->phone ?? '',
                    'email' => $member->email ?? '',
                    'address' => $member->address ?? '',
                ];
            }
        }

        if (class_exists('\Workdo\Churchly\Entities\MaintenanceSetting')) {
            $setting = \Workdo\Churchly\Entities\MaintenanceSetting::forWorkspace()->first();
            if ($setting && !empty($setting->notification_methods)) {
                return [
                    'name' => __('Church Rural Food Bank'),
                    'phone' => '',
                    'email' => '',
                    'address' => '',
                ];
            }
        }

        return [
            'name' => '',
            'phone' => '',
            'email' => '',
            'address' => '',
        ];
    }

    public static function getPublicTokenRecord()
    {
        $workspace = function_exists('getActiveWorkSpace') ? getActiveWorkSpace() : null;
        if (empty($workspace)) {
            $workspace = 0;
        }
        $token = FoodBankPublicToken::firstOrCreate(
            ['workspace_id' => $workspace],
            [
                'token' => Str::upper(Str::random(32)),
                'created_by' => creatorId(),
                'updated_by' => creatorId(),
            ]
        );
        return $token;
    }

    public static function publicToken(): string
    {
        return static::getPublicTokenRecord()->token;
    }

    public static function publicRequestUrl(): string
    {
        return route('foodbank.public.request', ['token' => static::publicToken()]);
    }

    public static function publicDonateUrl(): string
    {
        return route('foodbank.public.donate', ['token' => static::publicToken()]);
    }

    public static function normalizeMaritalStatus(?string $value): string
    {
        $allowed = ['single', 'married', 'other'];
        if (!empty($value) && in_array($value, $allowed, true)) {
            return $value;
        }

        return 'single';
    }

    public static function workspaceForToken(?string $token): ?int
    {
        if (!empty($token)) {
            $record = FoodBankPublicToken::where('token', $token)->first();
            if ($record) {
                return $record->workspace_id;
            }
        }
        if (function_exists('getActiveWorkSpace')) {
            return getActiveWorkSpace();
        }
        return null;
    }

    public static function validatePublicToken(?string $token): bool
    {
        if (!config('foodbank.public_forms.require_token')) {
            return true;
        }

        if (empty($token)) {
            return false;
        }

        return FoodBankPublicToken::where('token', $token)->exists();
    }

    public static function ensurePermission(string $permission): void
    {
        $user = Auth::user();
        if (! $user) {
            abort(403, __('Permission denied.'));
        }

        if ($user->type === 'company') {
            return;
        }

        if (! $user->can($permission)) {
            abort(403, __('Permission denied.'));
        }
    }
}
