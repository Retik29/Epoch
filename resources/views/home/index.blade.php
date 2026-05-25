@extends('layouts.app')

@section('title', 'Epoch — Book Appointments Online')
@section('meta_description', 'Book appointments with top doctors, tutors, lawyers, and consultants. Epoch makes professional appointment booking fast and easy.')

@section('content')

{{-- Hero Section --}}
<section class="relative bg-gradient-to-br from-indigo-900 via-purple-900 to-gray-900 text-white overflow-hidden">
    <!-- Background blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-500 rounded-full opacity-20 blur-3xl animate-pulse"></div>
        <div class="absolute top-20 right-0 w-80 h-80 bg-purple-500 rounded-full opacity-20 blur-3xl animate-pulse" style="animation-delay:1s"></div>
        <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-pink-500 rounded-full opacity-10 blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 text-sm font-medium mb-6 animate-fade-in">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                Trusted by 10,000+ patients & clients
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold mb-6 leading-tight animate-slide-up">
                Book Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300">Perfect</span><br>Appointment
            </h1>

            <p class="text-lg sm:text-xl text-indigo-200 mb-10 max-w-2xl mx-auto leading-relaxed animate-fade-in">
                Connect with top-rated doctors, tutors, lawyers, and consultants. Choose your time, book in seconds.
            </p>

            <!-- Search -->
            <form action="{{ route('professionals.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 max-w-2xl mx-auto mb-10 animate-fade-in">
                <div class="flex-1 relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                    <input type="text" name="search" placeholder="Search doctors, tutors, lawyers..."
                           class="w-full pl-12 pr-4 py-4 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-indigo-300 focus:outline-none focus:ring-2 focus:ring-white/40 focus:bg-white/15 transition-all"
                           value="{{ request('search') }}">
                </div>
                <button type="submit" class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-xl hover:bg-indigo-50 shadow-lg hover:shadow-xl transition-all duration-200 whitespace-nowrap">
                    Find Now
                </button>
            </form>

            <!-- Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl mx-auto">
                @foreach([
                    ['icon' => 'users', 'val' => $stats['professionals'] . '+', 'label' => 'Professionals'],
                    ['icon' => 'grid', 'val' => $stats['categories'] . '+', 'label' => 'Specialties'],
                    ['icon' => 'calendar', 'val' => $stats['appointments'] . '+', 'label' => 'Appointments'],
                    ['icon' => 'smile', 'val' => $stats['users'] . '+', 'label' => 'Happy Clients'],
                ] as $stat)
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-3 text-center">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 mx-auto mb-1 text-indigo-300"></i>
                        <p class="text-2xl font-bold text-white">{{ $stat['val'] }}</p>
                        <p class="text-xs text-indigo-300">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Wave divider -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-20">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#f9fafb"/>
        </svg>
    </div>
</section>

{{-- Categories Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Browse by Specialty</h2>
        <p class="text-gray-500">Choose from our wide range of professional categories</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categories as $category)
            <a href="{{ route('professionals.index', ['category' => $category->slug]) }}"
               class="group bg-white rounded-2xl p-5 text-center border border-gray-100 hover:border-indigo-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 shadow-sm">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform"
                     style="background-color: {{ $category->color }}20;">
                    <i data-lucide="{{ $category->icon }}" class="w-6 h-6" style="color: {{ $category->color }}"></i>
                </div>
                <h3 class="text-sm font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $category->name }}</h3>
                <p class="text-xs text-gray-400 mt-1">{{ $category->professionals_count }} pros</p>
            </a>
        @endforeach
    </div>
</section>

{{-- Featured Professionals --}}
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-1">Top Rated Professionals</h2>
                <p class="text-gray-500">Highly rated by our community</p>
            </div>
            <a href="{{ route('professionals.index') }}" class="hidden sm:flex items-center gap-2 text-indigo-600 font-semibold hover:gap-3 transition-all text-sm">
                View All <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProfessionals as $professional)
                <div class="group bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 shadow-sm">
                    <div class="relative">
                        <a href="{{ route('professionals.show', $professional) }}" class="block overflow-hidden">
                            <img src="{{ $professional->photo_url }}" alt="{{ $professional->user->name }}"
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        </a>
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm rounded-full px-2 py-1 flex items-center gap-1 shadow-sm">
                            <i data-lucide="star" class="w-3 h-3 text-amber-400 fill-amber-400"></i>
                            <span class="text-xs font-bold text-gray-700">{{ $professional->rating }}</span>
                        </div>
                        <div class="absolute top-3 left-3">
                            <span class="text-xs font-medium px-2 py-1 rounded-full text-white shadow-sm"
                                  style="background-color: {{ $professional->category->color }}">
                                {{ $professional->category->name }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <a href="{{ route('professionals.show', $professional) }}" class="hover:underline">
                            <h3 class="font-bold text-gray-900 text-base group-hover:text-indigo-600 transition-colors">{{ $professional->user->name }}</h3>
                        </a>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1">
                            <i data-lucide="map-pin" class="w-3 h-3"></i>
                            {{ $professional->location }}
                        </div>
                        <div class="flex items-center gap-1 mt-1 text-xs text-gray-500">
                            <i data-lucide="briefcase" class="w-3 h-3"></i>
                            {{ $professional->experience_years }} yrs exp · {{ $professional->total_reviews }} reviews
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-indigo-600 font-bold">₹{{ number_format($professional->consultation_fee) }}<span class="text-xs text-gray-400 font-normal">/session</span></span>
                            <a href="{{ route('professionals.show', $professional) }}"
                               class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('professionals.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                View All Professionals <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

{{-- How It Works --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">How It Works</h2>
        <p class="text-gray-500">Book your appointment in 3 simple steps</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach([
            ['step'=>'1','icon'=>'search','title'=>'Find a Professional','desc'=>'Browse verified professionals by specialty, location, and availability.','color'=>'indigo'],
            ['step'=>'2','icon'=>'calendar-plus','title'=>'Choose a Time Slot','desc'=>'View real-time availability and pick the perfect date & time.','color'=>'purple'],
            ['step'=>'3','icon'=>'check-circle','title'=>'Confirm & Connect','desc'=>'Get instant confirmation and connect with your professional.','color'=>'green'],
        ] as $step)
            <div class="relative text-center group">
                @if(!$loop->last)
                    <div class="hidden md:block absolute top-8 left-1/2 w-full h-px bg-gradient-to-r from-gray-200 to-transparent z-0"></div>
                @endif
                <div class="relative z-10 inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-{{ $step['color'] }}-100 mx-auto mb-4 group-hover:scale-110 transition-transform shadow-sm">
                    <i data-lucide="{{ $step['icon'] }}" class="w-8 h-8 text-{{ $step['color'] }}-600"></i>
                    <span class="absolute -top-2 -right-2 w-6 h-6 bg-{{ $step['color'] }}-600 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $step['step'] }}</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- CTA Section --}}
@guest
<section class="bg-gradient-to-r from-indigo-600 to-purple-700 py-16 mx-4 sm:mx-8 lg:mx-16 rounded-3xl mb-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/10 bg-[size:30px_30px]"></div>
    <div class="relative text-center max-w-2xl mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-white mb-4">Ready to get started?</h2>
        <p class="text-indigo-200 mb-8">Join thousands of users who book appointments daily on Epoch.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-xl hover:bg-indigo-50 shadow-lg hover:shadow-xl transition-all">
                Create Free Account
            </a>
            <a href="{{ route('professionals.index') }}" class="px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white/10 transition-all">
                Browse Professionals
            </a>
        </div>
    </div>
</section>
@endguest

{{-- Contact Section --}}
<section id="contact" class="relative bg-gradient-to-br from-gray-900 via-indigo-950 to-gray-900 py-24 overflow-hidden">

    {{-- Decorative blobs --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-600 rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-purple-600 rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-900 rounded-full opacity-20 blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-2 bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                Get In Touch
            </span>
            <h2 class="text-4xl sm:text-5xl font-extrabold text-white mb-4">
                We'd love to <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">hear from you</span>
            </h2>
            <p class="text-gray-400 max-w-xl mx-auto text-base leading-relaxed">
                Have a question, suggestion, or need support? Drop us a message and we'll get back to you as soon as possible.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-start">

            {{-- Left Info Column --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Info Cards --}}
                @foreach([
                    ['icon' => 'mail', 'color' => 'indigo', 'title' => 'Email Us', 'value' => 'ritiknyadavofficial614@gmail.com', 'sub' => 'We reply within 24 hours'],
                    ['icon' => 'map-pin', 'color' => 'purple', 'title' => 'Location', 'value' => 'India', 'sub' => 'Serving clients nationwide'],
                    ['icon' => 'clock', 'color' => 'pink', 'title' => 'Support Hours', 'value' => 'Mon – Fri, 9am – 6pm', 'sub' => 'IST (Indian Standard Time)'],
                ] as $info)
                <div class="flex items-start gap-4 bg-white/5 border border-white/10 rounded-2xl p-5 hover:bg-white/10 transition-colors duration-300">
                    <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-{{ $info['color'] }}-500/20 flex items-center justify-center">
                        <i data-lucide="{{ $info['icon'] }}" class="w-5 h-5 text-{{ $info['color'] }}-400"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">{{ $info['title'] }}</p>
                        <p class="text-white font-semibold text-sm leading-snug">{{ $info['value'] }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ $info['sub'] }}</p>
                    </div>
                </div>
                @endforeach

                {{-- Social Links --}}
                <div class="pt-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Connect with us</p>
                    <div class="flex gap-3">
                        @foreach([
                            ['icon' => 'github', 'href' => '#', 'label' => 'GitHub'],
                            ['icon' => 'twitter', 'href' => '#', 'label' => 'Twitter'],
                            ['icon' => 'linkedin', 'href' => '#', 'label' => 'LinkedIn'],
                        ] as $social)
                        <a href="{{ $social['href'] }}" aria-label="{{ $social['label'] }}"
                           class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-indigo-400 hover:border-indigo-500/50 hover:bg-indigo-500/10 transition-all duration-200">
                            <i data-lucide="{{ $social['icon'] }}" class="w-4 h-4"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: Contact Form --}}
            <div class="lg:col-span-3">
                <div class="bg-white/5 border border-white/10 rounded-3xl p-8 backdrop-blur-sm">

                    {{-- Success Message --}}
                    @if(session('contact_success'))
                    <div class="flex items-start gap-3 bg-green-500/15 border border-green-500/30 text-green-300 rounded-2xl p-4 mb-6">
                        <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-sm">Message sent successfully!</p>
                            <p class="text-xs text-green-400 mt-0.5">Thanks {{ session('contact_name') }}, we'll get back to you shortly.</p>
                        </div>
                    </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->any())
                    <div class="flex items-start gap-3 bg-red-500/15 border border-red-500/30 text-red-300 rounded-2xl p-4 mb-6">
                        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                        <ul class="text-xs space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-5" id="contact-form">
                        @csrf

                        {{-- Name + Email Row --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="contact_name" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Your Name</label>
                                <div class="relative">
                                    <i data-lucide="user" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                                    <input type="text" id="contact_name" name="name" required
                                           value="{{ old('name') }}"
                                           placeholder="Ritik Yadav"
                                           class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            <div>
                                <label for="contact_email" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                                <div class="relative">
                                    <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                                    <input type="email" id="contact_email" name="email" required
                                           value="{{ old('email', auth()->user()?->email) }}"
                                           placeholder="you@example.com"
                                           class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                        </div>

                        {{-- Subject --}}
                        <div>
                            <label for="contact_subject" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Subject</label>
                            <div class="relative">
                                <i data-lucide="tag" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                                <input type="text" id="contact_subject" name="subject" required
                                       value="{{ old('subject') }}"
                                       placeholder="What's this about?"
                                       class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            </div>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="contact_message" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Message</label>
                            <textarea id="contact_message" name="message" rows="5" required
                                      maxlength="2000"
                                      placeholder="Tell us how we can help you..."
                                      class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none">{{ old('message') }}</textarea>
                            <p class="text-xs text-gray-600 mt-1 text-right">Max 2000 characters</p>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" id="contact-submit"
                                class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-900/50 hover:shadow-indigo-700/50 transition-all duration-200 flex items-center justify-center gap-2 group">
                            <i data-lucide="send" class="w-4 h-4 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
