<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CiCdController extends Controller
{
    protected function repoOwner(): string
    {
        return env('GITHUB_OWNER', 'visezion');
    }

    protected function repoName(): string
    {
        return env('GITHUB_REPO', 'OPEN');
    }

    protected function token(): ?string
    {
        return env('GITHUB_TOKEN'); // must have repo/workflow scopes for dispatch
    }

    protected function workflowRef(): string
    {
        // Prefer explicit workflow file id/name if provided, else default to php.yml
        return env('GITHUB_WORKFLOW', '.github/workflows/php.yml');
    }

    public function index(Request $request)
    {
        $owner = $this->repoOwner();
        $repo  = $this->repoName();
        $token = $this->token();
        $workflow = $this->workflowRef();

        $runs = [];
        $error = null;
        try {
            $url = "https://api.github.com/repos/{$owner}/{$repo}/actions/runs?per_page=10";
            $resp = Http::withHeaders([
                'Accept' => 'application/vnd.github+json',
                'X-GitHub-Api-Version' => '2022-11-28',
            ])->when($token, function ($h) use ($token) {
                return $h->withToken($token);
            })->get($url);

            if ($resp->ok()) {
                $runs = $resp->json('workflow_runs') ?? [];
            } else {
                $error = 'GitHub API error: ' . $resp->status();
            }
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }

        return view('superadmin.cicd.index', [
            'owner' => $owner,
            'repo' => $repo,
            'tokenPresent' => !empty($token),
            'workflow' => $workflow,
            'runs' => $runs,
            'error' => $error,
        ]);
    }

    public function dispatch(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('setting manage')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $owner = $this->repoOwner();
        $repo  = $this->repoName();
        $token = $this->token();
        $workflow = $this->workflowRef();

        if (empty($token)) {
            return back()->with('error', __('Missing GITHUB_TOKEN in env (requires workflow scope).'));
        }

        try {
            $url = "https://api.github.com/repos/{$owner}/{$repo}/actions/workflows/" . rawurlencode($workflow) . "/dispatches";
            $resp = Http::withToken($token)
                ->withHeaders([
                    'Accept' => 'application/vnd.github+json',
                    'X-GitHub-Api-Version' => '2022-11-28',
                ])->post($url, [
                    'ref' => 'main',
                ]);
            if ($resp->status() === 204) {
                return back()->with('success', __('Workflow dispatched for branch main.'));
            }
            return back()->with('error', __('Failed to dispatch workflow: HTTP ').$resp->status());
        } catch (\Throwable $e) {
            return back()->with('error', __('Dispatch error: ') . $e->getMessage());
        }
    }
}

