<footer class="bg-gray-900 text-gray-300 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('build/assets/logo.jpg') }}" alt="Epoch Logo" class="w-8 h-8 rounded-lg object-cover">
                    <span class="text-xl font-bold text-white">Epoch</span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed max-w-sm mb-6">
                    Book appointments with top professionals — doctors, tutors, lawyers, consultants, and more. Fast, easy, and reliable.
                </p>
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Connect with us</h4>
                    <div class="flex items-center gap-3">
                        <a href="#" onclick="event.preventDefault()" class="w-8 h-8 rounded-lg bg-gray-800/80 hover:bg-gray-800 flex items-center justify-center text-gray-400 hover:text-indigo-400 transition-all duration-200" title="Twitter / X">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                            </svg>
                        </a>
                        <a href="#" onclick="event.preventDefault()" class="w-8 h-8 rounded-lg bg-gray-800/80 hover:bg-gray-800 flex items-center justify-center text-gray-400 hover:text-indigo-400 transition-all duration-200" title="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                            </svg>
                        </a>
                        <a href="#" onclick="event.preventDefault()" class="w-8 h-8 rounded-lg bg-gray-800/80 hover:bg-gray-800 flex items-center justify-center text-gray-400 hover:text-indigo-400 transition-all duration-200" title="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>
                        </a>
                        <a href="#" onclick="event.preventDefault()" class="w-8 h-8 rounded-lg bg-gray-800/80 hover:bg-gray-800 flex items-center justify-center text-gray-400 hover:text-indigo-400 transition-all duration-200" title="LinkedIn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                                <rect width="4" height="12" x="2" y="9" />
                                <circle cx="4" cy="4" r="2" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-sm font-semibold text-white mb-3">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('professionals.index') }}" class="hover:text-indigo-400 transition-colors">Find Professionals</a></li>
                    @guest
                        <li><a href="{{ route('register') }}" class="hover:text-indigo-400 transition-colors">Register</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-indigo-400 transition-colors">Login</a></li>
                    @endguest
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="text-sm font-semibold text-white mb-3">Support</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Help Center</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Terms of Service</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-indigo-400 transition-colors">Contact Us</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500">© {{ date('Y') }} Epoch. All rights reserved.</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('locale.switch', 'en') }}" class="text-xs {{ app()->getLocale() === 'en' ? 'text-indigo-400' : 'text-gray-500 hover:text-gray-300' }} transition-colors">English</a>
                <a href="{{ route('locale.switch', 'hi') }}" class="text-xs {{ app()->getLocale() === 'hi' ? 'text-indigo-400' : 'text-gray-500 hover:text-gray-300' }} transition-colors">हिंदी</a>
            </div>
        </div>
    </div>
</footer>
<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
