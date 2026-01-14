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

    <meta property="og:url" content="https://legaldata.mn/book/view/{{ (int)$id }}" />
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" integrity="sha512-Zh6VJ5Qv7o+U2u+Xy2GUpvZ7QeL/4F5IYj7CttfXy3j1lZB8eB9k6dE+JZ0wK8G9W+9t2y3yqVq0aOZg0Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/favicon.ico') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        .ld-empty {
            padding: 24px 0;
            text-align: center;
            opacity: .8;
        }

        .compare-wishlist-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .compare-wishlist-row .twitter-share-button,
        .compare-wishlist-row .fb-share-button {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
        }

        .compare-wishlist-row iframe {
            vertical-align: middle !important;
        }
    </style>
</head>

<body>
    <div id="fb-root"></div>
    <div class="site-wrapper" id="top">
        @include('pustok.partials.header')

        <section class="breadcrumb-section">
            <h2 class="sr-only">Site Breadcrumb</h2>
            <div class="container">
                <div class="breadcrumb-contents">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/book') }}">Нүүр хуудас</a></li>
                            <li class="breadcrumb-item active">Номын дэлгэрэнгүй мэдээлэл</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>

        <main class="inner-page-sec-padding-bottom">
            <div class="container">
                <div class="row  mb--60">
                    <div class="col-lg-5 mb--30">
                        <div class="product-details-slider sb-slick-slider arrow-type-two" data-slick-setting='{
                                    "slidesToShow": 1,
                                    "arrows": false,
                                    "fade": true,
                                    "draggable": false,
                                    "swipe": false,
                                    "asNavFor": ".product-slider-nav"
                                    }'>
                            <div class="single-slide">
                                <a id="ldLightboxLink" href="#" data-lightbox="book{{ (int)$id }}" data-title="">
                                    <img id="ldBookImage" src="https://legaldata.mn/images/LD_cover.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="product-details-info pl-lg--30 ">
                            <h3 id="ldBookTitle" class="product-title"></h3>
                            <p>
                                <a id="ldBookAuthor" href="#" onclick="return false;"></a>
                            </p>
                            <div class="price-block">
                                <span style="border: 1px solid silver; padding:5px; background-color:#EEE; text-align:center">
                                    <span style="font-size: 16px; line-height:1.5em" id="ldBookPrice" class="price-new"></span>
                                    / <span style="font-size: 12px; color:#666"> зөөлөн хавтастай</span>
                                </span>
                            </div>

                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-lg-3 col-5 col-sm-5">Хэвлэгдсэн он:</div>
                                    <div class="col-lg-9 col-7 col-sm-7 font-weight-bold" id="ldBookYear"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-5 col-sm-5">Хуудасны тоо:</div>
                                    <div class="col-lg-9 col-7 col-sm-7 font-weight-bold" id="ldBookPages"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-5 col-sm-5">Ангилал:</div>
                                    <div class="col-lg-9 col-7 col-sm-7 font-weight-bold" id="ldBookCategory"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-5 col-sm-5">ISBN дугаар:</div>
                                    <div class="col-lg-9 col-7 col-sm-7 font-weight-bold" id="ldBookIsbn"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-5 col-sm-5">Хэл:</div>
                                    <div class="col-lg-9 col-7 col-sm-7 font-weight-bold" id="ldBookLang"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-5 col-sm-5">Хэмжээ (мм):</div>
                                    <div class="col-lg-9 col-7 col-sm-7 font-weight-bold" id="ldBookSize"></div>
                                </div>
                            </div>

                            <div class="add-to-cart-row">
                                <div class="count-input-block">
                                    <span class="widget-label">Тоо ширхэг</span>
                                    <select name="number1" id="number1" class="form-control text-center">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="add-cart-btn">
                                    <button id="ldAddToCart" class="btn btn-outlined--primary"> Сагсанд нэмэх</button>
                                    <a id="ldBuyLink" href="#" class="btn btn-outlined--primary" target="_blank" rel="noopener">Худалдаж авах</a>
                                </div>
                            </div>

                            <div class="compare-wishlist-row mt-5">
                                <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false" data-size="large">Tweet</a>
                                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                <div class="fb-share-button" id="ldFbShare" data-href="" data-layout="button" data-size="large" data-mobile-iframe="true"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sb-custom-tab review-tab section-padding">
                    <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Номын танилцуулга</a>
                        </li>
                    </ul>
                    <div class="tab-content space-db--20" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab1">
                            <article class="review-article">
                                <h1 class="sr-only">Номын танилцуулга</h1>
                                <p id="ldBookIntro" style="opacity:.85">Танилцуулга байхгүй.</p>
                            </article>
                        </div>
                    </div>
                </div>

                <section class="">
                    <div class="container">
                        <div class="section-title section-title--bordered">
                            <h2>Төсөөтэй номууд</h2>
                        </div>
                        <div id="ldRelatedSlider" class="product-slider sb-slick-slider slider-border-single-row" data-slick-setting='{
                "autoplay": true,
                "autoplaySpeed": 8000,
                "slidesToShow": 4,
                "slidesToScroll": 4,
                "dots":true
            }' data-slick-responsive='[
                {"breakpoint":1200, "settings": {"slidesToShow": 4, "slidesToScroll": 4} },
                {"breakpoint":992, "settings": {"slidesToShow": 3, "slidesToScroll": 3} },
                {"breakpoint":768, "settings": {"slidesToShow": 2, "slidesToScroll": 2} },
                {"breakpoint":480, "settings": {"slidesToShow": 1, "slidesToScroll": 1} }
            ]'></div>
                        <div id="ldRelatedEmpty" class="ld-empty" style="display:none">Илэрц олдсонгүй.</div>
                    </div>
                </section>
            </div>
        </main>

        @include('pustok.partials.footer')
    </div>

    <script src="{{ asset('data/legaldata-book.js') }}"></script>
    <script>
        (function () {
            var bookId = Number({{ (int)$id }});

            function escapeHtml(s) {
                return String(s || '').replace(/[&<>"']/g, function (c) {
                    return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c];
                });
            }

            function parseIdFromUrl(url) {
                var m = String(url || '').match(/\/view\/(\d+)/);
                return m ? Number(m[1]) : 0;
            }

            function findBook() {
                var items = Array.isArray(window.__LEGALDATA_BOOKS__) ? window.__LEGALDATA_BOOKS__ : [];
                for (var i = 0; i < items.length; i++) {
                    var b = items[i];
                    if ((b.id && Number(b.id) === bookId) || parseIdFromUrl(b.url) === bookId) return b;
                }
                return null;
            }

            function setText(id, value) {
                var el = document.getElementById(id);
                if (!el) return;
                el.textContent = value || '';
            }

            function setIntroHtml(html) {
                var el = document.getElementById('ldBookIntro');
                if (!el) return;
                if (!html) {
                    el.textContent = 'Танилцуулга байхгүй.';
                    return;
                }
                el.innerHTML = html;
            }

            function rewriteLinksToLocal(rootEl) {
                if (!rootEl) return;
                var anchors = rootEl.querySelectorAll('a[href]');
                for (var i = 0; i < anchors.length; i++) {
                    var a = anchors[i];
                    var href = a.getAttribute('href') || '';
                    var m = href.match(/https?:\/\/legaldata\.mn\/book\/view\/(\d+)/);
                    if (m) {
                        a.setAttribute('href', '{{ url('/book') }}/' + m[1]);
                        a.removeAttribute('target');
                        a.removeAttribute('rel');
                    }
                }
            }

            function renderRelatedSlides(html) {
                var slider = document.getElementById('ldRelatedSlider');
                var empty = document.getElementById('ldRelatedEmpty');
                if (!slider) return;

                if (!html || !String(html).trim()) {
                    if (empty) empty.style.display = '';
                    return;
                }

                // Parse and rewrite links, then inject.
                var tmp = document.createElement('div');
                tmp.innerHTML = html;
                rewriteLinksToLocal(tmp);
                slider.innerHTML = tmp.innerHTML;
                if (empty) empty.style.display = 'none';

                function initSlick() {
                    if (typeof window.jQuery === 'undefined' || !window.jQuery.fn || !window.jQuery.fn.slick) return false;
                    try { window.jQuery(slider).slick('unslick'); } catch (e) { }
                    try {
                        var setting = window.jQuery(slider).data('slick-setting');
                        window.jQuery(slider).slick(setting || {});
                        return true;
                    } catch (e) {
                        return false;
                    }
                }

                // Slick is defined in plugins.js; sometimes API returns before plugins load.
                if (!initSlick()) {
                    var tries = 0;
                    var t = setInterval(function () {
                        tries++;
                        if (initSlick() || tries > 80) {
                            clearInterval(t);
                        }
                    }, 100);
                }
            }

            // First, render from local list (fast) to avoid blank UI.
            var book = findBook();
            if (book) {
                setText('ldBookTitle', book.title || '');
                setText('ldBookPrice', book.price || '');
                var authorEl = document.getElementById('ldBookAuthor');
                if (authorEl) authorEl.textContent = book.author || '';

                var img = document.getElementById('ldBookImage');
                var link = document.getElementById('ldLightboxLink');
                if (img) img.src = book.image || '';
                if (link) {
                    link.href = book.image || '#';
                    link.setAttribute('data-title', book.title || '');
                }

                var buy = document.getElementById('ldBuyLink');
                if (buy) {
                    buy.href = book.url || '#';
                }

                var fb = document.getElementById('ldFbShare');
                if (fb) fb.setAttribute('data-href', book.url || '');

                var btn = document.getElementById('ldAddToCart');
                if (btn) {
                    btn.addEventListener('click', function (e) {
                        e.preventDefault();
                        if (window.toastr) {
                            window.toastr.success('Demo: “' + escapeHtml(book.title || '') + '” сагсанд нэмэгдлээ.', 'Сагс');
                        }
                    });
                }
            }

            // Then, fetch full detail (intro + meta fields) from same-origin API to match Legaldata.
            fetch('{{ url('/api/legaldata/book') }}/' + bookId, { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (!data || !data.ok) return;

                    setText('ldBookTitle', data.title || '');
                    setText('ldBookPrice', data.price || '');

                    var authorEl = document.getElementById('ldBookAuthor');
                    if (authorEl) authorEl.textContent = data.author || '';

                    setText('ldBookYear', (data.meta && data.meta.year) || '');
                    setText('ldBookPages', (data.meta && data.meta.pages) || '');
                    setText('ldBookCategory', (data.meta && data.meta.category) || '');
                    setText('ldBookIsbn', (data.meta && data.meta.isbn) || '');
                    setText('ldBookLang', (data.meta && data.meta.lang) || '');
                    setText('ldBookSize', (data.meta && data.meta.size) || '');

                    var img = document.getElementById('ldBookImage');
                    var link = document.getElementById('ldLightboxLink');
                    if (img && data.image) img.src = data.image;
                    if (link && data.image) {
                        link.href = data.image;
                        link.setAttribute('data-title', data.title || '');
                    }

                    var buy = document.getElementById('ldBuyLink');
                    if (buy && data.buyUrl) buy.href = data.buyUrl;

                    var fb = document.getElementById('ldFbShare');
                    if (fb && data.viewUrl) fb.setAttribute('data-href', data.viewUrl);
                    if (window.FB && window.FB.XFBML) {
                        try { window.FB.XFBML.parse(); } catch (e) { }
                    }

                    setIntroHtml(data.introHtml || '');

                    renderRelatedSlides(data.relatedSlidesHtml || '');
                })
                .catch(function () { });
        })();
    </script>

    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/ajax-mail.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js" integrity="sha512-4zWq9h1Qb9nY5m8eZp9mGg0bqkzjQkz6oM2w8m1m3kqzvQGxCk2Q8w4q7vQ+QwXxj3o9g0mO+o0w3cE0xw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v19.0"></script>
    <script>
        if (window.toastr) {
            toastr.options = { closeButton: true, progressBar: true, timeOut: "2000" };
        }
    </script>
</body>

</html>
