
  <span>
    @php 
    $user = $member->user;
    @endphp
    
    @if(admin_setting('email_verification') == 'on' && $user->email_verified_at == null)
    <div class="action-btn me-2">
        <a href="{{ route('user.verified', $user->id) }}" class="btn btn-sm d-inline-flex align-items-center bg-secondary"  data-bs-toggle="tooltip" data-bs-original-title="{{ __('Verified Now') }}"> <span class="text-white"><i class="ti ti-checks"></i></a>
    </div>
    @endif
    @permission('user reset password')
        <div class="action-btn me-2">
            <a href="#" class="btn btn-sm d-inline-flex align-items-center bg-warning"
                data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}" data-ajax-popup="true"
                data-bs-toggle="tooltip" data-bs-original-title="{{ __('Reset Password') }}"
                data-title="{{ __('Reset Password') }}"> <span class="text-white"><i class="ti ti-adjustments"></i></a>
        </div>
    @endpermission

    @permission('user login manage')
        @if ($user->is_enable_login == 1)
            <div class="action-btn me-2">
                <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}"
                    class="btn btn-sm d-inline-flex align-items-center bg-danger" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Login Disable') }}"> <span class="text-white"><i
                            class="ti ti-road-sign"></i></a>
            </div>
        @elseif ($user->is_enable_login == 0 && $user->password == null)
            <div class="action-btn me-2">
                <a href="#" data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}" data-ajax-popup="true"
                    data-size="md" class="btn btn-sm d-inline-flex align-items-center login_enable bg-secondary"
                    data-title="{{ __('New Password') }}" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('New Password') }}"> <span class="text-white"><i
                            class="ti ti-road-sign"></i></a>
            </div>
        @else
            <div class="action-btn me-2">
                <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}"
                    class="btn btn-sm d-inline-flex align-items-center login_enable bg-success" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Login Enable') }}"> <span class="text-white"> <i
                            class="ti ti-road-sign"></i>
                </a>
            </div>
        @endif
    @endpermission
 
    @permission('church_member show')
    <div class="action-btn  me-2">
        <a href="{{ route('members.show', \Illuminate\Support\Facades\Crypt::encrypt( $member->id)) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="{{ __('View') }}">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
    @endpermission

    @permission('church_member edit')
    <div class="action-btn  me-2">
        <a href="{{ route('members.edit', \Illuminate\Support\Facades\Crypt::encrypt( $member->id)) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
           
            <i class="ti ti-pencil text-white"></i>
        </a>
    </div>
    @endpermission

    @permission('church_member delete')
        {!! Form::open(['method' => 'DELETE', 'route' => ['members.destroy', $member->id], 'style'=>'display:inline']) !!}
            <button type="submit" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                <i class="ti ti-trash"></i>
            </button>
        {!! Form::close() !!}
    @endpermission
</span>
