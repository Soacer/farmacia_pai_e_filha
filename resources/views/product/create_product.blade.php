@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 px-4 pb-12" x-data="{ novoFornecedor: false, addLote: false }">
        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg border border-slate-200">

            <div class="bg-slate-50 border-b border-slate-200 p-4 flex justify-between items-center rounded-t-lg">
                <h2 class="text-xl font-bold text-slate-800 flex items-center">
                    <span class="text-green-600 mr-2">✚</span>
                    Cadastro de Medicamento
                </h2>
                <div class="flex space-x-2">
                    <span
                        class="text-[10px] font-bold bg-blue-100 text-blue-700 px-2 py-1 rounded uppercase tracking-wider">Estoque</span>
                    <span
                        class="text-[10px] font-bold bg-slate-200 text-slate-600 px-2 py-1 rounded uppercase tracking-wider">v1.4</span>
                </div>
            </div>

            <div class="p-6">
                @include('partials._alerts')

                <form action="{{ route('store_product') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-2 h-4 bg-blue-600 rounded-full"></span>
                            <h3 class="text-sm font-bold text-slate-700 uppercase">Informações Básicas</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nome do Produto</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm transition shadow-sm"
                                    placeholder="Ex: Paracetamol 500mg">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Categoria</label>
                                <select name="idCategory" required
                                    class="w-full px-3 py-2 rounded border border-slate-300 bg-white text-sm outline-none focus:border-blue-500 shadow-sm">
                                    <option value="">Selecione...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('idCategory') == $category->id ? 'selected' : '' }}>
                                            {{ $category->class }} - {{ $category->subclass }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Código de Barras
                                    (EAN)</label>
                                <input type="text" name="barcode" value="{{ old('barcode') }}" maxlength="13" required
                                    class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-blue-500 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Princípio Ativo</label>
                                <input type="text" name="active_principle" value="{{ old('active_principle') }}"
                                    class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-blue-500 shadow-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Descrição Comercial /
                                Detalhes</label>
                            <textarea name="description" rows="2"
                                class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none resize-none focus:border-blue-500 shadow-sm"
                                placeholder="Breve descrição técnica ou apresentação comercial...">{{ old('description') }}</textarea>
                        </div>
                        <div class="bg-blue-50/30 p-4 rounded-lg border border-dashed border-blue-200">
                            <label class="block text-xs font-bold text-blue-700 uppercase mb-2">Foto do Produto
                                (Vitrine)</label>
                            <input type="file" name="image_product" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                            <p class="mt-2 text-[10px] text-slate-400">Recomendado: 800x800px (Fundo branco) | Máx:
                                2MB</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-4 bg-indigo-600 rounded-full"></span>
                                <h3 class="text-sm font-bold text-slate-700 uppercase">Fornecedor</h3>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="toggleFornecedor" x-model="novoFornecedor" name="novoFornecedor"
                                    value="1"
                                    class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                                <label for="toggleFornecedor"
                                    class="ml-2 text-[11px] font-bold text-indigo-700 cursor-pointer uppercase">Cadastrar
                                    Novo Fornecedor?</label>
                            </div>
                        </div>

                        <div x-show="!novoFornecedor" x-transition>
                            <select name="idSupplier"
                                class="w-full px-3 py-2 rounded border border-slate-300 bg-slate-50 text-sm outline-none focus:border-indigo-500">
                                <option value="">Nenhum fornecedor selecionado (Pular)</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->company_name }} -
                                        {{ $supplier->cnpj }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div x-show="novoFornecedor" x-transition class="space-y-6">
                            <div class="bg-indigo-50/30 p-5 rounded-lg border border-indigo-100 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-indigo-900 uppercase mb-1">Razão
                                            Social</label>
                                        <input type="text" name="company_name" :required="novoFornecedor"
                                            class="w-full px-3 py-2 rounded border border-indigo-200 text-sm outline-none bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-indigo-900 uppercase mb-1">Nome
                                            Fantasia</label>
                                        <input type="text" name="trade_name"
                                            class="w-full px-3 py-2 rounded border border-indigo-200 text-sm outline-none bg-white">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-indigo-900 uppercase mb-1">CNPJ</label>
                                        <input type="text" name="cnpj" :required="novoFornecedor"
                                            class="w-full px-3 py-2 rounded border border-indigo-200 text-sm outline-none bg-white"
                                            placeholder="00.000.000/0001-00">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-indigo-900 uppercase mb-1">Inscrição
                                            Estadual</label>
                                        <input type="text" name="state_registration"
                                            class="w-full px-3 py-2 rounded border border-indigo-200 text-sm outline-none bg-white">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-slate-50 p-5 rounded-lg border border-slate-200 space-y-4">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="w-2 h-4 bg-indigo-400 rounded-full"></span>
                                    <h3 class="text-xs font-bold text-slate-700 uppercase">Contato Comercial</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-600 uppercase mb-1">E-mail</label>
                                        <input type="email" name="email" :required="novoFornecedor"
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none bg-white">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Telefone</label>
                                        <input type="text" name="phone" :required="novoFornecedor"
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none bg-white"
                                            placeholder="(71) 00000-0000">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Pessoa de
                                            Contato</label>
                                        <input type="text" name="contact_name"
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none bg-white">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-slate-50 p-5 rounded-lg border border-slate-200 space-y-4">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="w-2 h-4 bg-emerald-500 rounded-full"></span>
                                    <h3 class="text-xs font-bold text-slate-700 uppercase">Endereço do Fornecedor</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                                    <div class="md:col-span-2">
                                        <label
                                            class="block text-[10px] font-bold text-slate-600 uppercase mb-1">CEP</label>
                                        <input type="text" name="zip_code" :required="novoFornecedor"
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-blue-500 bg-white shadow-sm"
                                            placeholder="00000-000">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label
                                            class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Logradouro</label>
                                        <input type="text" name="street" :required="novoFornecedor"
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-blue-500 bg-white shadow-sm">
                                    </div>
                                    <div class="md:col-span-1">
                                        <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Nº</label>
                                        <input type="text" name="number" :required="novoFornecedor"
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-blue-500 bg-white shadow-sm">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label
                                            class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Complemento</label>
                                        <input type="text" name="complement"
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none bg-white shadow-sm"
                                            placeholder="Apto, Sala, Galpão...">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label
                                            class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Bairro</label>
                                        <input type="text" name="neighborhood" :required="novoFornecedor"
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none bg-white shadow-sm">
                                    </div>
                                    <div class="md:col-span-4">
                                        <label
                                            class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Cidade</label>
                                        <input type="text" name="city" value="Salvador" required
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none bg-white shadow-sm">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">UF</label>
                                        <input type="text" name="state" value="BA" maxlength="2" required
                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm text-center font-bold bg-white uppercase">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-4 bg-emerald-600 rounded-full"></span>
                                <h3 class="text-sm font-bold text-slate-700 uppercase">Estoque / Lote (Opcional)</h3>
                            </div>
                            <button type="button" @click="addLote = !addLote"
                                class="text-[10px] font-bold px-4 py-1.5 rounded-full border transition-all"
                                :class="addLote ? 'bg-red-50 text-red-600 border-red-200' :
                                    'bg-emerald-50 text-emerald-600 border-emerald-200 hover:bg-emerald-100'">
                                <span x-text="addLote ? '✖ REMOVER LOTE' : '✚ INFORMAR LOTE AGORA'"></span>
                            </button>
                        </div>

                        <div x-show="addLote" x-transition
                            class="bg-emerald-50/20 p-5 rounded-lg border border-emerald-100 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-emerald-900 uppercase mb-1">Cód. do
                                        Lote</label>
                                    <input type="text" name="batch_code" :required="addLote"
                                        class="w-full px-3 py-2 rounded border border-emerald-200 text-sm outline-none focus:border-emerald-500 bg-white shadow-sm"
                                        placeholder="Ex: LOT-2026/01">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-emerald-900 uppercase mb-1">Data de
                                        Fabricação</label>
                                    <input type="date" name="manufacturing_date" :required="addLote"
                                        class="w-full px-3 py-2 rounded border border-emerald-200 text-sm bg-white shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-emerald-900 uppercase mb-1">Data de
                                        Vencimento</label>
                                    <input type="date" name="expiration_date" :required="addLote"
                                        class="w-full px-3 py-2 rounded border border-emerald-200 text-sm bg-white shadow-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-emerald-900 uppercase mb-1">Quantidade
                                        Inicial</label>
                                    <input type="number" name="quantity" :required="addLote"
                                        class="w-full px-3 py-2 rounded border border-emerald-200 text-sm bg-white shadow-sm"
                                        placeholder="0">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-emerald-900 uppercase mb-1">Preço de
                                        Custo (Unidade)</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center text-emerald-400 text-sm font-bold">R$</span>
                                        <input type="text" name="cost_price" :required="addLote"
                                            class="w-full pl-9 pr-3 py-2 rounded border border-emerald-200 text-sm font-bold outline-none focus:border-emerald-500 text-emerald-700 bg-white shadow-sm"
                                            placeholder="0,00">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-lg border border-slate-200">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Preço de Venda
                                Final</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-sm font-bold">R$</span>
                                <input type="text" name="price" value="{{ old('price') }}" required
                                    class="w-full pl-9 pr-3 py-2 rounded border border-slate-300 text-sm font-bold outline-none focus:border-blue-500 text-blue-700 bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Alerta de Estoque
                                Mínimo</label>
                            <input type="number" name="min_stock_alert" value="{{ old('min_stock_alert', 5) }}"
                                class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-blue-500 bg-white shadow-sm">
                        </div>
                        <div class="flex items-end pb-1 px-2">
                            <label class="flex items-center cursor-pointer select-none group">
                                <input type="checkbox" name="requires_prescription" value="1"
                                    class="w-5 h-5 text-red-600 border-slate-300 rounded focus:ring-red-500 cursor-pointer">
                                <span
                                    class="ml-2 text-xs font-bold text-slate-600 group-hover:text-red-700 uppercase transition">Reter
                                    Receita?</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end items-center space-x-4 pt-4 border-t border-slate-100">
                        <button type="reset"
                            class="text-sm font-bold text-slate-400 hover:text-slate-600 transition uppercase tracking-tighter">Limpar
                            Tudo</button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-lg shadow-lg font-bold text-sm transition uppercase tracking-widest transform active:scale-95">
                            Gravar no Inventário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
