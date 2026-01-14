@extends('layouts.app')

@section('title', 'Ангилалаар')

@section('content')
@php
    $legaldataCategories = config('legaldata.categories', []);
    $categoryLabel = collect($legaldataCategories)->firstWhere('id', $catId)['label'] ?? 'Ангилалаар';
@endphp

<div x-data="categoryPage({ catId: {{ (int) $catId }}, categories: @js($legaldataCategories) })" class="min-h-screen" x-cloak>
    @include('partials.header')

    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-4">
            <nav class="text-sm text-slate-600" aria-label="breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a class="hover:text-slate-900" href="{{ url('/book') }}">Нүүр хуудас</a></li>
                    <li class="text-slate-400">/</li>
                    <li class="font-semibold text-slate-900">Ангилалаар</li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="mx-auto max-w-7xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-12">
            <section class="lg:col-span-9">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-bold tracking-tight text-slate-900 sm:text-xl">
                            <span class="text-slate-500">Ангилал:</span>
                            <span class="ml-2" x-text="categoryLabel">{{ $categoryLabel }}</span>
                        </h1>
                        <p class="mt-1 text-sm text-slate-500" x-text="loading ? 'Ачаалж байна…' : (total + ' бүтээгдэхүүн')"></p>
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="text-sm font-semibold text-slate-700" for="sort">Эрэмбэлэх</label>
                        <select
                            id="sort"
                            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-900 outline-none"
                            x-model="sort"
                            @change="setPage(1)"
                        >
                            <option value="new">Анхдагч</option>
                            <option value="title_asc">Нэр (А-Я)</option>
                            <option value="title_desc">Нэр (Я-А)</option>
                            <option value="price_asc">Үнэ (өсөх)</option>
                            <option value="price_desc">Үнэ (буурах)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-5" x-show="loading" x-transition>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-600 shadow-sm">
                        Ачаалж байна...
                    </div>
                </div>

                <div class="mt-5" x-show="!loading && error" x-transition>
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 p-6 text-sm text-rose-800">
                        Алдаа: <span class="font-semibold" x-text="error"></span>
                    </div>
                </div>

                <div class="mt-5" x-show="!loading && paged.length === 0" x-transition>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-600 shadow-sm">
                        Илэрц олдсонгүй.
                    </div>
                </div>

                <div class="mt-6" x-show="!loading && paged.length" x-transition>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <template x-for="book in paged" :key="book.url">
                            <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                <a :href="detailUrl(book)" class="block">
                                    <div class="relative aspect-3/4 bg-slate-50">
                                        <img :src="$store.shop.proxyImage(book.image)" :alt="book.title" class="h-full w-full object-cover" loading="lazy">

                                        <template x-if="book.soldOut">
                                            <span class="absolute left-3 top-3 rounded-full bg-rose-600 px-3 py-1 text-xs font-bold text-white">Дууссан</span>
                                        </template>
                                        <template x-if="book.discount">
                                            <span class="absolute right-3 top-3 rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800" x-text="book.discount"></span>
                                        </template>
                                    </div>
                                </a>

                                <div class="p-4">
                                    <div class="line-clamp-2 text-sm font-semibold text-slate-900">
                                        <a :href="detailUrl(book)" class="no-underline hover:no-underline hover:text-[#62ab00]" x-text="book.title"></a>
                                    </div>
                                    <p class="mt-1 line-clamp-1 text-xs font-semibold text-slate-600" x-text="book.author || (isGiftCategory ? 'Бэлэг дурсгал' : '')"></p>

                                    <div class="mt-3 flex flex-wrap items-center gap-2">
                                        <span class="text-base font-extrabold text-slate-900" x-text="book.price"></span>
                                        <template x-if="book.oldPrice">
                                            <span class="text-xs font-semibold text-slate-500 line-through" x-text="book.oldPrice"></span>
                                        </template>
                                    </div>

                                    <div class="mt-4 flex items-center gap-2">
                                        <template x-if="!book.soldOut">
                                            <button
                                                class="inline-flex flex-1 items-center justify-center rounded-xl bg-[#62ab00] px-3 py-2 text-sm font-semibold text-white hover:bg-[#569600]"
                                                type="button"
                                                @click.prevent="addToCart(book)"
                                            >
                                                Сагсанд хийх
                                            </button>
                                        </template>

                                        <a
                                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50"
                                            :href="detailUrl(book)"
                                        >
                                            Дэлгэрэнгүй
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </template>
                    </div>

                    <div class="mt-8 flex items-center justify-center gap-2" x-show="pageCount > 1">
                        <button
                            type="button"
                            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-50"
                            :disabled="page <= 1"
                            @click="setPage(page - 1)"
                        >
                            Өмнөх
                        </button>

                        <div class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">
                            <span x-text="page"></span> / <span x-text="pageCount"></span>
                        </div>

                        <button
                            type="button"
                            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-50"
                            :disabled="page >= pageCount"
                            @click="setPage(page + 1)"
                        >
                            Дараах
                        </button>
                    </div>
                </div>
            </section>

            <aside class="lg:col-span-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-900 text-white">☰</span>
                        <h3 class="text-sm font-semibold text-slate-900">Номын ангилал</h3>
                    </div>

                    <nav class="mt-4">
                        <ul class="space-y-1 text-sm">
                            @foreach ($legaldataCategories as $c)
                                <li>
                                    <a
                                        href="{{ url('/book/cat/' . $c['id']) }}"
                                        class="block rounded-xl px-3 py-2 hover:bg-slate-50 {{ (int)$catId === (int)$c['id'] ? 'bg-slate-100 font-semibold text-slate-900' : 'text-slate-700' }}"
                                    >
                                        {{ $c['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>

                <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h3 class="text-sm font-semibold text-slate-900">Хайлт</h3>
                    <p class="mt-1 text-xs text-slate-500">Дээрх хайлтын хэсэгтэй синк болно.</p>
                    <input
                        type="search"
                        class="mt-3 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none"
                        placeholder="Нэр / зохиолч"
                        x-model="$store.shop.query"
                        @input="setPage(1)"
                    />
                </div>
            </aside>
        </div>
    </main>

    @include('partials.footer')
</div>
@endsection
