<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Shop Cart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="container mx-auto py-10">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
