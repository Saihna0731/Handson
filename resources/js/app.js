import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('shop', {
	query: '',
	category: 'all',
	cartItems: [],
	categories: [
		{ id: 'all', label: 'Бүгд' },
		{ id: 'book', label: 'Ном' },
		{ id: 'gift', label: 'Бэлэг' },
	],

	get cartCount() {
		return this.cartItems.reduce((sum, item) => sum + (Number(item?.qty) || 0), 0);
	},

	get cartTotal() {
		return this.cartItems.reduce((sum, item) => {
			const qty = Number(item?.qty) || 0;
			return sum + qty * this.priceToNumber(item?.price);
		}, 0);
	},

	get cartTotalFormatted() {
		return `${this.formatNumber(this.cartTotal)} ₮`;
	},

	normalize(s) {
		return String(s ?? '').replace(/\s+/g, ' ').trim().toLowerCase();
	},

	formatNumber(n) {
		const num = Number(n) || 0;
		try {
			return new Intl.NumberFormat('mn-MN').format(num);
		} catch {
			return String(num);
		}
	},

	priceToNumber(price) {
		const raw = String(price ?? '');
		const digits = raw.replace(/[^0-9]/g, '');
		return Number(digits) || 0;
	},

	proxyImage(url) {
		const raw = String(url ?? '').trim();
		if (!raw) return '/image/others/product-promo-3.jpg';
		if (raw.startsWith('http://') || raw.startsWith('https://')) {
			return `/media/legaldata-image?u=${encodeURIComponent(raw)}`;
		}
		return raw;
	},

	loadCart() {
		try {
			const raw = window.localStorage.getItem('ld_cart_v1');
			if (!raw) return;
			const parsed = JSON.parse(raw);
			if (!Array.isArray(parsed)) return;
			this.cartItems = parsed
				.map((i) => ({
					key: String(i?.key ?? ''),
					title: String(i?.title ?? ''),
					image: String(i?.image ?? ''),
					price: String(i?.price ?? ''),
					qty: Math.max(1, Number(i?.qty) || 1),
				}))
				.filter((i) => i.key && i.title);
		} catch {
			// ignore
		}
	},

	saveCart() {
		try {
			window.localStorage.setItem('ld_cart_v1', JSON.stringify(this.cartItems));
		} catch {
			// ignore
		}
	},

	addToCart(book, qty = 1) {
		const key = String(book?.url ?? '');
		if (!key) return;
		const safeQty = Math.max(1, Number(qty) || 1);
		const idx = this.cartItems.findIndex((i) => i.key === key);
		if (idx >= 0) {
			this.cartItems[idx].qty = Math.max(1, (Number(this.cartItems[idx].qty) || 1) + safeQty);
			this.cartItems = [...this.cartItems];
		} else {
			this.cartItems = [
				...this.cartItems,
				{
					key,
					title: String(book?.title ?? 'Ном'),
					image: String(book?.image ?? ''),
					price: String(book?.price ?? '0'),
					qty: safeQty,
				},
			];
		}
		this.saveCart();
	},

	removeFromCart(key) {
		const k = String(key ?? '');
		if (!k) return;
		this.cartItems = this.cartItems.filter((i) => i.key !== k);
		this.saveCart();
	},

	addItem(item, qty = 1) {
		const safeQty = Math.max(1, Number(qty) || 1);
		const key = String(item?.key ?? item?.url ?? '');
		if (!key) return;

		const idx = this.cartItems.findIndex((i) => i.key === key);
		if (idx >= 0) {
			this.cartItems[idx].qty = Math.max(1, (Number(this.cartItems[idx].qty) || 1) + safeQty);
			this.cartItems = [...this.cartItems];
		} else {
			this.cartItems = [
				...this.cartItems,
				{
					key,
					title: String(item?.title ?? 'Бүтээгдэхүүн'),
					image: String(item?.image ?? '/image/others/product-promo-3.jpg'),
					price: String(item?.price ?? '0'),
					qty: safeQty,
				},
			];
		}
		this.saveCart();
	},

	addGiftBundle() {
		this.addItem(
			{
				key: 'gift-bundle',
				title: 'Бэлгийн багц',
				image: '/image/others/product-promo-3.jpg',
				price: '59,900 ₮',
			},
			1
		);
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
			const path = String(window.location.pathname || '');
			const base = path.startsWith('/book/cat/') ? path : '/book';
			const url = new URL(base, window.location.origin);
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

Alpine.store('shop').hydrateFromUrl();
Alpine.store('shop').loadCart();

Alpine.data('categoryPage', ({ catId, categories }) => ({
	catId: Number(catId || 0),
	categories: Array.isArray(categories) ? categories : [],
	loading: true,
	error: null,
	books: [],
	sort: 'new',
	page: 1,
	perPage: 12,

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
			this.page = 1;
		} catch (e) {
			this.error = e instanceof Error ? e.message : 'Unknown error';
			this.books = [];
		} finally {
			this.loading = false;
		}
	},

	get categoryLabel() {
		return this.categories.find((c) => Number(c?.id) === this.catId)?.label ?? 'Ангилалаар';
	},

	get isGiftCategory() {
		// config('legaldata.categories') uses id=21 for "Бэлэг дурсгал"
		return Number(this.catId) === 21;
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
		const desiredType = this.isGiftCategory ? 'gift' : 'book';

		let list = this.books.filter((b) => {
			const title = this.$store.shop.normalize(b?.title);
			const author = this.$store.shop.normalize(b?.author);
			const matchQ = !q || title.includes(q) || author.includes(q);
			const matchType = this.$store.shop.itemType(b) === desiredType;
			return matchQ && matchType;
		});

		// Sorting
		const sort = String(this.sort || 'new');
		if (sort === 'price_asc' || sort === 'price_desc') {
			list = [...list].sort((a, b) => {
				const pa = this.$store.shop.priceToNumber(a?.price);
				const pb = this.$store.shop.priceToNumber(b?.price);
				return sort === 'price_asc' ? pa - pb : pb - pa;
			});
		} else if (sort === 'title_asc' || sort === 'title_desc') {
			list = [...list].sort((a, b) => {
				const ta = String(a?.title ?? '');
				const tb = String(b?.title ?? '');
				return sort === 'title_asc' ? ta.localeCompare(tb) : tb.localeCompare(ta);
			});
		}

		return list;
	},

	get total() {
		return this.filtered.length;
	},

	get pageCount() {
		return Math.max(1, Math.ceil(this.total / this.perPage));
	},

	get paged() {
		const p = Math.min(Math.max(1, Number(this.page) || 1), this.pageCount);
		const start = (p - 1) * this.perPage;
		return this.filtered.slice(start, start + this.perPage);
	},

	setPage(p) {
		this.page = Math.min(Math.max(1, Number(p) || 1), this.pageCount);
		try {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		} catch {
			window.scrollTo(0, 0);
		}
	},

	addToCart(book) {
		if (book?.soldOut) return;
		this.$store.shop.addToCart(book, 1);
	},
}));

Alpine.data('bookPage', () => ({
	loading: true,
	error: null,

	newPage: 0,
	bestSellerPage: 0,
	lawPage: 0,

	books: [],

	async init() {
		this.$watch('$store.shop.query', () => {
			this.$store.shop.syncUrl();
			this.newPage = 0;
			this.bestSellerPage = 0;
			this.lawPage = 0;
			this.startAutoRotate();
		});
		this.$watch('$store.shop.category', () => {
			this.$store.shop.syncUrl();
			this.newPage = 0;
			this.bestSellerPage = 0;
			this.lawPage = 0;
			this.startAutoRotate();
		});

		try {
			const response = await fetch('/data/legaldata-book.json', {
				headers: { 'Accept': 'application/json' },
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
			this.startAutoRotate();
		}
	},

	startAutoRotate() {
		if (this.__rotators) {
			this.__rotators.forEach((t) => window.clearInterval(t));
		}
		this.__rotators = [];

		const newLen = this.newBookPages.length;
		const bestLen = this.bestSellerPages.length;
		const lawLen = this.lawBookPages.length;

		if (newLen > 1) {
			this.__rotators.push(
				window.setInterval(() => {
					this.newPage = (this.newPage + 1) % newLen;
				}, 4500)
			);
		}
		if (bestLen > 1) {
			this.__rotators.push(
				window.setInterval(() => {
					this.bestSellerPage = (this.bestSellerPage + 1) % bestLen;
				}, 5000)
			);
		}
		if (lawLen > 1) {
			this.__rotators.push(
				window.setInterval(() => {
					this.lawPage = (this.lawPage + 1) % lawLen;
				}, 5500)
			);
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

	get isSearching() {
		const q = this.$store.shop.normalize(this.$store.shop.query);
		const category = this.$store.shop.category;
		return Boolean(q) || (category && category !== 'all');
	},

	get categoryLabel() {
		return this.$store.shop.categories.find((c) => c.id === this.$store.shop.category)?.label ?? 'Бүгд';
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

	paginate(items, perPage) {
		const list = Array.isArray(items) ? items : [];
		const size = Math.max(1, Number(perPage) || 1);
		const pages = [];
		for (let i = 0; i < list.length; i += size) pages.push(list.slice(i, i + size));
		return pages;
	},

	get newBookPages() {
		return this.paginate(this.newBooks, 4);
	},

	get bestSellerPages() {
		return this.paginate(this.bestSeller, 4);
	},

	get lawBookPages() {
		return this.paginate(this.lawBooks, 2);
	},

	get currentNewBooks() {
		return this.newBookPages[this.newPage] ?? [];
	},

	get currentBestSellerBooks() {
		return this.bestSellerPages[this.bestSellerPage] ?? [];
	},

	get currentLawBooks() {
		return this.lawBookPages[this.lawPage] ?? [];
	},

	addToCart(book) {
		if (book?.soldOut) return;
		this.$store.shop.addToCart(book, 1);
	},
}));

Alpine.data('storePage', () => ({
	loading: true,
	error: null,

	books: [],

	async init() {
		try {
			const response = await fetch('/data/legaldata-book.json', {
				headers: { 'Accept': 'application/json' },
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
		this.$store.shop.addToCart(book, 1);
	},
}));

Alpine.data('bookDetailPage', ({ id }) => ({
	loading: true,
	error: null,

	id,
	books: [],
	book: null,
	qty: 1,
	activeTab: 'desc',
	relatedPage: 0,
	_relatedTimer: null,

	async init() {
		try {
			const response = await fetch('/data/legaldata-book.json', {
				headers: { 'Accept': 'application/json' },
			});
			if (!response.ok) throw new Error(`Failed to load book data (${response.status})`);

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
			this.startRelatedAutoRotate();
		}

		this.$watch('qty', () => {
			const v = Math.max(1, Math.floor(Number(this.qty) || 1));
			if (v !== this.qty) this.qty = v;
		});
	},

	get unitPriceMnt() {
		return this.$store.shop.priceToNumber(this.book?.price);
	},

	get totalPriceMnt() {
		const qty = Math.max(1, Number(this.qty) || 1);
		const unit = Number(this.unitPriceMnt) || 0;
		return unit ? unit * qty : 0;
	},

	get totalPriceFormatted() {
		const total = Number(this.totalPriceMnt) || 0;
		if (!total) return '';
		return `${this.$store.shop.formatNumber(total)} ₮`;
	},

	paginate(items, perPage) {
		const list = Array.isArray(items) ? items : [];
		const size = Math.max(1, Number(perPage) || 1);
		const pages = [];
		for (let i = 0; i < list.length; i += size) pages.push(list.slice(i, i + size));
		return pages;
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

		const others = this.books.filter((b) => {
			const id = this.bookId(b);
			return id !== null && id !== target;
		});

		const cat = String(this.book?.category ?? '').trim();
		if (!cat) return others.slice(0, 12);

		const same = others.filter((b) => String(b?.category ?? '').trim() === cat);
		if (same.length >= 12) return same.slice(0, 12);

		const rest = others.filter((b) => String(b?.category ?? '').trim() !== cat);
		return [...same, ...rest].slice(0, 12);
	},

	get relatedBookPages() {
		return this.paginate(this.relatedBooks, 4);
	},

	get currentRelatedBooks() {
		const pages = this.relatedBookPages;
		if (!pages.length) return [];
		const idx = Math.min(Math.max(0, Number(this.relatedPage) || 0), pages.length - 1);
		return pages[idx] || [];
	},

	startRelatedAutoRotate() {
		if (this._relatedTimer) {
			clearInterval(this._relatedTimer);
			this._relatedTimer = null;
		}

		const pages = this.relatedBookPages;
		if (!pages || pages.length <= 1) return;

		this._relatedTimer = setInterval(() => {
			const len = this.relatedBookPages.length;
			if (len <= 1) return;
			this.relatedPage = (Number(this.relatedPage) + 1) % len;
		}, 4500);
	},

	categoryListUrl(book) {
		const cat = String(book?.category ?? '').trim();
		if (!cat) return '/book';
		try {
			const url = new URL('/book', window.location.origin);
			url.searchParams.set('cat', `cat:${cat}`);
			return url.pathname + url.search;
		} catch {
			return '/book';
		}
	},

	addToCart(book, qty = 1) {
		if (book?.soldOut) return;
		const q = Math.max(1, Number(qty) || 1);
		this.$store.shop.addToCart(book, q);
	},
}));

Alpine.data('cartPage', () => ({
	showGiftModal: false,
	deliveryFee: 5000,

	get items() {
		return Array.isArray(this.$store.shop.cartItems) ? this.$store.shop.cartItems : [];
	},

	formatMoney(amount) {
		const n = Number(amount) || 0;
		return `${this.$store.shop.formatNumber(n)} ₮`;
	},

	lineTotal(item) {
		const qty = Math.max(1, Number(item?.qty) || 1);
		const unit = this.$store.shop.priceToNumber(item?.price);
		return qty * unit;
	},

	itemTotal(item) {
		return this.lineTotal(item);
	},

	get subtotal() {
		return this.items.reduce((sum, item) => sum + (Number(this.lineTotal(item)) || 0), 0);
	},

	get grandTotal() {
		if (!this.items.length) return 0;
		return (Number(this.subtotal) || 0) + (Number(this.deliveryFee) || 0);
	},

	setQty(key, value) {
		const k = String(key ?? '');
		if (!k) return;
		const qty = Math.max(1, Math.floor(Number(value) || 1));
		const idx = this.$store.shop.cartItems.findIndex((i) => i.key === k);
		if (idx < 0) return;
		this.$store.shop.cartItems[idx].qty = qty;
		this.$store.shop.cartItems = [...this.$store.shop.cartItems];
		this.$store.shop.saveCart();
	},

	remove(key) {
		this.$store.shop.removeFromCart(key);
	},

	clearCart() {
		this.$store.shop.cartItems = [];
		this.$store.shop.saveCart();
	},

	addGiftBundle() {
		this.$store.shop.addGiftBundle();
		this.showGiftModal = false;
	},
}));

Alpine.data('checkoutPage', () => ({
	showGiftModal: false,
	deliveryFee: 5000,

	get items() {
		return Array.isArray(this.$store.shop.cartItems) ? this.$store.shop.cartItems : [];
	},

	formatMoney(amount) {
		const n = Number(amount) || 0;
		return `${this.$store.shop.formatNumber(n)} ₮`;
	},

	lineTotal(item) {
		const qty = Math.max(1, Number(item?.qty) || 1);
		const unit = this.$store.shop.priceToNumber(item?.price);
		return qty * unit;
	},

	get subtotal() {
		return this.items.reduce((sum, item) => sum + (Number(this.lineTotal(item)) || 0), 0);
	},

	get grandTotal() {
		if (!this.items.length) return 0;
		return (Number(this.subtotal) || 0) + (Number(this.deliveryFee) || 0);
	},

	addGiftBundle() {
		this.$store.shop.addGiftBundle();
		this.showGiftModal = false;
	},
}));

Alpine.start();
