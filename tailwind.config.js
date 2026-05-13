import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Ganti Figtree jadi Inter biar lebih modern & clean kayak di desain Stitch
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Palet Warna Dark Forest Stitch
                primary: '#13ec37',
                'primary-hover': '#0fd630',
                dark: '#10221f',
                surface: '#162e26',
            },
        },
    },

    plugins: [forms],
};