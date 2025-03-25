
    <!-- Transparent Navbar -->
    <nav class="absolute top-0 left-0 w-full z-10 bg-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="#" class="flex-shrink-0 flex items-center">
                        <img class="h-10 w-auto" src="images/logo.png" alt="Logo">
                        <!-- <span class="ml-2 text-xl font-bold text-white">Company</span> -->
                    </a>
                    <div class="hidden md:ml-10 md:flex md:space-x-10">
                        <a href="#" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                            Home
                        </a>
                        <a href="#" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                            About
                        </a>
                        <a href="#" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                            Services
                        </a>
                        <a href="#" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                            Contact
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="hidden md:ml-4 md:flex md:items-center md:space-x-4">
                        <a href="login.php" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">
                            Login
                        </a>
                        <a href="inscription.php" class="bg-white text-indigo-600 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            Sign Up
                        </a>
                    </div>
                    <div class="flex items-center md:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu, show/hide based on menu state -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-gray-800 bg-opacity-90">
                <a href="#" class="text-white block px-3 py-2 rounded-md text-base font-medium">
                    Home
                </a>
                <a href="#" class="text-gray-300 hover:text-white hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">
                    About
                </a>
                <a href="#" class="text-gray-300 hover:text-white hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">
                    Services
                </a>
                <a href="#" class="text-gray-300 hover:text-white hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">
                    Contact
                </a>
                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center px-5 space-y-3">
                        <a href="#" class="block w-full text-center text-white bg-gray-700 px-3 py-2 rounded-md text-base font-medium hover:bg-gray-600">
                            Login
                        </a>
                    </div>
                    <div class="mt-3 px-5">
                        <a href="#" class="block w-full text-center bg-white text-indigo-600 px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">
                            Sign Up
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    

    <script>
        // Simple toggle for mobile menu
        document.querySelector('button[aria-expanded]').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden');
        });
    </script>
