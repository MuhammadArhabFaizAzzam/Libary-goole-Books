@extends('layouts.guest')

@section('title', 'Beranda | E-Library')

@section('content')
<section class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-16">
    <div class="w-full max-w-7xl grid gap-12 lg:grid-cols-[1.2fr_0.8fr] items-center">
        <div class="space-y-8">
            <div class="inline-flex items-center gap-3 rounded-full bg-white/90 px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900/90 dark:text-slate-100 dark:ring-slate-700">
                <span class="inline-flex h-2.5 w-2.5 rounded-full bg-violet-500"></span>
                Akses katalog buku dan pinjam dengan mudah.
            </div>

            <div class="space-y-6">
                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-950 dark:text-white">
                    Temukan buku favoritmu, <span class="text-violet-600 dark:text-violet-400">di satu tempat</span>.
                </h1>
                <p class="max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-300">
                    Sistem perpustakaan digital sederhana untuk mencari buku, melihat detail, dan menyimpan koleksi buku yang kamu suka. Login untuk mulai meminjam dan kelola daftar bacaanmu.
                </p>
            </div>

            <div class="flex flex-col gap-4 sm:flex-row">
                @if(Route::has('login'))
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-2xl bg-violet-600 px-6 py-4 text-base font-semibold text-white shadow-lg shadow-violet-500/20 transition hover:bg-violet-700">
                        Masuk Sekarang
                    </a>
                @endif

                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-4 text-base font-semibold text-slate-900 shadow-sm transition hover:border-slate-400 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800">
                        Daftar Akun
                    </a>
                @endif
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
                    <p class="text-3xl font-bold text-violet-600">300+</p>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">Judul buku</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
                    <p class="text-3xl font-bold text-emerald-600">100%</p>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">Akses online</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
                    <p class="text-3xl font-bold text-sky-600">Terus berkembang</p>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">Fitur peminjaman dan bookmark</p>
                </div>
            </div>
        </div>

        <div class="rounded-4xl bg-gradient-to-br from-violet-600 to-fuchsia-600 p-1 shadow-2xl shadow-violet-500/20">
            <div class="h-full rounded-[1.75rem] bg-slate-950 p-8 text-white shadow-xl sm:p-10">
                <div class="mb-8 inline-flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 text-xs uppercase tracking-[0.25em] text-slate-100/80">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-300"></span>
                    E-Library Digital
                </div>
                <div class="space-y-6">
                    <h2 class="text-3xl font-bold sm:text-4xl">Mulai pinjam buku hari ini</h2>
                    <p class="text-slate-200/80 leading-7">Kelola koleksi, temukan buku baru, dan simpan favoritmu dengan desain yang mudah digunakan.</p>
                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-white/10 p-5 ring-1 ring-white/10 backdrop-blur">
                        <p class="text-sm text-slate-300">Semua kategori</p>
                        <p class="mt-3 text-3xl font-semibold">Fiksi & Non-fiksi</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-5 ring-1 ring-white/10 backdrop-blur">
                        <p class="text-sm text-slate-300">Akses kapan saja</p>
                        <p class="mt-3 text-3xl font-semibold">Dari handphone ataupun laptop</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
