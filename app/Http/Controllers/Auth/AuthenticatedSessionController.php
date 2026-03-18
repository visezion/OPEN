<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginDetail;
use App\Models\Plan;
use App\Models\User;
use App\Models\WorkSpace;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Facades\ModuleFacade as Module;;
use Workdo\GoogleCaptcha\Events\VerifyReCaptchaToken;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function __construct()
    {
        if(!file_exists(storage_path() . "/installed"))
        {
            header('location:install');
            die;
        }
        $admin_settings = getAdminAllSetting();
        if(module_is_active('GoogleCaptcha') && (isset($admin_settings['google_recaptcha_is_on']) ? $admin_settings['google_recaptcha_is_on'] : 'off') == 'on' )
        {
            config(['captcha.secret' => isset($admin_settings['google_recaptcha_secret']) ? $admin_settings['google_recaptcha_secret'] : '']);
            config(['captcha.sitekey' => isset($admin_settings['google_recaptcha_key']) ? $admin_settings['google_recaptcha_key'] : '']);
        }
        // $this->middleware('guest')->except('logout');
    }
    public function create($lang = '')
    {
        if($lang == '')
        {
            $lang = getActiveLanguage();
        }
        else
        {
            $lang = array_key_exists($lang, languages()) ? $lang : 'en';
        }
        \App::setLocale($lang);
        $captcha = $this->buildLoginCaptcha();
        session(['login_captcha_answer' => $captcha['answer']]);

        return view('auth.login', [
            'lang' => $lang,
            'captchaImage' => $captcha['image'],
        ]);
    }

    public function refreshCaptcha(Request $request): JsonResponse
    {
        $captcha = $this->buildLoginCaptcha();
        $request->session()->put('login_captcha_answer', $captcha['answer']);

        return response()->json([
            'ok' => true,
            'captcha_image' => $captcha['image'],
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $validation = [];
        $redirect = false;

        $submittedCaptcha = strtoupper((string) preg_replace('/[^A-Za-z0-9]/', '', (string) $request->input('captcha_answer', '')));
        $expectedCaptcha = strtoupper((string) $request->session()->get('login_captcha_answer', ''));

        if ($expectedCaptcha === '' || $submittedCaptcha === '' || !hash_equals($expectedCaptcha, $submittedCaptcha)) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    'captcha_answer' => __('The security captcha is invalid.'),
                ]);
        }

        if (module_is_active('GoogleCaptcha') && admin_setting('google_recaptcha_is_on') == 'on') {
            if (admin_setting('google_recaptcha_version') == 'v2-checkbox') {
                $request->validate([
                    'g-recaptcha-response' => 'required|captcha',
                ]);
            } else {

                $result = event(new VerifyReCaptchaToken($request));
                if (!isset($result[0]['status']) || $result[0]['status'] != true) {
                    $key = 'g-recaptcha-response';
                    $request->merge([$key => null]); // Set the key to null
                    $validation['g-recaptcha-response'] = 'required';
                }
            }
        }
        // $this->validate($request, $validation);

        $request->authenticate();

        $request->session()->regenerate();
        $request->session()->forget('login_captcha_answer');

        //  User logs

        $ip = $_SERVER['REMOTE_ADDR']; // your ip address here

        // $ip = '49.36.83.154'; // This is static ip address

        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));

        if(isset($query['status']) && $query['status'] == 'success')
        {
            $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
            if ($whichbrowser->device->type == 'bot')
            {
                return redirect()->intended(RouteServiceProvider::HOME);
            }

            $referrer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : null;

            /* Detect extra details about the user */
            $query['browser_name'] = $whichbrowser->browser->name ?? null;
            $query['os_name'] = $whichbrowser->os->name ?? null;
            $query['browser_language'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            $query['device_type'] = GetDeviceType($_SERVER['HTTP_USER_AGENT']);
            $query['referrer_host'] = !empty($referrer['host']);
            $query['referrer_path'] = !empty($referrer['path']);

            $json = json_encode($query);

            $login_detail = new LoginDetail();
            $login_detail->user_id = Auth::user()->id;
            $login_detail->ip = $ip;
            $login_detail->date = date('Y-m-d H:i:s');
            $login_detail->Details = $json;
            $login_detail->type = Auth::user()->type;
            $login_detail->created_by = creatorId();
            $login_detail->workspace = getActiveWorkSpace();
            $login_detail->save();
        }

        // custom domain code
        if(Auth::user()->type != 'super admin')
        {
            $uri = url()->full();
            $segments = explode('/', str_replace(''.url('').'', '', $uri));
            $segments = $segments[1] ?? null;

            $local = parse_url(config('app.url'))['host'];
            // Get the request host
            $remote = request()->getHost();
            if($local != $remote)
            {
                $remote = str_replace('www.', '', $remote);
                $workSpace = WorkSpace::where('domain',$remote)->orwhere('subdomain',$remote)->where('created_by',creatorId())->first();
                if($workSpace && ($workSpace->enable_domain == 'on'))
                {
                    $redirect = true;
                    $user = User::find(Auth::user()->id);
                    $user->active_workspace = $workSpace->id;
                    $user->save();
                }
            }
        }

        if(Auth::user()->type == 'company')
        {
            $user = User::where('id', Auth::user()->id)->first();

            if($user->plan_expire_date > (!empty($user->trial_expire_date) ? $user->trial_expire_date :''))
            {
                $datetime1 = new \DateTime($user->plan_expire_date);
            }else{
                $datetime1 = new \DateTime($user->trial_expire_date);
            }
            $datetime2 = new \DateTime(date('Y-m-d'));
            $interval = $datetime2->diff($datetime1);
            $days     = $interval->format('%r%a');
            if($days <= 0)
            {
                $plan = Plan::where('is_free_plan',1)->first();
                if($plan)
                {
                    $user->assignPlan($plan->id,'Month',$plan->modules,0,$user->id);
                }
                return redirect()->route('active.plans')->with('error', __('Your Plan is expired.'));
            }

        }
        // Settings Cache forget
        sideMenuCacheForget();

        if($redirect)
        {
            return redirect()->away('http://'.$remote.'/dashboard');
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function buildLoginCaptcha(): array
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $length = strlen($characters) - 1;
        $answer = '';
        for ($i = 0; $i < 5; $i++) {
            $answer .= $characters[random_int(0, $length)];
        }

        $width = 260;
        $height = 74;

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" viewBox="0 0 ' . $width . ' ' . $height . '">';
        $svg .= '<rect width="100%" height="100%" fill="#ffffff"/>';

        for ($i = 0; $i < 10; $i++) {
            $x1 = random_int(0, $width);
            $y1 = random_int(0, $height);
            $x2 = random_int(0, $width);
            $y2 = random_int(0, $height);
            $stroke = random_int(190, 235);
            $svg .= '<line x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '" stroke="rgb(' . $stroke . ',' . ($stroke - 8) . ',' . ($stroke - 18) . ')" stroke-width="1"/>';
        }

        for ($i = 0; $i < 14; $i++) {
            $cx = random_int(6, $width - 6);
            $cy = random_int(6, $height - 6);
            $r = random_int(1, 2);
            $fill = random_int(165, 220);
            $svg .= '<circle cx="' . $cx . '" cy="' . $cy . '" r="' . $r . '" fill="rgb(' . $fill . ',' . $fill . ',' . $fill . ')" />';
        }

        $x = 28;
        $letters = str_split($answer);
        foreach ($letters as $letter) {
            $rotate = random_int(-14, 14);
            $y = random_int(44, 58);
            $color = random_int(60, 105);
            $svg .= '<text x="' . $x . '" y="' . $y . '" font-size="52" font-family="Verdana, Arial, sans-serif" fill="rgb(' . $color . ',' . ($color + 7) . ',' . ($color + 20) . ')" transform="rotate(' . $rotate . ' ' . $x . ' ' . $y . ')">' . $letter . '</text>';
            $x += 44;
        }

        $svg .= '</svg>';

        return [
            'answer' => $answer,
            'image' => 'data:image/svg+xml;base64,' . base64_encode($svg),
        ];
    }
}
