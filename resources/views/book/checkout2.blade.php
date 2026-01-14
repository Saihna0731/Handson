@extends('layouts.app')

@section('title', 'Хүргэлтийн хаяг')

@section('content')
<div x-data="checkoutPage" class="min-h-screen" x-cloak>
    @include('partials.header')

    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-4">
            <nav class="text-sm text-slate-600" aria-label="breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a class="hover:text-slate-900" href="{{ url('/book') }}">Нүүр хуудас</a></li>
                    <li class="text-slate-400">/</li>
                    <li><a class="hover:text-slate-900" href="{{ url('/book/cart') }}">Сагс</a></li>
                    <li class="text-slate-400">/</li>
                    <li class="font-semibold text-slate-900">Хүргэлтийн хаяг</li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="mx-auto max-w-7xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-12">
            <section class="lg:col-span-8">

            <h1 class="text-xl font-bold text-slate-900 sm:text-2xl">Хүргэлтийн хаяг</h1>

                <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <form class="grid gap-4 sm:grid-cols-2" @submit.prevent>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Овог нэр</label>
                            <input class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" placeholder="Овог нэр" />
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Утас</label>
                            <input class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" placeholder="9xxxxxxx" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-slate-700">Хүргэлтийн хаяг</label>
                            <input class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" placeholder="Дүүрэг, хороо, байр/тоот" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-slate-700">Тэмдэглэл</label>
                            <textarea class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" rows="4" placeholder="Хүргэлтийн нэмэлт тайлбар..."></textarea>
                        </div>

                        <div class="sm:col-span-2 flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ url('/book/cart') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                                Буцах
                            </a>
                            <button type="button" class="inline-flex items-center justify-center rounded-xl bg-[#62ab00] px-4 py-2.5 text-sm font-extrabold text-white hover:bg-[#569600]" :class="items.length ? '' : 'pointer-events-none opacity-50'">
                                Захиалга батлах
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900" x-show="items.length === 0">
                    Сагс хоосон байна. Эхлээд ном нэмнэ үү.
                </div>
            </section>

            <aside class="lg:col-span-4">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="text-lg font-bold text-slate-900">Таны захиалга</h2>
                    </div>

                    <div class="p-5">
                        <ul class="space-y-3">
                            <template x-for="item in items" :key="item.key">
                                <li class="flex items-start justify-between gap-3 text-sm">
                                    <div class="min-w-0">
                                        <div class="truncate font-semibold text-slate-800" x-text="item.title"></div>
                                        <div class="mt-1 text-xs text-slate-500" x-text="item.qty + ' × ' + item.price"></div>
                                    </div>
                                    <div class="shrink-0 font-bold text-slate-900" x-text="formatMoney(lineTotal(item))"></div>
                                </li>
                            </template>
                        </ul>

                        <div class="mt-4 space-y-2 border-t border-slate-200 pt-4 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-slate-600">Үнийн дүн</span>
                                <span class="font-bold text-slate-900" x-text="formatMoney(subtotal)"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-slate-600">Хүргэлтийн үнэ</span>
                                <span class="font-bold text-slate-900" x-text="formatMoney(deliveryFee)"></span>
                            </div>
                        </div>

                        <div class="mt-4 border-t border-slate-200 pt-4">
                            <div class="flex items-baseline justify-between">
                                <span class="text-sm font-semibold text-slate-600">Нийт үнийн дүн</span>
                                <span class="text-lg font-extrabold text-slate-900" x-text="formatMoney(grandTotal)"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

    </main>

    @include('partials.footer')
    @include('partials.toast')
</div>
@endsection
