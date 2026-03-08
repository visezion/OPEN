<x-guest-layout :workspace="$workspaceModel">
</div>
    <div class="min-h-screen px-4 py-8">
        <div class=""style="padding: 2rem;">
            <div class="space-y-4 text-center">
                <h1 class="text-3xl font-semibold text-slate-900">Register as a Church Member</h1>
                <p class="text-sm text-slate-500">
                    Share your info and we’ll notify the leadership team to welcome you properly.
                </p>
            </div><br>

            @if (session('success'))
                <div class="rounded-1xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-1xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ Form::open([
                'route' => ['churchly.self.register.store', $workspace],
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'class' => 'space-y-5 text-sm text-slate-700'
            ]) }}

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Full Name') }}
                        </label>
                        {{ Form::text('name', null, ['required', 'placeholder' => __('Enter Full Name'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Email Address') }}
                        </label>
                        {{ Form::email('email', null, ['required', 'placeholder' => __('Enter Email Address'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Phone Number') }}
                        </label>
                        {{ Form::text('phone', null, ['placeholder' => __('Enter Phone Number'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Date of Birth') }}
                        </label>
                        {{ Form::date('dob', null, ['max' => date('Y-m-d'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Gender') }}
                        </label>
                        {{ Form::select('gender', ['' => __('Select Gender'), 'Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'], null, ['required', 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Church Branch') }}
                        </label>
                        {{ Form::select('branch_id', ['' => __('Select Branch')] + $branches->toArray(), null, ['required', 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Department (optional)') }}
                        </label>
                        {{ Form::select('department_id', ['' => __('Select Department (Optional)')] + $departments->toArray(), null, ['class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Designation (optional)') }}
                        </label>
                        {{ Form::select('designation_id', ['' => __('Select Designation (Optional)')] + $designations->toArray(), null, ['class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                        {{ __('Church Date of Joining') }}
                    </label>
                    {{ Form::date('doj', null, ['max' => date('Y-m-d'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                        {{ __('Address') }}
                    </label>
                    {{ Form::textarea('address', null, ['rows' => 2, 'placeholder' => __('Enter Address'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Emergency Contact Name') }}
                        </label>
                        {{ Form::text('emergency_contact', null, ['required', 'placeholder' => __('Enter Emergency Contact Name'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            {{ __('Emergency Contact Phone Number') }}
                        </label>
                        {{ Form::text('emergency_phone', null, ['required', 'placeholder' => __('Enter Emergency Contact Phone Number'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200']) }}
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                        {{ __('Upload Document (Optional)') }}
                    </label>
                    {{ Form::file('documents', ['class' => 'mt-2 w-full text-sm text-slate-600 file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-slate-700']) }}
                </div>

                {{ Form::hidden('is_active', 0) }}

                <div class="pt-1"><br>
                    <button type="submit" class="w-full" style="background-color: #070533ff; color: white; padding: 0.75rem; border-radius: 0.75rem; font-weight: 600;">
                        {{ __('Register') }}
                    </button>
                </div>

            {{ Form::close() }}
        </div>
    </div>
</x-guest-layout>
