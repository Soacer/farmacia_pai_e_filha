<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Farmácia Pai e Filha')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 h-screen flex overflow-hidden font-sans">
    
    @include('partials.sidebar') <main class="flex-1 flex flex-col">
        <header class="h-16 bg-white shadow-sm flex items-center px-8">
            <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Painel de Controle')</h2>
        </header>

        <div class="p-8">
            @yield('content') </div>
    </main>
</body>
</html>