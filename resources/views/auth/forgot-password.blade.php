@extends('layouts.guest')

@section('title', 'Lupa Password | E-Library')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-16">
    <div class="w-full max-w-md space-y-8 rounded-[2rem] bg-white p-8 shadow-2xl ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
        <div class="space-y-3 text-center">
            <h1 class="text-3xl font-bold text-slate-950 dark:text-white">Lupa kata sandi?</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Masukkan email Anda, lalu kami akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>
        </div>

        @if(session('status'))
            <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm text-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full rounded-3xl bg-violet-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-violet-500/20 transition hover:bg-violet-700">Kirim Tautan Reset</button>
        </form>

        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('login') }}" class="font-semibold text-violet-600 hover:text-violet-700 dark:text-violet-300">Kembali ke Halaman Masuk</a>
        </p>
    </div>
</div>
@endsection
