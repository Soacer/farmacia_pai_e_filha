@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 px-4 pb-12" x-data="{ cadastrarEndereco: false }">
        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg border border-slate-200">

            <div class="bg-slate-50 border-b border-slate-200 p-4 flex justify-between items-center sticky top-0 z-10 rounded-t-lg">
                <h2 class="text-xl font-bold text-slate-800 flex items-center">
                    <span class="text-blue-600 mr-2">🏢</span>
                    Novo Fornecedor
                </h2>
                <div class="flex space-x-2">
                    <span class="text-[10px] font-bold bg-indigo-100 text-indigo-700 px-2 py-1 rounded uppercase tracking-wider">Suprimentos</span>
                    <span class="text-[10px] font-bold bg-slate-200 text-slate-600 px-2 py-1 rounded uppercase tracking-wider">v1.1</span>
                </div>
            </div>

            <div class="p-6">
                {{-- Alertas de Sucesso/Erro --}}
                @include('partials._alerts')

                <form action="{{ route('store_supplier') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-2 h-4 bg-blue-600 rounded-full"></span>
                            <h3 class="text-sm font-bold text-slate-700 uppercase">Dados Jurídicos</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Razão Social (Oficial)</label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}" required
                                    class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm transition"
                                    placeholder="Ex: DISTRIBUIDORA BAHIA LTDA">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nome Fantasia (Comercial)</label>
                                <input type="text" name="trade_name" value="{{ old('trade_name') }}"
                                    class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm transition"
                                    placeholder="Ex: Farma Distribuidora">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">CNPJ</label>
                                <input type="text" name="cnpj" value="{{ old('cnpj') }}" required
                                    class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm transition"
                                    placeholder="00.000.000/0001-00">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Inscrição Estadual (IE)</label>
                                <input type="text" name="state_registration" value="{{ old('state_registration') }}"
                                    class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm transition"
                                    placeholder="Isento ou Nº da Inscrição">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="w-2 h-4 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-sm font-bold text-slate-700 uppercase">Contato Comercial</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-lg border border-slate-200">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pessoa de Contato</label>
                                <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                                    class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm transition"
                                    placeholder="Ex: João Silva">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Telefone / WhatsApp</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                    class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm transition"
                                    placeholder="(71) 00000-0000">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">E-mail de Pedidos</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm transition"
                                    placeholder="pedidos@fornecedor.com">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-4 bg-emerald-500 rounded-full"></span>
                                <h3 class="text-sm font-bold text-slate-700 uppercase">Endereço do Fornecedor</h3>
                            </div>
                            
                            {{-- Checkbox que controla a visibilidade --}}
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="has_address" x-model="cadastrarEndereco" value="1"
                                    class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500 cursor-pointer transition">
                                <span class="ml-2 text-[10px] font-bold text-emerald-700 uppercase group-hover:text-emerald-800 transition">Cadastrar endereço agora?</span>
                            </label>
                        </div>

                        {{-- Esta div só aparece se 'cadastrarEndereco' for true --}}
                        <div x-show="cadastrarEndereco" x-transition:enter="transition ease-out duration-300" 
                             x-transition:enter-start="opacity-0 transform -translate-y-4" 
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="space-y-4 bg-emerald-50/20 p-5 rounded-lg border border-emerald-100">
                            
                            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">CEP</label>
                                    <input type="text" name="zip_code" :required="cadastrarEndereco"
                                        class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-emerald-500 bg-white shadow-sm"
                                        placeholder="00000-000">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Logradouro (Rua/Av)</label>
                                    <input type="text" name="street" :required="cadastrarEndereco"
                                        class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-emerald-500 bg-white shadow-sm">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Nº</label>
                                    <input type="text" name="number" :required="cadastrarEndereco"
                                        class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-emerald-500 bg-white shadow-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Complemento</label>
                                    <input type="text" name="complement"
                                        class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-emerald-500 bg-white shadow-sm"
                                        placeholder="Galpão, Sala, Apto...">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Bairro</label>
                                    <input type="text" name="neighborhood" :required="cadastrarEndereco"
                                        class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-emerald-500 bg-white shadow-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                                <div class="md:col-span-4">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Cidade</label>
                                    <input type="text" name="city" value="Salvador" :required="cadastrarEndereco"
                                        class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-emerald-500 bg-white shadow-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">UF</label>
                                    <input type="text" name="state" value="BA" maxlength="2" :required="cadastrarEndereco"
                                        class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-emerald-500 bg-white shadow-sm text-center font-bold">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end items-center space-x-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('create_supplier') }}"
                            class="text-sm font-bold text-slate-400 hover:text-slate-600 transition uppercase tracking-tighter">
                            Limpar Campos
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-lg shadow-lg font-bold text-sm transition uppercase tracking-widest transform active:scale-95">
                            Salvar Fornecedor
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="max-w-4xl mx-auto mt-4 flex justify-start items-center px-2">
            <a href="{{ route('create_product') }}"
                class="text-xs font-bold text-blue-600 hover:underline flex items-center">
                <span class="mr-1">←</span> Voltar para Cadastro de Medicamentos
            </a>
        </div>
    </div>
@endsection