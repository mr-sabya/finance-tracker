<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header class="mb-4">
        <h2 class="h4 text-dark">
            {{ __('Update Password') }}
        </h2>
        <p class="text-muted">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit.prevent="updatePassword" class="mt-4">
        <!-- Current Password -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">
                {{ __('Current Password') }}
            </label>
            <input
                wire:model="current_password"
                type="password"
                id="update_password_current_password"
                name="current_password"
                class="form-control"
                autocomplete="current-password" />
            @error('current_password')
            <div class="text-danger mt-2">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">
                {{ __('New Password') }}
            </label>
            <input
                wire:model="password"
                type="password"
                id="update_password_password"
                name="password"
                class="form-control"
                autocomplete="new-password" />
            @error('password')
            <div class="text-danger mt-2">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">
                {{ __('Confirm Password') }}
            </label>
            <input
                wire:model="password_confirmation"
                type="password"
                id="update_password_password_confirmation"
                name="password_confirmation"
                class="form-control"
                autocomplete="new-password" />
            @error('password_confirmation')
            <div class="text-danger mt-2">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Save Button and Message -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if (session('password-updated'))
            <span class="text-success">
                {{ __('Saved.') }}
            </span>
            @endif
        </div>
    </form>
</section>