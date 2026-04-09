@extends('layouts.guest')@extends('layouts.guest')
































@endsection</div>    </div>        </div>            </form>                <button type="submit" class="w-full rounded-3xl border border-slate-300 bg-white px-5 py-4 text-base font-semibold text-slate-950 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:hover:bg-slate-800">Keluar</button>                @csrf            <form method="POST" action="{{ route('logout') }}" class="space-y-4">            </form>                <button type="submit" class="w-full rounded-3xl bg-violet-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-violet-500/20 transition hover:bg-violet-700">Kirim ulang tautan verifikasi</button>                @csrf            <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">        <div class="space-y-6">        @endif            </div>                Tautan verifikasi baru telah dikirim ke alamat email Anda.            <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm text-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-100">        @if(session('status') === 'verification-link-sent')        </div>            <p class="text-sm text-slate-500 dark:text-slate-400">Silakan periksa email untuk tautan verifikasi sebelum melanjutkan.</p>            <h1 class="text-3xl font-bold text-slate-950 dark:text-white">Verifikasi Email</h1>        <div class="space-y-3 text-center">    <div class="w-full max-w-md space-y-8 rounded-[2rem] bg-white p-8 shadow-2xl ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700"><div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-16">@section('content')@section('title', 'Verifikasi Email | E-Library')
@section('title', 'Verifikasi Email | E-Library')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-16">
    <div class="w-full max-w-md space-y-8 rounded-[2rem] bg-white p-8 shadow-2xl ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
        <div class="space-y-3 text-center">
            <h1 class="text-3xl font-bold text-slate-950 dark:text-white">Verifikasi alamat email</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Periksa inbox Anda dan klik tautan verifikasi untuk melanjutkan.</p>
        </div>

        @if(session('status') === 'verification-link-sent')
            <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm text-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-100">
                Tautan verifikasi baru telah dikirim ke alamat email Anda.
            </div>
        @endif

        <div class="rounded-3xl bg-slate-50 p-6 text-slate-700 dark:bg-slate-950 dark:text-slate-200">
            <p class="text-sm leading-7">Kami telah mengirimkan tautan verifikasi email. Silakan buka email Anda dan selesaikan verifikasinya sebelum masuk ke aplikasi.</p>
        </div>

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full rounded-3xl bg-violet-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-violet-500/20 transition hover:bg-violet-700">Kirim ulang tautan verifikasi</button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-3xl border border-slate-200 bg-white px-5 py-4 text-base font-semibold text-slate-900 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:hover:bg-slate-800">Keluar</button>
            </form>
        </div>
    </div>
</div>
@endsection
