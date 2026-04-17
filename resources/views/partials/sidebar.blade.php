<aside class="w-64 bg-blue-900 text-white flex flex-col shadow-xl">
    <div class="h-16 flex items-center justify-center border-b border-blue-800">
        <h1 class="text-xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-plus-circle"></i> FARMÁCIA
        </h1>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">

        <a href="{{ url('/dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 {{ Request::is('dashboard') ? 'bg-blue-700' : 'hover:bg-blue-800' }} rounded-lg transition-colors">
            <i class="fa-solid fa-house text-blue-300"></i>
            <span class="font-medium">Home</span>
        </a>

        <a href="{{ route('select_all_products') }}"
            class="flex items-center gap-3 px-4 py-3 {{ Request::is('product/stock*') ? 'bg-blue-700' : 'hover:bg-blue-800' }} rounded-lg transition-colors border border-blue-800/50">
            <i class="fa-solid fa-boxes-stacked text-blue-300"></i>
            <span class="font-medium">Controle de Estoque</span>
        </a>

        <details class="group" {{ Request::is('suppliers/list*') || Request::is('batches*') ? 'open' : '' }}>
            <summary
                class="flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-800 cursor-pointer list-none transition-colors border border-blue-800/50">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-list-ul text-blue-400"></i>
                    <span class="font-medium">Listas</span>
                </div>
                <i
                    class="fa-solid fa-chevron-down text-[10px] transition-transform group-open:rotate-180 text-blue-400"></i>
            </summary>

            <ul class="mt-2 ml-4 pl-4 border-l-2 border-blue-700 space-y-1">
                <li>
                    <a href="{{ route('list_suppliers') }}"
                        class="block px-4 py-2 text-sm {{ Request::is('suppliers/list') ? 'text-white bg-blue-800/50' : 'text-blue-200 hover:text-white hover:bg-blue-800' }} rounded-lg transition font-medium">
                        Fornecedores
                    </a>
                </li>
                <li>
                    <a href="{{ route('batches.list') }}"
                        class="block px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-blue-800 rounded-lg transition font-medium">
                        Lotes
                    </a>
                </li>
            </ul>
        </details>

        <hr class="border-blue-800 my-4 mx-2">

        <details class="group" {{ Request::is('supplier*') || Request::is('product/product-form*') ? 'open' : '' }}>
            <summary
                class="flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-800 cursor-pointer list-none transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-pen-to-square text-blue-400"></i>
                    <span class="font-medium">Cadastros</span>
                </div>
                <i
                    class="fa-solid fa-chevron-down text-[10px] transition-transform group-open:rotate-180 text-blue-400"></i>
            </summary>

            <ul class="mt-2 ml-4 pl-4 border-l-2 border-blue-700 space-y-1">
                @if (auth()->user()->idRoles == 1)
                    <li>
                        <a href="{{ route('create_employee') }}"
                            class="block px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-blue-800 rounded-lg transition">
                            Funcionários
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('create_product') }}"
                        class="block px-4 py-2 text-sm {{ Request::is('product/product-form*') ? 'text-white bg-blue-800/50' : 'text-blue-200 hover:text-white hover:bg-blue-800' }} rounded-lg transition">
                        Medicamentos
                    </a>
                </li>
                <li>
                    <a href="{{ route('create_supplier') }}"
                        class="block px-4 py-2 text-sm {{ Request::is('supplier*') ? 'text-white bg-blue-800/50' : 'text-blue-200 hover:text-white hover:bg-blue-800' }} rounded-lg transition">
                        Fornecedores
                    </a>
                </li>
            </ul>
        </details>
    </nav>

    <div class="p-4 border-t border-blue-800 bg-blue-950/50">
        <div class="flex items-center gap-3 mb-4 px-2">
            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center font-bold text-xs">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-blue-300 leading-none mb-1">Logado como:</p>
                <p class="text-sm font-bold truncate">{{ auth()->user()->name }}</p>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all font-bold text-xs uppercase tracking-widest shadow-lg active:scale-95">
                <i class="fa-solid fa-right-from-bracket"></i> Sair
            </button>
        </form>
    </div>
</aside>
