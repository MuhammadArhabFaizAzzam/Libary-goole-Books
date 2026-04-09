@extends('layouts.guest')

@section('title', 'Appearance Settings | E-Library')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-16">
    <div class="w-full max-w-md space-y-8 rounded-[2rem] bg-white p-8 shadow-2xl ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
        <div class="space-y-3 text-center">
            <h1 class="text-3xl font-bold text-slate-950 dark:text-white">Appearance Settings</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Customize how the application looks and feels.</p>
        </div>

        @if(session('success'))
            <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm text-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-950 dark:text-white mb-4">Theme</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input id="light" name="theme" type="radio" value="light" class="h-4 w-4 text-violet-600 focus:ring-violet-500 border-slate-300" />
                        <label for="light" class="ml-3 block text-sm font-medium text-slate-700 dark:text-slate-200">Light</label>
                    </div>
                    <div class="flex items-center">
                        <input id="dark" name="theme" type="radio" value="dark" class="h-4 w-4 text-violet-600 focus:ring-violet-500 border-slate-300" />
                        <label for="dark" class="ml-3 block text-sm font-medium text-slate-700 dark:text-slate-200">Dark</label>
                    </div>
                    <div class="flex items-center">
                        <input id="system" name="theme" type="radio" value="system" checked class="h-4 w-4 text-violet-600 focus:ring-violet-500 border-slate-300" />
                        <label for="system" class="ml-3 block text-sm font-medium text-slate-700 dark:text-slate-200">System</label>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-950 dark:text-white mb-4">Language</h3>
                <select class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                    <option value="en">English</option>
                    <option value="id">Bahasa Indonesia</option>
                </select>
            </div>

            <button type="submit" class="w-full rounded-3xl bg-violet-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-violet-500/20 transition hover:bg-violet-700">Save Preferences</button>
        </div>
    </div>
</div>
@endsection