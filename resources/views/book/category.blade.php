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
                    <h1 class="text-lg font-bold tracking-tight text-slate-900">
                        <span class="text-slate-500">Ангилал:</span>
                        <span class="ml-2" x-text="categoryLabel">{{ $categoryLabel }}</span>
                    </h1>
                    <p class="text-sm text-slate-500" x-text="loading ? 'Ачаалж байна…' : (filtered.length + ' ном')"></p>
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

                <div class="mt-5" x-show="!loading && filtered.length === 0" x-transition>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-600 shadow-sm">
                        Илэрц олдсонгүй.
                    </div>
                </div>

                <div class="mt-5 space-y-5" x-show="!loading && filtered.length" x-transition>
                    <template x-for="book in filtered" :key="book.url">
                        <article class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-12">
                            <a :href="detailUrl(book)" class="sm:col-span-4">
                                <img :src="book.image" :alt="book.title" class="w-full rounded-xl border border-slate-200 aspect-[3/4] object-cover" loading="lazy">
                            </a>

                            <div class="sm:col-span-8">
                                <div class="border-b border-slate-200 pb-3">
                                    <h2 class="text-base font-semibold text-slate-900">
                                        <a :href="detailUrl(book)" class="hover:underline" x-text="book.title"></a>
                                    </h2>
                                    <p class="mt-1 text-sm font-medium text-slate-600" x-text="book.author"></p>
                                </div>

                                <div class="mt-3 flex flex-wrap items-center gap-3">
                                    <span class="text-lg font-bold text-slate-900" x-text="book.price"></span>
                                    <template x-if="book.oldPrice">
                                        <span class="text-sm font-semibold text-slate-500 line-through" x-text="book.oldPrice"></span>
                                    </template>
                                    <template x-if="book.discount">
                                        <span class="rounded-md bg-rose-600 px-2 py-1 text-xs font-semibold text-white" x-text="book.discount"></span>
                                    </template>
                                </div>

                                <div class="mt-4 flex flex-wrap items-center gap-3">
                                    <template x-if="book.soldOut">
                                        <span class="text-sm font-semibold text-rose-700">Дууссан !</span>
                                    </template>
                                    <template x-if="!book.soldOut">
                                        <button class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50" @click.prevent="addToCart(book)">
                                            Сагсанд хийх
                                        </button>
                                    </template>

                                    <a class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" :href="book.url" target="_blank" rel="noopener">
                                        Албан линк
                                    </a>
                                </div>
                            </div>
                        </article>
                    </template>
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
            </aside>
        </div>
    </main>

    @include('partials.footer')
    @include('partials.toast')
</div>
@endsection
