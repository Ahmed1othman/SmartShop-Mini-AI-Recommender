<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth.split', ['title' => 'Create account', 'description' => 'Join our boutique community today.'])]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Initialize the component.
     */
    public function mount(): void
    {
        if (! session()->has('url.intended') && url()->previous() !== url()->current()) {
            session()->put('url.intended', url()->previous());
        }
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        /** @var array{name: string, email: string, password: string} */
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(default: route('home'), navigate: true);
    }
}
