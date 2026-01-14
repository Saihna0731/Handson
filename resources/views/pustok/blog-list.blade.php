<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="">
    <title>Legaldata-Номын худалдаа</title>
    <meta name="description" content="">
    <meta name="author" content="Д.Соёл-Эрдэнэ">

    <meta property="og:url" content="https://legaldata.mn/book/cat/{{ (int)($catId ?? 1) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Legaldata-Номын худалдаа" />
    <meta property="og:image" content="https://legaldata.mn/images/LD_cover.png" />
    <meta property="og:description" content="" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@legaldata_mn" />
    <meta name="twitter:title" content="Legaldata-Номын худалдаа" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="https://legaldata.mn/images/LD_tw_summary.png" />

    <meta name="ld-user-id" content="0">

    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/plugins.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/main1.css') }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/favicon.ico') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        .ld-empty {
            padding: 24px 0;
            text-align: center;
            opacity: .8;
        }

        .product-details-info article {
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div class="site-wrapper" id="top">
        @include('pustok.partials.header')

        <section class="breadcrumb-section">
            <h2 class="sr-only">Site Breadcrumb</h2>
            <div class="container">
                <div class="breadcrumb-contents">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/book') }}">Нүүр хуудас</a></li>
                            <li class="breadcrumb-item active">Ангилалаар</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>

        <main class="inner-page-sec-padding-bottom">
            <div class="container">
                <div class="row">

                    <div class="col-12 col-md-9 col-lg-9">
                        <div class="ld-empty" style="display:none" id="ldCatLoading">Ачаалж байна...</div>
                        <div id="ldCatList"></div>
                        <div id="ldCatEmpty" class="ld-empty" style="display:none">Илэрц олдсонгүй.</div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-3">
                        <nav class="category-nav show">
                            <div>
                                <a href="javascript:void(0)" class="category-trigger"><i class="fa fa-bars"></i>Номын ангилал</a>
                                <ul class="category-menu" style="position:static">
                                    <li class="cat-item"><a href="{{ url('/book/cat/1') }}">Хууль, эрх зүй</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/15') }}">Хууль, эрх зүйн сэтгүүл</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/16') }}">Эрх зүйн акт, эмхэтгэл, орчуулга</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/20') }}">Өгүүлэл, илтгэлийн эмхэтгэл</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/12') }}">Эрх зүйн боловсрол</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/14') }}">Хуулийн ховор, хуучин ном</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/19') }}">Хуулийн тайлбар, толь</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/2') }}">Нийгэм, улс төр</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/3') }}">Эдийн засаг, бизнесс</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/4') }}">Шинжлэх ухаан, танин мэдэхүй</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/10') }}">Шашин, философи</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/6') }}">Өөртөө туслах, хувь хүний хөгжил</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/17') }}">Хүүхдийн ном</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/18') }}">Уран зохиол, яруу найраг</a></li>
                                    <li class="cat-item"><a href="{{ url('/book/cat/21') }}">Бэлэг дурсгал</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </main>

        @include('pustok.partials.footer')
    </div>

    <script src="{{ asset('data/legaldata-book.js') }}"></script>
    <script>
        (function () {
            var catId = Number({{ (int)($catId ?? 1) }});

            function escapeHtml(s) {
                return String(s || '').replace(/[&<>"']/g, function (c) {
                    return ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#39;'
                    })[c];
                });
            }

            function normalizeText(s) {
                return String(s || '').replace(/\s+/g, ' ').trim();
            }

            function formatPrice(p) {
                var s = normalizeText(p);
                if (!s) return '';
                return s.replace(/₮/g, ' ₮').replace(/\s+₮/g, ' ₮').trim();
            }

            function parseIdFromUrl(url) {
                var m = String(url || '').match(/\/view\/(\d+)/);
                return m ? Number(m[1]) : 0;
            }

            function rowHtml(book) {
                var price = formatPrice(book.price);
                var oldPrice = formatPrice(book.oldPrice);
                var discount = normalizeText(book.discount);

                var id = book.id || parseIdFromUrl(book.url);

                var btn;
                if (book.soldOut) {
                    btn = '<div class="mt-2 mb-2" style="color:red">Дууссан !</div>';
                } else {
                    btn = '<span><i class="fas fa-cart-plus"></i> '
                        + '<a href="#" class="mr-2 js-add" data-title="' + escapeHtml(book.title || '') + '" onclick="return false;">Сагсанд хийх</a>'
                        + '</span>';
                }

                return (
                    '<div class="row mb-5">'
                    + '<div class="col-lg-4 col-md-4 col-sm-6">'
                    + '<a href="' + escapeHtml('{{ url('/book') }}/' + id) + '">'
                    + '<img class="img-fluid" src="' + escapeHtml(book.image) + '" alt="">'
                    + '</a>'
                    + '</div>'
                    + '<div class="col-lg-8 col-md-8 col-sm-6 product-details-info">'
                    + '<div class="pb-3" style="border-bottom: 1px solid silver">'
                    + '<div class="product-list-content">'
                    + '<div class="product-card--body">'
                    + '<div class="product-header">'
                    + '<h5><a href="' + escapeHtml('{{ url('/book') }}/' + id) + '">' + escapeHtml(book.title || '') + '</a></h5>'
                    + '<a href="#" class="author" onclick="return false;">' + escapeHtml(book.author || '') + '</a>'
                    + '</div>'
                    + '<article><p></p></article>'
                    + '<div class="price-block">'
                    + '<span class="price">' + escapeHtml(price) + '</span>'
                    + (oldPrice ? ('<del class="price-old">' + escapeHtml(oldPrice) + '</del>') : '')
                    + (discount ? ('<span class="price-discount">' + escapeHtml(discount) + '</span>') : '')
                    + '</div>'
                    + '<div class="btn-block">' + btn + '</div>'
                    + '<div></div>'
                    + '</div></div></div></div></div>'
                    + '</div>'
                );
            }

            function applySearch(query, items) {
                query = normalizeText(query).toLowerCase();
                if (!query) return items;
                return items.filter(function (b) {
                    return (
                        String(b.title || '').toLowerCase().includes(query)
                        || String(b.author || '').toLowerCase().includes(query)
                    );
                });
            }

            function applyCategory(id, items) {
                // Data source doesn't contain categories. Keep the UI route-compatible and show all.
                // If you later extend `legaldata-book.js` with category info, filter here.
                return items;
            }

            function getQueryParam(name) {
                try {
                    var params = new URLSearchParams(window.location.search || '');
                    return params.get(name) || '';
                } catch (e) {
                    return '';
                }
            }

            function renderList(items) {
                var list = document.getElementById('ldCatList');
                var empty = document.getElementById('ldCatEmpty');
                var loading = document.getElementById('ldCatLoading');
                if (loading) loading.style.display = 'none';
                if (!list) return;
                list.innerHTML = items.map(rowHtml).join('');
                if (empty) empty.style.display = items.length ? 'none' : '';
            }

            window.__ldSearchSubmit__ = function (event) {
                if (event && event.preventDefault) event.preventDefault();
                var input = document.getElementById('ldSearch');
                var mobile = document.getElementById('ldSearchMobile');
                var q = (input && input.value) ? input.value : ((mobile && mobile.value) ? mobile.value : '');
                var items = Array.isArray(window.__LEGALDATA_BOOKS__) ? window.__LEGALDATA_BOOKS__ : [];
                renderList(applySearch(q, applyCategory(catId, items)));
                var list = document.getElementById('ldCatList');
                list && list.scrollIntoView({ behavior: 'smooth', block: 'start' });
                return false;
            };

            var items = Array.isArray(window.__LEGALDATA_BOOKS__) ? window.__LEGALDATA_BOOKS__ : [];
            var loading = document.getElementById('ldCatLoading');
            if (loading) loading.style.display = items.length ? 'none' : '';
            renderList(applyCategory(catId, items));

            var qFromUrl = getQueryParam('q');
            if (qFromUrl) {
                var input = document.getElementById('ldSearch');
                var mobile = document.getElementById('ldSearchMobile');
                if (input) input.value = qFromUrl;
                if (mobile) mobile.value = qFromUrl;
                window.__ldSearchSubmit__();
            }

            document.addEventListener('click', function (e) {
                var a = e.target && e.target.closest ? e.target.closest('.js-add') : null;
                if (!a) return;
                e.preventDefault();
                var t = a.getAttribute('data-title') || '';
                if (window.toastr) {
                    window.toastr.success('Demo: “' + t + '” сагсанд нэмэгдлээ.', 'Сагс');
                }
            });
        })();
    </script>

    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/ajax-mail.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        if (window.toastr) {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                timeOut: "2000",
            };
        }
    </script>
</body>

</html>
