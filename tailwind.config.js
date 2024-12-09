/** @type {import('tailwindcss').Config} */
export default {
  content: ["./resources/views/**/*.blade.php"],
  theme: {
    extend: {
      colors: {
        'chartreuse': '#7fff00',
        'stone-350': '#d0c5ba'
      },
			 fontFamily: {
        monospace: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'Liberation Mono', 'Courier New', 'monospace'],
        sans: ['InterVariable', 'Roboto', 'Fira-Sans', 'Noto Sans JP', 'Helvetica', 'Arial',  'sans-serif']
      }, 
    },
  },
  plugins: [],
}

// module.exports = {
//   content: ["./resources/views/*.php"],
//   theme: {
//     colors: {
//       primary: {
//         50: '#f9fafb',
//         100: '#f3f4f6',
//         200: '#e5e7eb',
//         300: '#d1d5db',
//         400: '#9ca3af',
//         500: '#6b7280',
//         600: '#4b5563',
//         700: '#374151',
//         800: '#1f2937',
//         900: '#111827',
//       },
//       secondary: {
//         50: '#f0fdfa',
//         100: '#ccfbf1',
//         200: '#99f6e4',
//         300: '#5eead4',
//         400: '#2dd4bf',
//         500: '#14b8a6',
//         600: '#0d9488',
//         700: '#0f766e',
//         800: '#115e59',
//         900: '#134e4a',
//       },
//     },
//   },
// }

