@extends('layouts.app')

@section('title', 'Legaldata-Номын худалдаа')

@section('content')
<div x-data="storePage" class="min-h-screen" x-cloak>
    @include('partials.header')

    <main>
        <section class="bg-gradient-to-b from-slate-100 to-slate-50">
            <div class="mx-auto max-w-7xl px-4 py-10">
                <div class="grid items-center gap-8 md:grid-cols-2">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Тавтай морил</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                            Legaldata номын худалдаа
                        </h1>
                        <p class="mt-3 text-sm text-slate-600">
                            Tailwind CSS + Alpine.js дээрх Laravel хувилбар.
                        </p>

                        <div class="mt-6 flex flex-wrap items-center gap-3">
                            <a href="{{ url('/book') }}" class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                                Номууд үзэх
                            </a>
                            <a href="https://legaldata.mn/book" target="_blank" rel="noopener" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                                Албан сайт
                            </a>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-semibold text-slate-700">Хайлт</p>
                        <div class="mt-3 flex overflow-hidden rounded-xl border border-slate-200 bg-white">
                            <input type="search" x-model="$store.shop.query" class="w-full px-4 py-2.5 text-sm outline-none" placeholder="Ном / зохиолч..." />
                            <button type="button" class="px-4 py-2.5 text-sm font-medium text-white bg-slate-900" @click.prevent>
                                Хайх
                            </button>
                        </div>
                        <p class="mt-3 text-xs text-slate-500" x-text="loading ? 'Ачаалж байна…' : (filtered.length + ' ном')"></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-10">
            <div class="flex items-end justify-between gap-4">
                <h2 class="text-lg font-bold tracking-tight text-slate-900">Шинээр нэмэгдсэн</h2>
                <a href="{{ url('/book') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900">Бүгд</a>
            </div>

            <div class="mt-5" x-show="!loading && filtered.length === 0" x-transition>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-600 shadow-sm">
                    Илэрц олдсонгүй.
                </div>
            </div>

            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" x-show="!loading && newBooks.length" x-transition>
                <template x-for="book in newBooks" :key="book.url">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition-shadow">
                        <a :href="detailUrl(book)" class="block">
                            <img :src="book.image" :alt="book.title" class="aspect-[3/4] w-full object-cover" loading="lazy">
                        </a>

                        <div class="p-4">
                            <p class="text-xs font-semibold text-slate-500" x-text="book.author"></p>
                            <a :href="detailUrl(book)" class="mt-1 line-clamp-2 text-sm font-semibold text-slate-900 hover:underline" x-text="book.title"></a>

                            <div class="mt-3 flex items-center justify-between gap-2">
                                <div class="text-sm font-bold text-slate-900" x-text="book.price"></div>
                                <template x-if="book.soldOut">
                                    <span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-700">Дууссан</span>
                                </template>
                                <template x-if="!book.soldOut">
                                    <button class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-500" @click.prevent="addToCart(book)">
                                        Сагсанд хийх
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </section>
    </main>

    @include('partials.footer')
    @include('partials.toast')
</div>
@endsection
