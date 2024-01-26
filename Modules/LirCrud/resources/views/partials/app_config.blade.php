<script>
    /**
     * all global varaible here, must define in types/gobal.d.ts
     */
    const appUrl = baseUrl = '{{ url('/') }}'
    const appName = '{{ Str::snake(env('APP_NAME')) }}'
    const appConfig = Object.freeze({
        local: '{{ config('app.locale') }}',
        fallback_locale: '{{ config('app.fallback_locale') }}',
    })
    // const assetUrl = '{{ asset('/') }}'
</script>
