@extends('layouts.app')

@section('title', 'Ном')

@section('content')
<div x-data="bookDetailPage({ id: {{ $id }} })" class="min-h-screen" x-cloak>
    @include('partials.header')

    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-4">
            <nav class="text-sm text-slate-600">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a class="hover:text-slate-900" href="{{ url('/') }}">Нүүр</a></li>
                    <li class="text-slate-400">/</li>
                    <li><a class="hover:text-slate-900" href="{{ url('/book') }}">Номууд</a></li>
                    <li class="text-slate-400">/</li>
                    <li class="font-semibold text-slate-900" x-text="book?.title ?? 'Ном'">Ном</li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="mx-auto max-w-7xl px-4 py-10">
        <template x-if="loading">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-600 shadow-sm">
                Ачаалж байна...
            </div>
        </template>

        <template x-if="!loading && error">
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-6 text-sm text-rose-800">
                Алдаа: <span class="font-semibold" x-text="error"></span>
            </div>
        </template>

        <template x-if="!loading && book">
            <div>
                <div class="grid gap-8 lg:grid-cols-12">
                    <div class="lg:col-span-5">
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <img :src="$store.shop.proxyImage(book.image)" :alt="book.title" class="w-full aspect-3/4 object-cover" loading="lazy">
                        </div>

                        <div class="mt-8">
                            <div class="flex flex-wrap gap-2 border-b border-slate-200">
                                <button
                                    class="px-3 py-2 text-sm font-semibold"
                                    :class="activeTab === 'desc' ? 'border-b-2 border-slate-900 text-slate-900' : 'text-slate-600 hover:text-slate-900'"
                                    @click="activeTab = 'desc'"
                                    type="button"
                                >
                                    Номын тайлбар
                                </button>
                                <button
                                    class="px-3 py-2 text-sm font-semibold"
                                    :class="activeTab === 'note' ? 'border-b-2 border-slate-900 text-slate-900' : 'text-slate-600 hover:text-slate-900'"
                                    @click="activeTab = 'note'"
                                    type="button"
                                >
                                    Тайлбар
                                </button>
                            </div>

                            <div class="pt-4">
                                <div x-show="activeTab === 'desc'" x-transition>
                                    <p class="text-sm leading-6 text-slate-700" x-text="book?.desc || 'Танилцуулга байхгүй.'"></p>
                                </div>
                                <div x-show="activeTab === 'note'" x-transition>
                                    <p class="text-sm leading-6 text-slate-700" x-text="book?.note || 'Нэмэлт тайлбар байхгүй.'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-7">
                        <p class="text-sm font-semibold text-slate-500" x-text="book.author"></p>
                        <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl" x-text="book.title"></h1>

                        <div class="mt-3" x-show="book.category" x-transition>
                            <a
                                class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                                :href="categoryListUrl(book)"
                            >
                                <span class="text-slate-500">Ангилал:</span>
                                <span class="ml-2" x-text="book.category"></span>
                            </a>
                        </div>

                        <div class="mt-12 flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl" x-text="book.price"></span>
                            <template x-if="unitPriceMnt">
                                <span class="inline-flex items-baseline gap-2 rounded-xl bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-800">
                                    <span class="text-emerald-700">Нийт:</span>
                                    <span class="text-lg font-extrabold" x-text="totalPriceFormatted"></span>
                                </span>
                            </template>

                            <template x-if="book.oldPrice">
                                <span class="text-sm font-semibold text-slate-500 line-through" x-text="book.oldPrice"></span>
                            </template>

                            <template x-if="book.discount">
                                <span class="rounded-full bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-800" x-text="book.discount"></span>
                            </template>

                            <template x-if="book.soldOut">
                                <span class="rounded-full bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700">Дууссан</span>
                            </template>
                        </div>

                        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                                <div>
                                    <div class="text-sm font-semibold text-slate-700">Тоо ширхэг</div>
                                    <input
                                        x-model.number="qty"
                                        type="number"
                                        min="1"
                                        step="1"
                                        inputmode="numeric"
                                        class="mt-2 w-40 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                                    >
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <template x-if="!book.soldOut">
                                        <button
                                            class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-500"
                                            @click.prevent="addToCart(book, qty)"
                                        >
                                            Сагсанд нэмэх
                                        </button>
                                    </template>

                                    <a
                                        class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                                        href="{{ url('/book/cart') }}"
                                    >
                                        Сагс руу очих
                                    </a>

                                    <a
                                        href="{{ url('/book') }}"
                                        class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50"
                                    >
                                        Буцах
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-200 px-4 py-3">
                                <h2 class="text-sm font-semibold text-slate-900">Номын мэдээлэл</h2>
                            </div>
                            <dl class="divide-y divide-slate-200 text-sm">
                                <div class="grid grid-cols-3 gap-3 px-4 py-3">
                                    <dt class="col-span-1 font-semibold text-slate-600">Ангилал</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.category || '-'" ></dd>
                                </div>
                                <div class="grid grid-cols-3 gap-3 px-4 py-3">
                                    <dt class="col-span-1 font-semibold text-slate-600">Хэвлэгдсэн он</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.year || '-'" ></dd>
                                </div>
                                <div class="grid grid-cols-3 gap-3 px-4 py-3">
                                    <dt class="col-span-1 font-semibold text-slate-600">Хуудасны тоо</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.pages || '-'" ></dd>
                                </div>
                                <div class="grid grid-cols-3 gap-3 px-4 py-3">
                                    <dt class="col-span-1 font-semibold text-slate-600">ISBN дугаар</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.isbn || '-'" ></dd>
                                </div>
                                <div class="grid grid-cols-3 gap-3 px-4 py-3">
                                    <dt class="col-span-1 font-semibold text-slate-600">Хэл</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.language || '-'" ></dd>
                                </div>
                                <div class="grid grid-cols-3 gap-3 px-4 py-3">
                                    <dt class="col-span-1 font-semibold text-slate-600">Хэмжээ (мм)</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.sizeMm || '-'" ></dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <section class="mt-12">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold tracking-tight text-slate-900">Төсөөтэй номууд</h2>
                        <!-- <div class="mx-auto mt-2 h-1 w-48 rounded bg-[#62ab00]"></div> -->
                    </div>

                    <div class="mt-5" x-show="relatedBookPages.length" x-transition>
                        <div class="overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm">
                            <div class="grid gap-0 grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
                                <template x-for="(b, idx) in currentRelatedBooks" :key="b.url">
                                    <article
                                        class="flex flex-col gap-4 p-5"
                                        :class="(idx >= 2 ? 'border-t border-slate-200' : '') + (idx % 2 === 1 ? ' sm:border-l sm:border-slate-200' : '')"
                                    >
                                        <a :href="detailUrl(b)" class="w-full shrink-0 overflow-hidden rounded-md border border-slate-200 bg-white">
                                            <img :src="$store.shop.proxyImage(b.image)" :alt="b.title" class="aspect-3/4 w-full object-cover" loading="lazy">
                                        </a>
                                        <div class="min-w-0">
                                            <p class="text-xs text-slate-500" x-text="b.author"></p>
                                            <a :href="detailUrl(b)" class="mt-1 block text-sm font-semibold text-slate-900 no-underline hover:no-underline hover:text-[#62ab00] line-clamp-3" x-text="b.title"></a>
                                            <div class="mt-3 text-sm font-semibold text-[#62ab00]" x-text="b.price"></div>


                                            <div class="mt-3 flex items-center gap-3 text-sm text-slate-600">
                                                <template x-if="b.soldOut">
                                                    <span class="text-rose-600">Дууссан !</span>
                                                </template>
                                                <template x-if="!b.soldOut">
                                                    <button class="inline-flex items-center gap-2 text-slate-700 hover:text-slate-900" @click.prevent="addToCart(b, 1)">
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

                        <div class="mt-6 flex justify-center gap-2" x-show="relatedBookPages.length > 1">
                            <template x-for="(page, idx) in relatedBookPages" :key="idx">
                                <button
                                    type="button"
                                    class="h-2.5 w-2.5 rounded-full"
                                    :class="idx === relatedPage ? 'bg-[#62ab00]' : 'bg-slate-300'"
                                    @click="relatedPage = idx; startRelatedAutoRotate()"
                                    :aria-label="'page ' + (idx + 1)"
                                ></button>
                            </template>
                        </div>
                    </div>
                </section>
            </div>
        </template>
    </main>

    @include('partials.footer')
</div>
@endsection
