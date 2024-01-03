
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react'
import collectModuleAssetsPaths from './vite-module-loader.js'

import lircrudAllAlias from './Modules/LirCrud/resources/assets/js/helpers/Vite/alias.js'

async function getConfig() {
    const paths = [
        'resources/css/app.css',
        'resources/js/app.jsx',
    ];
    const {paths: allPaths, resolvelists} = await collectModuleAssetsPaths(paths, 'Modules')
    const lircrudAlias = await lircrudAllAlias()
    
    return defineConfig({
        plugins: [
            laravel({
                input: allPaths,
                refresh: true,
            }),
            react(),
        ],
        resolve: {
            alias: {
                ...resolvelists,
                ...lircrudAlias,
                '@/root': '/resources/js'
            }
        }
    });
}

export default getConfig()