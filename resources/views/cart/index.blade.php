<x-layouts.store>
    <div class="mx-auto max-w-7xl px-6 py-12">
        <header class="mb-12">
            <h1 class="font-headline text-on-surface mb-2 text-4xl font-extrabold tracking-tight">Your Cart</h1>
            <p class="text-on-surface-variant font-body">Review your items before proceeding to checkout.</p>
        </header>

        @if ($products->isEmpty())
            <div class="bg-surface-container-low rounded-3xl border border-slate-200 py-20 text-center">
                <span class="material-symbols-outlined text-outline mb-4 text-6xl">shopping_cart</span>
                <h2 class="font-headline text-on-surface mb-2 text-xl font-bold">Your cart is empty</h2>
                <p class="text-on-surface-variant font-body mb-8">Looks like you haven't added anything to your cart yet.
                </p>
                <a
                    class="bg-primary font-headline hover:bg-primary-dim shadow-primary/20 inline-flex items-center rounded-2xl px-8 py-4 font-bold text-white shadow-lg transition-colors"
                    href="{{ route('home') }}"
                >
                    Start Shopping
                </a>
            </div>
        @else
            <div
                class="grid grid-cols-1 gap-12 lg:grid-cols-12"
                x-data="{
                    items: [
                        @foreach ($products as $product)
                                        {
                                            id: {{ $product->id }},
                                            price: {{ $product->price }},
                                            quantity: {{ $cart[$product->id] }},
                                            originalQuantity: {{ $cart[$product->id] }},
                                            updateUrl: '{{ route('cart.update', $product) }}'
                                        }, @endforeach
                    ],
                    get subtotal() {
                        return this.items.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                    },
                    get tax() {
                        return this.subtotal * 0.08; // Example 8% tax
                    }
                }"
            >

                <!-- Product List -->
                <div class="flex flex-col gap-4 lg:col-span-8">
                    @foreach ($products as $product)
                        <div
                            class="bg-surface-container-lowest group flex flex-col items-center gap-6 rounded-xl border border-transparent p-6 transition-all duration-300 hover:border-slate-200 md:flex-row"
                            x-data="{
                                item: null,
                                init() {
                                    this.item = this.items.find(i => i.id === {{ $product->id }});
                                }
                            }"
                        >
                            <div class="bg-surface-container-low h-24 w-24 shrink-0 overflow-hidden rounded-lg">
                                <img
                                    class="h-full w-full object-cover"
                                    src="{{ $product->image_url }}"
                                    alt="{{ $product->name }}"
                                />
                            </div>

                            <div class="flex-grow text-center md:text-left">
                                <h3 class="font-headline text-on-surface text-lg font-semibold">{{ $product->name }}
                                </h3>
                                <p
                                    class="text-primary mt-1 font-bold"
                                    x-text="'$' + (item?.price / 100).toFixed(2)"
                                ></p>
                            </div>

                            <div class="flex items-center gap-4">
                                <form
                                    class="flex flex-col items-center gap-2"
                                    :action="item?.updateUrl"
                                    method="POST"
                                    x-show="item"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <div class="bg-surface-container-low flex items-center rounded-full px-2 py-1">
                                        <button
                                            class="text-on-surface-variant hover:text-primary flex h-8 w-8 items-center justify-center transition-all active:scale-90"
                                            type="button"
                                            @click="if(item.quantity > 1) item.quantity--"
                                        >
                                            <span class="material-symbols-outlined text-[18px]">remove</span>
                                        </button>
                                        <input
                                            class="w-8 border-none bg-transparent p-0 text-center text-sm font-semibold focus:ring-0"
                                            name="quantity"
                                            type="number"
                                            x-model="item.quantity"
                                            readonly
                                        />
                                        <button
                                            class="text-on-surface-variant hover:text-primary flex h-8 w-8 items-center justify-center transition-all active:scale-90"
                                            type="button"
                                            @click="if(item.quantity < 99) item.quantity++"
                                        >
                                            <span class="material-symbols-outlined text-[18px]">add</span>
                                        </button>
                                    </div>
                                    <button
                                        class="text-primary text-[10px] font-bold uppercase tracking-tighter hover:underline"
                                        type="submit"
                                        x-show="item.quantity != item.originalQuantity"
                                    >
                                        Update
                                    </button>
                                </form>

                                <form
                                    action="{{ route('cart.remove', $product) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="text-outline-variant hover:text-error p-2 transition-colors"
                                        type="submit"
                                    >
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="lg:col-span-4">
                    <div
                        class="bg-surface-container-lowest sticky top-28 rounded-xl border border-slate-200 p-8 shadow-sm">
                        <h2 class="font-headline text-on-surface mb-6 text-xl font-bold">Order Summary</h2>
                        <div class="mb-8 space-y-4">
                            <div class="font-body flex items-center justify-between text-sm">
                                <span class="text-on-surface-variant">Subtotal</span>
                                <span
                                    class="text-on-surface font-medium"
                                    x-text="'$' + (subtotal / 100).toFixed(2)"
                                ></span>
                            </div>
                            <div class="font-body flex items-center justify-between text-sm">
                                <span class="text-on-surface-variant">Shipping</span>
                                <span class="text-xs font-bold uppercase tracking-wider text-green-600">Free</span>
                            </div>
                            <div class="font-body flex items-center justify-between text-sm">
                                <span class="text-on-surface-variant">Tax</span>
                                <span
                                    class="text-on-surface font-medium"
                                    x-text="'$' + (tax / 100).toFixed(2)"
                                ></span>
                            </div>
                            <div
                                class="border-surface-container-low mt-4 flex items-center justify-between border-t pt-4">
                                <span class="font-headline text-on-surface font-bold">Total</span>
                                <span
                                    class="font-headline text-primary text-xl font-extrabold"
                                    x-text="'$' + ((subtotal + tax) / 100).toFixed(2)"
                                ></span>
                            </div>
                        </div>

                        <form
                            action="{{ route('cart.checkout') }}"
                            method="POST"
                        >
                            @csrf
                            <button
                                class="from-primary to-primary-container font-headline shadow-primary/20 hover:shadow-primary/40 w-full rounded-xl bg-gradient-to-r px-6 py-4 font-bold text-white shadow-lg transition-all duration-200 active:scale-[0.98]"
                                type="submit"
                            >
                                Proceed to Checkout
                            </button>
                        </form>

                        <div
                            class="text-on-surface-variant mt-6 flex items-center justify-center gap-2 text-xs font-medium">
                            <span
                                class="material-symbols-outlined text-sm"
                                style="font-variation-settings: 'FILL' 1;"
                            >lock</span>
                            SECURE ENCRYPTED CHECKOUT
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.store>
