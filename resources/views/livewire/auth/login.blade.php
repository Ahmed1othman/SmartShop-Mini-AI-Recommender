<div class="space-y-6">
    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <form
        class="space-y-6"
        wire:submit="login"
    >
        <div class="space-y-1.5">
            <label
                class="font-label text-on-surface-variant ml-1 text-xs font-medium uppercase tracking-wider"
                for="email"
            >Email Address</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined text-outline-variant absolute left-4 top-1/2 -translate-y-1/2 text-xl"
                >mail</span>
                <input
                    class="bg-surface-container-low focus:ring-primary focus:bg-surface-container-lowest text-on-surface placeholder:text-outline-variant w-full rounded-lg border-none py-3.5 pl-12 pr-4 transition-all focus:ring-1"
                    id="email"
                    name="email"
                    type="email"
                    wire:model.live="email"
                    placeholder="alex@atelier.com"
                    required
                    autofocus
                />
            </div>
            @error('email')
                <p class="text-error ml-1 mt-1 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <div class="flex items-center justify-between px-1">
                <label
                    class="font-label text-on-surface-variant text-xs font-medium uppercase tracking-wider"
                    for="password"
                >Password</label>
                @if (Route::has('password.request'))
                    <a
                        class="text-primary text-xs font-medium hover:underline"
                        href="{{ route('password.request') }}"
                        wire:navigate
                    >Forgot?</a>
                @endif
            </div>
            <div
                class="relative"
                x-data="{ show: false }"
            >
                <span
                    class="material-symbols-outlined text-outline-variant absolute left-4 top-1/2 -translate-y-1/2 text-xl"
                >lock</span>
                <input
                    class="bg-surface-container-low focus:ring-primary focus:bg-surface-container-lowest text-on-surface placeholder:text-outline-variant w-full rounded-lg border-none py-3.5 pl-12 pr-4 transition-all focus:ring-1"
                    id="password"
                    :type="show ? 'text' : 'password'"
                    wire:model="password"
                    required
                />
                <button
                    class="text-outline-variant hover:text-on-surface absolute right-4 top-1/2 -translate-y-1/2 transition-colors"
                    type="button"
                    @click="show = !show"
                >
                    <span
                        class="material-symbols-outlined text-xl"
                        x-text="show ? 'visibility_off' : 'visibility'"
                    >visibility</span>
                </button>
            </div>
            @error('password')
                <p class="text-error ml-1 mt-1 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3 py-1">
            <input
                class="text-primary focus:ring-primary/20 bg-surface-container-low h-4 w-4 rounded border-none"
                id="remember"
                type="checkbox"
                wire:model="remember"
            />
            <label
                class="text-on-surface-variant select-none text-sm font-medium"
                for="remember"
            >Remember me for 30 days</label>
        </div>

        <button
            class="bg-primary hover:bg-primary-dim shadow-primary/20 group flex w-full items-center justify-center gap-2 rounded-xl py-4 font-semibold text-white shadow-lg transition-all active:scale-[0.98]"
            type="submit"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Sign In</span>
            <span wire:loading>Signing in...</span>
            <span
                class="material-symbols-outlined text-xl transition-transform group-hover:translate-x-1">arrow_forward</span>
        </button>
    </form>

    <div class="relative my-10">
        <div class="absolute inset-0 flex items-center">
            <div class="border-surface-container-high w-full border-t"></div>
        </div>
        <div class="relative flex justify-center text-xs font-bold uppercase tracking-widest">
            <span class="bg-surface-container-lowest text-outline-variant px-4">Or continue with</span>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <button
            class="bg-surface-container-low hover:bg-surface-container-high flex items-center justify-center gap-2 rounded-lg px-4 py-3 transition-colors active:scale-95"
        >
            <img
                class="h-5 w-5"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBrjrxAyOYWSIFgB9UFoRorskHBc4T6tknNkS_pfOSloRBrlkt6ESYzI9j2O5nMz4tWB_FvX3vh51qDbg0eo-AmRq7REP1TcWgrDYR5thhzAUVgkyZb4-FX7uF2q5TabxfZHZFXUytjCRegkLxX9DGc1V7xQxy1cLIKjNbuZzLAIUZJQbMeOxLmPdEVN8s1bpzGI_NMOfRR7-GKvyzKBF6JC1sitOiq9xcg1CdAsMBdeaDrCCOVrYqglOk5myGEySMCOJ8wyX7k7Ywt"
                alt="Google"
            />
            <span class="text-on-surface text-sm font-semibold">Google</span>
        </button>
        <button
            class="bg-surface-container-low hover:bg-surface-container-high flex items-center justify-center gap-2 rounded-lg px-4 py-3 transition-colors active:scale-95"
        >
            <img
                class="h-5 w-5"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkGGpyhI_-kzR0dmdH_rdFrfuB-c31ln69Smf_bIFnU9e-wG7WTTYAEpTVGzoxX7TKgrKdiSxJHuPNS8krmsNMJZw9Bz9pIjkXtjjq9fKsrCF-iG50tNUHAQJhxZeOhWgqXjPBYKxnNb-rEgn5DNG76yTiSPknHkBZiu33LMqvjVTzqFkk4L9fgFwcNSVuyMv7tRGE7GyuxJrsLxo5DiVjefHZLqkul_XYRIjTvJNS7uNXy6D1CvEHW8m-d0AhKl6P7DfdFmWeu3EL"
                alt="Apple"
            />
            <span class="text-on-surface text-sm font-semibold">Apple</span>
        </button>
    </div>

    <footer class="mt-12 text-center">
        <p class="text-on-surface-variant text-sm">
            Don't have an account?
            <a
                class="text-primary ml-1 font-bold hover:underline"
                href="{{ route('register') }}"
                wire:navigate
            >Create an Account</a>
        </p>
    </footer>
</div>
