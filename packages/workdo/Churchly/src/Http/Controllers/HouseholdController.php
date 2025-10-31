<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\Household;

class HouseholdController extends Controller
{
    public function index()
    {
        $this->authorizeAccess();

        $households = Household::forWorkspace()
            ->with(['primaryContact', 'members'])
            ->orderBy('name')
            ->paginate(15);

        return view('churchly::households.index', compact('households'));
    }

    public function store(Request $request)
    {
        $this->authorizeAccess();

        $data = $this->validateHousehold($request);

        Household::create(array_merge($data, [
            'slug' => $this->generateSlug($data['name']),
            'workspace' => getActiveWorkSpace(),
            'created_by' => Auth::id(),
        ]));

        return back()->with('success', __('Household created.'));
    }

    public function update(Request $request, Household $household)
    {
        $this->authorizeAccess();
        $this->ensureHouseholdWorkspace($household);

        $data = $this->validateHousehold($request, $household->id);
        $household->update($data);

        return back()->with('success', __('Household updated.'));
    }

    public function destroy(Household $household)
    {
        $this->authorizeAccess();
        $this->ensureHouseholdWorkspace($household);

        $household->delete();

        return back()->with('success', __('Household removed.'));
    }

    public function attachMember(Request $request, Household $household)
    {
        $this->authorizeAccess();
        $this->ensureHouseholdWorkspace($household);

        $data = $request->validate([
            'member_id' => 'required|exists:church_members,id',
            'relationship' => 'nullable|string|max:50',
            'is_primary' => 'boolean',
            'joined_at' => 'nullable|date',
        ]);

        $member = ChurchMember::findOrFail($data['member_id']);
        if ($member->workspace != getActiveWorkSpace()) {
            abort(403, __('Member outside current workspace.'));
        }

        $this->syncHouseholdMember($household, $member, [
            'relationship' => $data['relationship'] ?? null,
            'is_primary' => $data['is_primary'] ?? false,
            'joined_at' => $data['joined_at'] ?? null,
        ]);

        return back()->with('success', __('Member added to household.'));
    }

    public function attachMemberFromForm(Request $request)
    {
        $this->authorizeAccess();

        $data = $request->validate([
            'household_id' => 'required|exists:church_households,id',
            'member_id' => 'required|exists:church_members,id',
            'relationship' => 'nullable|string|max:50',
            'is_primary' => 'boolean',
            'joined_at' => 'nullable|date',
        ]);

        $household = Household::forWorkspace()->findOrFail($data['household_id']);
        $member = ChurchMember::findOrFail($data['member_id']);

        if ($member->workspace != getActiveWorkSpace()) {
            abort(403, __('Member outside current workspace.'));
        }

        $this->syncHouseholdMember($household, $member, [
            'relationship' => $data['relationship'] ?? null,
            'is_primary' => $data['is_primary'] ?? false,
            'joined_at' => $data['joined_at'] ?? null,
        ]);

        return back()->with('success', __('Member added to household.'));
    }

    public function detachMember(Household $household, ChurchMember $member)
    {
        $this->authorizeAccess();
        $this->ensureHouseholdWorkspace($household);

        $household->members()->detach($member->id);

        if ($household->primary_contact_id === $member->id) {
            $household->primary_contact_id = optional(
                $household->members()->wherePivot('is_primary', true)->first()
            )->id;
            $household->save();
        }

        return back()->with('success', __('Member removed from household.'));
    }

    protected function syncHouseholdMember(Household $household, ChurchMember $member, array $attributes): void
    {
        $household->members()->syncWithoutDetaching([
            $member->id => [
                'relationship' => $attributes['relationship'] ?? null,
                'is_primary' => $attributes['is_primary'] ?? false,
                'joined_at' => $attributes['joined_at'] ?? null,
            ],
        ]);

        if (!empty($attributes['is_primary'])) {
            $household->primary_contact_id = $member->id;
            $household->save();

            \DB::table('church_household_members')
                ->where('household_id', $household->id)
                ->where('member_id', '!=', $member->id)
                ->update(['is_primary' => false]);
        }
    }

    protected function validateHousehold(Request $request, ?int $householdId = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:191',
            'primary_contact_id' => 'nullable|exists:church_members,id',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email',
            'address_line1' => 'nullable|string|max:191',
            'address_line2' => 'nullable|string|max:191',
            'city' => 'nullable|string|max:120',
            'state' => 'nullable|string|max:120',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:3',
            'notes' => 'nullable|string',
        ]);
    }

    protected function authorizeAccess(): void
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_member manage')) {
            abort(403, __('Permission denied.'));
        }
    }

    protected function ensureHouseholdWorkspace(Household $household): void
    {
        if ($household->workspace != getActiveWorkSpace()) {
            abort(403, __('Household outside current workspace.'));
        }
    }

    protected function generateSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 1;
        while (Household::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}




