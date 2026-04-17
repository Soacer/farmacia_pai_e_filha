@extends('layouts.site')

@section('title', 'Página Inicial - Farmácia Pai e Filhos')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="w-full h-64 md:h-96 bg-blue-100 rounded-2xl flex items-center px-12 mb-10 overflow-hidden relative">
            <div class="z-10">
                <h1 class="text-4xl font-bold text-blue-900 mb-4">Cuidado completo <br> para sua saúde.</h1>
                <p class="text-lg text-blue-700 mb-6">Até 50% de desconto em vitaminas.</p>
                <button
                    class="bg-blue-700 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-800 transition">Confira</button>
            </div>
            <img src="https://via.placeholder.com/400x300" alt="Remédios" class="absolute right-10 bottom-0 hidden md:block">
        </div>

        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-700">Alguns Produtos: </h2>
                <a href="#" class="text-blue-700 font-semibold underline">Ver todos</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach ($products as $product)
                    <div
                        class="group flex flex-col bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">

                        <div class="relative aspect-square overflow-hidden bg-slate-100">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @if ($product->requires_prescription)
                                <span
                                    class="absolute top-2 right-2 bg-red-100 text-red-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider border border-red-200">
                                    Retenção de Receita
                                </span>
                            @endif
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold mb-1">
                                {{ $product->active_principle }}
                            </span>

                            <h3 class="text-sm font-bold text-slate-800 leading-snug mb-2 line-clamp-2 h-10">
                                {{ $product->name }}
                            </h3>

                            <div class="mt-auto pt-3">
                                <p class="text-xs text-slate-400">A partir de</p>
                                <p class="text-xl font-black text-blue-600">
                                    <span class="text-sm font-bold">R$</span>
                                    {{ number_format($product->price, 2, ',', '.') }}
                                </p>
                                <a href="{{ route('select_product_by_id', $product->id) }}" class="product-card group ...">
                                <button
                                    class="w-full mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg text-sm transition-colors shadow-sm active:scale-95">
                                    Comprar
                                </button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
