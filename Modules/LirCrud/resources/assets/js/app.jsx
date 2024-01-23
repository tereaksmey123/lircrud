import React from 'react'
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

import resolvePageComponent from '@/Modules/LirCrud/helpers/Insertia/resolve-page.js'
import AdminLayout from '@/lircrud/Layouts/Admin'

import 'antd/dist/reset.css'; // use to reset browser default style

createInertiaApp({
  resolve: async (name) => {
    let page = await resolvePageComponent(name)

    // set default layout or component layout
      page.default.layout = page.default.layout || (page => <AdminLayout>{page}</AdminLayout>)

		return page
  },
    setup({ el, App, props }) {
        createRoot(el).render(
          <React.StrictMode>
            <App {...props} />
          </React.StrictMode>
        )
    },
})