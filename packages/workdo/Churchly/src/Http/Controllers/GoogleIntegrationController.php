<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use Workdo\Churchly\Entities\{WorkspaceGoogleCredential, UserGoogleAccount};
use Workdo\Churchly\Services\Google\GoogleOAuth;

class GoogleIntegrationController extends Controller
{
    public function credentials()
    {
        $row = WorkspaceGoogleCredential::where('workspace_id', getActiveWorkSpace())->first();
        return view('churchly::google.credentials', ['cred' => $row]);
    }

    public function saveCredentials(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'redirect_uri' => 'required|url',
            'active' => 'nullable|boolean'
        ]);
        $data['active'] = (bool)($data['active'] ?? true);
        WorkspaceGoogleCredential::updateOrCreate(
            ['workspace_id' => getActiveWorkSpace()],
            array_merge($data, ['workspace_id' => getActiveWorkSpace()])
        );
        return back()->with('success','Google credentials saved.');
    }

    public function connect(Request $request)
    {
        $state = Str::random(32);
        session(['google_oauth_state' => $state, 'google_oauth_back' => url()->previous()]);
        $url = GoogleOAuth::buildAuthUrl(getActiveWorkSpace(), $state);
        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        $state = $request->input('state');
        if (!$state || $state !== session('google_oauth_state')) {
            return redirect()->route('churchly.google.credentials')->with('error','Invalid state, please try again.');
        }
        $code = $request->input('code');
        if (!$code) return redirect()->route('churchly.google.credentials')->with('error','Missing authorization code.');
        try {
            $tokens = GoogleOAuth::exchangeCode(getActiveWorkSpace(), $code);
            $accessToken = $tokens['access_token'] ?? null;
            $refreshToken = $tokens['refresh_token'] ?? null;
            $expiresIn = $tokens['expires_in'] ?? null;
            if (!$accessToken) throw new \RuntimeException('No access token');
            $info = GoogleOAuth::userInfo($accessToken);
            $email = $info['email'] ?? null; $gid = $info['sub'] ?? null; $name = $info['name'] ?? ($info['given_name'] ?? '');
            if (!$email || !$gid) throw new \RuntimeException('Unable to identify Google user');
            $user = Auth::user();
            if (!$user) {
                $user = User::where('email',$email)->first();
                if (!$user) { $user = User::create(['name'=>$name ?: $email,'email'=>$email,'password'=>Hash::make(Str::random(32))]); }
                Auth::login($user);
            }
            $acct = UserGoogleAccount::firstOrNew(['user_id'=>$user->id,'google_id'=>$gid]);
            $acct->workspace_id = getActiveWorkSpace();
            $acct->email = $email;
            $acct->access_token = $accessToken;
            if ($refreshToken) $acct->refresh_token = $refreshToken;
            $acct->expires_at = $expiresIn ? now()->addSeconds((int)$expiresIn) : null;
            $acct->scopes = implode(' ', GoogleOAuth::scopes());
            $acct->save();
            $back = session('google_oauth_back') ?: route('churchly.google.credentials');
            return redirect($back)->with('success','Google account connected.');
        } catch (\Throwable $e) {
            Log::error('google_web_callback_error: '.$e->getMessage());
            return redirect()->route('churchly.google.credentials')->with('error','Could not connect Google.');
        }
    }
}