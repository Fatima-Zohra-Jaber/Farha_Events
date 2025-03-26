

    <!-- Navbar -->
    <nav x-data="{ open: false }" class="bg-gray-50">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between border-b border-gray-200">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img class="h-8 w-auto" src="images/logo.png" alt="Farha Event Logo">
            </div>

            <!-- Links section -->
            <div class="hidden lg:ml-10 lg:block">
              <div class="flex space-x-4">
                  <a href="#" class="hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium text-gray-900" x-state-description="undefined: &quot;bg-gray-100&quot;, undefined: &quot;hover:text-gray-700&quot;">Accueil</a>
                  <?php if(isset($_SESSION['utilisateur'])): ?>
                  <a href="#" class="hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium text-gray-900" x-state-description="undefined: &quot;bg-gray-100&quot;, undefined: &quot;hover:text-gray-700&quot;">Mes Réservations</a>
                  <?php endif; ?>
                  <a href="#" class="hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium text-gray-900" x-state-description="undefined: &quot;bg-gray-100&quot;, undefined: &quot;hover:text-gray-700&quot;">Contact</a>            
              </div>
            </div>
          </div>

          <div class="flex flex-1 justify-center px-2 lg:ml-6 lg:justify-end">
          <div class="flex lg:hidden">
            <!-- Mobile menu button -->
            <button type="button" class="inline-flex items-center justify-center rounded-md bg-gray-50 p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-50" aria-controls="mobile-menu" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
              <span class="sr-only">Open main menu</span>
              <svg x-state:on="Menu open" x-state:off="Menu closed" class="block h-6 w-6" :class="{ 'hidden': open, 'block': !(open) }" x-description="Heroicon name: outline/bars-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
</svg>
              <svg x-state:on="Menu open" x-state:off="Menu closed" class="hidden h-6 w-6" :class="{ 'block': open, 'hidden': !(open) }" x-description="Heroicon name: outline/x-mark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
</svg>
            </button>
          </div>

          <!-- Actions section -->
          <div class="hidden lg:ml-4 lg:block">
            <div class="flex items-center">
             
            <?php if(isset($_SESSION['utilisateur'])): ?> 
              <!-- Profile dropdown -->
              <div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative ml-3 flex-shrink-0">
                <div>
                  <button  @click="open = !open" type="button" class="flex rounded-full bg-gray-50 text-sm text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-50" >
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="">
                  </button>
                </div>
                
                  <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state." x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()">
                    
                      <a href="#" class="block py-2 px-4 text-sm text-gray-700" x-state:on="Active" x-state:off="Not Active" :class="{ 'bg-gray-100': activeIndex === 0 }" role="menuitem" tabindex="-1" id="user-menu-item-0" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, 0)" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">Profile</a>
                    
                      <a href="#" class="block py-2 px-4 text-sm text-gray-700" :class="{ 'bg-gray-100': activeIndex === 1 }" role="menuitem" tabindex="-1" id="user-menu-item-1" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, 1)" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">Paramètres</a>
                    
                      <a href="#" class="block py-2 px-4 text-sm text-gray-700" :class="{ 'bg-gray-100': activeIndex === 2 }" role="menuitem" tabindex="-1" id="user-menu-item-2" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, 2)" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">Déconnexion</a>
                    
                  </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>

      <div x-description="Mobile menu, show/hide based on menu state." class="border-b border-gray-200 bg-gray-50 lg:hidden" id="mobile-menu" x-show="open">
        <div class="space-y-1 px-2 pt-2 pb-3">
          
          
            <a href="#" class="hover:bg-gray-100 block px-3 py-2 rounded-md font-medium text-gray-900" x-state-description="undefined: &quot;bg-gray-100&quot;, undefined: &quot;hover:bg-gray-100&quot;">Accueil</a>
            <?php if(isset($_SESSION['utilisateur'])): ?>
            <a href="#" class="hover:bg-gray-100 block px-3 py-2 rounded-md font-medium text-gray-900" x-state-description="undefined: &quot;bg-gray-100&quot;, undefined: &quot;hover:bg-gray-100&quot;">Mes Réservations</a>
            <?php endif; ?>
          
            <a href="#" class="hover:bg-gray-100 block px-3 py-2 rounded-md font-medium text-gray-900" x-state-description="undefined: &quot;bg-gray-100&quot;, undefined: &quot;hover:bg-gray-100&quot;">Contact</a>
          
        </div>
        <div class="border-t border-gray-200 pt-4 pb-3">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="">
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800"><?php echo $_SESSION['utilisateur']['nomUser'];echo ' '; echo $_SESSION['utilisateur']['prenomUser']; ?></div>
              <div class="text-sm font-medium text-gray-500"><?php echo $_SESSION['utilisateur']['mailUser']; ?></div>
            </div>
         
          </div>
          <div class="mt-3 space-y-1 px-2">
            
              <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-900 hover:bg-gray-100">Profile</a>
            
              <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-900 hover:bg-gray-100">Paramètres</a>
            
              <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-900 hover:bg-gray-100">Déconnexion</a>
            
          </div>
        </div>
      </div>
    </nav>

    

       
        </nav>
      </div>
    </main>
  </div>

  </div>
  </body>