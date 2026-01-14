@extends('layouts.app')

@section('title', 'Legaldata-Номын худалдаа')

@section('content')
<div x-data="bookPage" class="min-h-screen" x-cloak>
    @include('partials.header')

    <main>
        <section class="mx-auto max-w-7xl px-4 py-8" x-show="!loading && isSearching" x-transition>
            <div class="flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-slate-900">Хайлтын үр дүн</h2>
                    <p class="mt-1 text-sm text-slate-600">
                        Нийт: <span class="font-semibold" x-text="filtered.length"></span>
                    </p>
                </div>
                <a href="{{ url('/book') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900" @click.prevent="$store.shop.query=''; $store.shop.category='all'; $store.shop.goToBooks()">
                    Цэвэрлэх
                </a>
            </div>

            <div class="mt-5" x-show="filtered.length === 0">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-600 shadow-sm">
                    Илэрц олдсонгүй.
                </div>
            </div>

            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" x-show="filtered.length" x-transition>
                <template x-for="book in filtered" :key="book.url">
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition-shadow">
                        <a :href="detailUrl(book)" class="block">
                            <img :src="$store.shop.proxyImage(book.image)" :alt="book.title" class="aspect-3/4 w-full object-cover" loading="lazy">
                        </a>
                        <div class="p-4">
                            <p class="text-xs text-slate-500" x-text="book.author"></p>
                            <a :href="detailUrl(book)" class="mt-1 block text-sm font-semibold text-slate-900 no-underline hover:no-underline hover:text-[#62ab00] line-clamp-2" x-text="book.title"></a>
                            <div class="mt-3 flex items-center justify-between gap-3">
                                <div class="text-sm font-semibold text-[#62ab00]" x-text="book.price"></div>
                                <template x-if="book.soldOut">
                                    <span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-700">Дууссан</span>
                                </template>
                            </div>
                        </div>
                    </article>
                </template>
            </div>
        </section>

        <section class="bg-linear-to-b from-slate-100 to-slate-50 border-b border-slate-200">
            <div class="mx-auto max-w-7xl px-4 py-12">
                <template x-if="featured">
                    <div class="grid items-center gap-8 md:grid-cols-2">
                        <div class="order-2 md:order-1">
                            <p class="text-sm font-semibold tracking-wide text-slate-500">Онцлох ном</p>
                            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl" x-text="featured.title"></h1>
                            <p class="mt-3 text-base text-slate-600" x-text="featured.author"></p>

                            <div class="mt-5 flex flex-wrap items-center gap-3">
                                <a
                                    class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                                    :href="detailUrl(featured)"
                                >
                                    Дэлгэрэнгүй
                                </a>

                                <a
                                    class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50"
                                    :href="detailUrl(featured)"
                                >
                                    Дэлгэрэнгүй
                                </a>

                                <span class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900" x-text="'Үнэ: ' + (featured.price || '0₮')"></span>
                            </div>
                        </div>

                        <div class="order-1 md:order-2">
                            <div class="mx-auto max-w-sm overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                <img :src="$store.shop.proxyImage(featured.image)" :alt="featured.title" class="aspect-3/4 w-full object-cover" loading="lazy">
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

        <section class="mx-auto max-w-7xl px-4 py-12">
            <div class="text-center">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Шинээр нэмэгдсэн</h2>
            </div>

            <div class="mt-6" x-show="!loading && !isSearching && newBookPages.length" x-transition>
                <div class="overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm">
                    <div class="grid gap-0 grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
                        <template x-for="(book, idx) in currentNewBooks" :key="book.url">
                            <article class="flex flex-col gap-4 p-5" :class="(idx >= 2 ? 'border-t border-slate-200' : '') + (idx % 2 === 1 ? ' sm:border-l sm:border-slate-200' : '')">
                                <a :href="detailUrl(book)" class="w-full shrink-0 overflow-hidden rounded-md border border-slate-200 bg-white">
                                    <img :src="$store.shop.proxyImage(book.image)" :alt="book.title" class="aspect-3/4 w-full object-cover" loading="lazy">
                                </a>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500" x-text="book.author"></p>
                                    <a :href="detailUrl(book)" class="mt-1 block text-sm font-semibold text-slate-900 no-underline hover:no-underline hover:text-[#62ab00] line-clamp-3" x-text="book.title"></a>
                                    <div class="mt-3 text-sm font-semibold text-[#62ab00]" x-text="book.price"></div>
                                    <div class="mt-3 flex items-center gap-3 text-sm text-slate-600">
                                        <template x-if="book.soldOut">
                                            <span class="text-rose-600">Дууссан !</span>
                                        </template>
                                        <template x-if="!book.soldOut">
                                            <button class="inline-flex items-center gap-2 text-slate-700 hover:text-slate-900" @click.prevent="addToCart(book)">
                                                <span aria-hidden>🛒</span>
                                                <span>Сагсанд хийх</span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </article>
                        </template>
                    </div>
                </div>

                <div class="mt-6 flex justify-center gap-2">
                    <template x-for="(page, idx) in newBookPages" :key="idx">
                        <button
                            type="button"
                            class="h-2.5 w-2.5 rounded-full"
                            :class="idx === newPage ? 'bg-[#62ab00]' : 'bg-slate-300'"
                            @click="newPage = idx"
                            :aria-label="'page ' + (idx + 1)"
                        ></button>
                    </template>
                </div>
            </div>
        </section>

        <section class="bg-cover bg-center" style="background-image: url('{{ asset('image/bg-images/best-seller-bg.jpg') }}')">
            <div class="mx-auto max-w-7xl px-4 py-10">
                <div class="mx-auto max-w-5xl">
                    <div class="rounded-md bg-white/95 shadow-sm">
                        <div class="px-6 pt-10 text-center">
                            <h2 class="text-2xl font-bold tracking-tight text-slate-900">Best seller</h2>
                        </div>

                        <div class="px-6 pb-8 pt-8" x-show="!loading && !isSearching && bestSellerPages.length" x-transition>
                            <div class="grid gap-0 sm:grid-cols-2">
                                <template x-for="(book, idx) in currentBestSellerBooks" :key="book.url">
                                    <article class="flex gap-4 p-5" :class="(idx >= 4 ? 'border-t border-slate-200' : '') + (idx % 2 === 1 ? ' sm:border-l sm:border-slate-200' : '')">
                                        <a :href="detailUrl(book)" class="w-28 shrink-0 overflow-hidden rounded-md border border-slate-200 bg-white">
                                            <img :src="$store.shop.proxyImage(book.image)" :alt="book.title" class="aspect-3/4 w-full object-cover" loading="lazy">
                                        </a>
                                        <div class="min-w-0">
                                            <p class="text-xs text-slate-500" x-text="book.author"></p>
                                            <a :href="detailUrl(book)" class="mt-1 block text-sm font-semibold text-slate-900 no-underline hover:no-underline hover:text-[#62ab00] line-clamp-3" x-text="book.title"></a>
                                            <div class="mt-3 text-sm font-semibold text-[#62ab00]" x-text="book.price"></div>
                                            <div class="mt-3 flex items-center gap-3 text-sm text-slate-600">
                                                <template x-if="book.soldOut">
                                                    <span class="text-rose-600">Дууссан !</span>
                                                </template>
                                                <template x-if="!book.soldOut">
                                                    <button class="inline-flex items-center gap-2 text-slate-700 hover:text-slate-900" @click.prevent="addToCart(book)">
                                                        <span aria-hidden>🛒</span>
                                                        <span>Сагсанд хийх</span>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </article>
                                </template>
                            </div>

                            <div class="mt-8 flex justify-center gap-2">
                                <template x-for="(page, idx) in bestSellerPages" :key="idx">
                                    <button
                                        type="button"
                                        class="h-2.5 w-2.5 rounded-full"
                                        :class="idx === bestSellerPage ? 'bg-[#62ab00]' : 'bg-slate-300'"
                                        @click="bestSellerPage = idx"
                                        :aria-label="'page ' + (idx + 1)"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-12">
            <div class="flex items-center justify-center gap-4">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Хууль, эрх зүй</h2>
            </div>
            <div class="mt-8" x-show="!loading && !isSearching && lawBookPages.length" x-transition>
                <div class="overflow-hidden rounded-md bg-white shadow-sm">
                    <div class="grid gap-0 md:grid-cols-2">
                            <template x-for="(book, idx) in currentLawBooks" :key="book.url">
                                <article class="flex gap-4 p-6" :class="idx === 1 ? 'md:border-l md:border-slate-200' : ''">
                                <a :href="detailUrl(book)" class="w-28 shrink-0 overflow-hidden rounded-md border border-slate-200 bg-white">
                                    <img :src="$store.shop.proxyImage(book.image)" :alt="book.title" class="aspect-3/4 w-full object-cover" loading="lazy">
                                </a>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500" x-text="book.author"></p>
                                    <a :href="detailUrl(book)" class="mt-1 block text-sm font-semibold text-slate-900 no-underline hover:no-underline hover:text-[#62ab00] line-clamp-3" x-text="book.title"></a>
                                    <div class="mt-3 text-sm font-semibold text-[#62ab00]" x-text="book.price"></div>
                                    <div class="mt-3 flex items-center gap-3 text-sm text-slate-600">
                                        <template x-if="book.soldOut">
                                            <span class="text-rose-600">Дууссан !</span>
                                        </template>
                                        <template x-if="!book.soldOut">
                                            <button class="inline-flex items-center gap-2 text-slate-700 hover:text-slate-900" @click.prevent="addToCart(book)">
                                                <span aria-hidden>🛒</span>
                                                <span>Сагсанд хийх</span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </article>
                        </template>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap justify-center gap-2">
                    <template x-for="(page, idx) in lawBookPages" :key="idx">
                        <button
                            type="button"
                            class="h-2.5 w-2.5 rounded-full"
                            :class="idx === lawPage ? 'bg-[#62ab00]' : 'bg-slate-300'"
                            @click="lawPage = idx"
                            :aria-label="'page ' + (idx + 1)"
                        ></button>
                    </template>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
</div>
@endsection
