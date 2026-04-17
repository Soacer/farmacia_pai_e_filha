<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icon.ico') }}">
    <title>@yield('title', 'Farmácia Pai e Filhos')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 text-gray-800">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-4">

            <div class="shrink-0 text-2xl font-bold text-blue-700 flex items-center gap-2">
                <i class="fas fa-plus-square"></i>
                <a href="{{ route('home') }}">
                    <span class="hidden sm:inline">FARMÁCIA PAI E FILHOS</span>
                </a>
            </div>

            <div class="w-full md:flex-1 md:max-w-xl order-3 md:order-2">
                <div class="relative">
                    <input type="text" placeholder="O que você procura?"
                        class="w-full border-2 border-gray-200 rounded-full py-2 px-5 focus:outline-none focus:border-blue-500">
                    <button class="absolute right-4 top-2.5 text-blue-700">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="shrink-0 flex items-center gap-6 order-2 md:order-3 text-blue-700">
                <div class="hidden md:block text-sm">
                    @guest
                        <span class="block text-gray-400">Olá, </span>
                        <span class="font-bold"><a href="{{ route('login/auth') }}">Entre</a></span> ou
                        <span class="font-bold"><a href="{{ route('create_customer') }}">Cadastre-se</a></span>
                    @endguest

                    @auth
                        <center>
                        <span class="block text-gray-400 text-[10px] uppercase font-bold">Bem-vindo(a)</span>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-blue-900">{{ auth()->user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700" title="Sair">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                        @if (auth()->user()->idRoles === 1 || auth()->user()->idRoles === 2)
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center gap-2 mt-2 px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-full transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect width="7" height="9" x="3" y="3" rx="1" />
                                    <rect width="7" height="5" x="14" y="3" rx="1" />
                                    <rect width="7" height="9" x="14" y="12" rx="1" />
                                    <rect width="7" height="5" x="3" y="16" rx="1" />
                                </svg>
                                Painel de Controle
                            </a>
                        @endif
                        </center>
                    @endauth
                </div>

                <div class="relative cursor-pointer">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    <span
                        class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] rounded-full px-1.5 font-bold">0</span>
                </div>
            </div>
        </div>
    </header>

    <nav class="bg-white border-b hidden md:block">
        <div class="container mx-auto px-4">
            <ul class="flex gap-8 py-3 text-sm font-semibold text-gray-600">
                <li class="hover:text-blue-700 cursor-pointer">Medicamentos</li>
                <li class="hover:text-blue-700 cursor-pointer">Higiene e Cuidado Pessoal</li>
                <li class="hover:text-blue-700 cursor-pointer">Beleza</li>
                <li class="hover:text-blue-700 cursor-pointer">Infantil</li>
                <li class="hover:text-blue-700 cursor-pointer text-red-600">Ofertas do Dia</li>
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @include('partials.footer-site')

</body>

</html>
