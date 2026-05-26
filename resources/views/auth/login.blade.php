@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <img src="{{ asset('build/assets/logo.jpg') }}" alt="Epoch Logo" class="w-10 h-10 rounded-xl object-cover shadow-md">
                <span class="text-2xl font-bold gradient-text">Epoch</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 mt-6 mb-1">Welcome back</h1>
            <p class="text-gray-500 text-sm">Sign in to manage your appointments</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            @include('partials._flash')

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                               class="w-full pl-10 pr-4 py-3 border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                               placeholder="you@example.com">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative" x-data="{ showPw: false }">
                        <i data-lucide="lock" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input id="password" :type="showPw ? 'text' : 'password'" name="password" required autocomplete="current-password"
                               class="w-full pl-10 pr-12 py-3 border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                               placeholder="Your password">
                        <button type="button" @click="showPw = !showPw"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i data-lucide="eye" class="w-4 h-4" x-show="!showPw"></i>
                            <i data-lucide="eye-off" class="w-4 h-4" x-show="showPw" x-cloak></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded text-indigo-600 border-gray-300">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <button type="submit" id="login-btn"
                        class="w-full py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Sign In
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
                        Sign up free
                    </a>
                </p>
            </div>


        </div>
    </div>
</div>
@endsection
