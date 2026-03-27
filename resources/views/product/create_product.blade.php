@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg border border-slate-200">
        
        <div class="bg-slate-50 border-b border-slate-200 p-4">
            <h2 class="text-xl font-bold text-slate-800 flex items-center">
                <span class="text-green-600 mr-2">✚</span>
                Cadastro de Medicamento
            </h2>
        </div>

        <div class="p-6">
            {{-- Alertas --}}
            @include('partials._alerts')

            <form action="{{ route('store_product') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nome do Produto</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm" 
                            placeholder="Ex: Paracetamol 500mg">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Categoria</label>
                        <select name="idCategory" required
                            class="w-full px-3 py-2 rounded border border-slate-300 bg-white text-sm outline-none">
                            <option value="">Selecione...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('idCategory') == $category->id ? 'selected' : '' }}>
                                    {{ $category->class }} - {{ $category->subclass }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Código de Barras (EAN)</label>
                        <input type="text" name="barcode" value="{{ old('barcode') }}" maxlength="13"
                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none" 
                            placeholder="789...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Princípio Ativo</label>
                        <input type="text" name="active_principle" value="{{ old('active_principle') }}"
                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none" 
                            placeholder="Ex: Dipirona">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Descrição Comercial</label>
                    <textarea name="description" rows="2" 
                        class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none resize-none" 
                        placeholder="Detalhes técnicos ou de venda...">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-lg border border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Preço de Venda</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-sm">R$</span>
                            <input type="text" name="price" value="{{ old('price') }}" required
                                class="w-full pl-9 pr-3 py-2 rounded border border-slate-300 text-sm font-semibold outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Alerta de Estoque Mínimo</label>
                        <input type="number" name="min_stock_alert" value="{{ old('min_stock_alert', 5) }}"
                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none">
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="requires_prescription" value="1" id="presc" 
                                class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-xs font-bold text-red-700 uppercase">Reter Receita?</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end items-center space-x-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('create_product') }}" class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 transition">
                        LIMPAR
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded shadow font-bold text-sm transition uppercase">
                        Gravar Medicamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection