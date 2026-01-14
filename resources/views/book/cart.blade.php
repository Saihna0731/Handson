@extends('layouts.app')

@section('title', 'Сагс')

@section('content')
<div x-data="cartPage" class="min-h-screen" x-cloak>
    @include('partials.header')

    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-4">
            <nav class="text-sm text-slate-600" aria-label="breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a class="hover:text-slate-900" href="{{ url('/book') }}">Нүүр хуудас</a></li>
                    <li class="text-slate-400">/</li>
                    <li class="font-semibold text-slate-900">Сагс</li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="mx-auto max-w-7xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-12">
            <section class="lg:col-span-8">
                <h1 class="text-xl font-bold text-slate-900 sm:text-2xl">Таны сагс</h1>

                <template x-if="items.length === 0">
                    <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm font-semibold text-amber-900">
                        Таны сагс хоосон байна !
                    </div>
                </template>

                <template x-if="items.length">
                    <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="divide-y divide-slate-200">
                            <template x-for="item in items" :key="item.key">
                                <div class="flex flex-col gap-4 p-4 sm:flex-row sm:items-center">
                                    <img :src="$store.shop.proxyImage(item.image)" :alt="item.title" class="h-24 w-20 rounded-lg border border-slate-200 object-cover" loading="lazy">

                                    <div class="min-w-0 flex-1">
                                        <div class="truncate text-sm font-bold text-slate-900" x-text="item.title"></div>
                                        <div class="mt-1 text-sm font-semibold text-[#62ab00]" x-text="item.price"></div>
                                        <div class="mt-1 text-xs text-slate-500" x-text="formatMoney(lineTotal(item))"></div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <label class="text-sm font-semibold text-slate-600">Тоо</label>
                                        <input
                                            type="number"
                                            min="1"
                                            step="1"
                                            inputmode="numeric"
                                            class="w-24 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                                            :value="item.qty"
                                            @input="setQty(item.key, $event.target.value)"
                                        />
                                        <button
                                            type="button"
                                            class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                            @click.prevent="remove(item.key)"
                                        >
                                            Устгах
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </section>

            <aside class="lg:col-span-4">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="text-lg font-bold text-slate-900">Таны захиалга</h2>
                    </div>

                    <div class="p-5">
                        <div class="flex items-center justify-between text-sm font-semibold text-slate-600">
                            <span>Номын нэр</span>
                            <span>Үнэ</span>
                        </div>

                        <ul class="mt-3 space-y-2">
                            <template x-for="item in items" :key="item.key">
                                <li class="flex items-start justify-between gap-4 text-sm">
                                    <span class="min-w-0 flex-1 truncate text-slate-700" x-text="item.title"></span>
                                    <span class="shrink-0 font-semibold text-slate-900" x-text="formatMoney(itemTotal(item))"></span>
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

                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <button
                                    type="button"
                                    class="w-full mt-6 inline-flex items-center justify-center gap-2 rounded-xl border-2 border-[#62ab00] bg-white px-4 py-2.5 text-sm font-extrabold text-[#62ab00] hover:bg-[#62ab00] hover:text-white transition-colors"
                                    @click="showGiftModal = true"
                                >
                                    <!-- <span class ="text-lg">(Бэлгийн багцийн icon оруулах хэсэг)</span> -->
                                    Бэлгийн багц авах
                                </button>
                            </div>

                            <div class="mt-4">
                                <a
                                    href="{{ url('/book/checkout') }}"
                                    class="inline-flex w-full items-center justify-center rounded-xl bg-[#62ab00] px-4 py-3 text-sm font-extrabold text-white hover:bg-[#569600]"
                                    :class="items.length ? '' : 'pointer-events-none opacity-50'"
                                >
                                    Хүргүүлэх хаяг оруулах
                                </a>
                            </div>

                            <button
                                type="button"
                                class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-800 hover:bg-slate-50"
                                x-show="items.length"
                                @click.prevent="clearCart()"
                            >
                                Сагс цэвэрлэх
                            </button>
                        </div>

                        <!-- <div class="mt-5 h-1 rounded bg-[#62ab00]"></div> -->
                    </div>
                </div>
            </aside>
        </div>
    </main>

    @include('partials.gift-modal')

    @include('partials.footer')
</div>
@endsection
