<x-layouts.store>
    <div class="mx-auto max-w-6xl px-6 py-12">
        {{-- Breadcrumbs / Back button --}}
        <div class="mb-8">
            <a
                class="hover:text-primary inline-flex items-center gap-2 font-medium text-slate-600 transition-colors"
                href="{{ route('home') }}"
            >
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to Store
            </a>
        </div>

        <div class="grid grid-cols-1 items-start gap-12 md:grid-cols-2">
            {{-- Product Image --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl">
                <img
                    class="aspect-square w-full object-cover"
                    src="{{ $product->image_url }}"
                    alt="{{ $product->name }}"
                >
            </div>

            {{-- Product Info --}}
            <div class="space-y-8">
                <div class="space-y-4">
                    <span
                        class="bg-primary/10 text-primary font-headline inline-block rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest"
                    >Premium Product</span>
                    <h1 class="font-headline text-on-surface text-4xl font-extrabold leading-tight">{{ $product->name }}
                    </h1>
                    <p class="font-headline text-primary text-3xl font-bold">
                        ${{ number_format($product->price / 100, 2) }}
                    </p>
                </div>

                <div class="space-y-4">
                    <h2 class="font-headline text-on-surface text-lg font-bold">Description</h2>
                    <p class="text-on-surface-variant font-body text-lg leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <div
                    class="border-t border-slate-100 pt-8"
                    x-data="{ quantity: 1 }"
                >
                    <form
                        class="space-y-6"
                        action="{{ route('cart.add', $product) }}"
                        method="POST"
                    >
                        @csrf
                        <div class="flex flex-col gap-3">
                            <label
                                class="font-headline text-on-surface-variant text-sm font-bold uppercase tracking-wider"
                            >Select Quantity</label>
                            <div
                                class="bg-surface-container-low flex w-fit items-center rounded-2xl border border-slate-200 p-1">
                                <button
                                    class="text-on-surface-variant hover:text-primary flex h-12 w-12 items-center justify-center transition-all active:scale-90"
                                    type="button"
                                    @click="if(quantity > 1) quantity--"
                                >
                                    <span class="material-symbols-outlined">remove</span>
                                </button>
                                <input
                                    class="w-16 border-none bg-transparent p-0 text-center text-lg font-bold focus:ring-0"
                                    name="quantity"
                                    type="number"
                                    x-model="quantity"
                                    readonly
                                />
                                <button
                                    class="text-on-surface-variant hover:text-primary flex h-12 w-12 items-center justify-center transition-all active:scale-90"
                                    type="button"
                                    @click="if(quantity < 99) quantity++"
                                >
                                    <span class="material-symbols-outlined">add</span>
                                </button>
                            </div>
                        </div>

                        <button
                            class="bg-primary hover:bg-primary-dim font-headline shadow-primary/20 flex w-full items-center justify-center gap-3 rounded-2xl py-5 font-bold text-white shadow-lg transition-all active:scale-[0.98]"
                            type="submit"
                        >
                            <span class="material-symbols-outlined">shopping_cart</span>
                            Add to Cart
                        </button>
                    </form>
                </div>

                {{-- Trust Badges --}}
                <div class="grid grid-cols-3 gap-4 pt-8">
                    <div class="bg-surface-container-low rounded-xl p-4 text-center">
                        <span class="material-symbols-outlined text-outline mb-2">local_shipping</span>
                        <p class="text-on-surface-variant font-headline text-xs font-semibold">Free Shipping</p>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-4 text-center">
                        <span class="material-symbols-outlined text-outline mb-2">verified_user</span>
                        <p class="text-on-surface-variant font-headline text-xs font-semibold">2yr Warranty</p>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-4 text-center">
                        <span class="material-symbols-outlined text-outline mb-2">history</span>
                        <p class="text-on-surface-variant font-headline text-xs font-semibold">30 Day Return</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.store>
