import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#666EE8',
                secondary: '#868E96',
                danger: '#FF4961',
                warning: '#FF9149',
                success: '#28D094',
                info: '#1E9FF2',
                dark: '#343A40',
                light: '#F8F9FA',
            },
        },
    },
    plugins: [],
};
