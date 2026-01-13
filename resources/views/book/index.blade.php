@extends('layouts.app')

@section('title', 'Legaldata-Номын худалдаа')

@section('content')
<div x-data="bookPage" class="min-h-screen" x-cloak>
    @include('partials.header')

    <main>
        <section class="bg-gradient-to-b from-slate-100 to-slate-50">
            <div class="mx-auto max-w-7xl px-4 py-10">
                <template x-if="featured">
                    <div class="grid items-center gap-8 md:grid-cols-2">
                        <div class="order-2 md:order-1">
                            <p class="text-sm font-semibold text-slate-500">Онцлох ном</p>
                            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl" x-text="featured.title"></h1>
                            <p class="mt-2 text-sm text-slate-600" x-text="featured.author"></p>

                            <div class="mt-5 flex flex-wrap items-center gap-3">
                                <a
                                    class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                                    :href="detailUrl(featured)"
                                >
                                    Дэлгэрэнгүй
                                </a>

                                <a
                                    class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50"
                                    :href="featured.url"
                                    target="_blank"
                                    rel="noopener"
                                >
                                    Албан линк
                                </a>

                                <span class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900" x-text="'Үнэ: ' + (featured.price || '0₮')"></span>
                            </div>
                        </div>

                        <div class="order-1 md:order-2">
                            <div class="mx-auto max-w-sm overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                <img :src="featured.image" :alt="featured.title" class="aspect-[3/4] w-full object-cover" loading="lazy">
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="loading">
                    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-600 shadow-sm">
                        Номууд ачаалж байна...
                    </div>
                </template>

                <template x-if="!loading && error">
                    <div class="mt-8 rounded-2xl border border-rose-200 bg-rose-50 p-6 text-sm text-rose-800">
                        Мэдээлэл уншихад алдаа гарлаа: <span class="font-semibold" x-text="error"></span>
                    </div>
                </template>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-10">
            <div class="flex items-end justify-between gap-4">
                <h2 class="text-lg font-bold tracking-tight text-slate-900">Шинээр нэмэгдсэн</h2>
                <p class="text-sm text-slate-500" x-text="filtered.length ? (filtered.length + ' ном') : ''"></p>
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

        <section class="bg-slate-900">
            <div class="mx-auto max-w-7xl px-4 py-10">
                <div class="flex items-end justify-between gap-4">
                    <h2 class="text-lg font-bold tracking-tight text-white">Best seller</h2>
                    <a href="#" class="text-sm font-medium text-slate-200 hover:text-white" @click.prevent>Бүгд</a>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-2" x-show="!loading && bestSeller.length" x-transition>
                    <template x-for="book in bestSeller" :key="book.url">
                        <div class="flex gap-4 rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                            <a :href="detailUrl(book)" class="w-20 shrink-0 overflow-hidden rounded-xl ring-1 ring-white/10">
                                <img :src="book.image" :alt="book.title" class="aspect-[3/4] w-full object-cover" loading="lazy">
                            </a>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-slate-300" x-text="book.author"></p>
                                <a :href="detailUrl(book)" class="mt-1 block truncate text-sm font-semibold text-white hover:underline" x-text="book.title"></a>
                                <div class="mt-2 flex items-center gap-3">
                                    <span class="text-sm font-bold text-white" x-text="book.price"></span>
                                    <template x-if="book.soldOut">
                                        <span class="rounded-full bg-rose-500/20 px-2 py-1 text-xs font-semibold text-rose-200">Дууссан</span>
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
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-10">
            <div class="flex items-end justify-between gap-4">
                <h2 class="text-lg font-bold tracking-tight text-slate-900">Бусад</h2>
            </div>

            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" x-show="!loading && lawBooks.length" x-transition>
                <template x-for="book in lawBooks" :key="book.url">
                    <div class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <a :href="detailUrl(book)" class="w-20 shrink-0 overflow-hidden rounded-xl border border-slate-200">
                            <img :src="book.image" :alt="book.title" class="aspect-[3/4] w-full object-cover" loading="lazy">
                        </a>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-slate-500" x-text="book.author"></p>
                            <a :href="detailUrl(book)" class="mt-1 block line-clamp-2 text-sm font-semibold text-slate-900 hover:underline" x-text="book.title"></a>
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <span class="text-sm font-bold text-slate-900" x-text="book.price"></span>
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
