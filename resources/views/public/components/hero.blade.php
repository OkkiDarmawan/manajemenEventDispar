<section
    x-data="{
        events: @js($events),
        current: 0,
        interval: null,

        formatDate(date) {
            return new Date(date).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        },

        startAutoPlay() {
            this.interval = setInterval(() => {
                this.next();
            }, 5000);
        },

        next() {
            this.current = (this.current + 1) % this.events.length;
        },

        prev() {
            this.current = (this.current - 1 + this.events.length) % this.events.length;
        },

        goTo(index) {
            this.current = index;
        },

        // Mengambil 3 event secara berurutan dan berputar (looping) berdasarkan index current
        get visibleEvents() {
            let list = [];
            let count = Math.min(3, this.events.length);
            for (let i = 0; i < count; i++) {
                let index = (this.current + i) % this.events.length;
                list.push({
                    event: this.events[index],
                    originalIndex: index
                });
            }
            return list;
        }
    }"
    x-init="startAutoPlay()"
    class="relative min-h-screen overflow-hidden bg-gray-900"
>

    {{-- ===================================================== --}}
    {{-- BACKGROUND EVENT --}}
    {{-- ===================================================== --}}
    <div class="absolute inset-0">
        <template
            x-for="(event, index) in events"
            :key="'bg-' + event.id"
        >
            <div
                x-show="current === index"
                x-transition:enter="transition-opacity duration-[1500ms] ease-in-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-[1500ms] ease-in-out"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0"
            >
                <img
                    :src="'/storage/' + event.poster"
                    :alt="event.nama_event"
                    class="w-full h-full object-cover scale-105"
                >
                <div
                    class="absolute inset-0
                           bg-gradient-to-r
                           from-black/80
                           via-black/55
                           to-black/30"
                ></div>
            </div>
        </template>
    </div>

    {{-- ===================================================== --}}
    {{-- CONTENT --}}
    {{-- ===================================================== --}}
    <div class="relative z-10 min-h-screen flex items-center">
        <div class="max-w-7xl w-full mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-center">

                {{-- ================================================= --}}
                {{-- EVENT UTAMA --}}
                {{-- ================================================= --}}
                <div class="lg:col-span-2">
                    <template
                        x-for="(event, index) in events"
                        :key="'content-' + event.id"
                    >
                        <div
                            x-show="current === index"
                            x-transition:enter="transition-all duration-[1200ms] ease-out"
                            x-transition:enter-start="opacity-0 translate-y-5"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="text-white"
                        >
                            {{-- Badge --}}
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 border border-white/20 backdrop-blur-md text-sm font-semibold"
                            >
                                <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                <span
                                    x-text="
                                        new Date(event.tanggal_mulai) > new Date()
                                            ? 'Coming Soon'
                                            : 'Event Aktif'
                                    "
                                ></span>
                            </span>

                            {{-- Judul --}}
                            <h1
                                class="mt-6 text-4xl md:text-6xl lg:text-7xl font-black leading-tight tracking-tight"
                                x-text="event.nama_event"
                            ></h1>

                            {{-- Deskripsi --}}
                            <p
                                class="mt-6 text-base md:text-lg text-gray-200 max-w-2xl leading-relaxed"
                                x-text="event.deskripsi"
                            ></p>

                            {{-- Tanggal --}}
                            <div class="mt-8 flex flex-wrap gap-3">
                                <div class="flex items-center gap-2 bg-white/10 border border-white/10 backdrop-blur-md px-5 py-3 rounded-xl">
                                    <span>📅</span>
                                    <span x-text="formatDate(event.tanggal_mulai)"></span>
                                </div>
                                <div class="flex items-center gap-2 bg-white/10 border border-white/10 backdrop-blur-md px-5 py-3 rounded-xl">
                                    <span class="text-gray-300">Sampai</span>
                                    <span x-text="formatDate(event.tanggal_selesai)"></span>
                                </div>
                            </div>

                            {{-- Button --}}
                            <a
                                :href="'/event/' + event.id"
                                class="inline-flex items-center gap-2 mt-10 px-7 py-4 rounded-xl bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-600/30 transition duration-300 text-lg font-semibold"
                            >
                                Lihat Event
                                <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                            </a>
                        </div>
                    </template>
                </div>

                {{-- ================================================= --}}
                {{-- CARD EVENT (Maksimal 3 Tampil dan Bergantian) --}}
                {{-- ================================================= --}}
                <div class="hidden lg:block">
                    <div class="space-y-4">
                        <template
                            x-for="item in visibleEvents"
                            :key="'card-' + item.event.id"
                        >
                            <button
                                type="button"
                                @click="goTo(item.originalIndex)"
                                class="w-full overflow-hidden rounded-2xl text-left border transition-all duration-500"
                                :class="
                                    current === item.originalIndex
                                        ? 'border-white/40 bg-white/20 scale-[1.02] shadow-2xl'
                                        : 'border-white/10 bg-black/20 hover:bg-white/10'
                                "
                            >
                                <div class="flex">
                                    {{-- Thumbnail --}}
                                    <div class="w-28 h-28 flex-shrink-0 overflow-hidden">
                                        <img
                                            :src="'/storage/' + item.event.poster"
                                            :alt="item.event.nama_event"
                                            class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                                        >
                                    </div>

                                    {{-- Content --}}
                                    <div class="p-4 flex-1">
                                        <p
                                            class="text-xs font-semibold text-blue-300"
                                            x-text="
                                                new Date(item.event.tanggal_mulai) > new Date()
                                                    ? 'COMING SOON'
                                                    : 'EVENT AKTIF'
                                            "
                                        ></p>
                                        <h3
                                            class="mt-1 text-sm font-bold text-white line-clamp-2"
                                            x-text="item.event.nama_event"
                                        ></h3>
                                        <p
                                            class="mt-2 text-xs text-gray-300"
                                            x-text="formatDate(item.event.tanggal_mulai)"
                                        ></p>
                                    </div>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

            </div>
        </div>

        {{-- ================================================= --}}
        {{-- NAVIGATION --}}
        {{-- ================================================= --}}
        <button
            type="button"
            @click="prev()"
            class="absolute left-5 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/20 hover:bg-black/40 border border-white/10 backdrop-blur-md text-white text-2xl transition duration-300"
        >
            ‹
        </button>

        <button
            type="button"
            @click="next()"
            class="absolute right-5 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/20 hover:bg-black/40 border border-white/10 backdrop-blur-md text-white text-2xl transition duration-300"
        >
            ›
        </button>

        {{-- ================================================= --}}
        {{-- INDICATOR --}}
        {{-- ================================================= --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-2">
            <template
                x-for="(event, index) in events"
                :key="'dot-' + event.id"
            >
                <button
                    type="button"
                    @click="goTo(index)"
                    class="transition-all duration-500 rounded-full"
                    :class="
                        current === index
                            ? 'w-8 h-2 bg-white'
                            : 'w-2 h-2 bg-white/40'
                    "
                ></button>
            </template>
        </div>

    </div>
</section>