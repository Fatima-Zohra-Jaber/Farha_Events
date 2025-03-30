
    <!-- Navbar -->
    <nav x-data="{ open: false }" class="bg-white shadow-md backdrop-blur-lg dark:bg-gray-900 dark:shadow-lg">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="relative flex h-20 items-center justify-between">
                <!-- Logo and Desktop Navigation -->
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="index.php">
                            <img class="h-16 w-auto" src="images/logo.png" alt="Farha Event Logo">
                        </a>
                    </div>

                    <!-- Desktop Navigation Links -->
                    <div class="hidden lg:ml-10 lg:block">
                        <div class="flex space-x-4">
                            <a href="index.php" class="text-gray-900 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
                            <a href="#" class="text-gray-900 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">À propos</a>
                            <a href="#" class="text-gray-900 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex lg:hidden">
                    <button 
                        @click="open = !open" 
                        class="inline-flex items-center justify-center rounded-md bg-gray-50 p-2 text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                        <span class="sr-only">Ouvrir le menu</span>
                        <!-- Hamburger Icon -->
                        <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <!-- Close Icon -->
                        <svg x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- User Actions -->
                <div class="hidden lg:block">
                    <?php if(isset($_SESSION['utilisateur'])): ?>
                        <!-- Logged-in User Dropdown -->
                        <div x-data="{ dropdown: false }" class="relative">
                            <div class="flex items-center px-4">
                                <button 
                                @click="dropdown = !dropdown" 
                                class="flex rounded-full bg-gray-200 p-0.5 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                >
                                    <img 
                                        class="h-10 w-10 rounded-full" 
                                        src="images/profil.svg" 
                                        alt="Profile image"
                                    >
                                </button>

                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-900">
                                        <?= $_SESSION['utilisateur']['nomUser'] . ' ' . $_SESSION['utilisateur']['prenomUser'] ?>
                                    </div>
                                    <div class="text-sm font-medium text-gray-500">
                                        <?= $_SESSION['utilisateur']['mailUser'] ?>
                                    </div>
                                </div>
                            </div>

                            <div 
                                x-show="dropdown" 
                                @click.outside="dropdown = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg"
                            >
                                <div class="py-1">
                                    <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <a href="reservations.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mes Réservations</a>
                                    <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Déconnexion</a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Login/Register Buttons -->
                        <div class="flex space-x-2">
                            <a href="login.php" class="bg-primary-600 text-white hover:bg-accent-600 px-3 py-2 rounded-md text-sm font-medium ">
                                Se connecter
                            </a>
                            <a href="inscription.php" class="bg-white text-primary-600 px-3 py-2 rounded-md text-sm font-medium border hover:bg-gray-100">
                                S'inscrire
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
           
            <!-- Mobile Menu -->
            <div x-show="open" class="lg:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="index.php" class="text-gray-900 hover:bg-gray-100 block px-3 py-2 rounded-md font-medium">Accueil</a>
                        <a href="#" class="text-gray-900 hover:bg-gray-100 block px-3 py-2 rounded-md font-medium">À propos</a>
                    <a href="#" class="text-gray-900 hover:bg-gray-100 block px-3 py-2 rounded-md font-medium">Contact</a>

                    <?php if(isset($_SESSION['utilisateur'])): ?>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center px-4">
                                <img 
                                    class="h-10 w-10 rounded-full" 
                                    src="images/profil.svg" 
                                    alt="Profile image"
                                >
                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-900">
                                        <?= $_SESSION['utilisateur']['nomUser'] . ' ' . $_SESSION['utilisateur']['prenomUser'] ?>
                                    </div>
                                    <div class="text-sm font-medium text-gray-500">
                                        <?= $_SESSION['utilisateur']['mailUser'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <a href="profile.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Profil</a>
                                <a href="reservations.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Mes Réservations</a>
                                <a href="logout.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-gray-100">Déconnexion</a>
                            </div>
                        </div>
                        <?php else: ?>
                          <!-- Login/Register Buttons -->
                          <div class="flex space-x-2">
                              <a href="login.php" class="bg-primary-600 text-white hover:bg-accent-600 px-3 py-2 rounded-md text-sm font-medium">
                                  Se connecter
                              </a>
                              <a href="inscription.php" class="bg-white text-primary-600 px-3 py-2 rounded-md text-sm font-medium border hover:bg-gray-100">
                                  S'inscrire
                              </a>
                          </div>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>