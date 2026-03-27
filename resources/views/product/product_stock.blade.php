@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 px-4 pb-12" x-data="{ mostrarInativos: false }">
        <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg border border-slate-200">

            <div
                class="bg-slate-50 border-b border-slate-200 p-4 flex justify-between items-center sticky top-0 z-10 rounded-t-lg">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 flex items-center">
                        <span class="text-blue-600 mr-2">📦</span>
                        Controle de Estoque
                    </h2>
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Visão Geral de Lotes e Validades
                    </p>
                </div>

                <div class="flex items-center space-x-3">
                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" x-model="mostrarInativos"
                            class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-xs font-bold text-slate-600 uppercase">Mostrar Inativos</span>
                    </label>
                    <a href="{{ route('create_product') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-xs font-bold transition uppercase">
                        ✚ Novo Produto
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[10px] uppercase font-bold text-slate-500">
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Produto / Princípio Ativo</th>

                            <th class="px-6 py-4 text-center">Categoria</th>

                            <th class="px-6 py-4 text-center">Saldo Total</th>
                            <th class="px-6 py-4 text-center">Estoque Mín.</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($products as $product)
                            {{-- Filtro via Alpine.js --}}
                            <tr x-show="mostrarInativos || {{ $product->isActive ? 'true' : 'false' }}"
                                class="hover:bg-slate-50/50 transition duration-150"
                                :class="!{{ $product->isActive ? 'true' : 'false' }} ?
                                    'opacity-60 grayscale-[0.5] bg-slate-50' : ''">

                                <td class="px-6 py-4 text-center">
                                    @if ($product->isActive)
                                        <span
                                            class="w-2.5 h-2.5 rounded-full bg-green-500 inline-block shadow-sm shadow-green-200"></span>
                                    @else
                                        <span
                                            class="w-2.5 h-2.5 rounded-full bg-slate-300 inline-block shadow-sm shadow-slate-100"></span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-700 leading-tight">{{ $product->name }}</p>
                                    <p class="text-[11px] text-slate-400 font-medium italic">
                                        {{ $product->active_principle }}</p>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-1 rounded uppercase">
                                        {{ $product->category->class ?? 'Geral' }}
                                    </span>
                                    <span
                                        class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-1 rounded uppercase">
                                        {{ $product->category->subclass ?? 'Geral' }}
                                    </span>
                                </td>

                                @php
                                    $saldoTotal = $product->batch->sum('quantity_now');
                                    $isBaixo = $saldoTotal <= $product->min_stock_alert;
                                @endphp

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="text-sm font-bold {{ $isBaixo ? 'text-red-600 bg-red-50 px-3 py-1 rounded-full' : 'text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full' }}">
                                        {{ $saldoTotal }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center text-xs text-slate-500 font-bold">
                                    {{ $product->min_stock_alert }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button class="text-slate-400 hover:text-blue-600 transition" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="text-slate-400 hover:text-indigo-600 transition" title="Ver Lotes">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div
                class="bg-slate-50 p-4 border-t border-slate-200 flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                <span>Total de Itens: {{ $products->count() }}</span>
                <span>Sistema Pai e Filha - Inventário</span>
            </div>
        </div>
    </div>
@endsection
