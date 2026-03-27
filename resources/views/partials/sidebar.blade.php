<aside class="w-64 bg-blue-900 text-white flex flex-col shadow-xl">
    <div class="h-16 flex items-center justify-center border-b border-blue-800">
        <h1 class="text-xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-plus-circle"></i> FARMÁCIA
        </h1>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-800 rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fa-solid fa-house"></i> <span class="font-medium">Home</span>
        </a>

        <details class="group">
            <summary class="flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-800 cursor-pointer list-none">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-boxes-stacked"></i> <span class="font-medium">Cadastros</span>
                </div>
                <i class="fa-solid fa-chevron-down text-sm transition-transform group-open:rotate-180"></i>
            </summary>

            <ul class="mt-2 ml-4 pl-4 border-l-2 border-blue-700 space-y-1">
                {{-- Apenas Admin (ID 1) vê Funcionários --}}
                @if(auth()->user()->idRoles == 1)
                <li><a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-blue-800 rounded-lg">Funcionários</a></li>
                @endif
                
                {{-- Admin e Funcionário (1 e 2) veem Medicamentos --}}
                <li><a href="{{ route('create_product') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-blue-800 rounded-lg">Medicamentos</a></li>
            </ul>
        </details>
    </nav>

    <div class="p-4 border-t border-blue-800 text-sm">
        <p class="text-blue-200">Logado como:</p>
        <p class="font-bold truncate">{{ auth()->user()->name }}</p>
        
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium">
                <i class="fa-solid fa-right-from-bracket"></i> Sair
            </button>
        </form>
    </div>
</aside>