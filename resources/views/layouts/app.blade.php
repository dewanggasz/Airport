{{-- Mengatur atribut 'lang' secara dinamis sesuai bahasa yang aktif --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandara Internasional Adisucipto</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>

    @include('layouts.partials.header')
    <main>
        @yield('content')
    </main>
    @include('layouts.partials.footer')

</body>
</html>
