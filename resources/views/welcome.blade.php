<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icon.ico') }}">    <title>Farmácia Pai e Filhos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <!--<div class="bg-blue-700 text-white text-xs py-2 text-center font-bold">
            FRETE GRÁTIS EM COMPRAS ACIMA DE R$ 150,00
        </div>-->
        
        <div class="container mx-auto px-4 py-4 flex flex-wrap items-center justify-between">
            <div class="text-2xl font-bold text-blue-700 flex items-center gap-2">
                <i class="fas fa-plus-square"></i> FARMÁCIA PAI E FILHOS
            </div>

            <div class="w-full md:w-1/2 order-3 md:order-2 mt-4 md:mt-0">
                <div class="relative">
                    <input type="text" placeholder="O que você procura?" 
                        class="w-full border-2 border-gray-200 rounded-full py-2 px-5 focus:outline-none focus:border-blue-500">
                    <button class="absolute right-4 top-2.5 text-blue-700">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-6 order-2 md:order-3 text-blue-700">
                <div class="hidden md:block text-sm">
                    <span class="block text-gray-400">Olá, </span>
                    <span class="font-bold"><a href="{{route('login/auth')}}">Entre</a></span> ou
                    <span class="font-bold"><a href="{{route('login/cadastro')}}">Cadastre-se</a></span>
                </div>
                <div class="relative">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] rounded-full px-1.5 font-bold">0</span>
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

    <main class="container mx-auto px-4 py-8">
        <div class="w-full h-64 md:h-96 bg-blue-100 rounded-2xl flex items-center px-12 mb-10 overflow-hidden relative">
            <div>
                <h1 class="text-4xl font-bold text-blue-900 mb-4">Cuidado completo <br> para sua saúde.</h1>
                <p class="text-lg text-blue-700 mb-6">Até 50% de desconto em vitaminas.</p>
                <button class="bg-blue-700 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-800 transition">Confira</button>
            </div>
            <img src="https://via.placeholder.com/400x300" alt="Remédios" class="absolute right-10 bottom-0 hidden md:block">
        </div>

        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-700">Mais Vendidos</h2>
                <a href="#" class="text-blue-700 font-semibold underline">Ver todos</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                <div class="bg-white p-4 rounded-xl border border-gray-100 hover:shadow-lg transition">
                    <div class="h-40 bg-gray-50 mb-4 flex items-center justify-center rounded">
                        <img src="https://via.placeholder.com/120" alt="Produto">
                    </div>
                    <span class="text-[10px] uppercase font-bold text-gray-400">Marca Laboratório</span>
                    <h3 class="text-sm font-semibold h-10 overflow-hidden mb-2">Dipirona Monoidratada 500mg 10 Comprimidos</h3>
                    <div class="mt-4">
                        <span class="text-xs text-gray-400 line-through">R$ 15,90</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-lg font-bold text-blue-700">R$ 8,50</span>
                        </div>
                    </div>
                    <button class="w-full mt-4 bg-green-500 text-white py-2 rounded font-bold hover:bg-green-600 transition">
                        Comprar
                    </button>
                </div>
                </div>
        </section>
    </main>

    <footer class="bg-white border-t mt-20 py-10">
        <div class="container mx-auto px-4 grid md:grid-cols-3 gap-8 text-sm">
            <div>
                <h4 class="font-bold mb-4">Atendimento</h4>
                <p class="text-gray-500">Central de Vendas: 0800-000-0000</p>
                <p class="text-gray-500 mt-2">Segunda a Sábado, das 08h às 21h</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Links Úteis</h4>
                <ul class="text-gray-500 space-y-2">
                    <li>Política de Privacidade</li>
                    <li>Nossas Lojas</li>
                    <li>Trabalhe Conosco</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Formas de Pagamento</h4>
                <div class="flex gap-4 text-2xl text-gray-400">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-pix"></i>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
