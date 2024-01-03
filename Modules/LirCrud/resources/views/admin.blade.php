<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <script>
            const appUrl = '{{ env('APP_URL') }}'
            // const assetUrl = '{{ asset('/') }}'
        </script>
        
        @viteReactRefresh
        {{-- <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.5/dist/flowbite.min.css" /> --}}
        @vite([
            'Modules/LirCrud/resources/assets/css/app.css',
            // 'resources/js/admin_app.jsx'
            'Modules/LirCrud/resources/assets/js/app.jsx',
            // 'Modules/LirCrud/resources/assets/js/flowbite.js',
        ])
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script> --}}
        @inertiaHead
    </head>
    <body>
        @inertia
        {{-- <script src="https://unpkg.com/flowbite@1.4.5/dist/flowbite.js"></script> --}}
    </body>
</html>

  