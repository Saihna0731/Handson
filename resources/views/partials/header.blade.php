@php
    $categories = config('legaldata.categories', []);
    $cols = 3;
    $perCol = (int) ceil(max(count($categories), 1) / $cols);
    $categoryColumns = array_chunk($categories, $perCol);
@endphp

<header x-data class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex items-center justify-between gap-4 py-3">
            <a href="{{ url('/book') }}" class="flex items-center gap-3">
                <img
                    src="https://legaldata.mn/nom/assets/image/LDLogo2.png"
                    alt="Pustok"
                    class="h-14 w-28 object-contain sm:h-16 sm:w-32"
                >
            </a>

            <nav class="hidden items-center justify-center gap-8 lg:flex">
                <a class="text-[18px] font-semibold text-slate-700 hover:text-slate-900" href="{{ url('/book') }}">Номын худалдаа нүүр</a>

                <div class="group relative">
                    <a class="text-[18px] inline-flex items-center gap-2 font-semibold text-slate-700 hover:text-slate-900" href="{{ url('/book') }}">
                        Номын ангилал
                        <svg class="h-4 w-4 text-slate-500 transition-transform group-hover:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </a>

                    <div class="invisible absolute left-1/2 top-full z-50 mt-3 w-[40vw] max-w-6xl -translate-x-1/2 translate-y-1 rounded-2xl border border-slate-200 bg-white p-6 opacity-0 shadow-lg transition-all duration-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                        <div class="max-h-[70vh] overflow-y-auto">
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($categoryColumns as $colIndex => $col)
                                <ul class="space-y-2 {{ $colIndex ? 'border-l border-slate-200 pl-6' : '' }}">
                                    @foreach ($col as $item)
                                        <li>
                                            <a class="text-[16px] text-slate-700 hover:text-[#62ab00]" href="{{ url('/book/cat/' . $item['id']) }}">{{ $item['label'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <a class="text-[18px] font-semibold text-slate-700 hover:text-slate-900" href="{{ url('/book') }}">Бүтээлийн сан</a>
            </nav>

            <details class="relative lg:hidden">
<!-- 
                @if (Route::has('login')) -->
                    <!-- @auth -->
                        <!-- <a class="mt-2 block rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="{{ url('/dashboard') }}">Dashboard</a>
                    @else -->
                    <summary class="w-16 align-center text-center list-none cursor-pointer rounded-xl border border-slate-200 bg-white px-3 py-2 text-[18px] font-semibold">
                        <a class="mt-2 flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="{{ Route::has('login') ? route('login') : url('/login') }}">
                            <svg class="h-5 w-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <path d="M10 17l5-5-5-5" />
                                <path d="M15 12H3" />
                            </svg>
                            <span>Нэвтрэх</span>
                        </a>
                    </summary>
                    <!-- @endauth -->
                <!-- @endif -->

                <summary class="w-16 align-center text-center list-none cursor-pointer rounded-xl border border-slate-200 bg-white px-3 py-2 text-[18px] font-semibold">Цэс</summary>
                <div class="absolute right-0 top-full mt-2 w-72 z-50 rounded-2xl border border-slate-200 bg-white p-3 shadow-lg">
                    <a class="block rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="{{ url('/book') }}">Номын худалдаа нүүр</a>
                    <a class="block rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="{{ url('/book') }}">Бүтээлийн сан</a>

                    <div class="mt-2 border-t border-slate-200 pt-2">
                        @foreach ($categories as $item)
                            <a class="block rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50" href="{{ url('/book/cat/' . $item['id']) }}">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            </details>
        </div>

        <div class="pb-3">
            <div class="grid grid-cols-12 items-center gap-3">
                <form class="col-span-12 flex overflow-hidden rounded-xl border border-slate-200 bg-white lg:col-span-8" @submit.prevent="$store.shop.goToBooks()">
                    <div class="relative flex-1">
                        <input
                            type="search"
                            x-model="$store.shop.query"
                            class="w-full px-4 py-2.5 pr-10 text-sm outline-none"
                            placeholder="Номын нэр / зохиолч"
                        />
                        <button
                            type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md px-2 py-1 text-slate-500 hover:bg-slate-50"
                            x-show="$store.shop.query"
                            @click.prevent="$store.shop.query = ''; $store.shop.goToBooks()"
                            aria-label="clear"
                        >
                            ✕
                        </button>
                    </div>
                    <button type="submit" class="bg-[#62ab00] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#569600]">
                        Хайх
                    </button>
                </form>

                <div class="col-span-12 flex items-center justify-end gap-2 lg:col-span-4 lg:gap-3">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50"
                        >
                            <svg class="h-5 w-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <span class="hidden sm:inline">Dashboard</span>
                        </a>
                    @else
                        <a
                            href="{{ Route::has('login') ? route('login') : url('/login') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50"
                        >
                            <svg class="h-5 w-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <path d="M10 17l5-5-5-5" />
                                <path d="M15 12H3" />
                            </svg>
                            <span>Нэвтрэх</span>
                        </a>
                    @endauth

                    <div class="group relative">
                        <a
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50"
                            href="{{ url('/book/cart') }}"
                        >
                            <svg class="h-5 w-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M6 6h15l-1.5 9h-13z" />
                                <path d="M6 6 5 3H2" />
                                <path d="M9 22a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" />
                                <path d="M18 22a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" />
                            </svg>
                            <span class="hidden sm:inline">Сагсанд</span>
                            <span class="font-bold text-[#62ab00]" x-text="$store.shop.cartTotalFormatted"></span>
                            <span class="ml-1 inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-rose-600 px-2 text-xs font-bold text-white" x-text="$store.shop.cartCount"></span>
                        </a>

                        <div class="invisible absolute right-0 top-full z-50 mt-3 w-80 translate-y-1 rounded-2xl border border-slate-200 bg-white opacity-0 shadow-lg transition-all duration-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                            <template x-if="$store.shop.cartItems.length === 0">
                                <div class="p-5 text-sm text-slate-600">Сагс хоосон байна.</div>
                            </template>

                            <template x-if="$store.shop.cartItems.length">
                                <div class="p-4">
                                    <div class="space-y-4">
                                        <template x-for="item in $store.shop.cartItems" :key="item.key">
                                            <div class="flex gap-3">
                                                <img :src="$store.shop.proxyImage(item.image)" :alt="item.title" class="h-14 w-12 rounded-md border border-slate-200 object-cover" loading="lazy">
                                                <div class="min-w-0 flex-1">
                                                    <div class="truncate text-sm font-semibold text-slate-900" x-text="item.title"></div>
                                                    <div class="mt-1 text-xs text-slate-600" x-text="item.qty + ' × ' + item.price"></div>
                                                </div>
                                                <button
                                                    type="button"
                                                    class="rounded-lg px-2 py-1 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                                                    @click.prevent="$store.shop.removeFromCart(item.key)"
                                                    aria-label="remove"
                                                >
                                                    ✕
                                                </button>
                                            </div>
                                        </template>
                                    </div>

                                    <div class="mt-4 border-t border-slate-200 pt-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="font-semibold text-slate-600">Нийт:</span>
                                            <span class="font-bold text-slate-900" x-text="$store.shop.cartTotalFormatted"></span>
                                        </div>

                                        <a
                                            href="{{ url('/book/cart') }}"
                                            class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-[#62ab00] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#569600]"
                                        >
                                            Сагс руу очих
                                        </a>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
