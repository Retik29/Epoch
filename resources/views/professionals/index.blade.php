@extends('layouts.app')

@section('title', 'Find Professionals')
@section('meta_description', 'Browse and filter top professionals on Epoch.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Find a Professional</h1>
        <p class="text-gray-500 mt-1">{{ $professionals->total() }} professionals available</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8" x-data="{ filtersOpen: false }">

        {{-- Mobile filter toggle --}}
        <div class="lg:hidden">
            <button @click="filtersOpen = !filtersOpen"
                    class="w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl shadow-sm text-sm font-semibold text-gray-700">
                <span class="flex items-center gap-2">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4 text-indigo-500"></i>
                    Filters & Search
                </span>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="filtersOpen ? 'rotate-180' : ''"></i>
            </button>
        </div>

        <!-- Sidebar Filters -->
        <aside class="lg:w-72 flex-shrink-0" x-show="filtersOpen || window.innerWidth >= 1024" x-cloak>
            <form method="GET" action="{{ route('professionals.index') }}" id="filter-form"
                  class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6 lg:sticky top-20">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4 text-indigo-500"></i> Filters
                </h2>

                <!-- Search -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('messages.search') }}</label>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Doctor's name..."
                               class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Specialty</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}
                                   class="text-indigo-600" onchange="document.getElementById('filter-form').submit()">
                            <span class="text-sm text-gray-700">All Specialties</span>
                        </label>
                        @foreach($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="category" value="{{ $cat->slug }}"
                                       {{ request('category') === $cat->slug ? 'checked' : '' }}
                                       class="text-indigo-600" onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                                <span class="ml-auto text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $cat->professionals_count }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Location</label>
                    <input type="text" name="location" value="{{ request('location') }}"
                           placeholder="Mumbai, Delhi..."
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all">
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Sort By</label>
                    <select name="sort" onchange="document.getElementById('filter-form').submit()"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                        <option value="rating" {{ request('sort', 'rating') === 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        <option value="experience" {{ request('sort') === 'experience' ? 'selected' : '' }}>Most Experienced</option>
                        <option value="fee_low" {{ request('sort') === 'fee_low' ? 'selected' : '' }}>Fee: Low to High</option>
                        <option value="fee_high" {{ request('sort') === 'fee_high' ? 'selected' : '' }}>Fee: High to Low</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors text-sm">
                    Apply Filters
                </button>

                @if(request()->hasAny(['search', 'category', 'location', 'sort']))
                    <a href="{{ route('professionals.index') }}" class="block text-center text-sm text-gray-500 hover:text-red-600 transition-colors">
                        Clear Filters
                    </a>
                @endif
            </form>
        </aside>

        <!-- Professionals Grid -->
        <div class="flex-1">
            @if($professionals->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
                    <i data-lucide="search-x" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No professionals found</h3>
                    <p class="text-sm text-gray-400 mb-6">Try adjusting your search or filters.</p>
                    <a href="{{ route('professionals.index') }}" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors text-sm">
                        Reset Filters
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($professionals as $professional)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group">
                            <div class="relative">
                                <a href="{{ route('professionals.show', $professional) }}" class="block overflow-hidden">
                                    <img src="{{ $professional->photo_url }}" alt="{{ $professional->user->name }}"
                                         class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                                </a>
                                <div class="absolute top-3 left-3">
                                    <span class="text-xs font-medium px-2 py-1 rounded-full text-white shadow-sm"
                                          style="background-color: {{ $professional->category->color }}">
                                        {{ $professional->category->name }}
                                    </span>
                                </div>
                                <div class="absolute top-3 right-3 bg-white/95 rounded-full px-2 py-1 flex items-center gap-1 shadow-sm">
                                    <i data-lucide="star" class="w-3 h-3 text-amber-400 fill-amber-400"></i>
                                    <span class="text-xs font-bold text-gray-700">{{ $professional->rating }}</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <a href="{{ route('professionals.show', $professional) }}" class="hover:underline">
                                    <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $professional->user->name }}</h3>
                                </a>
                                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1">
                                    <i data-lucide="map-pin" class="w-3 h-3 flex-shrink-0"></i>
                                    <span class="truncate">{{ $professional->location }}</span>
                                </div>
                                <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3 h-3"></i>
                                        {{ $professional->session_duration }} min
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="message-circle" class="w-3 h-3"></i>
                                        {{ $professional->total_reviews }} reviews
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="briefcase" class="w-3 h-3"></i>
                                        {{ $professional->experience_years }}y
                                    </span>
                                </div>
                                @if($professional->specializations)
                                    <div class="flex flex-wrap gap-1 mt-3">
                                        @foreach(array_slice($professional->specializations, 0, 3) as $spec)
                                            <span class="text-xs bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full">{{ $spec }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-50">
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">₹{{ number_format($professional->consultation_fee) }}</span>
                                        <span class="text-xs text-gray-400">/session</span>
                                    </div>
                                    <a href="{{ route('professionals.show', $professional) }}"
                                       class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $professionals->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
