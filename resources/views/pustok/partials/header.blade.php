<div class="site-header d-none d-lg-block">
    <div class="header-middle pt--10 pb--10">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 ">
                    <a href="{{ url('/book') }}" class="site-brand">
                        <img src="https://legaldata.mn/nom/assets/image/LDLogo2.png" style="height:60px" alt="">
                    </a>
                </div>

                <div class="col-lg-9">
                    <div class="main-navigation flex-lg-right">
                        <ul class="main-menu menu-right ">
                            <li class="menu-item">
                                <a href="https://legaldata.mn/book" target="_blank" rel="noopener">Номын худалдаа нүүр</a>
                            </li>

                            <li class="menu-item has-children mega-menu">
                                <a href="#" onclick="return false;">Номын ангилал <i class="fas fa-chevron-down dropdown-arrow"></i></a>
                                <ul class="sub-menu four-column">
                                    <li class="single-block">
                                        <h3 class="menu-title">Ангилал</h3>
                                        <ul>
                                            <li><a href="{{ url('/book/cat/1') }}">Хууль, эрх зүй</a></li>
                                            <li><a href="{{ url('/book/cat/15') }}">Хууль, эрх зүйн сэтгүүл</a></li>
                                            <li><a href="{{ url('/book/cat/16') }}">Эрх зүйн акт, эмхэтгэл, орчуулга</a></li>
                                            <li><a href="{{ url('/book/cat/20') }}">Өгүүлэл, илтгэлийн эмхэтгэл</a></li>
                                            <li><a href="{{ url('/book/cat/12') }}">Эрх зүйн боловсрол</a></li>
                                        </ul>
                                    </li>
                                    <li class="single-block">
                                        <h3 class="menu-title">Ангилал</h3>
                                        <ul>
                                            <li><a href="{{ url('/book/cat/14') }}">Хуулийн ховор, хуучин ном</a></li>
                                            <li><a href="{{ url('/book/cat/19') }}">Хуулийн тайлбар, толь</a></li>
                                            <li><a href="{{ url('/book/cat/2') }}">Нийгэм, улс төр</a></li>
                                            <li><a href="{{ url('/book/cat/3') }}">Эдийн засаг, бизнесс</a></li>
                                            <li><a href="{{ url('/book/cat/4') }}">Шинжлэх ухаан, танин мэдэхүй</a></li>
                                        </ul>
                                    </li>
                                    <li class="single-block">
                                        <h3 class="menu-title">Ангилал</h3>
                                        <ul>
                                            <li><a href="{{ url('/book/cat/10') }}">Шашин, философи</a></li>
                                            <li><a href="{{ url('/book/cat/6') }}">Өөртөө туслах, хувь хүний хөгжил</a></li>
                                            <li><a href="{{ url('/book/cat/17') }}">Хүүхдийн ном</a></li>
                                            <li><a href="{{ url('/book/cat/18') }}">Уран зохиол, яруу найраг</a></li>
                                            <li><a href="{{ url('/book/cat/21') }}">Бэлэг дурсгал</a></li>
                                        </ul>
                                    </li>
                                    <li class="single-block">
                                        <div class="promo">
                                            <a href="#" class="promo-image" onclick="return false;">
                                                <img src="https://legaldata.mn/book/storage/images/ss7aRtUlKDGP9jLxtxLEpCs6MU4nYMoZjtJtE6d6.png" alt="promo">
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu-item">
                                <a href="https://legaldata.mn" target="_blank" rel="noopener">Бүтээлийн сан</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-header d-none d-lg-block">
    <div id="fixed-header" class="header-bottom pb--10">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="header-search-block">
                        <form action="{{ url('/book') }}" method="get" onsubmit="return window.__ldSearchSubmit__ ? window.__ldSearchSubmit__(event) : true;">
                            <input type="text" name="q" id="ldSearch" value="" placeholder="Номын нэрэнд орсон үг эсвэл зохиолчийн нэр..." required>
                            <button>Хайх</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-navigation flex-lg-right">
                        <div class="cart-widget">
                            <div class="login-block">
                                <a href="https://legaldata.mn/book/login" target="_blank" rel="noopener" class="mr-3"><i class="fas fa-sign-in-alt"></i> Нэвтрэх</a>
                            </div>
                            <div class="cart-block">
                                <div class="cart-total">
                                    <a href="#" onclick="return false;">
                                        <span class="text-number">0</span>
                                        <span class="text-item">Сагсанд</span>
                                        <span class="price">0 ₮ <i class="fas fa-chevron-down"></i></span>
                                    </a>
                                </div>
                                <div class="cart-dropdown-block">
                                    <div class="single-cart-block ">
                                        <div class="btn-block">
                                            <a class="btn">Нийт: 0 ₮</a>
                                            <a href="#" class="btn btn--primary" onclick="return false;">Сагс хоосон!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-mobile-menu fixed" id="mobile-header">
    <header class="mobile-header d-block d-lg-none pt--10 pb-md--10">
        <div class="container">
            <div class="row align-items-sm-end align-items-center">
                <div class="col-md-4 col-5">
                    <a href="{{ url('/book') }}" style="margin-top:5px; margin-bottom:5px">
                        <img src="https://legaldata.mn/nom/assets/image/LDLogo2.png" style="height:40px" alt="">
                    </a>
                </div>
                <div class="col-md-4 col-3">
                    <a href="#" class="cart-link link-icon" onclick="return false;">
                        <span style="padding:8px" class="badge badge-success">Сaгсанд: 0</span>
                    </a>
                </div>
                <div class="col-md-3 col-4 order-md-3 text-right">
                    <div class="mobile-header-btns header-top-widget">
                        <ul class="header-links">
                            <li class="sin-link"></li>
                            <li class="sin-link">
                                <a href="javascript:" class="link-icon hamburgur-icon off-canvas-btn"><i class="ion-navicon"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <aside class="off-canvas-wrapper">
        <div class="btn-close-off-canvas">
            <i class="ion-android-close"></i>
        </div>
        <div class="off-canvas-inner">
            <div class="search-box offcanvas">
                <form action="{{ url('/book') }}" method="get" onsubmit="return window.__ldSearchSubmit__ ? window.__ldSearchSubmit__(event) : true;">
                    <input type="text" name="q" id="ldSearchMobile" value="" placeholder="Номын нэрэнд орсон үг эсвэл зохиолчийн нэр..." required>
                    <button class="search-btn"><i class="ion-ios-search-strong"></i></button>
                </form>
            </div>
            <div class="mobile-navigation">
                <nav class="off-canvas-nav">
                    <ul class="mobile-menu main-mobile-menu">
                        <li><a href="https://legaldata.mn/book" target="_blank" rel="noopener">Номын худалдаа нүүр</a></li>
                        <li class="menu-item-has-children">
                            <a href="#" onclick="return false;">Номын ангилал</a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('/book/cat/1') }}">Хууль, эрх зүй</a></li>
                                <li><a href="{{ url('/book/cat/15') }}">Хууль, эрх зүйн сэтгүүл</a></li>
                                <li><a href="{{ url('/book/cat/16') }}">Эрх зүйн акт, эмхэтгэл, орчуулга</a></li>
                                <li><a href="{{ url('/book/cat/20') }}">Өгүүлэл, илтгэлийн эмхэтгэл</a></li>
                                <li><a href="{{ url('/book/cat/12') }}">Эрх зүйн боловсрол</a></li>
                                <li><a href="{{ url('/book/cat/14') }}">Хуулийн ховор, хуучин ном</a></li>
                                <li><a href="{{ url('/book/cat/19') }}">Хуулийн тайлбар, толь</a></li>
                                <li><a href="{{ url('/book/cat/2') }}">Нийгэм, улс төр</a></li>
                                <li><a href="{{ url('/book/cat/3') }}">Эдийн засаг, бизнесс</a></li>
                                <li><a href="{{ url('/book/cat/4') }}">Шинжлэх ухаан, танин мэдэхүй</a></li>
                                <li><a href="{{ url('/book/cat/10') }}">Шашин, философи</a></li>
                                <li><a href="{{ url('/book/cat/6') }}">Өөртөө туслах, хувь хүний хөгжил</a></li>
                                <li><a href="{{ url('/book/cat/17') }}">Хүүхдийн ном</a></li>
                                <li><a href="{{ url('/book/cat/18') }}">Уран зохиол, яруу найраг</a></li>
                                <li><a href="{{ url('/book/cat/21') }}">Бэлэг дурсгал</a></li>
                            </ul>
                        </li>
                        <li><a href="https://legaldata.mn" target="_blank" rel="noopener">Хууль зүйн судалгааны бүтээлийн сан</a></li>
                    </ul>
                </nav>
            </div>
            <div class="off-canvas-bottom">
                <div class="contact-list mb--10">
                    <a href="#" class="sin-contact" onclick="return false;"><i class="fas fa-envelope"></i> info@legaldata.mn</a>
                </div>
                <div class="off-canvas-social">
                    <a href="https://www.facebook.com/www.legaldata.mn" target="_blank" rel="noopener" class="single-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/legaldata_mn" target="_blank" rel="noopener" class="single-icon"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </aside>
</div>
