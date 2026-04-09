@extends('layouts.guest')

@section('title', 'Two-Factor Authentication | E-Library')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-16">
    <div class="w-full max-w-md space-y-8 rounded-[2rem] bg-white p-8 shadow-2xl ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
        <div class="space-y-3 text-center">
            <h1 class="text-3xl font-bold text-slate-950 dark:text-white">Two-Factor Authentication</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Add additional security to your account using two-factor authentication.</p>
        </div>

        @if(session('success'))
            <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm text-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        @if($user->two_factor_secret)
            <div class="space-y-6">
                <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm text-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-100">
                    Two-factor authentication is enabled.
                </div>

                <form method="POST" action="{{ route('two-factor.disable') }}" class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Password</label>
                        <input id="password" name="password" type="password" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                    </div>

                    <button type="submit" class="w-full rounded-3xl bg-red-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-red-500/20 transition hover:bg-red-700">Disable Two-Factor Authentication</button>
                </form>
            </div>
        @else
            <div class="space-y-6">
                <div class="rounded-2xl bg-amber-100 px-4 py-3 text-sm text-amber-900 dark:bg-amber-900/20 dark:text-amber-100">
                    Two-factor authentication is not enabled.
                </div>

                <form method="POST" action="{{ route('two-factor.enable') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="code" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Authentication Code</label>
                        <input id="code" name="code" type="text" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full rounded-3xl bg-violet-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-violet-500/20 transition hover:bg-violet-700">Enable Two-Factor Authentication</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection