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
                'backTheme' : '#495057',
                'primary' : '#212529', 
                'secondary': '#50406c',
                'ternary': '#adb5bd',
                'quat': '#a2d2ff'
            },
        },

    },

    plugins: [forms, typography],
};

