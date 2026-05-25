<footer class="bg-gray-900 text-gray-300 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <i data-lucide="calendar-check" class="w-4 h-4 text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Epoch</span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed max-w-sm">
                    Book appointments with top professionals — doctors, tutors, lawyers, consultants, and more. Fast, easy, and reliable.
                </p>
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
