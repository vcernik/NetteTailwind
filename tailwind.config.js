/** @type {import('tailwindcss').Config} */

module.exports = {
    content: ["./app/**/*.latte", "./app/**/*.php"],
    theme: {
        fontFamily: {
            'sans': 'Comenia Sans',
        },
      colors: {
        indigo: {
          50: '#cffafe', //5
          100: '#a5f3fc', //10
          500: '#0FA4BF', //Default
          700: '#0A7285', //Dark
          900: '#063B44', //Darkest
        },
        gray: {
          50: '#F5F5F4', //5 
          100: '#EBEAEA', //10
          200: '#D6D5D4', //25
          500: '#999694', //50
          700: '#66625F', //75
          900: '#332E2A', //Text
        },
        'white': '#fff',
        'white-opacity': {
          75: 'rgba(255,255,255,0.75)', //75% 
          50: 'rgba(255,255,255,0.50)', //50%
          25: 'rgba(255,255,255,0.25)', //25%
          10: 'rgba(255,255,255,0.10)', //10%
          5: 'rgba(255,255,255,0.05)', //5%
        },
        'orange': {
          300: '#F5C090', //lighter
          500: '#FF9669', //Default
          700: '#D1734B', //dark
        },
        'red': '#8C5E58',
        'yellow': '#8C5E58',
        'sand': '#F4F3EE',
        transparent: 'transparent'
      },
    },
    plugins: [
        require('@tailwindcss/forms')
    ],
  }