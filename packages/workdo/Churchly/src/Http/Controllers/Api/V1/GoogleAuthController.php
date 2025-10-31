<?php

namespace Workdo\Churchly\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Workdo\Churchly\Entities\UserGoogleAccount;
use Workdo\Churchly\Services\Google\GoogleOAuth;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request)
    {
        $state = Str::random(32);
        session(['google_oauth_state' => $state]);
        $url = GoogleOAuth::buildAuthUrl(getActiveWorkSpace(), $state);
        return response()->json(['status'=>'success','url'=>$url]);
    }

    public function callback(Request $request)
    {
        $state = $request->input('state');
        if (!$state || $state !== session('google_oauth_state')) {
            return response()->json(['status'=>'error','message'=>'Invalid state'], 422);
        }
        $code = $request->input('code');
        if (!$code) return response()->json(['status'=>'error','message'=>'Missing code'],422);

        $tokens = GoogleOAuth::exchangeCode(getActiveWorkSpace(), $code);
        $accessToken = $tokens['access_token'] ?? null;
        $refreshToken = $tokens['refresh_token'] ?? null;
        $expiresIn = $tokens['expires_in'] ?? null;
        if (!$accessToken) return response()->json(['status'=>'error','message'=>'No access token'],500);
        $info = GoogleOAuth::userInfo($accessToken);
        $email = $info['email'] ?? null;
        $gid = $info['sub'] ?? null;
        $name = $info['name'] ?? ($info['given_name'] ?? '');
        if (!$email || !$gid) return response()->json(['status'=>'error','message'=>'Unable to identify Google user'],500);

        $user = Auth::user();
        if (!$user) {
            $user = User::where('email',$email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $name ?: $email,
                    'email' => $email,
                    'password' => Hash::make(Str::random(32)),
                ]);
            }
            Auth::login($user);
        }

        $acct = UserGoogleAccount::firstOrNew(['user_id'=>$user->id,'google_id'=>$gid]);
        $acct->fill([
            'workspace_id' => getActiveWorkSpace(),
            'email' => $email,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_at' => $expiresIn ? now()->addSeconds((int)$expiresIn) : null,
            'scopes' => implode(' ', GoogleOAuth::scopes()),
        ]);
        $acct->save();

        $token = $user->createToken('google_login')->plainTextToken;
        return response()->json(['status'=>'success','token'=>$token]);
    }

    // Mobile: exchange Google ID token for Sanctum token
    public function mobile(Request $request)
    {
        $data = $request->validate([
            'id_token' => 'required|string',
        ]);
        $payload = GoogleOAuth::verifyIdToken($data['id_token']);
        $email = $payload['email'] ?? null;
        $gid = $payload['sub'] ?? null;
        $aud = $payload['aud'] ?? null;
        if (!$email || !$gid) return response()->json(['status'=>'error','message'=>'Invalid Google token'],422);
        // Optional: validate aud matches any configured client_id (workspace/global)
        $creds = GoogleOAuth::getCredentials(getActiveWorkSpace());
        if (!empty($creds['client_id']) && $aud !== $creds['client_id']) {
            // allow if mismatch? return error for safety
            // return response()->json(['status'=>'error','message'=>'Client mismatch'], 403);
        }
        $user = User::where('email',$email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $payload['name'] ?? $email,
                'email'=> $email,
                'password' => Hash::make(Str::random(32)),
            ]);
        }
        $acct = UserGoogleAccount::firstOrNew(['user_id'=>$user->id,'google_id'=>$gid]);
        $acct->fill([
            'workspace_id' => getActiveWorkSpace(),
            'email' => $email,
        ]);
        $acct->save();

        $token = $user->createToken('google_mobile')->plainTextToken;
        return response()->json(['status'=>'success','token'=>$token]);
    }
}