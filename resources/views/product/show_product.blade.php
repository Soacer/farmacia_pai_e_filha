@extends('layouts.site')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <nav class="text-sm text-slate-400 mb-6">
        <a href="/" class="hover:text-blue-600">Início</a> > 
        <a href="#" class="hover:text-blue-600">{{ $product->category->class }}</a> > 
        <span class="text-slate-600">{{ $product->category->subclass }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        
        <div class="flex flex-col items-center">
            <div class="w-full aspect-square rounded-xl overflow-hidden bg-slate-50 border border-slate-100 p-4">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
            </div>
            <div class="flex gap-4 mt-6">
                <div class="w-20 h-20 border-2 border-blue-600 rounded-lg p-2 cursor-pointer">
                    <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-contain">
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <span class="text-blue-600 font-bold text-sm uppercase tracking-wide">
                {{ $product->category->subclass }}
            </span>
            
            <h1 class="text-3xl font-black text-slate-800 mt-2 leading-tight">
                {{ $product->name }}
            </h1>
            
            <p class="text-slate-400 text-sm mt-2">SKU: {{ $product->barcode }}</p>

            <div class="mt-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <div class="flex items-baseline gap-2">
                    <span class="text-slate-400 line-through text-lg">R$ {{ number_format($product->price * 1.2, 2, ',', '.') }}</span>
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded">20% OFF</span>
                </div>
                
                <div class="text-4xl font-black text-slate-900 mt-1">
                    <span class="text-xl">R$</span> {{ number_format($product->price, 2, ',', '.') }}
                </div>
                <p class="text-slate-500 text-sm mt-1">ou 3x de R$ {{ number_format($product->price / 3, 2, ',', '.') }} sem juros</p>

                <div class="flex gap-4 mt-8">
                    <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden bg-white">
                        <button class="px-4 py-2 hover:bg-slate-100 font-bold">-</button>
                        <input type="text" value="1" class="w-12 text-center border-none focus:ring-0 font-bold text-slate-700">
                        <button class="px-4 py-2 hover:bg-slate-100 font-bold">+</button>
                    </div>

                    <button class="flex-grow bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95 uppercase tracking-wider">
                        Comprar Agora
                    </button>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-4 p-4 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                <div class="bg-white p-2 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.333 0 4 1 4 3" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Desconto Convênio</h4>
                    <p class="text-xs text-slate-500 italic">Exclusivo para clientes cadastrados.</p>
                </div>
                <button class="ml-auto text-blue-600 font-bold text-xs hover:underline">Ver Desconto</button>
            </div>
        </div>
    </div>

    <div class="mt-12">
        <h2 class="text-xl font-bold text-slate-800 border-b-2 border-blue-600 inline-block pb-1">Descrição do Produto</h2>
        <div class="mt-6 text-slate-600 leading-relaxed bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
            {{ $product->description }}
        </div>
    </div>
</div>
@endsection