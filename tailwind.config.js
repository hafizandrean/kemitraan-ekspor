import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                display: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                exportani: {
                    dark: '#005700',
                    primary: '#2F7226',
                    mint: '#74C690',
                    teal: '#3AA68B',
                    accent: '#1F6F63',
                    background: '#F4F6F5',
                    text: '#1F2937',
                    secondaryText: '#6B7280',
                    border: '#E5E7EB',
                },
            },
            borderRadius: {
                'xl': '12px',
                '2xl': '16px',
            },
        },
    },

    plugins: [forms],
};
