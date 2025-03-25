<?php
  require  'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">  
    </style>
  
</head>
<body>
  <?php
    require 'header.php';
  ?>
  <!-- Hero background to show transparent navbar -->
  <div class="bg-gradient-to-r from-purple-800 to-indigo-700 h-screen flex items-center justify-center">
      <div class="text-center text-white px-4">
          <h1 class="text-4xl font-extrabold sm:text-5xl md:text-6xl">
              Welcome to Our Website
          </h1>
          <p class="mt-3 max-w-md mx-auto text-base text-gray-200 sm:text-lg md:mt-5 md:text-xl">
              This transparent navbar works great with hero sections.
          </p>
          <div class="mt-10">
              <a href="#" class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-gray-100 md:py-4 md:text-lg md:px-10">
                  Get Started
              </a>
          </div>
      </div>
  </div>
<div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16">
    <div class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-2 gap-10">
        <?php
        // ev.eventTitle, ev.eventDescription, ev.TariffReduit,
        // ed.dateEvent, ed.timeEvent, ed.numSalle, ed.image
        foreach($editions as $edition):
          ?>
        <div class="rounded overflow-hidden shadow-lg">

            <a href="#"></a>
            <div class="relative">
                <a href="#">
                    <img class="w-full" src="images/<?= $edition['image'] ?>" alt="<?= $edition['eventTitle'] ?>">
                    <div
                        class="hover:bg-transparent transition duration-300 absolute bottom-0 top-0 right-0 left-0 bg-gray-900 opacity-25">
                    </div>
                </a>
                <a href="#!">
                    <div class="absolute bottom-0 left-0 bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out">
                        <?= $edition['eventType'] ?>
                    </div>
                </a>

                <a href="details.php?id=<?= $edition['editionId'] ?>">
                    <div
                        class="text-sm absolute top-0 right-0 bg-indigo-600 px-4 text-white rounded-full h-16 w-16 flex flex-col items-center justify-center mt-3 mr-3 hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out">
                        <!-- <span >15</span> -->
                        <small class="font-bold"> Détails Edition</small>
                    </div>
                </a>
            </div>
            <div class="px-6 py-4">

                <a href="#" class="font-semibold text-lg inline-block hover:text-indigo-600 transition duration-500 ease-in-out">
                  <?= $edition['eventTitle'] ?></a>
                <p class="text-gray-500 text-sm">
                  <?= $edition['eventDescription'] ?>
                </p>
            </div>
            <div class="px-6 py-4 flex flex-row items-center">
                <span href="#"
                    class="py-1 text-sm font-regular text-gray-900 mr-1 flex flex-row justify-between items-center">
                    <svg height="13px" width="13px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <g>
                            <g>
                                <path
                                    d="M256,0C114.837,0,0,114.837,0,256s114.837,256,256,256s256-114.837,256-256S397.163,0,256,0z M277.333,256 c0,11.797-9.536,21.333-21.333,21.333h-85.333c-11.797,0-21.333-9.536-21.333-21.333s9.536-21.333,21.333-21.333h64v-128 c0-11.797,9.536-21.333,21.333-21.333s21.333,9.536,21.333,21.333V256z">
                                </path>
                            </g>
                        </g>
                    </svg>
                    <span class="ml-1"><?= $edition['dateEvent'] ?> <?= $edition['timeEvent'] ?></span></span>
            </div>
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="text-gray-500">À partir de</p>
                    <p class="text-indigo-600 "><?= $edition['TariffReduit'] ?> DH</p>
                </div>
                <a href="details.php?id=<?= $edition['editionId'] ?>" class=" bg-indigo-600 text-white px-4 py-2 rounded">
                        J'achète
                </a>
            </div>
        </div>
        <?php
          endforeach;
        ?>
    </div>
</div>
</body>
</html>