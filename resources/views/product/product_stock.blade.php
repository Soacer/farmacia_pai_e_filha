@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 px-4 pb-12" x-data="{ mostrarInativos: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg border border-slate-200">

            <div class="bg-slate-50 border-b border-slate-200 p-4 flex flex-wrap justify-between items-center rounded-t-lg gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 flex items-center">
                        <span class="text-blue-600 mr-2">📦</span>
                        Controle de Estoque
                    </h2>
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Visão Geral de Lotes e Validades</p>
                </div>

                <div class="flex items-center space-x-3">
                    <form action="{{ url()->current() }}" method="GET" class="flex items-center space-x-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Ver:</label>
                        <select name="per_page" onchange="this.form.submit()" 
                            class="text-xs border-slate-300 rounded focus:ring-blue-500 py-1 pl-2 pr-8 bg-white font-bold text-slate-600">
                            @foreach([10, 15, 20, 25, 30] as $opcao)
                                <option value="{{ $opcao }}" {{ request('per_page') == $opcao ? 'selected' : '' }}>{{ $opcao }}</option>
                            @endforeach
                        </select>
                    </form>

                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" x-model="mostrarInativos"
                            class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-xs font-bold text-slate-600 uppercase">Mostrar Inativos</span>
                    </label>
                    <a href="{{ route('create_product') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-xs font-bold transition uppercase tracking-widest">
                        ✚ Novo Produto
                    </a>
                </div>
            </div>

            @include('partials._alerts')

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[10px] uppercase font-bold text-slate-500">
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Produto / Princípio Ativo</th>
                            <th class="px-6 py-4 text-center">Categoria</th>
                            <th class="px-6 py-4 text-center">Saldo Total</th>
                            <th class="px-6 py-4 text-center">Estoque Mín.</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($products as $product)
                            <tr x-show="mostrarInativos || {{ $product->isActive ? 'true' : 'false' }}"
                                class="hover:bg-slate-50/50 transition duration-150"
                                :class="editId === '{{ $product->id }}' ? 'bg-blue-50/50' : ''">

                                <td class="px-6 py-4 text-center">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $product->isActive ? 'bg-green-500 shadow-green-200' : 'bg-slate-300' }} inline-block shadow-sm"></span>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-700 leading-tight">{{ $product->name }}</p>
                                    <p class="text-[11px] text-slate-400 font-medium italic">{{ $product->active_principle }}</p>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-1 rounded uppercase">
                                        {{ $product->category->class ?? 'Geral' }}
                                    </span>
                                </td>

                                @php
                                    $loteAtual = $product->batch->first();
                                    $saldoTotal = $product->batch->sum('quantity_now');
                                    $isBaixo = $saldoTotal <= $product->min_stock_alert;
                                @endphp

                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-bold {{ $isBaixo ? 'text-red-600 bg-red-50 px-3 py-1 rounded-full' : 'text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full' }}">
                                        {{ $saldoTotal }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center text-xs text-slate-500 font-bold">
                                    {{ $product->min_stock_alert }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="editId = (editId === '{{ $product->id }}' ? null : '{{ $product->id }}')"
                                            class="text-slate-400 hover:text-blue-600 transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        @if ($product->isActive)
                                            <form action="{{ route('deactivate_product', $product->id) }}" method="POST"
                                                onsubmit="return confirm('Deseja realmente inativar este produto?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="text-slate-400 hover:text-red-600 transition" title="Inativar Produto">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('deactivate_product', $product->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="text-slate-300 hover:text-green-600 transition" title="Reativar Produto">
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Formulário de Edição --}}
                            <tr x-show="editId === '{{ $product->id }}'" x-transition class="bg-blue-50/40" x-cloak>
                                <td colspan="6" class="p-0 border-l-4 border-blue-500">
                                    <form action="{{ route('update_product', $product->id) }}" enctype="multipart/form-data" method="POST" class="p-6 space-y-6">
                                        @csrf @method('PUT')
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div class="md:col-span-2">
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Nome do Produto</label>
                                                <input type="text" name="name" value="{{ $product->name }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm focus:ring-1 focus:ring-blue-500 outline-none bg-white">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Categoria</label>
                                                <select name="idCategory" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white outline-none">
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $product->idCategory == $cat->id ? 'selected' : '' }}>{{ $cat->class }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Cód. Barras</label>
                                                <input type="text" name="barcode" value="{{ $product->barcode }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white outline-none">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div class="md:col-span-2">
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Princípio Ativo</label>
                                                <input type="text" name="active_principle" value="{{ $product->active_principle }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Fornecedor</label>
                                                <select name="idSupplier" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white outline-none">
                                                    <option value="">Selecione um fornecedor...</option>
                                                    @foreach ($suppliers as $sup)
                                                        <option value="{{ $sup->id }}" {{ ($loteAtual->idSuppliers ?? '') == $sup->id ? 'selected' : '' }}>{{ $sup->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Descrição Comercial</label>
                                            <textarea name="description" rows="2" class="w-full px-3 py-2 rounded border border-blue-200 text-sm outline-none resize-none focus:border-blue-500 bg-white shadow-sm">{{ $product->description }}</textarea>
                                        </div>

                                        @if ($loteAtual)
                                            <div class="pt-4 border-t border-blue-100">
                                                <h3 class="text-[10px] font-bold text-slate-600 uppercase mb-3 flex items-center">
                                                    <span class="w-2 h-4 bg-emerald-500 rounded-full mr-2"></span> Informações do Lote Atual
                                                </h3>
                                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                                    <input type="hidden" name="idBatch" value="{{ $loteAtual->id }}">
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Cód. Lote</label>
                                                        <input type="text" name="batch_code" value="{{ $loteAtual->batch_code }}" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Vencimento</label>
                                                        <input type="date" name="expiration_date" value="{{ $loteAtual->expiration_date }}" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Qtd Atual</label>
                                                        <input type="number" name="quantity_now" value="{{ $loteAtual->quantity_now }}" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Preço (R$)</label>
                                                        <input type="text" name="price" value="{{ number_format($product->price, 2, ',', '.') }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm font-bold text-blue-700 bg-white">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="flex justify-between items-center pt-4 border-t border-blue-100">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" name="requires_prescription" value="1" {{ $product->requires_prescription ? 'checked' : '' }} class="w-4 h-4 text-red-600 rounded">
                                                <span class="ml-2 text-[10px] font-bold text-slate-600 uppercase">Reter Receita</span>
                                            </label>
                                            <div class="flex space-x-3">
                                                <button type="button" @click="editId = null" class="text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest">Cancelar</button>
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow-lg text-xs font-bold transition uppercase tracking-widest transform active:scale-95">Salvar Alterações</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-white border-t border-slate-100">
                {{ $products->links() }}
            </div>

            <div class="bg-slate-50 p-4 border-t border-slate-200 flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                <span>Total no Sistema: {{ $products->total() }}</span>
                <span>Página {{ $products->currentPage() }} de {{ $products->lastPage() }}</span>
            </div>
        </div>
    </div>
@endsection