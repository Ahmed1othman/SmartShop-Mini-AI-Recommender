<div class="space-y-6">
    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <form
        class="space-y-6"
        wire:submit="register"
    >
        <div class="space-y-1.5">
            <label
                class="font-label text-on-surface-variant ml-1 text-xs font-medium uppercase tracking-wider"
                for="name"
            >Full Name</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined text-outline-variant absolute left-4 top-1/2 -translate-y-1/2 text-xl"
                >person</span>
                <input
                    class="bg-surface-container-low focus:ring-primary focus:bg-surface-container-lowest text-on-surface placeholder:text-outline-variant w-full rounded-lg border-none py-3.5 pl-12 pr-4 transition-all focus:ring-1"
                    id="name"
                    wire:model="name"
                    required
                    autofocus
                />
            </div>
            @error('name')
                <p class="text-error ml-1 mt-1 text-xs">{{ $message }}</p>
            @enderror
        </div>

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
                    wire:model="email"
                    required
                />
            </div>
            @error('email')
                <p class="text-error ml-1 mt-1 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label
                class="font-label text-on-surface-variant ml-1 text-xs font-medium uppercase tracking-wider"
                for="password"
            >Password</label>
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

        <div class="space-y-1.5">
            <label
                class="font-label text-on-surface-variant ml-1 text-xs font-medium uppercase tracking-wider"
                for="password_confirmation"
            >Confirm Password</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined text-outline-variant absolute left-4 top-1/2 -translate-y-1/2 text-xl"
                >lock_reset</span>
                <input
                    class="bg-surface-container-low focus:ring-primary focus:bg-surface-container-lowest text-on-surface placeholder:text-outline-variant w-full rounded-lg border-none py-3.5 pl-12 pr-4 transition-all focus:ring-1"
                    id="password_confirmation"
                    type="password"
                    wire:model="password_confirmation"
                    required
                />
            </div>
        </div>

        <button
            class="bg-primary hover:bg-primary-dim shadow-primary/20 group flex w-full items-center justify-center gap-2 rounded-xl py-4 font-semibold text-white shadow-lg transition-all active:scale-[0.98]"
            type="submit"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Create Account</span>
            <span wire:loading>Creating...</span>
            <span
                class="material-symbols-outlined text-xl transition-transform group-hover:translate-x-1">arrow_forward</span>
        </button>
    </form>

    <footer class="mt-12 text-center">
        <p class="text-on-surface-variant text-sm">
            Already have an account?
            <a
                class="text-primary ml-1 font-bold hover:underline"
                href="{{ route('login') }}"
                wire:navigate
            >Sign In instead</a>
        </p>
    </footer>
</div>
