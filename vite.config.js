
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react'

import lircrudComponentAlias from './Modules/LirCrud/resources/assets/js/helpers/Vite/alias.js'
import lircrudPathLoader from './Modules/LirCrud/resources/assets/js/helpers/Modules/path-loader.js'


async function getConfig() {
    const {paths, resolvelists} = await lircrudPathLoader([
        'resources/css/app.css',
        'resources/js/app.jsx',
    ], 'Modules')

    // .then to resolve eslint await
    const lircrudAlias = await lircrudComponentAlias().then(res => res)
    // console.log(resolvelists, paths)
    return defineConfig({
        plugins: [
            laravel({
                input: paths,
                refresh: true,
            }),
            react(),
        ],
        resolve: {
            alias: {
                ...resolvelists, // @/Modules
                ...lircrudAlias, // @/lircrud
                '@/root': '/resources/js'
            }
        }
    });
}

export default getConfig()