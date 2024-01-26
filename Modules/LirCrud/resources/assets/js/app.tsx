import React from 'react'
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

import resolvePageComponent from '@/Modules/LirCrud/helpers/Insertia/resolve-page.js'
import AdminLayout from '@/lircrud/Layouts/Admin'

import 'antd/dist/reset.css'; // use to reset browser default style
import {useTranslate} from '@/lircrud/Stores/useTranslate'
import axios from 'axios'

// add config before axios request is fire
axios.interceptors.request.use(function (config) {
  config.headers['Accept-Language'] = useTranslate.getState().locale
  
  return config;
}, error => Promise.reject(error));

createInertiaApp({
  resolve: async (name: string) => {
    let page = await resolvePageComponent(name)

    // set default layout or component layout
      page.default.layout = page.default.layout
        || ((page: React.ReactNode) => <AdminLayout>{page}</AdminLayout>)

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