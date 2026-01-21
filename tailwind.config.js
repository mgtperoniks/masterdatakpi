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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ["Inter", "sans-serif"],
            },
            colors: {
                primary: "#2563EB",
                "background-light": "#F8FAFC",
                "background-dark": "#0F172A",
                "card-light": "#FFFFFF",
                "card-dark": "#111827",
                "active": "#22C55E",
                "inactive": "#F59E0B",
                "archived": "#64748B"
            },
            borderRadius: {
                DEFAULT: "12px",
            },
        },
    },
    darkMode: "class",

    plugins: [forms],
};
