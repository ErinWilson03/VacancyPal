/** @type {import('tailwindcss').Config} */
export default {
  content: [ 
    // TODO check if this is right 
    './resources/views/**/*.blade.php',  // Include Blade views
    './resources/js/**/*.js',  // Include JavaScript files
    './resources/css/**/*.css',  // Include CSS files
    ],
  theme: {
    extend: {
      colors: {
        white: {
          DEFAULT: '#ffffff',
          100: '#333333',
          200: '#666666',
          300: '#999999',
          400: '#cccccc',
          500: '#ffffff',
          600: '#ffffff',
          700: '#ffffff',
          800: '#ffffff',
          900: '#ffffff',
        },
        gray: {
          DEFAULT: '#c0ccde',
          100: '#1d2736',
          200: '#394d6c',
          300: '#5674a2',
          400: '#89a0c1',
          500: '#c0ccde',
          600: '#ccd6e4',
          700: '#d9e0eb',
          800: '#e6eaf2',
          900: '#f2f5f8',
        },
        lightBlue: {
          DEFAULT: '#8199bc',
          100: '#161e29',
          200: '#2c3b53',
          300: '#41597c',
          400: '#5777a6',
          500: '#8199bc',
          600: '#99adca',
          700: '#b3c1d7',
          800: '#ccd6e4',
          900: '#e6eaf2',
        },
        midBlue: {
          DEFAULT: '#42669b',
          100: '#0d141f',
          200: '#1a283d',
          300: '#273d5c',
          400: '#35517b',
          500: '#42669b',
          600: '#5c81b9',
          700: '#85a1cb',
          800: '#aec0dc',
          900: '#d6e0ee',
        },
        darkBlue: {
          DEFAULT: '#023379',
          100: '#000a18',
          200: '#011530',
          300: '#011f48',
          400: '#012960',
          500: '#023379',
          600: '#0354c5',
          700: '#1a78fc',
          800: '#66a5fd',
          900: '#b3d2fe',
        },
      },
    },
  },
  plugins: [],
}
