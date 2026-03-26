@extends('layouts.site')

@section('title', 'Página Inicial - Farmácia Pai e Filhos')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="w-full h-64 md:h-96 bg-blue-100 rounded-2xl flex items-center px-12 mb-10 overflow-hidden relative">
        <div class="z-10">
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
            {{-- Card de Exemplo --}}
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
            {{-- Fim Card --}}
        </div>
    </section>
</div>
@endsection