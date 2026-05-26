@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-teal-50/40 via-white to-indigo-50/30 py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Top Section: Header -->
        <div class="text-center mb-16 animate-fade-in">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-teal-50 border border-teal-100 text-teal-700 text-xs font-semibold uppercase tracking-wider mb-4 shadow-sm">
                <i data-lucide="help-circle" class="w-3.5 h-3.5 text-teal-600"></i>
                <span>Epoch Support Desk</span>
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                Let's start a <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-indigo-600">conversation</span>
            </h1>
            <p class="mt-4 max-w-xl mx-auto text-base sm:text-lg text-slate-500">
                Have questions about booking appointments or listing as a certified professional? Send us a message and our dedicated support team will reply within 24 hours.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-stretch animate-slide-up">
            <!-- Left Side Columns (2 cols on large screen) -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                <!-- Card 1: Contact Information -->
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-100/80 flex flex-col justify-between relative overflow-hidden group">
                    <!-- Glassmorphism accent blur circles -->
                    <div class="absolute -right-16 -top-16 w-36 h-36 bg-teal-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
                    <div class="absolute -left-16 -bottom-16 w-36 h-36 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>

                    <div class="relative">
                        <h3 class="text-lg font-bold text-slate-950 mb-2">General Enquiries</h3>
                        <p class="text-slate-500 text-xs sm:text-sm mb-6 leading-relaxed">
                            Feel free to reach out via our direct communication channels.
                        </p>

                        <!-- Contact Channels -->
                        <div class="space-y-5">
                            <!-- Phone -->
                            <div class="flex items-center gap-4 group/item">
                                <div class="w-11 h-11 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center group-hover/item:bg-teal-600 group-hover/item:scale-105 transition-all duration-300 shadow-sm">
                                    <i data-lucide="phone" class="w-5 h-5 text-teal-600 group-hover/item:text-white transition-colors"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Helpline</p>
                                    <p class="text-sm font-semibold text-slate-800 hover:text-teal-600 transition-colors cursor-pointer">+91 1824 404404</p>
                                    <p class="text-[11px] text-slate-400">General Campus Desk</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-center gap-4 group/item">
                                <div class="w-11 h-11 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center group-hover/item:bg-indigo-600 group-hover/item:scale-105 transition-all duration-300 shadow-sm">
                                    <i data-lucide="mail" class="w-5 h-5 text-indigo-600 group-hover/item:text-white transition-colors"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Support Email</p>
                                    <p class="text-sm font-semibold text-slate-800 hover:text-indigo-600 transition-colors cursor-pointer">info@lpu.co.in</p>
                                    <p class="text-[11px] text-slate-400">Response within 24h</p>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex items-center gap-4 group/item">
                                <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center group-hover/item:bg-amber-600 group-hover/item:scale-105 transition-all duration-300 shadow-sm">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-amber-600 group-hover/item:text-white transition-colors"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">HQ Address</p>
                                    <p class="text-sm font-semibold text-slate-800 leading-snug">Lovely Professional University</p>
                                    <p class="text-[11px] text-slate-500">G.T. Road, Phagwara, Punjab, 144411</p>
                                </div>
                            </div>

                            <!-- Clock -->
                            <div class="flex items-center gap-4 group/item">
                                <div class="w-11 h-11 rounded-xl bg-purple-500/10 border border-purple-200 flex items-center justify-center group-hover/item:bg-purple-600 group-hover/item:scale-105 transition-all duration-300 shadow-sm">
                                    <i data-lucide="clock" class="w-5 h-5 text-purple-600 group-hover/item:text-white transition-colors"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Operational Hours</p>
                                    <p class="text-sm font-semibold text-slate-800">Mon - Sat: 9:00 AM - 6:00 PM</p>
                                    <p class="text-[11px] text-slate-400">Sunday Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Socials inside Card -->
                    <div class="mt-8 pt-5 border-t border-slate-100 relative">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-3">Connect on Socials</p>
                        <div class="flex gap-3">
                            <!-- GitHub -->
                            <a href="javascript:void(0)" class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-purple-500/10 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-600 group/social">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-slate-500 group-hover/social:text-white transition-colors duration-300">
                                    <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4" />
                                    <path d="M9 18c-4.51 2-5-2-7-2" />
                                </svg>
                            </a>
                            <!-- LinkedIn -->
                            <a href="javascript:void(0)" class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-purple-500/10 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-600 group/social">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-slate-500 group-hover/social:text-white transition-colors duration-300">
                                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                                    <rect width="4" height="12" x="2" y="9" />
                                    <circle cx="4" cy="4" r="2" />
                                </svg>
                            </a>
                            <!-- Instagram -->
                            <a href="javascript:void(0)" class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-purple-500/10 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-600 group/social">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-slate-500 group-hover/social:text-white transition-colors duration-300">
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                                </svg>
                            </a>
                            <!-- Twitter/X -->
                            <a href="javascript:void(0)" class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-purple-500/10 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-600 group/social">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-slate-500 group-hover/social:text-white transition-colors duration-300">
                                    <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                                </svg>
                            </a>
                            <!-- Facebook -->
                            <a href="javascript:void(0)" class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-purple-500/10 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-600 group/social">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-slate-500 group-hover/social:text-white transition-colors duration-300">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Map Section -->
                <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100/80 flex flex-col justify-between overflow-hidden relative group">
                    <h4 class="text-xs font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <i data-lucide="map" class="w-4 h-4 text-teal-600"></i>
                        <span>Campus Location Map</span>
                    </h4>
                    <div class="rounded-2xl overflow-hidden shadow-inner border border-slate-100 relative h-48 sm:h-56 lg:h-64">
                        <iframe class="absolute inset-0 w-full h-full border-0" 
                                src="https://maps.google.com/maps?q=Lovely%20Professional%20University,%20Phagwara,%20Punjab&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- Right Side Column: Form Card (3 cols on large screen) -->
            <div class="lg:col-span-3 bg-white rounded-3xl shadow-xl border border-slate-100/80 p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden"
                 x-data="{
                     name: '{{ old('name', '') }}',
                     email: '{{ old('email', '') }}',
                     subject: '{{ old('subject', '') }}',
                     message: '{{ old('message', '') }}',
                     touched: { name: false, email: false, subject: false, message: false },
                     nameError() {
                         if (!this.name) return 'Name is required.';
                         if (this.name.length < 3) return 'Name must be at least 3 characters.';
                         if (!/^[a-zA-Z\s]+$/.test(this.name)) return 'Name can only contain letters and spaces.';
                         return '';
                     },
                     emailError() {
                         if (!this.email) return 'Email is required.';
                         if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) return 'Please enter a valid email address.';
                         return '';
                     },
                     subjectError() {
                         if (!this.subject) return 'Subject is required.';
                         if (this.subject.length < 5) return 'Subject must be at least 5 characters.';
                         return '';
                     },
                     messageError() {
                         if (!this.message) return 'Message is required.';
                         if (this.message.length < 10) return 'Message must be at least 10 characters.';
                         return '';
                     },
                     isFormInvalid() {
                         return !!(this.nameError() || this.emailError() || this.subjectError() || this.messageError());
                     }
                 }">

                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Send us a Message</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mb-8">Have a query? Please fill out the form fields. Required inputs are marked (*).</p>

                    <form id="contact-page-form" method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                        @csrf

                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5 flex justify-between">
                                <span>Your Name *</span>
                                <span class="text-[11px] text-slate-400 font-normal">Min 3 chars</span>
                            </label>
                            <div class="relative">
                                <i data-lucide="user" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                <input id="name" type="text" name="name" x-model="name" @blur="touched.name = true" required
                                       :class="touched.name ? (nameError() ? 'border-red-400 bg-red-50/30 focus:ring-red-100' : 'border-teal-400 bg-teal-50/10 focus:ring-teal-100') : 'border-slate-200 focus:ring-teal-500/25'"
                                       class="w-full pl-10 pr-4 py-3 border rounded-xl text-sm focus:ring-4 focus:border-transparent outline-none transition-all duration-200 shadow-sm"
                                       placeholder="John Doe">
                            </div>
                            <!-- Client-side Error -->
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5" x-show="touched.name && nameError()" x-cloak>
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5 flex-shrink-0"></i> <span x-text="nameError()"></span>
                            </p>
                            <!-- Server-side Error fallback -->
                            @error('name')
                                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5" x-show="!touched.name">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5 flex-shrink-0"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5 flex justify-between">
                                <span>Email Address *</span>
                                <span class="text-[11px] text-slate-400 font-normal">Valid email format</span>
                            </label>
                            <div class="relative">
                                <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                <input id="email" type="email" name="email" x-model="email" @blur="touched.email = true" required
                                       :class="touched.email ? (emailError() ? 'border-red-400 bg-red-50/30 focus:ring-red-100' : 'border-teal-400 bg-teal-50/10 focus:ring-teal-100') : 'border-slate-200 focus:ring-teal-500/25'"
                                       class="w-full pl-10 pr-4 py-3 border rounded-xl text-sm focus:ring-4 focus:border-transparent outline-none transition-all duration-200 shadow-sm"
                                       placeholder="johndoe@example.com">
                            </div>
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5" x-show="touched.email && emailError()" x-cloak>
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5 flex-shrink-0"></i> <span x-text="emailError()"></span>
                            </p>
                            @error('email')
                                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5" x-show="!touched.email">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5 flex-shrink-0"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Subject Input -->
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-slate-700 mb-1.5 flex justify-between">
                                <span>Subject *</span>
                                <span class="text-[11px] text-slate-400 font-normal">Min 5 chars</span>
                            </label>
                            <div class="relative">
                                <i data-lucide="heading" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                <input id="subject" type="text" name="subject" x-model="subject" @blur="touched.subject = true" required
                                       :class="touched.subject ? (subjectError() ? 'border-red-400 bg-red-50/30 focus:ring-red-100' : 'border-teal-400 bg-teal-50/10 focus:ring-teal-100') : 'border-slate-200 focus:ring-teal-500/25'"
                                       class="w-full pl-10 pr-4 py-3 border rounded-xl text-sm focus:ring-4 focus:border-transparent outline-none transition-all duration-200 shadow-sm"
                                       placeholder="How can we assist you today?">
                            </div>
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5" x-show="touched.subject && subjectError()" x-cloak>
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5 flex-shrink-0"></i> <span x-text="subjectError()"></span>
                            </p>
                            @error('subject')
                                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5" x-show="!touched.subject">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5 flex-shrink-0"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Message TextArea -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-slate-700 mb-1.5 flex justify-between">
                                <span>Your Message *</span>
                                <span class="text-[11px] text-slate-400 font-normal">Min 10 chars</span>
                            </label>
                            <div class="relative">
                                <i data-lucide="message-square" class="absolute left-3.5 top-3.5 w-4 h-4 text-slate-400"></i>
                                <textarea id="message" name="message" rows="4" x-model="message" @blur="touched.message = true" required
                                          :class="touched.message ? (messageError() ? 'border-red-400 bg-red-50/30 focus:ring-red-100' : 'border-teal-400 bg-teal-50/10 focus:ring-teal-100') : 'border-slate-200 focus:ring-teal-500/25'"
                                          class="w-full pl-10 pr-4 py-3 border rounded-xl text-sm focus:ring-4 focus:border-transparent outline-none transition-all duration-200 shadow-sm"
                                          placeholder="Type your query or explanation here..."></textarea>
                            </div>
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5" x-show="touched.message && messageError()" x-cloak>
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5 flex-shrink-0"></i> <span x-text="messageError()"></span>
                            </p>
                            @error('message')
                                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1.5" x-show="!touched.message">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5 flex-shrink-0"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" :disabled="isFormInvalid()"
                                    :class="isFormInvalid() ? 'from-slate-300 to-slate-400 cursor-not-allowed opacity-60 shadow-none' : 'from-teal-600 to-indigo-600 hover:from-teal-700 hover:to-indigo-700 shadow-md hover:shadow-teal-500/10 hover:-translate-y-0.5'"
                                    class="w-full py-3.5 bg-gradient-to-r text-white font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-sm uppercase tracking-wide">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                <span>Send Message</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const contactForm = document.getElementById('contact-page-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            const accessKey = "{{ env('WEB3FORMS_ACCESS_KEY') }}";
            if (accessKey) {
                e.preventDefault();
                const form = this;
                const submitBtn = form.querySelector('button[type="submit"]');
                
                if (submitBtn) {
                    submitBtn.disabled = true;
                    const spanEl = submitBtn.querySelector('span');
                    if (spanEl) {
                        spanEl.innerHTML = 'Sending...';
                    }
                }

                const formData = new FormData(form);
                formData.append('access_key', accessKey);
                formData.append('subject', '[Epoch Contact] ' + (formData.get('subject') || 'New Message'));
                formData.append('from_name', 'Epoch Platform');

                fetch('https://api.web3forms.com/submit', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    form.submit();
                }).catch(err => {
                    form.submit();
                });
            }
        });
    }
});
</script>
@endpush