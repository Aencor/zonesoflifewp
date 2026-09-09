/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./wp-content/themes/codebymonk/**/*.{php,html,js}"],
  theme: {
    extend: {
      // If you want to extend or customize gradients
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic': 'conic-gradient(from 180deg, var(--tw-gradient-stops))',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
