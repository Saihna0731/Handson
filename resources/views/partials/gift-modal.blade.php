<div
    x-show="showGiftModal"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    @click.self="showGiftModal = false"
>
    <div class="mx-auto w-full max-w-3xl overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-slate-900/5 font-sans">
    
        <div class="flex items-center justify-between border-b border-slate-100 p-5">
            <h3 class="text-lg font-medium text-slate-700">Бэлгийн багц - 59,900 төгрөг</h3>
            
            <button class="text-slate-400 hover:text-slate-600 transition-colors" @click="showGiftModal = false" aria-label="Close gift modal">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6 scroll-py-4 max-h-[80vh] overflow-y-auto">
            
            <button class="mb-5 inline-block rounded border border-[#62ab00] px-8 py-2.5 text-sm font-semibold text-[#62ab00] transition-colors hover:bg-[#62ab00] hover:text-white uppercase tracking-wide"

                @click="addGiftBundle();showGiftModal = false"

                >

                Бэлгийн багц авах
            </button>

            <div class="space-y-2 text-sm text-slate-600 leading-relaxed">
                <p><span class="font-medium text-slate-800">Бэлгийн багц:</span></p>
                <ul class="list-none space-y-1">
                    <li>• Legaldata тоте тор</li>
                    <li>• Feinherb noir 80% хар шоколад</li>
                    <li>• Халуунаа барьдаг ган усны сав 450 мл + дуртай номоо нэмж худалдан аваад бэлгийн багцаа баяжуулах боломжтой.</li>
                </ul>
                <p class="mt-3 text-xs text-slate-500 italic">
                    Та бэлгийн багцыг өөрийн хаягаар биш бэлэг хүлээн авагчийн хаягаар хүргүүлэх бол Хүргүүлэх хаяг хэсэгт бэлэг хүлээн авагчийн мэдээллийг үнэн зөв оруулахыг анхаарна уу.
                </p>
            </div>

            <div class="mt-6 w-full overflow-hidden rounded-lg bg-slate-100 relative">
                <img 
                    src="{{ route('legaldata.image', ['u' => 'https://legaldata.mn/storage/pictures/1676/bagts-legal-site.jpg']) }}" 
                    alt="Бэлгийн багц Legaldata" 
                    class="w-full h-auto object-cover"
                >
                
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/40 text-center p-4">
                    <h2 class="text-3xl font-bold text-white drop-shadow-md mb-2">Бэлгийн багц #1</h2>
                    <div class="bg-white/90 text-slate-900 px-4 py-1 rounded-full text-lg font-bold shadow-lg">
                        59.900₮
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
