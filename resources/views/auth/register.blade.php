@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <img src="{{ asset('build/assets/logo.jpg') }}" alt="Epoch Logo" class="w-10 h-10 rounded-xl object-cover shadow-md">
                <span class="text-2xl font-bold gradient-text">Epoch</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 mt-6 mb-1">Create your account</h1>
            <p class="text-gray-500 text-sm">Join thousands of users booking appointments daily</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            @include('partials._flash')

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                               class="w-full pl-10 pr-4 py-3 border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                               placeholder="Dr. Priya Sharma">
                    </div>
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-10 pr-4 py-3 border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                               placeholder="you@example.com">
                    </div>
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1.5">Phone (optional)</label>
                    <div class="relative">
                        <i data-lucide="phone" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                               placeholder="+91-9876543210">
                    </div>
                </div>

                <!-- Role selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">I am a...</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="user" {{ old('role', 'user') === 'user' ? 'checked' : '' }} class="sr-only peer">
                            <div class="p-3 border-2 border-gray-200 rounded-xl peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all text-center hover:border-indigo-300">
                                <i data-lucide="user" class="w-5 h-5 mx-auto mb-1 text-gray-500 peer-checked:text-indigo-600"></i>
                                <p class="text-sm font-semibold text-gray-700">Patient / Client</p>
                                <p class="text-xs text-gray-400">Book appointments</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="professional" {{ old('role') === 'professional' ? 'checked' : '' }} class="sr-only peer">
                            <div class="p-3 border-2 border-gray-200 rounded-xl peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all text-center hover:border-indigo-300">
                                <i data-lucide="briefcase" class="w-5 h-5 mx-auto mb-1 text-gray-500"></i>
                                <p class="text-sm font-semibold text-gray-700">Professional</p>
                                <p class="text-xs text-gray-400">Accept bookings</p>
                            </div>
                        </label>
                    </div>
                    @error('role') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div x-data="{ showPw: false }">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input id="password" :type="showPw ? 'text' : 'password'" name="password" required
                               class="w-full pl-10 pr-12 py-3 border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                               placeholder="Min 8 characters">
                        <button type="button" @click="showPw = !showPw" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i data-lucide="eye" class="w-4 h-4" x-show="!showPw"></i>
                            <i data-lucide="eye-off" class="w-4 h-4" x-show="showPw" x-cloak></i>
                        </button>
                    </div>
                    @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                               placeholder="Re-enter password">
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    Create Account
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
