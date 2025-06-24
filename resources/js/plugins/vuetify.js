 import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

export default createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: 'light',
    themes: {
      light: {
        colors: {
          primary: '#ec407a',     // rosa claro
          secondary: '#f8bbd0',   // rosa suave
          success: '#4caf50',
          error: '#e53935',
        },
      },
    },
  },
})
