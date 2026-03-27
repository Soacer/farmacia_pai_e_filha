<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmácia Pai e Filha - Gestão Segura</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Estilização da Scrollbar para ficar sutil e moderna */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Garante que o conteúdo não 'vaze' horizontalmente */
        [x-cloak] { display: none !important; }
    </style>

    {{-- Alpine.js (Necessário para os toggles e interatividade do sistema) --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-slate-100 text-slate-900 antialiased overflow-hidden">

    <div class="flex h-screen overflow-hidden">

        {{-- 
           Certifique-se de que o arquivo está em: resources/views/partials/sidebar.blade.php
           Se estiver na raiz de views, use apenas @include('sidebar')
        --}}
        @include('partials.sidebar')

        <div class="flex-1 flex flex-col min-w-0">
            
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 flex-shrink-0 z-10 shadow-sm">
                <div class="flex items-center space-x-2">
                    <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Painel Operacional</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-[10px] font-bold text-slate-400 text-right">
                        <p class="leading-none">{{ now()->translatedFormat('l, d \d\e F') }}</p>
                        <p class="leading-none mt-1">{{ now()->format('H:i') }}</p>
                    </div>
                </div>
            </header>

            {{-- 
               O overflow-y-auto aqui permite que o formulário de medicamento 
               role livremente enquanto a Sidebar e o Header ficam parados.
            --}}
            <main class="flex-1 overflow-y-auto bg-slate-50 p-6 scroll-smooth">
                <div class="max-w-6xl mx-auto pb-12">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    {{-- Scripts Adicionais se necessário --}}
    @stack('scripts')
</body>
</html>