/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"], // Adjust paths based on your project
    theme: {
      extend: {
        colors: {
          customPurple: "#4A21A5",

          blueText: "#0075c9",
          blueBackground: "#0a58ca",
          redErrors: "#f44336",
          grayBackground: "#f5f7fa",
          brandblue: "#0075c9",
          branddarkblue: "#0a58ca",
          brandtextblue: "#041d43",
        },
        fontFamily: {
          roboto: ["Roboto", "sans-serif"],
          "roboto-bold": ["Roboto-Bold", "sans-serif"],
          "roboto-bolder": ["Roboto-ExtraBold", "sans-serif"],
        },
      },
    },
    plugins: [],
  };