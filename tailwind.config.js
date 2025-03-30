/** @type {import('tailwindcss').Config} */
  content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"], // Adjust paths based on your project
  tailwind.config = {
            theme: {
                extend: {
                  colors: {
                    primary: {
                        50: '#f3f0ff',
                        100: '#e5e0ff',
                        200: '#cdbbff',
                        300: '#a48aff',
                        400: '#7a56ff',
                        500: '#5a30e0',
                        600: '#4415c0',
                        700: '#350fa0',
                        800: '#2b0c80',
                        900: '#23096b',
                    },
                    accent: {
                        50: '#fff0f7',
                        100: '#ffd9ec',
                        200: '#ffb3d9',
                        300: '#ff80bf',
                        400: '#ff4da6',
                        500: '#ff1a8c',
                        600: '#e00074',
                        700: '#b3005c',
                        800: '#800044',
                        900: '#660033',
                    }
                },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
          }