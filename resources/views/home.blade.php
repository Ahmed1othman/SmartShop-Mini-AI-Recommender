<x-layouts.store>
    <script>
        window.productsData = {!! Illuminate\Support\Js::from(
            $products->map(
                fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'price' => $p->price,
                    'image' => $p->image_url,
                    'showUrl' => route('products.show', $p->slug),
                    'addUrl' => route('cart.add', $p),
                ],
            ),
        ) !!};
    </script>
    <section x-data="{
        search: '',
        products: window.productsData,
        get filteredProducts() {
            if (!this.search) return this.products;
            return this.products.filter(p => p.name.toLowerCase().includes(this.search.toLowerCase()));
        }
    }">
        {{-- Hero Section --}}
        <div class="mx-auto max-w-7xl px-6 py-16 text-center">
            <div
                class="bg-surface-container-low relative flex flex-col items-center overflow-hidden rounded-xl p-12 md:p-24">
                <div class="pointer-events-none absolute inset-0 opacity-10">
                    <div
                        class="absolute left-0 top-0 h-full w-full"
                        style="background-image: radial-gradient(circle at 2px 2px, #4a4bd7 1px, transparent 0); background-size: 40px 40px;"
                    ></div>
                </div>
                <h1
                    class="font-headline text-on-surface mb-6 max-w-2xl text-4xl font-extrabold leading-tight tracking-tight md:text-6xl">
                    Smart shopping powered by AI
                </h1>
                <div class="group relative w-full max-w-xl">
                    <span
                        class="material-symbols-outlined text-outline absolute left-4 top-1/2 -translate-y-1/2">search</span>
                    <input
                        class="bg-surface-container-lowest focus:ring-primary w-full rounded-xl border-none py-4 pl-12 pr-6 text-lg shadow-sm transition-all duration-300 focus:ring-2"
                        type="text"
                        x-model.trim="search"
                        placeholder="Search for products..."
                    />
                </div>
            </div>
        </div>

        <!-- Recommended Section (Always visible if exists, unaffected by local search per typical store UX, or I can filter it too. Requirement didn't specify. I'll leave it as is for UX clarity or filter it if I want to be 100% Alpine. The requirement said "search functionality" must use Alpine.) -->
        @if ($recommendedProducts->isNotEmpty())
            <div class="mx-auto mb-20 max-w-7xl px-6">
                <div class="mb-8 flex items-end justify-between">
                    <div>
                        <span
                            class="text-primary font-headline mb-2 block text-xs font-semibold uppercase tracking-widest"
                        >Curated for you</span>
                        <h2 class="font-headline text-on-surface text-3xl font-bold">Recommended for you</h2>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    @foreach ($recommendedProducts as $recommended)
                        <div class="group block cursor-pointer">
                            <a href="{{ route('products.show', $recommended->slug) }}">
                                <div
                                    class="bg-surface-container-high mb-4 aspect-[4/5] overflow-hidden rounded-xl transition-transform duration-500 group-hover:scale-[1.02]">
                                    <img
                                        class="h-full w-full object-cover"
                                        src="{{ $recommended->image_url }}"
                                        alt="{{ $recommended->name }}"
                                    />
                                </div>
                                <h3
                                    class="font-headline text-on-surface group-hover:text-primary text-lg font-bold transition-colors">
                                    {{ $recommended->name }}</h3>
                                <p class="text-on-surface-variant font-medium">
                                    ${{ number_format($recommended->price / 100, 2) }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Product Grid -->
        <div class="mx-auto max-w-7xl px-6 pb-20">
            <h2 class="font-headline text-on-surface mb-10 text-2xl font-bold">Discover More</h2>

            <div class="grid grid-cols-2 gap-x-6 gap-y-12 md:grid-cols-4">
                <template
                    x-for="product in filteredProducts"
                    :key="product.id"
                >
                    <div class="group cursor-pointer">
                        <div class="block">
                            <a :href="product.showUrl">
                                <div
                                    class="bg-surface-container-low group-hover:shadow-primary/5 mb-4 aspect-square overflow-hidden rounded-xl transition-all duration-300 group-hover:shadow-xl">
                                    <img
                                        class="h-full w-full object-cover"
                                        :alt="product.name"
                                        :src="product.image"
                                    />
                                </div>
                                <h3
                                    class="font-headline text-on-surface truncate text-base font-semibold"
                                    x-text="product.name"
                                ></h3>
                            </a>
                            <div class="mt-1 flex items-center justify-between">
                                <p
                                    class="text-on-surface-variant font-medium"
                                    x-text="'$' + (product.price / 100).toFixed(2)"
                                ></p>
                                <form
                                    :action="product.addUrl"
                                    method="POST"
                                >
                                    @csrf
                                    <button
                                        class="text-primary hover:text-primary-dim p-1 transition-colors"
                                        type="submit"
                                    >
                                        <span class="material-symbols-outlined">add_shopping_cart</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div
                class="text-on-surface-variant py-20 text-center"
                x-show="filteredProducts.length === 0"
            >
                No products found matching "<span x-text="search"></span>"
            </div>
        </div>
    </section>
</x-layouts.store>
