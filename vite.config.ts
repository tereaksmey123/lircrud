import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react'

import {alias} from './Modules/LirCrud/resources/assets/js/helpers/Vite/alias'
import {pathLoader} from './Modules/LirCrud/resources/assets/js/helpers/Modules/path-loader'

async function getConfig() {
    const {paths, resolvelists} = await pathLoader([
        'resources/css/app.css',
        'resources/js/app.jsx',
    ], 'Modules')

    const lircrudAlias = await alias()
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
            },
            // extensions: ['.js', '.ts', '.tsx', '.jsx'],
        }
    });
}

export default getConfig()