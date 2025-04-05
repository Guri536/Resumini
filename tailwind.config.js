import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';


/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/views/*.{html,js,php}",
        "./resources/views/**.blade.php",
        "./resources/js/**.js"
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'backTheme': '#495057',
                'primary': '#FDFBEE',
                'secondary': '#57B4BA',
                'ternary': '#4D787A',
                'quat': '#4F959D',
                'text-primary': '#eaeaea',
                'brd-primary': '#c0c0c0de',
                'hvr-brd-primary': '#e7e7e7'
            },
            keyframes: {
                typing: {
                    "0%": {
                        width: "0%",
                        visibility: "hidden"
                    },
                    "100%": {
                        width: "150%"
                    }
                },
                blink: {
                    "50%": {
                        borderColor: "transparent"
                    },
                    "100%": {
                        borderColor: "white"
                    }
                }
            },
            animation: {
                typing: "typing 1.5s steps(3) infinite alternate, blink .5s infinite"
            }
        },

    },

    plugins: [forms, typography],
};

