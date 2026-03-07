<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Farmácia Pai e Filha</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 h-screen flex overflow-hidden font-sans">
    @auth
        <aside class="w-64 bg-blue-900 text-white flex flex-col shadow-xl">

            <div class="h-16 flex items-center justify-center border-b border-blue-800">
                <h1 class="text-xl font-bold flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle"></i>
                    FARMÁCIA
                </h1>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

                <a href="{{ url('/dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 bg-blue-800 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fa-solid fa-house"></i>
                    <span class="font-medium">Home</span>
                </a>

                <details class="group">
                    <summary
                        class="flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-800 cursor-pointer transition-colors list-none">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            <span class="font-medium">Cadastros</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-sm transition-transform group-open:rotate-180"></i>
                    </summary>

                    <ul class="mt-2 ml-4 pl-4 border-l-2 border-blue-700 space-y-1">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-blue-800 rounded-lg transition-colors">
                                Funcionários
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-blue-800 rounded-lg transition-colors">
                                Medicamentos
                            </a>
                        </li>
                    </ul>
                </details>

            </nav>

            <div class="p-4 border-t border-blue-800 text-sm">
                <p class="text-blue-200">Logado como:</p>
                <p class="font-bold truncate">{{ auth()->user()->name ?? 'Usuário Teste' }}</p>
            </div>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="h-16 bg-white shadow-sm flex items-center px-8">
                <h2 class="text-xl font-semibold text-gray-800">Painel de Controle</h2>
            </header>

            <div class="p-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Bem-vindo ao sistema!</h3>
                    <p class="text-gray-600">Bem Vindo(a) {{ auth()->user()->name ?? 'Usuário Teste' }}</p>
                </div>
            </div>
        </main>
    @endauth
    </main>
</body>

</html>
