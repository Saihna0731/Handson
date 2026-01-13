<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Legaldata-Номын худалдаа</title>
    <meta name="description" content="">
    <meta name="author" content="Д.Соёл-Эрдэнэ">
    <meta name="csrf-token" content="">
    <meta name="ld-user-id" content="0">

    <meta property="og:url" content="https://legaldata.mn/book" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Legaldata-Номын худалдаа" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="https://legaldata.mn/images/LD_tw_summary.png" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@legaldata_mn" />
    <meta name="twitter:title" content="Legaldata-Номын худалдаа" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="https://legaldata.mn/images/LD_tw_summary.png" />

    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/plugins.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/main1.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/favicon.ico') }}">

    <style>
        .ld-empty {
            padding: 24px 0;
            text-align: center;
            opacity: .8;
        }
    </style>
</head>

<body>
    <div class="site-wrapper" id="top">
        @include('pustok.partials.header')

        <section class="hero-area hero-slider-1">
            <div class="sb-slick-slider" data-slick-setting='{
                            "autoplay": true,
                            "fade": true,
                            "autoplaySpeed": 3000,
                            "speed": 3000,
                            "slidesToShow": 1,
                            "dots":false 
                            }'>
                <div class="single-slide bg-shade-whisper">
                    <div class="container">
                        <div class="home-content text-center text-sm-left position-relative">
                            <div class="hero-partial-image image-right">
                                <img id="ldHeroImg" src="https://legaldata.mn/images/LD_cover.png" alt="">
                            </div>
                            <div class="row no-gutters ">
                                <div class="col-xl-6 col-md-6 col-sm-7">
                                    <div class="home-content-inner content-left-side">
                                        <h1>
                                            <a id="ldHeroTitle" href="#" onclick="return false;">Legaldata номын худалдаа</a>
                                        </h1>
                                        <h2>
                                            <a id="ldHeroAuthor" href="#" onclick="return false;"></a>
                                        </h2>
                                        <a id="ldHeroPrice" href="#" class="btn btn-outlined--primary" onclick="return false;">Үнэ: 0₮</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb--30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-md-12 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="text">
                                <h5>Хүргэлт</h5>
                                <p>Улаанбаатар хотод захиалга өгснөөс хойш 48 цагийн дотор хүргэлт хийгдэнэ. Орон нутаг руу унаанд дайж явуулна. Энэ тохиолдолд дайврын төлбөрийг хүлээн авагч төлнө.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-margin mt-5">
            <div class="container">
                <div class="section-title section-title--bordered">
                    <h2>Шинээр нэмэгдсэн</h2>
                </div>
                <div id="ldNewSlider" class="product-slider sb-slick-slider slider-border-single-row" data-slick-setting='{
                "autoplay": true,
                "arrows": false,
                "autoplaySpeed": 8000,
                "slidesToShow": 4,
                "slidesToScroll": 4,
                "dots":true
            }' data-slick-responsive='[
                {"breakpoint":1500, "settings": {"slidesToShow": 4, "slidesToScroll": 4} },
                {"breakpoint":992, "settings": {"slidesToShow": 3, "slidesToScroll": 3} },
                {"breakpoint":768, "settings": {"slidesToShow": 2, "slidesToScroll": 2} },
                {"breakpoint":480, "settings": {"slidesToShow": 1, "slidesToScroll": 1} },
                {"breakpoint":320, "settings": {"slidesToShow": 1, "slidesToScroll": 1} }
            ]'></div>
                <div id="ldNewEmpty" class="ld-empty" style="display:none">Илэрц олдсонгүй.</div>
            </div>
        </section>

        <section class="section-margin bg-image section-padding-top section-padding" data-bg="https://legaldata.mn/nom/assets/image/bg-images/best-seller-bg.jpg">
            <div class="container">
                <div class="section-title section-title--bordered mb-0">
                    <h2>BEST SELLER BOOKS</h2>
                </div>
                <div class="best-seller-block">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-md-12">
                            <div id="ldBestSlider" class="sb-slick-slider product-slider product-list-slider multiple-row slider-border-multiple-row" data-slick-setting='{
                                    "autoplay": false,
                                    "autoplaySpeed": 8000,
                                    "slidesToShow":2,
                                    "rows":2,
                                    "dots":true
                                }' data-slick-responsive='[
                                    {"breakpoint":1200, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":992, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":768, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                ]'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-margin">
            <div class="container">
                <div class="section-title section-title--bordered">
                    <h2>Хууль, эрх зүй</h2>
                </div>
                <div id="ldLawSlider" class="product-list-slider slider-two-column product-slider multiple-row sb-slick-slider slider-border-multiple-row" data-slick-setting='{
                                            "autoplay": true,
                                            "autoplaySpeed": 8000,
                                            "slidesToShow":2,
                                            "slidesToScroll": 2,
                                            "rows":1,
                                            "dots":true
                                        }' data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 2, "slidesToScroll": 2} },
                                            {"breakpoint":992, "settings": {"slidesToShow": 2, "slidesToScroll": 2} },
                                            {"breakpoint":768, "settings": {"slidesToShow": 1,"slidesToScroll": 1} },
                                            {"breakpoint":575, "settings": {"slidesToShow": 1,"slidesToScroll": 1} },
                                            {"breakpoint":490, "settings": {"slidesToShow": 1,"slidesToScroll": 1} }
                                        ]'></div>
            </div>
        </section>

        @include('pustok.partials.footer')
    </div>

    <script src="{{ asset('data/legaldata-book.js') }}"></script>

    <script>
        (function () {
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

            function parseIdFromUrl(url) {
                var m = String(url || '').match(/\/view\/(\d+)/);
                return m ? Number(m[1]) : 0;
            }

            function renderHero(book) {
                var img = document.getElementById('ldHeroImg');
                var title = document.getElementById('ldHeroTitle');
                var author = document.getElementById('ldHeroAuthor');
                var price = document.getElementById('ldHeroPrice');
                if (!img || !title || !author || !price || !book) return;

                img.src = book.image;
                title.textContent = book.title || 'Legaldata номын худалдаа';
                title.href = book.url;
                title.target = '_blank';
                title.rel = 'noopener';

                author.textContent = book.author || '';
                author.href = book.url;
                author.target = '_blank';
                author.rel = 'noopener';

                price.textContent = 'Үнэ: ' + (book.price || '0₮');
                price.href = book.url;
                price.target = '_blank';
                price.rel = 'noopener';
            }

            function slideHtmlCard(book) {
                var id = book.id || parseIdFromUrl(book.url);
                var detailUrl = id ? ('{{ url('/book') }}/' + id) : (book.url || '#');
                var soldOutHtml = book.soldOut
                    ? '<div class="mt-2 mb-2" style="color:red">Дууссан !</div>'
                    : '<div class="mt-2 mb-2"><i class="fas fa-cart-plus"></i> <a href="#" class="mr-2 js-add" data-title="' + escapeHtml(book.title || '') + '" onclick="return false;">Сагсанд хийх</a></div>';

                return (
                    '<div class="single-slide">'
                    + '  <div class="product-card">'
                    + '    <div class="product-card--body">'
                    + '      <div class="card-image">'
                    + '        <a href="' + escapeHtml(detailUrl) + '">'
                    + '          <img src="' + escapeHtml(book.image) + '" alt="">'
                    + '        </a>'
                    + '      </div>'
                    + '      <div class="price-block">'
                    + '        <span class="price">' + escapeHtml(book.price || '') + '</span>'
                    + (book.oldPrice ? ('<del class="price-old">' + escapeHtml(book.oldPrice) + '</del>') : '')
                    + (book.discount ? ('<span class="price-discount">' + escapeHtml(book.discount) + '</span>') : '')
                    + '        ' + soldOutHtml
                    + '      </div>'
                    + '    </div>'
                    + '    <div class="product-header">'
                    + '      <h3><a href="' + escapeHtml(detailUrl) + '">' + escapeHtml(book.title || '') + '</a></h3>'
                    + '      <a href="#" class="author" onclick="return false;">' + escapeHtml(book.author || '') + '</a>'
                    + '    </div>'
                    + '  </div>'
                    + '</div>'
                );
            }

            function slideHtmlList(book) {
                var id = book.id || parseIdFromUrl(book.url);
                var detailUrl = id ? ('{{ url('/book') }}/' + id) : (book.url || '#');
                var soldOutHtml = book.soldOut
                    ? '<div class="mt-2 mb-2" style="color:red">Дууссан !</div>'
                    : '<div class="mt-2 mb-2"><i class="fas fa-cart-plus"></i> <a href="#" class="mr-2 js-add" data-title="' + escapeHtml(book.title || '') + '" onclick="return false;">Сагсанд хийх</a></div>';

                return (
                    '<div class="single-slide">'
                    + '  <div class="product-card card-style-list">'
                    + '    <div class="col-lg-5 col-md-5">'
                    + '      <div>'
                    + '        <a href="' + escapeHtml(detailUrl) + '">'
                    + '          <img class="shadow-sm" src="' + escapeHtml(book.image) + '" alt="">'
                    + '        </a>'
                    + '      </div>'
                    + '    </div>'
                    + '    <div class="col-lg-7 col-lg-7">'
                    + '      <div class="product-card--body">'
                    + '        <div class="product-header">'
                    + '          <a href="#" class="author" onclick="return false;">' + escapeHtml(book.author || '') + '</a>'
                    + '          <h3><a href="' + escapeHtml(detailUrl) + '">' + escapeHtml(book.title || '') + '</a></h3>'
                    + '        </div>'
                    + '        <div class="price-block">'
                    + '          <span class="price">' + escapeHtml(book.price || '') + '</span>'
                    + (book.oldPrice ? ('<del class="price-old">' + escapeHtml(book.oldPrice) + '</del>') : '')
                    + (book.discount ? ('<span class="price-discount">' + escapeHtml(book.discount) + '</span>') : '')
                    + '        </div>'
                    + '        ' + soldOutHtml
                    + '      </div>'
                    + '    </div>'
                    + '  </div>'
                    + '</div>'
                );
            }

            function renderSlider(el, books, template) {
                if (!el) return;
                el.innerHTML = books.map(function (b) { return template(b); }).join('');
            }

            function showEmpty(show) {
                var empty = document.getElementById('ldNewEmpty');
                if (!empty) return;
                empty.style.display = show ? '' : 'none';
            }

            function applySearch(query, items) {
                query = normalizeText(query).toLowerCase();
                if (!query) return items;
                return items.filter(function (b) {
                    return (
                        String(b.title || '').toLowerCase().includes(query) ||
                        String(b.author || '').toLowerCase().includes(query)
                    );
                });
            }

            function getQueryParam(name) {
                try {
                    var params = new URLSearchParams(window.location.search || '');
                    return params.get(name) || '';
                } catch (e) {
                    return '';
                }
            }

            window.__ldSearchSubmit__ = function (event) {
                if (event && event.preventDefault) event.preventDefault();
                var input = document.getElementById('ldSearch');
                var mobile = document.getElementById('ldSearchMobile');
                var q = (input && input.value) ? input.value : ((mobile && mobile.value) ? mobile.value : '');
                var items = Array.isArray(window.__LEGALDATA_BOOKS__) ? window.__LEGALDATA_BOOKS__ : [];
                var filtered = applySearch(q, items);

                var newSlider = document.getElementById('ldNewSlider');
                renderSlider(newSlider, filtered.slice(0, 24), slideHtmlCard);
                showEmpty(filtered.length === 0);

                if (typeof window.jQuery !== 'undefined' && window.jQuery.fn && window.jQuery.fn.slick) {
                    try { window.jQuery(newSlider).slick('unslick'); } catch (e) { }
                    try {
                        var setting = window.jQuery(newSlider).data('slick-setting');
                        window.jQuery(newSlider).slick(setting || {});
                    } catch (e) { }
                }

                newSlider && newSlider.scrollIntoView({ behavior: 'smooth', block: 'start' });
                return false;
            };

            var items = Array.isArray(window.__LEGALDATA_BOOKS__) ? window.__LEGALDATA_BOOKS__ : [];
            renderHero(items[0]);

            var newSlider = document.getElementById('ldNewSlider');
            renderSlider(newSlider, items.slice(0, 12), slideHtmlCard);

            var bestSlider = document.getElementById('ldBestSlider');
            renderSlider(bestSlider, items.slice(12, 24), slideHtmlList);

            var lawSlider = document.getElementById('ldLawSlider');
            renderSlider(lawSlider, items.slice(0, 20), slideHtmlList);

            document.addEventListener('click', function (e) {
                var a = e.target && e.target.closest ? e.target.closest('.js-add') : null;
                if (!a) return;
                e.preventDefault();
                var t = a.getAttribute('data-title') || '';
                if (window.toastr) {
                    window.toastr.success('Demo: “' + t + '” сагсанд нэмэгдлээ.', 'Сагс');
                }
            });

            var qFromUrl = getQueryParam('q');
            if (qFromUrl) {
                var input = document.getElementById('ldSearch');
                var mobile = document.getElementById('ldSearchMobile');
                if (input) input.value = qFromUrl;
                if (mobile) mobile.value = qFromUrl;
                window.__ldSearchSubmit__();
            }
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
                timeOut: "2000"
            };
        }
    </script>
</body>

</html>
