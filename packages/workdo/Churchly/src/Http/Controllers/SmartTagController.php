<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Workdo\Churchly\Entities\SmartTag;
use Workdo\Churchly\Services\SmartTagEvaluator;

class SmartTagController extends Controller
{
    public function index()
    {
        $this->authorizeAccess();

        $smartTags = SmartTag::forWorkspace()
            ->withCount('members')
            ->orderBy('name')
            ->paginate(15);

        return view('churchly::smart-tags.index', compact('smartTags'));
    }

    public function create()
    {
        $this->authorizeAccess();

        return view('churchly::smart-tags.form', ['smartTag' => new SmartTag()]);
    }

    public function store(Request $request)
    {
        $this->authorizeAccess();

        $request->merge(['definition' => $this->extractDefinition($request)]);
        $data = $this->validateSmartTag($request);
        $data['definition'] = $request->input('definition');
        $data['is_active'] = $request->boolean('is_active', true);

        SmartTag::create(array_merge($data, [
            'slug' => $this->uniqueSlug($data['name']),
            'workspace' => getActiveWorkSpace(),
            'created_by' => Auth::id(),
        ]));

        return redirect()->route('churchly.smart-tags.index')
            ->with('success', __('Smart tag created. Run the tag to refresh matches.'));
    }

    public function edit(SmartTag $smartTag)
    {
        $this->authorizeAccess();
        $this->ensureWorkspace($smartTag);

        return view('churchly::smart-tags.form', compact('smartTag'));
    }

    public function update(Request $request, SmartTag $smartTag)
    {
        $this->authorizeAccess();
        $this->ensureWorkspace($smartTag);

        $request->merge(['definition' => $this->extractDefinition($request)]);
        $data = $this->validateSmartTag($request, $smartTag->id);
        $data['definition'] = $request->input('definition');
        $data['is_active'] = $request->boolean('is_active', true);
        $smartTag->update($data);

        return redirect()->route('churchly.smart-tags.index')
            ->with('success', __('Smart tag updated.'));
    }

    public function destroy(SmartTag $smartTag)
    {
        $this->authorizeAccess();
        $this->ensureWorkspace($smartTag);

        $smartTag->delete();

        return back()->with('success', __('Smart tag deleted.'));
    }

    public function run(SmartTag $smartTag, SmartTagEvaluator $evaluator)
    {
        $this->authorizeAccess();
        $this->ensureWorkspace($smartTag);

        $count = $evaluator->evaluate($smartTag);

        return back()->with('success', __('Smart tag refreshed. :count members currently match.', ['count' => $count]));
    }

    protected function validateSmartTag(Request $request, ?int $smartTagId = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
            'definition' => 'required|array|min:1',
            'definition.*.type' => 'required|string',
            'definition.*.operator' => 'nullable|string|max:3',
            'definition.*.value' => 'nullable',
            'definition.*.days' => 'nullable|integer|min:1',
            'definition.*.department_ids' => 'nullable|array',
            'definition.*.branch_ids' => 'nullable|array',
            'definition.*.statuses' => 'nullable|array',
            'is_active' => 'boolean',
        ]);
    }

    protected function authorizeAccess(): void
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_member manage')) {
            abort(403, __('Permission denied.'));
        }
    }

    protected function ensureWorkspace(SmartTag $smartTag): void
    {
        if ($smartTag->workspace != getActiveWorkSpace()) {
            abort(403, __('Smart tag outside current workspace.'));
        }
    }

    protected function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 1;

        while (SmartTag::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    protected function extractDefinition(Request $request): array
    {
        if (is_array($request->input('definition'))) {
            return $request->input('definition');
        }

        $raw = $request->input('definition_json');
        if (is_null($raw) || $raw === '') {
            return [];
        }

        $decoded = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            throw ValidationException::withMessages([
                'definition_json' => __('Definition must be valid JSON.'),
            ]);
        }

        return $decoded;
    }
}



