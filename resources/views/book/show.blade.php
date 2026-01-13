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
                            <img :src="book.image" :alt="book.title" class="w-full aspect-[3/4] object-cover" loading="lazy">
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

                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900" x-text="book.price"></span>

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
                                    <select
                                        x-model.number="qty"
                                        class="mt-2 w-40 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                                    >
                                        <template x-for="n in qtyOptions" :key="n">
                                            <option :value="n" x-text="n"></option>
                                        </template>
                                    </select>
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
                                        :href="book.url"
                                        target="_blank"
                                        rel="noopener"
                                    >
                                        Худалдаж авах
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

                        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" x-show="book.year || book.pages || book.isbn || book.sizeMm || book.language" x-transition>
                            <div class="border-b border-slate-200 px-4 py-3">
                                <h2 class="text-sm font-semibold text-slate-900">Нэмэлт мэдээлэл</h2>
                            </div>
                            <dl class="divide-y divide-slate-200 text-sm">
                                <div class="grid grid-cols-3 gap-3 px-4 py-3" x-show="book.year">
                                    <dt class="col-span-1 font-semibold text-slate-600">Хэвлэгдсэн он</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.year"></dd>
                                </div>
                                <div class="grid grid-cols-3 gap-3 px-4 py-3" x-show="book.pages">
                                    <dt class="col-span-1 font-semibold text-slate-600">Хуудасны тоо</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.pages"></dd>
                                </div>
                                <div class="grid grid-cols-3 gap-3 px-4 py-3" x-show="book.isbn">
                                    <dt class="col-span-1 font-semibold text-slate-600">ISBN</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.isbn"></dd>
                                </div>
                                <div class="grid grid-cols-3 gap-3 px-4 py-3" x-show="book.language">
                                    <dt class="col-span-1 font-semibold text-slate-600">Хэл</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.language"></dd>
                                </div>
                                <div class="grid grid-cols-3 gap-3 px-4 py-3" x-show="book.sizeMm">
                                    <dt class="col-span-1 font-semibold text-slate-600">Хэмжээ (мм)</dt>
                                    <dd class="col-span-2 font-semibold text-slate-900" x-text="book.sizeMm"></dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-8">
                            <div class="flex flex-wrap gap-2 border-b border-slate-200">
                                <button
                                    class="px-3 py-2 text-sm font-semibold"
                                    :class="activeTab === 'about' ? 'border-b-2 border-slate-900 text-slate-900' : 'text-slate-600 hover:text-slate-900'"
                                    @click="activeTab = 'about'"
                                    type="button"
                                >
                                    Номын танилцуулга
                                </button>
                                <button
                                    class="px-3 py-2 text-sm font-semibold"
                                    :class="activeTab === 'shipping' ? 'border-b-2 border-slate-900 text-slate-900' : 'text-slate-600 hover:text-slate-900'"
                                    @click="activeTab = 'shipping'"
                                    type="button"
                                >
                                    Хүргэлт / Тайлбар
                                </button>
                            </div>

                            <div class="pt-4">
                                <div x-show="activeTab === 'about'" x-transition>
                                    <p class="text-sm leading-6 text-slate-700">
                                        Энэ хувилбар дээр өгөгдөл нь JSON-оос ирж байгаа тул дэлгэрэнгүй тайлбар,
                                        хэвлэгдсэн он, ISBN зэрэг мэдээлэл одоогоор байхгүй. Дараагийн алхамд
                                        өгөгдлөө DB рүү оруулаад бүрэн мэдээлэлтэй болгоё.
                                    </p>
                                </div>
                                <div x-show="activeTab === 'shipping'" x-transition>
                                    <p class="text-sm leading-6 text-slate-700">
                                        Demo: Хүргэлт/нөхцөлийн хэсгийг дараа нь backend-тай холбож бичнэ.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="mt-12">
                    <div class="flex items-end justify-between gap-4">
                        <h2 class="text-lg font-bold tracking-tight text-slate-900">Төсөөтэй номууд</h2>
                        <a href="{{ url('/book') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Бүгд</a>
                    </div>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" x-show="relatedBooks.length" x-transition>
                        <template x-for="b in relatedBooks" :key="b.url">
                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition-shadow">
                                <a :href="detailUrl(b)" class="block">
                                    <img :src="b.image" :alt="b.title" class="aspect-[3/4] w-full object-cover" loading="lazy">
                                </a>
                                <div class="p-4">
                                    <p class="text-xs font-semibold text-slate-500" x-text="b.author"></p>
                                    <a :href="detailUrl(b)" class="mt-1 line-clamp-2 text-sm font-semibold text-slate-900 hover:underline" x-text="b.title"></a>
                                    <div class="mt-3 flex items-center justify-between gap-2">
                                        <div class="text-sm font-bold text-slate-900" x-text="b.price"></div>
                                        <template x-if="b.soldOut">
                                            <span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-700">Дууссан</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </section>
            </div>
        </template>
    </main>

    @include('partials.footer')
    @include('partials.toast')
</div>
@endsection
