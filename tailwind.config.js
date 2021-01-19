const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
      ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                kanit: ['Kanit']
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            ringColor: ['hover', 'active', 'focus'],
            backgroundColor: ['active'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
