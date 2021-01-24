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
        screens: {
            'lgp': {'max': '767px'},
            '2xl': '1535px',
            // => @media (max-width: 1535px) { ... }

            'xl': '1279px',
            // => @media (max-width: 1279px) { ... }

            'lg': '1023px',
            // => @media (max-width: 1023px) { ... }

            'md': '767px',
            // => @media (max-width: 767px) { ... }

            'sm': '639px',
            // => @media (max-width: 639px) { ... }
          }
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            ringColor: ['hover', 'active', 'focus'],
            backgroundColor: ['active'],
            textColor: ['active'],
            borderStyle: ['hover', 'focus'],
            borderColor: ['active'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
