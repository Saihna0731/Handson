@php
    $legaldataCategories = config('legaldata.categories', []);
    $promoImage = config('legaldata.promo_image');

    $col1 = array_slice($legaldataCategories, 0, 5);
    $col2 = array_slice($legaldataCategories, 5, 5);
    $col3 = array_slice($legaldataCategories, 10);
@endphp

<header class="sticky top-0 z-30 border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex items-center gap-4 py-3">
            <a href="{{ url('/book') }}" class="flex items-center gap-3">
                <img src="https://legaldata.mn/nom/assets/image/LDLogo2.png" alt="Legaldata" class="h-12 w-auto" loading="lazy">
            </a>

            <nav class="ml-auto hidden items-center gap-2 lg:flex" x-data="{ openCats: false }">
                <a href="https://legaldata.mn/book" target="_blank" rel="noopener" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                    Номын худалдаа нүүр
                </a>

                <div class="relative" @mouseenter="openCats = true" @mouseleave="openCats = false">
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                        Номын ангилал
                        <span class="text-slate-400">▾</span>
                    </button>

                    <div
                        x-show="openCats"
                        x-transition
                        class="absolute left-0 top-full mt-2 w-[min(56rem,90vw)] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg"
                    >
                        <div class="grid gap-6 p-5 sm:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Ангилал</div>
                                <ul class="mt-3 space-y-1 text-sm">
                                    @foreach ($col1 as $c)
                                        <li><a class="block rounded-lg px-2 py-1.5 text-slate-700 hover:bg-slate-50" href="{{ url('/book/cat/' . $c['id']) }}">{{ $c['label'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Ангилал</div>
                                <ul class="mt-3 space-y-1 text-sm">
                                    @foreach ($col2 as $c)
                                        <li><a class="block rounded-lg px-2 py-1.5 text-slate-700 hover:bg-slate-50" href="{{ url('/book/cat/' . $c['id']) }}">{{ $c['label'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Ангилал</div>
                                <ul class="mt-3 space-y-1 text-sm">
                                    @foreach ($col3 as $c)
                                        <li><a class="block rounded-lg px-2 py-1.5 text-slate-700 hover:bg-slate-50" href="{{ url('/book/cat/' . $c['id']) }}">{{ $c['label'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div>
                                <a href="#" @click.prevent class="block overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                    @if ($promoImage)
                                        <img src="{{ $promoImage }}" alt="promo" class="h-40 w-full object-cover" loading="lazy">
                                    @else
                                        <div class="flex h-40 items-center justify-center text-sm text-slate-500">Promo</div>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="https://legaldata.mn" target="_blank" rel="noopener" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                    Бүтээлийн сан
                </a>
            </nav>

            <div class="ml-auto lg:hidden" x-data="{ open: false }">
                <button type="button" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm" @click="open = !open">
                    Цэс
                </button>
                <div x-show="open" x-transition class="absolute left-0 right-0 top-full border-b border-slate-200 bg-white">
                    <div class="mx-auto max-w-7xl px-4 py-3">
                        <nav class="grid gap-1 text-sm">
                            <a class="rounded-lg px-3 py-2 hover:bg-slate-50" href="{{ url('/book') }}">Номын худалдаа нүүр</a>
                            <a class="rounded-lg px-3 py-2 hover:bg-slate-50" href="https://legaldata.mn" target="_blank" rel="noopener">Хууль зүйн судалгааны бүтээлийн сан</a>
                            <div class="mt-2 rounded-xl border border-slate-200 p-2">
                                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Номын ангилал</div>
                                <div class="mt-2 grid gap-1">
                                    @foreach ($legaldataCategories as $c)
                                        <a class="rounded-lg px-3 py-2 hover:bg-slate-50" href="{{ url('/book/cat/' . $c['id']) }}">{{ $c['label'] }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-3 border-t border-slate-200 py-3 lg:flex-row lg:items-center lg:justify-between">
            <form class="w-full lg:max-w-2xl" @submit.prevent="$store.shop.goToBooks()">
                <div class="flex overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <input
                        type="search"
                        x-model="$store.shop.query"
                        class="w-full px-4 py-2.5 text-sm outline-none"
                        placeholder="Номын нэрэнд орсон үг эсвэл зохиолчийн нэр..."
                        aria-label="Search"
                    />
                    <button type="button" class="px-4 py-2.5 text-sm font-medium text-white bg-slate-900 hover:bg-slate-800" @click.prevent="$store.shop.goToBooks()">
                        Хайх
                    </button>
                </div>
            </form>

            <div class="flex items-center justify-between gap-3">
                <a href="https://legaldata.mn/book/login" target="_blank" rel="noopener" class="text-sm font-medium text-slate-700 hover:text-slate-900">
                    Нэвтрэх
                </a>
                <a href="#" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm hover:bg-slate-50" @click.prevent>
                    <span class="font-medium">Сагсанд</span>
                    <span class="rounded-full bg-emerald-600 px-2 py-0.5 text-xs font-semibold text-white" x-text="$store.shop.cartCount"></span>
                </a>
            </div>
        </div>
    </div>
</header>
