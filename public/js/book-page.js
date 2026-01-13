document.addEventListener('alpine:init', () => {
    if (!Alpine.store('shop')) {
        Alpine.store('shop', {
            query: '',
            category: 'all',
            cartCount: 0,
            categories: [
                { id: 'all', label: 'Бүгд' },
                { id: 'book', label: 'Ном' },
                { id: 'gift', label: 'Бэлэг' },
            ],

            normalize(s) {
                return String(s ?? '').replace(/\s+/g, ' ').trim().toLowerCase();
            },

            itemType(book) {
                return this.normalize(book?.author) ? 'book' : 'gift';
            },
    
            categoryId(book) {
                const label = String(book?.category ?? '').trim();
                return label ? `cat:${label}` : this.itemType(book);
            },
    
            ensureCategoriesFromBooks(books) {
                const labels = (Array.isArray(books) ? books : [])
                    .map((b) => String(b?.category ?? '').trim())
                    .filter((v) => v.length > 0);
        
                const unique = Array.from(new Set(labels));
                if (!unique.length) return;
        
                const base = [
                    { id: 'all', label: 'Бүгд' },
                    { id: 'book', label: 'Ном' },
                    { id: 'gift', label: 'Бэлэг' },
                ];
        
                const cats = unique.map((label) => ({ id: `cat:${label}`, label }));
                this.categories = [...base, ...cats];
            },

            hydrateFromUrl() {
                try {
                    const params = new URLSearchParams(window.location.search);
                    const q = params.get('q');
                    const cat = params.get('cat');

                    if (q !== null) this.query = String(q);
                    if (cat !== null) {
                        const c = String(cat);
                        if (c === 'all' || c === 'book' || c === 'gift' || c.startsWith('cat:')) {
                            this.category = c;
                        }
                    }
                } catch {
                    // ignore
                }
            },

            goToBooks() {
                try {
                    const url = new URL('/book', window.location.origin);
                    const q = this.normalize(this.query);
                    if (q) url.searchParams.set('q', this.query);
                    if (this.category && this.category !== 'all') url.searchParams.set('cat', this.category);
                    window.location.href = url.toString();
                } catch {
                    window.location.href = '/book';
                }
            },

            syncUrl() {
                if (window.location.pathname !== '/book') return;
                try {
                    const url = new URL(window.location.href);
                    const q = this.normalize(this.query);
                    const cat = this.category;

                    if (q) url.searchParams.set('q', this.query);
                    else url.searchParams.delete('q');

                    if (cat && cat !== 'all') url.searchParams.set('cat', cat);
                    else url.searchParams.delete('cat');

                    window.history.replaceState({}, '', url.toString());
                } catch {
                    // ignore
                }
            },
        });
    }

    Alpine.store('shop').hydrateFromUrl();

    Alpine.data('bookPage', () => ({
        loading: true,
        error: null,
        books: [],

        toast: {
            open: false,
            message: '',
            type: 'success',
        },

        async init() {
            this.$watch('$store.shop.query', () => this.$store.shop.syncUrl());
            this.$watch('$store.shop.category', () => this.$store.shop.syncUrl());

            try {
                const response = await fetch('/data/legaldata-book.json', {
                    headers: { Accept: 'application/json' },
                });

                if (!response.ok) {
                    throw new Error(`Failed to load book data (${response.status})`);
                }

                const json = await response.json();
                this.books = Array.isArray(json) ? json : [];
                this.$store.shop.ensureCategoriesFromBooks(this.books);
            } catch (e) {
                this.error = e instanceof Error ? e.message : 'Unknown error';
                this.books = [];
            } finally {
                this.loading = false;
            }
        },

        get featured() {
            return this.books[0] ?? null;
        },

        bookId(book) {
            const url = String(book?.url ?? '');
            const match = url.match(/(\d+)\s*$/);
            return match ? Number(match[1]) : null;
        },

        detailUrl(book) {
            const id = this.bookId(book);
            return id ? `/book/${id}` : (book?.url ?? '#');
        },

        get filtered() {
            const q = this.$store.shop.normalize(this.$store.shop.query);
            const category = this.$store.shop.category;

            return this.books.filter((b) => {
                const title = this.$store.shop.normalize(b?.title);
                const author = this.$store.shop.normalize(b?.author);
                const matchQ = !q || title.includes(q) || author.includes(q);
                let matchC = true;
                if (category && category !== 'all') {
                    if (category.startsWith('cat:')) {
                        matchC = this.$store.shop.categoryId(b) === category;
                    } else {
                        matchC = this.$store.shop.itemType(b) === category;
                    }
                }
                return matchQ && matchC;
            });
        },

        get newBooks() {
            return this.filtered.slice(0, 12);
        },

        get bestSeller() {
            return this.filtered.slice(12, 24);
        },

        get lawBooks() {
            return this.filtered.slice(0, 20);
        },

        addToCart(book) {
            if (book?.soldOut) return;
            this.$store.shop.cartCount += 1;
            this.showToast(`Demo: “${book?.title ?? 'Ном'}” сагсанд нэмэгдлээ.`, 'success');
        },

        showToast(message, type = 'success') {
            this.toast.message = message;
            this.toast.type = type;
            this.toast.open = true;

            window.clearTimeout(this.__toastTimer);
            this.__toastTimer = window.setTimeout(() => {
                this.toast.open = false;
            }, 2000);
        },
    }));

    Alpine.data('storePage', () => ({
        loading: true,
        error: null,
        books: [],

        toast: {
            open: false,
            message: '',
            type: 'success',
        },

        async init() {
            try {
                const response = await fetch('/data/legaldata-book.json', {
                    headers: { Accept: 'application/json' },
                });

                if (!response.ok) {
                    throw new Error(`Failed to load book data (${response.status})`);
                }

                const json = await response.json();
                this.books = Array.isArray(json) ? json : [];
                this.$store.shop.ensureCategoriesFromBooks(this.books);
            } catch (e) {
                this.error = e instanceof Error ? e.message : 'Unknown error';
                this.books = [];
            } finally {
                this.loading = false;
            }
        },

        bookId(book) {
            const url = String(book?.url ?? '');
            const match = url.match(/(\d+)\s*$/);
            return match ? Number(match[1]) : null;
        },

        detailUrl(book) {
            const id = this.bookId(book);
            return id ? `/book/${id}` : (book?.url ?? '#');
        },

        get filtered() {
            const q = this.$store.shop.normalize(this.$store.shop.query);
            const category = this.$store.shop.category;

            return this.books.filter((b) => {
                const title = this.$store.shop.normalize(b?.title);
                const author = this.$store.shop.normalize(b?.author);
                const matchQ = !q || title.includes(q) || author.includes(q);
                let matchC = true;
                if (category && category !== 'all') {
                    if (category.startsWith('cat:')) {
                        matchC = this.$store.shop.categoryId(b) === category;
                    } else {
                        matchC = this.$store.shop.itemType(b) === category;
                    }
                }
                return matchQ && matchC;
            });
        },

        get newBooks() {
            return this.filtered.slice(0, 12);
        },

        addToCart(book) {
            if (book?.soldOut) return;
            this.$store.shop.cartCount += 1;
            this.showToast(`Demo: “${book?.title ?? 'Ном'}” сагсанд нэмэгдлээ.`, 'success');
        },

        showToast(message, type = 'success') {
            this.toast.message = message;
            this.toast.type = type;
            this.toast.open = true;

            window.clearTimeout(this.__toastTimer);
            this.__toastTimer = window.setTimeout(() => {
                this.toast.open = false;
            }, 2000);
        },
    }));

    Alpine.data('bookDetailPage', ({ id }) => ({
        loading: true,
        error: null,

        id,
        books: [],
        book: null,
        qty: 1,
        activeTab: 'about',

        toast: {
            open: false,
            message: '',
            type: 'success',
        },

        async init() {
            try {
                const response = await fetch('/data/legaldata-book.json', {
                    headers: { Accept: 'application/json' },
                });

                if (!response.ok) {
                    throw new Error(`Failed to load book data (${response.status})`);
                }

                const json = await response.json();
                const items = Array.isArray(json) ? json : [];
                this.books = items;
                const target = Number(this.id);

                this.book = items.find((b) => {
                    const url = String(b?.url ?? '');
                    const match = url.match(/(\d+)\s*$/);
                    return match ? Number(match[1]) === target : false;
                }) ?? null;

                if (!this.book) {
                    this.error = 'Ном олдсонгүй.';
                }
            } catch (e) {
                this.error = e instanceof Error ? e.message : 'Unknown error';
                this.book = null;
            } finally {
                this.loading = false;
            }
        },

        get qtyOptions() {
            return Array.from({ length: 10 }, (_, i) => i + 1);
        },

        bookId(book) {
            const url = String(book?.url ?? '');
            const match = url.match(/(\d+)\s*$/);
            return match ? Number(match[1]) : null;
        },

        detailUrl(book) {
            const id = this.bookId(book);
            return id ? `/book/${id}` : (book?.url ?? '#');
        },

        get relatedBooks() {
            if (!this.books?.length) return [];
            const target = Number(this.id);
            return this.books
                .filter((b) => {
                    const id = this.bookId(b);
                    return id !== null && id !== target;
                })
                .slice(0, 8);
        },

        addToCart(book, qty = 1) {
            if (book?.soldOut) return;
            const q = Math.max(1, Number(qty) || 1);
            this.$store.shop.cartCount += q;
            this.showToast(`Demo: “${book?.title ?? 'Ном'}” (${q}ш) сагсанд нэмэгдлээ.`, 'success');
        },

        showToast(message, type = 'success') {
            this.toast.message = message;
            this.toast.type = type;
            this.toast.open = true;

            window.clearTimeout(this.__toastTimer);
            this.__toastTimer = window.setTimeout(() => {
                this.toast.open = false;
            }, 2000);
        },
    }));
});
