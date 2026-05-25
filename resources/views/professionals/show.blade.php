@extends('layouts.app')

@section('title', $professional->user->name . ' — Professional Profile')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left: Profile -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-20">
                <div class="relative">
                    <img src="{{ $professional->photo_url }}" alt="{{ $professional->user->name }}"
                         class="w-full h-56 object-cover">
                    <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-3 left-4">
                        <span class="text-xs font-medium px-2 py-1 rounded-full text-white"
                              style="background-color: {{ $professional->category->color }}">
                            {{ $professional->category->name }}
                        </span>
                    </div>
                </div>

                <div class="p-5">
                    <div class="flex items-start justify-between">
                        <h1 class="text-xl font-bold text-gray-900">{{ $professional->user->name }}</h1>
                        <div class="flex items-center gap-1 bg-amber-50 border border-amber-100 rounded-full px-2 py-1">
                            <i data-lucide="star" class="w-3.5 h-3.5 text-amber-500 fill-amber-500"></i>
                            <span class="text-sm font-bold text-amber-700">{{ $professional->rating }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 text-sm text-gray-500 mt-1">
                        <i data-lucide="map-pin" class="w-4 h-4 text-indigo-400"></i>
                        {{ $professional->location }}
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <div class="bg-indigo-50 rounded-xl p-3 text-center">
                            <p class="text-xl font-bold text-indigo-600">{{ $professional->experience_years }}</p>
                            <p class="text-xs text-gray-500">Years Exp.</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-3 text-center">
                            <p class="text-xl font-bold text-green-600">{{ $professional->total_reviews }}</p>
                            <p class="text-xs text-gray-500">Reviews</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4 py-3 border-t border-gray-100">
                        <div>
                            <span class="text-2xl font-bold text-gray-900">₹{{ number_format($professional->consultation_fee) }}</span>
                            <span class="text-sm text-gray-400">/session</span>
                        </div>
                        <span class="text-sm text-gray-500 flex items-center gap-1">
                            <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i>
                            {{ $professional->session_duration }} min
                        </span>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1.5">Primary Specialty</p>
                            <span class="text-sm font-semibold px-3 py-1 rounded-full text-white shadow-sm inline-block"
                                  style="background-color: {{ $professional->category->color }}">
                                {{ $professional->category->name }}
                            </span>
                        </div>

                        @if($professional->specializations && count($professional->specializations) > 0)
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Specializations & Expertise</p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($professional->specializations as $spec)
                                        <span class="text-xs bg-indigo-50 text-indigo-700 border border-indigo-100 px-2 py-1 rounded-full">{{ $spec }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">About</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $professional->bio }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Booking -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Date Picker -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="bookingApp()">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5 text-indigo-500"></i>
                    Book Consultation
                </h2>

                <!-- Date Tabs -->
                <div class="mb-6">
                    <p class="text-sm font-semibold text-gray-600 mb-3">Available Dates</p>
                    <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                        @forelse($availableDates as $date => $slots)
                            @php $carbon = \Carbon\Carbon::parse($date); @endphp
                            <button @click="selectDate('{{ $date }}')"
                                    :class="selectedDate === '{{ $date }}' ? 'bg-indigo-600 text-white border-indigo-600 shadow-md' : 'bg-white text-gray-700 border-gray-200 hover:border-indigo-300'"
                                    class="flex-shrink-0 flex flex-col items-center px-4 py-3 border rounded-xl text-xs font-medium transition-all duration-200 min-w-[60px]">
                                <span class="uppercase text-current opacity-70">{{ $carbon->format('D') }}</span>
                                <span class="text-lg font-bold text-current">{{ $carbon->format('d') }}</span>
                                <span class="text-current opacity-70">{{ $carbon->format('M') }}</span>
                            </button>
                        @empty
                            <div class="text-center py-8 text-gray-400 w-full">
                                <i data-lucide="calendar-x" class="w-8 h-8 mx-auto mb-2"></i>
                                <p class="text-sm">No available slots in the next 14 days.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Time Slots -->
                <div x-show="selectedDate" x-transition>
                    <p class="text-sm font-semibold text-gray-600 mb-3">Available Time Slots</p>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                        @foreach($availableDates as $date => $slots)
                            <template x-if="selectedDate === '{{ $date }}'">
                                <div class="contents">
                                    @foreach($slots as $slot)
                                        <button @click="selectSlot('{{ $slot }}')"
                                                :class="selectedSlot === '{{ $slot }}' ? 'bg-indigo-600 text-white border-indigo-600 shadow-md' : 'bg-white text-gray-700 border-gray-200 hover:border-indigo-400 hover:text-indigo-600'"
                                                class="px-3 py-2.5 border rounded-xl text-xs font-medium text-center transition-all duration-200">
                                            {{ \Str::before($slot, '-') }}
                                        </button>
                                    @endforeach
                                </div>
                            </template>
                        @endforeach
                    </div>
                </div>

                <!-- Booking Form -->
                <div x-show="selectedDate && selectedSlot" x-transition class="mt-6 pt-6 border-t border-gray-100">
                    @auth
                        <form action="{{ route('appointments.store') }}" method="POST" id="booking-form">
                            @csrf
                            <input type="hidden" name="professional_id" value="{{ $professional->id }}">
                            <input type="hidden" name="appointment_date" id="f-date" x-ref="dateInput">
                            <input type="hidden" name="time_slot" id="f-slot" x-ref="slotInput">

                            <div class="bg-indigo-50 rounded-xl p-4 mb-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Date:</span>
                                    <span class="font-semibold text-gray-800" x-text="formatDate(selectedDate)"></span>
                                </div>
                                <div class="flex items-center justify-between text-sm mt-2">
                                    <span class="text-gray-600">Time:</span>
                                    <span class="font-semibold text-gray-800" x-text="selectedSlot"></span>
                                </div>
                                <div class="flex items-center justify-between text-sm mt-2">
                                    <span class="text-gray-600">Fee:</span>
                                    <span class="font-bold text-indigo-600">₹{{ number_format($professional->consultation_fee) }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                                <textarea name="notes" rows="3" maxlength="500"
                                          class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all resize-none"
                                          placeholder="Describe your concern or any information for the professional...">{{ old('notes') }}</textarea>
                                <p class="text-xs text-gray-400 mt-1">Max 500 characters</p>
                            </div>

                            <button type="button" id="book-btn"
                                    @click="doSubmit()"
                                    :disabled="!selectedDate || !selectedSlot || submitting"
                                    :class="(!selectedDate || !selectedSlot || submitting) ? 'opacity-50 cursor-not-allowed' : 'hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl'"
                                    class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 group">
                                <template x-if="submitting">
                                    <span class="inline-flex items-center gap-2">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing Payment...
                                    </span>
                                </template>
                                <template x-if="!submitting">
                                    <span class="inline-flex items-center gap-2">
                                        <i data-lucide="lock" class="w-5 h-5"></i>
                                        Proceed to Payment
                                    </span>
                                </template>
                            </button>

                            <p class="text-center text-xs text-gray-400 mt-2 flex items-center justify-center gap-1">
                                <i data-lucide="shield-check" class="w-3 h-3 text-green-500"></i>
                                Secured by Razorpay · UPI, Cards &amp; NetBanking accepted
                            </p>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-600 mb-4">Please log in to book an appointment.</p>
                            <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors">
                                Login to Book
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Reviews -->
            @if($professional->reviews->count() > 0)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i data-lucide="star" class="w-5 h-5 text-amber-500"></i>
                        Reviews ({{ $professional->reviews->count() }})
                    </h2>
                    <div class="space-y-4">
                        @foreach($professional->reviews->take(5) as $review)
                            <div class="border-b border-gray-50 pb-4 last:border-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}"
                                             class="w-8 h-8 rounded-full object-cover">
                                        <span class="font-semibold text-sm text-gray-800">{{ $review->user->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400 fill-amber-400' : 'text-gray-200' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                @if($review->comment)
                                    <p class="text-sm text-gray-600 ml-10">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function bookingApp() {
        return {
            selectedDate: '',
            selectedSlot: '',
            submitting: false,
            selectDate(date) {
                this.selectedDate = date;
                this.selectedSlot = '';
            },
            selectSlot(slot) {
                this.selectedSlot = slot;
            },
            formatDate(dateStr) {
                if (!dateStr) return '';
                const d = new Date(dateStr + 'T00:00:00');
                return d.toLocaleDateString('en-IN', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            },
            doSubmit() {
                if (!this.selectedDate || !this.selectedSlot) return;
                // Directly set hidden input values via DOM refs before submitting
                this.$refs.dateInput.value = this.selectedDate;
                this.$refs.slotInput.value = this.selectedSlot;
                this.submitting = true;
                
                // 2.5s mock payment processing delay before submitting
                setTimeout(() => {
                    document.getElementById('booking-form').submit();
                }, 2500);
            }
        }
    }
</script>
@endpush
@endsection
