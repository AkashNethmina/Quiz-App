import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

import './bootstrap'

// Create Inertia App
createInertiaApp({
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob('./Pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },

  // Configure the progress bar options
  progress: {
    delay: 250,
    color: '#29d',
    includeCSS: true,
    showSpinner: true,
  },
})

// Initialize Inertia Progress
InertiaProgress.init({
  delay: 250,       // Delay in ms before the progress bar appears
  color: '#29d',    // The color of the progress bar
  includeCSS: true, // Automatically include default styles
  showSpinner: true // Show the spinner while loading
})
