<!DOCTYPE html>
<html lang="en">
    <head>
        <title inertia>{{ config('app.name', 'My Inertia App') }}</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <script>
            const appUrl = '{{ env('APP_URL') }}'
            // const assetUrl = '{{ asset('/') }}'
        </script>
        
        @viteReactRefresh
        @vite([
            'Modules/LirCrud/resources/assets/css/app.css',
            'Modules/LirCrud/resources/assets/js/app.jsx',
        ])
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html>
