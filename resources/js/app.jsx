import React from 'react'
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import resolvePageComponent from '@/Modules/LirCrud/helpers/Insertia/resolve-page'
// import 'antd/dist/reset.css';

createInertiaApp({
  resolve: async (name) => {
    let page = resolvePageComponent(name)

    // set default layout or component layout
    // page.default.layout = page.default.layout || (page => <AdminLayout children={page} />)

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