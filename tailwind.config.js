/** @type {import('tailwindcss').Config} */

const customColors = {
    primary: { 
        DEFAULT: 'var(--color-primary)'
    },
    secondary: {
        DEFAULT: 'var(--color-secondary)',
    },
    gray: {
        100: '#f5f5f5',
        200: '#ededed',
        300: '#dedede',
        400: '#878787',
        500: '#b5b5b5',
        600: '#8f8e8f',
        700: '#696969',
        800: '#3d3d3d',
        900: '#232323'
    },
};

const plugin = require('tailwindcss/plugin');

module.exports = {
    content: [
      './template-parts/**/*.php',
      './template-parts/*.php',
      //'./template-parts/share-social.php',
      './src/**/*.sass',
      './inc/**/*.php',
      './inc/*.php',
      //'./inc/shortcodes.php',
      './404.php',
      './archive.php',
      './comments.php',
      './footer.php',
      './front-page.php',
      './header.php',
      './index.php',
      './page.php',
      './search.php',
      './sidebar.php',
      './single.php', 
    ],
    theme: {
      container: {
        center: true,
        padding: "1.5rem"
      },
      screens: {
        sm: '480px',
        md: '768px',
        lg: '1024px',
        xl: '1200px'
      },
      extend: {
        fontSize: {
          'xs': '12px',
          'sm': '16px',
          'base': '18px',
          'lg': '24px',
          'xl': '32px',
          '2xl': '40px'
        },
        fontFamily: {
          display: [ 'Montserrat', 'sans-serif' ],
          body: [ 'Montserrat', 'sans-serif' ]
        },
        colors: {
          ...customColors
        },
        textColor: {
            ...customColors
        },
        backgroundColor: {
            ...customColors
        },
        inset: {
          "-full": "-100%"
        },
        zIndex: {
          "-10": "-10"
        },
        textShadow: {
          DEFAULT: '3px 3px 0px #75734A'
        }
      },
    },
    plugins: [
      plugin(function({matchUtilities, theme}) {
        matchUtilities(
          {
            'text-shadow': (value) => ({
              textShadow: value,
            }),
          },
          { values: theme('textShadow') }
        )
      }),  
    ],
  }

