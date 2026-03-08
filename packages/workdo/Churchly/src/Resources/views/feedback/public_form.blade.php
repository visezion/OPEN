<x-guest-layout :workspace="$workspace">
   
        
            
            <h5 class="text-1xl font-semibold text-white">{{ __('We value your feedback!') }}</h5>
            <p class="mt-2 text-sm text-slate-200">
                {{ __('Share your praises, concerns, or ideas directly with the leadership team. Every comment helps us improve.') }}
            </p>
        </div>

        <div class="px-8 py-10">
            @if ($errors->any())
                <div class="mb-4 rounded-2xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ __('Please fix the highlighted fields before resubmitting.') }}
                </div>
            @endif
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 mb-6">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('churchly.feedback.submit', ['workspace' => request()->route('workspace')]) }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="type" value="public">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-slate-700 ">{{ __('Title (optional)') }}</label>
                        <input type="text" name="title" placeholder="Optional title" class="mt-2 block w-full  border px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700 ">{{ __('Name') }}</label>
                    <input type="text" name="name" placeholder="Optional name" class="mt-2 block w-full  border px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>

                <div class="mt-4">
                    <label class="text-sm font-medium text-slate-700 ">{{ __('Email') }}</label>
                    <input type="email" name="email" placeholder="Optional email" class="mt-2 block w-full  border px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                <div class="mt-4">
                    <label class="text-sm font-medium text-slate-700 ">{{ __('Category') }}</label>
                    <select name="category" required class="mt-2 block w-full  border px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="suggestion">{{ __('Suggestion') }}</option>
                        <option value="complaint">{{ __('Complaint') }}</option>
                        <option value="praise">{{ __('Praise') }}</option>
                        <option value="other">{{ __('Other') }}</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label class="text-sm font-medium text-slate-700 ">{{ __('Message') }}</label>
                    <textarea name="message" rows="5" required placeholder="Type your feedback..." class="mt-2 block w-full rounded-1xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <div class="mt-4">
                    <label class="text-sm font-medium text-slate-700 ">{{ __('Attach File (optional)') }}</label>
                    <input type="file" name="attachment" class="mt-2 block w-full text-sm text-slate-600 file:border-0 file:bg-slate-100 file:px-3 file:py-2 file: file:text-slate-700 focus:outline-none" />
                </div>

                <div class="mt-6 text-right">
                    <button type="submit" class="inline-flex items-center justify-center rounded-1xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ __('Send Feedback') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
