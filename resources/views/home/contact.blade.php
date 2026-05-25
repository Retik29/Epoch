@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-5xl w-full">
        <!-- Heading -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center gap-2 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                    <i data-lucide="mail-question" class="w-5 h-5 text-white"></i>
                </div>
                <span class="text-2xl font-bold gradient-text">Epoch Support</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Get in touch with us</h1>
            <p class="mt-4 max-w-xl mx-auto text-base text-gray-500">
                Have questions about booking appointments or listing as a professional? Send us a message and our support team will reply within 24 hours.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-stretch animate-slide-up">
            <!-- Left Panel: Contact Info -->
            <div class="lg:col-span-2 bg-gradient-to-br from-indigo-900 via-indigo-850 to-purple-950 text-white rounded-3xl p-8 shadow-xl flex flex-col justify-between relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

                <div class="relative">
                    <h3 class="text-xl font-bold mb-6">Contact Information</h3>
                    <p class="text-indigo-200 text-sm mb-8 leading-relaxed">
                        Fill out the form and our team will get back to you shortly. You can also reach us via the channels below.
                    </p>

                    <!-- Contact Details -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-all shadow-md">
                                <i data-lucide="phone" class="w-4 h-4 text-indigo-300"></i>
                            </div>
                            <div>
                                <p class="text-xs text-indigo-300 font-medium">Phone Support</p>
                                <p class="text-sm font-semibold text-white">+91 98765 43210</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-all shadow-md">
                                <i data-lucide="mail" class="w-4 h-4 text-indigo-300"></i>
                            </div>
                            <div>
                                <p class="text-xs text-indigo-300 font-medium">Email Address</p>
                                <p class="text-sm font-semibold text-white">support@epoch.com</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-all shadow-md">
                                <i data-lucide="map-pin" class="w-4 h-4 text-indigo-300"></i>
                            </div>
                            <div>
                                <p class="text-xs text-indigo-300 font-medium">Headquarters</p>
                                <p class="text-sm font-semibold text-white">12, Epoch Towers, HSR Layout, Bengaluru, Karnataka, 560102</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-all shadow-md">
                                <i data-lucide="clock" class="w-4 h-4 text-indigo-300"></i>
                            </div>
                            <div>
                                <p class="text-xs text-indigo-300 font-medium">Business Hours</p>
                                <p class="text-sm font-semibold text-white">Mon - Sat: 9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Socials -->
                <div class="mt-12 relative pt-6 border-t border-white/10">
                    <p class="text-xs text-indigo-300 mb-4 font-medium uppercase tracking-wider">Follow our updates</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/25 hover:-translate-y-0.5 transition-all duration-200">
                            <i data-lucide="twitter" class="w-4 h-4 text-white"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/25 hover:-translate-y-0.5 transition-all duration-200">
                            <i data-lucide="linkedin" class="w-4 h-4 text-white"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/25 hover:-translate-y-0.5 transition-all duration-200">
                            <i data-lucide="instagram" class="w-4 h-4 text-white"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Form Card -->
            <div class="lg:col-span-3 bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-10 flex flex-col justify-between"
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
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Send us a Message</h3>
                    <p class="text-sm text-gray-500 mb-6">Required fields are marked with an asterisk (*).</p>

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-5">
                        @csrf

                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5 flex justify-between">
                                <span>Your Name *</span>
                                <span class="text-xs text-gray-400 font-normal">Min 3 chars</span>
                            </label>
                            <div class="relative">
                                <i data-lucide="user" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input id="name" type="text" name="name" x-model="name" @blur="touched.name = true" required
                                       :class="touched.name ? (nameError() ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-emerald-400 bg-emerald-50/20 focus:ring-emerald-200') : 'border-gray-200 focus:ring-indigo-500'"
                                       class="w-full pl-10 pr-4 py-3 border rounded-xl text-sm focus:ring-2 focus:border-transparent outline-none transition-all shadow-sm"
                                       placeholder="John Doe">
                            </div>
                            <!-- Client-side Error -->
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1" x-show="touched.name && nameError()" x-cloak>
                                <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i> <span x-text="nameError()"></span>
                            </p>
                            <!-- Server-side Error fallback -->
                            @error('name')
                                <p class="text-xs text-red-600 mt-1 flex items-center gap-1" x-show="!touched.name">
                                    <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address *</label>
                            <div class="relative">
                                <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input id="email" type="email" name="email" x-model="email" @blur="touched.email = true" required
                                       :class="touched.email ? (emailError() ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-emerald-400 bg-emerald-50/20 focus:ring-emerald-200') : 'border-gray-200 focus:ring-indigo-500'"
                                       class="w-full pl-10 pr-4 py-3 border rounded-xl text-sm focus:ring-2 focus:border-transparent outline-none transition-all shadow-sm"
                                       placeholder="johndoe@example.com">
                            </div>
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1" x-show="touched.email && emailError()" x-cloak>
                                <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i> <span x-text="emailError()"></span>
                            </p>
                            @error('email')
                                <p class="text-xs text-red-600 mt-1 flex items-center gap-1" x-show="!touched.email">
                                    <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Subject Input -->
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1.5 flex justify-between">
                                <span>Subject *</span>
                                <span class="text-xs text-gray-400 font-normal">Min 5 chars</span>
                            </label>
                            <div class="relative">
                                <i data-lucide="heading" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input id="subject" type="text" name="subject" x-model="subject" @blur="touched.subject = true" required
                                       :class="touched.subject ? (subjectError() ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-emerald-400 bg-emerald-50/20 focus:ring-emerald-200') : 'border-gray-200 focus:ring-indigo-500'"
                                       class="w-full pl-10 pr-4 py-3 border rounded-xl text-sm focus:ring-2 focus:border-transparent outline-none transition-all shadow-sm"
                                       placeholder="How can we help you?">
                            </div>
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1" x-show="touched.subject && subjectError()" x-cloak>
                                <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i> <span x-text="subjectError()"></span>
                            </p>
                            @error('subject')
                                <p class="text-xs text-red-600 mt-1 flex items-center gap-1" x-show="!touched.subject">
                                    <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Message TextArea -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-1.5 flex justify-between">
                                <span>Your Message *</span>
                                <span class="text-xs text-gray-400 font-normal">Min 10 chars</span>
                            </label>
                            <div class="relative">
                                <i data-lucide="message-square" class="absolute left-3.5 top-3.5 w-4 h-4 text-gray-400"></i>
                                <textarea id="message" name="message" rows="4" x-model="message" @blur="touched.message = true" required
                                          :class="touched.message ? (messageError() ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-emerald-400 bg-emerald-50/20 focus:ring-emerald-200') : 'border-gray-200 focus:ring-indigo-500'"
                                          class="w-full pl-10 pr-4 py-3 border rounded-xl text-sm focus:ring-2 focus:border-transparent outline-none transition-all shadow-sm"
                                          placeholder="Write your detailed query here..."></textarea>
                            </div>
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1" x-show="touched.message && messageError()" x-cloak>
                                <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i> <span x-text="messageError()"></span>
                            </p>
                            @error('message')
                                <p class="text-xs text-red-600 mt-1 flex items-center gap-1" x-show="!touched.message">
                                    <i data-lucide="alert-circle" class="w-3 h-3 flex-shrink-0"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" :disabled="isFormInvalid()"
                                    :class="isFormInvalid() ? 'from-gray-400 to-gray-500 cursor-not-allowed opacity-60 shadow-none' : 'from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl hover:-translate-y-0.5'"
                                    class="w-full py-3.5 bg-gradient-to-r text-white font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
