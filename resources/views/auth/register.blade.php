@extends('layouts.guest')

@section('title', 'Daftar | E-Library')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-16">
    <div class="w-full max-w-md space-y-8 rounded-[2rem] bg-white p-8 shadow-2xl ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
        <div class="space-y-3 text-center">
            <h1 class="text-3xl font-bold text-slate-950 dark:text-white">Buat akun baru</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Daftar untuk mulai meminjam buku dan mengelola koleksi pribadi.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Kata Sandi</label>
                <input id="password" name="password" type="password" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
            </div>

            <button type="submit" class="w-full rounded-3xl bg-violet-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-violet-500/20 transition hover:bg-violet-700">Daftar</button>
        </form>

        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-violet-600 hover:text-violet-700 dark:text-violet-300">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
