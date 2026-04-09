@extends('layouts.guest')

@section('title', 'Profile Settings | E-Library')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-16">
    <div class="w-full max-w-md space-y-8 rounded-[2rem] bg-white p-8 shadow-2xl ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
        <div class="space-y-3 text-center">
            <h1 class="text-3xl font-bold text-slate-950 dark:text-white">Profile Settings</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Update your profile information.</p>
        </div>

        @if(session('success'))
            <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm text-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full rounded-3xl bg-violet-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-violet-500/20 transition hover:bg-violet-700">Update Profile</button>
        </form>

        <div class="border-t border-slate-200 pt-6 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-950 dark:text-white mb-4">Delete Account</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Once your account is deleted, all of its resources and data will be permanently deleted.</p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('DELETE')

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Kata Sandi</label>
                    <input id="password" name="password" type="password" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                </div>

                <button type="submit" class="w-full rounded-3xl bg-red-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-red-500/20 transition hover:bg-red-700">Delete Account</button>
            </form>
        </div>
    </div>
</div>
@endsection