

<!-- Transparent Navbar -->
<nav class="absolute top-0 left-0 w-full z-10 bg-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="#" class="flex-shrink-0 flex items-center">
                    <img class="h-10 w-auto" src="images/logo.png" alt="Logo">
                </a>
                <div class="hidden md:ml-10 md:flex md:space-x-10">
                    <a href="#" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">Accueil</a>
                    <a href="#" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">About</a>
                    <?php if(isset($_SESSION['utilisateur'])): ?>
                        <a href="#" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">Mes Réservations</a>
                    <?php endif; ?>
                    <a href="#" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">Contact</a>
                </div>
            </div>
            
            <?php if(isset($_SESSION['utilisateur'])): ?> 
                <!-- Profile dropdown -->
                <div x-data="{ open: false }" class="relative ml-3 flex-shrink-0">
                    <button @click="open = !open" class="flex rounded-full bg-gray-50 text-sm text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <span class="sr-only">Ouvrir le menu utilisateur</span>
                        <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    </button>
                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
                        <a href="#" class="block py-2 px-4 text-sm text-gray-700">Profil</a>
                        <a href="#" class="block py-2 px-4 text-sm text-gray-700">Paramètres</a>
                        <a href="logout.php" class="block py-2 px-4 text-sm text-gray-700">Déconnexion</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex items-center">
                    <div class="hidden md:flex md:items-center md:space-x-4">
                        <a href="login.php" class="text-white hover:text-gray-200 px-3 py-2 text-sm font-medium">Se connecter</a>
                        <a href="inscription.php" class="bg-white text-indigo-600 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-white">S'inscrire</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-gray-800 bg-opacity-90">
            <a href="#" class="text-white block px-3 py-2 rounded-md text-base font-medium">Accueil</a>
            <a href="#" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">About</a>
            <a href="#" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Services</a>
            <a href="#" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Contact</a>
            <div class="pt-4 pb-3 border-t border-gray-700">
                <div class="flex items-center px-5 space-y-3">
                    <a href="login.php" class="block w-full text-center text-white bg-gray-700 px-3 py-2 rounded-md text-base font-medium hover:bg-gray-600">Se connecter</a>
                </div>
                <div class="mt-3 px-5">
                    <a href="inscription.php" class="block w-full text-center bg-white text-indigo-600 px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">S'inscrire</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Toggle du menu mobile
    document.querySelector('[aria-expanded]').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>
