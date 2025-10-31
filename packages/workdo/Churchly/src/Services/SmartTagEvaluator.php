<?php

namespace Workdo\Churchly\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\MemberContribution;
use Workdo\Churchly\Entities\SmartTag;

class SmartTagEvaluator
{
    /**
     * Recalculate matches for a single smart tag.
     */
    public function evaluate(SmartTag $tag): int
    {
        $workspaceId = $tag->workspace ?? getActiveWorkSpace();
        $updatedIds = $this->evaluateDefinition(collect($tag->definition ?? []), $workspaceId);

        $syncPayload = collect($updatedIds)->mapWithKeys(function ($id) {
            return [$id => ['matched_at' => now()]];
        })->toArray();

        $tag->members()->sync($syncPayload);
        $tag->forceFill(['last_run_at' => now()])->save();

        return count($updatedIds);
    }

    /**
     * Evaluate all active smart tags in the current workspace.
     */
    public function evaluateAll(?int $workspaceId = null): array
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        $results = [];

        SmartTag::forWorkspace($workspaceId)
            ->active()
            ->cursor()
            ->each(function (SmartTag $tag) use (&$results, $workspaceId) {
                $results[$tag->id] = $this->evaluate($tag);
            });

        return $results;
    }

    protected function evaluateDefinition(Collection $rules, int $workspaceId): array
    {
        if ($rules->isEmpty()) {
            return ChurchMember::forWorkspace($workspaceId)->pluck('id')->all();
        }

        $candidateIds = null;

        foreach ($rules as $rule) {
            $rule = collect($rule);
            $matches = $this->resolveRule($rule, $workspaceId);

            if ($rule->get('negate')) {
                $candidateIds = $candidateIds
                    ? array_values(array_diff($candidateIds, $matches))
                    : ChurchMember::forWorkspace($workspaceId)
                        ->pluck('id')
                        ->filter(fn ($id) => !in_array($id, $matches))
                        ->all();
            } else {
                $candidateIds = $candidateIds === null
                    ? $matches
                    : array_values(array_intersect($candidateIds, $matches));
            }
        }

        return array_unique($candidateIds ?? []);
    }

    protected function resolveRule(Collection $rule, int $workspaceId): array
    {
        return match ($rule->get('type')) {
            'attendance_count' => $this->ruleAttendanceCount($rule, $workspaceId),
            'giving_gap_days' => $this->ruleGivingGap($rule, $workspaceId),
            'in_department' => $this->ruleDepartment($rule),
            'in_branch' => $this->ruleBranch($rule),
            'membership_status' => $this->ruleMembershipStatus($rule, $workspaceId),
            default => ChurchMember::forWorkspace($workspaceId)->pluck('id')->all(),
        };
    }

    protected function ruleAttendanceCount(Collection $rule, int $workspaceId): array
    {
        $days = (int) $rule->get('days', 30);
        $operator = $rule->get('operator', '>=');
        $value = (int) $rule->get('value', 1);
        $status = $rule->get('status', 'present');

        $query = DB::table('attendance_records')
            ->select('member_id', DB::raw('COUNT(*) as aggregate'))
            ->where('workspace_id', $workspaceId)
            ->whereNotNull('member_id');

        if ($days > 0) {
            $query->where('check_in_time', '>=', now()->subDays($days));
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->groupBy('member_id')
            ->get()
            ->filter(fn ($row) => $this->compare((int) $row->aggregate, $operator, $value))
            ->pluck('member_id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    protected function ruleGivingGap(Collection $rule, int $workspaceId): array
    {
        $operator = $rule->get('operator', '>=');
        $gapDays = (int) $rule->get('value', 60);

        $latest = MemberContribution::forWorkspace($workspaceId)
            ->select('member_id', DB::raw('MAX(received_at) as last_received'))
            ->groupBy('member_id')
            ->get()
            ->mapWithKeys(fn ($row) => [(int) $row->member_id => $row->last_received ? Carbon::parse($row->last_received) : null]);

        $memberIds = ChurchMember::forWorkspace($workspaceId)->pluck('id');
        $today = now();

        return $memberIds->filter(function ($memberId) use ($latest, $today, $operator, $gapDays) {
            $last = $latest->get($memberId);
            $difference = $last ? $last->diffInDays($today) : PHP_INT_MAX;
            return $this->compare($difference, $operator, $gapDays);
        })->map(fn ($id) => (int) $id)->all();
    }

    protected function ruleDepartment(Collection $rule): array
    {
        $departmentIds = collect($rule->get('department_ids', []))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->all();

        if (empty($departmentIds)) {
            return [];
        }

        return DB::table('church_member_department')
            ->whereIn('department_id', $departmentIds)
            ->pluck('church_member_id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    protected function ruleBranch(Collection $rule): array
    {
        $branchIds = collect($rule->get('branch_ids', []))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->all();

        if (empty($branchIds)) {
            return [];
        }

        return ChurchMember::query()
            ->whereIn('branch_id', $branchIds)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    protected function ruleMembershipStatus(Collection $rule, int $workspaceId): array
    {
        $statuses = collect($rule->get('statuses', []))
            ->filter()
            ->map(fn ($value) => (string) $value)
            ->all();

        if (empty($statuses)) {
            return [];
        }

        return ChurchMember::forWorkspace($workspaceId)
            ->whereIn('membership_status', $statuses)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    protected function compare(int $left, string $operator, int $right): bool
    {
        return match ($operator) {
            '>' => $left > $right,
            '>=' => $left >= $right,
            '<' => $left < $right,
            '<=' => $left <= $right,
            '=' , '==' => $left === $right,
            '!=' , '<>' => $left !== $right,
            default => $left >= $right,
        };
    }
}
