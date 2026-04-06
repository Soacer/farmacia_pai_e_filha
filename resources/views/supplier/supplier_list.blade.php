@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 px-4 pb-12" x-data="{ mostrarInativos: true, editId: null }">
        <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg border border-slate-200">

            <div class="bg-slate-50 border-b border-slate-200 p-4 flex justify-between items-center sticky top-0 z-10 rounded-t-lg">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 flex items-center">
                        <span class="text-blue-600 mr-2">🏢</span>
                        Lista de Fornecedores
                    </h2>
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Gestão de Parceiros e Distribuidoras</p>
                </div>

                <div class="flex items-center space-x-3">
                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" x-model="mostrarInativos" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-xs font-bold text-slate-600 uppercase">Mostrar Inativos</span>
                    </label>
                    <a href="{{ route('create_supplier') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-xs font-bold transition uppercase tracking-widest">
                        ✚ Novo Fornecedor
                    </a>
                </div>
            </div>

            @include('partials._alerts')

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[10px] uppercase font-bold text-slate-500">
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Razão Social / Fantasia</th>
                            <th class="px-6 py-4">CNPJ / IE</th>
                            <th class="px-6 py-4">Contato Principal</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($suppliers as $supplier)
                            @php $address = $supplier->addresses->first(); @endphp
                            <tr x-show="mostrarInativos || {{ $supplier->isActive ? 'true' : 'false' }}" 
                                class="hover:bg-slate-50/50 transition duration-150"
                                :class="editId === {{ $supplier->id }} ? 'bg-blue-50/50' : (!{{ $supplier->isActive ? 'true' : 'false' }} ? 'opacity-60 grayscale-[0.5] bg-slate-50' : '')">
                                
                                <td class="px-6 py-4 text-center">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $supplier->isActive ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-slate-300' }} inline-block"></span>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-700 leading-tight uppercase">{{ $supplier->company_name }}</p>
                                    <p class="text-[11px] text-slate-400 font-medium italic">{{ $supplier->trade_name ?? '---' }}</p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-xs font-mono text-slate-600">{{ $supplier->cnpj }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase">IE: {{ $supplier->state_registration ?? 'Isento' }}</p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold text-slate-700">{{ $supplier->contact_name ?? '---' }}</p>
                                    <p class="text-[11px] text-blue-600 font-medium">{{ $supplier->phone }}</p>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="editId = (editId === {{ $supplier->id }} ? null : {{ $supplier->id }})" 
                                            class="text-slate-400 hover:text-blue-600 transition" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        
                                        <form action="{{ route('deactivate_supplier', $supplier->id) }}" method="POST" onsubmit="return confirm('Alterar status deste fornecedor?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-slate-400 hover:{{ $supplier->isActive ? 'text-red-600' : 'text-green-600' }} transition">
                                                <i class="fa-solid {{ $supplier->isActive ? 'fa-trash-can' : 'fa-rotate-left' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <tr x-show="editId === {{ $supplier->id }}" x-transition class="bg-blue-50/40">
                                <td colspan="5" class="p-6 border-l-4 border-blue-500 shadow-inner">
                                    <form action="{{ route('update_supplier', $supplier->id) }}" method="POST" class="space-y-6">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Razão Social</label>
                                                <input type="text" name="company_name" value="{{ $supplier->company_name }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Nome Fantasia</label>
                                                <input type="text" name="trade_name" value="{{ $supplier->trade_name }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">CNPJ (Somente Leitura)</label>
                                                <input type="text" value="{{ $supplier->cnpj }}" readonly class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-slate-50 text-slate-500 cursor-not-allowed">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Inscrição Estadual</label>
                                                <input type="text" name="state_registration" value="{{ $supplier->state_registration }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-blue-100 pt-4">
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">E-mail</label>
                                                <input type="email" name="email" value="{{ $supplier->email }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Telefone</label>
                                                <input type="text" name="phone" value="{{ $supplier->phone }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Pessoa de Contato</label>
                                                <input type="text" name="contact_name" value="{{ $supplier->contact_name }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white">
                                            </div>
                                        </div>

                                        @if($address)
                                        <div class="pt-4 border-t border-blue-100 space-y-4">
                                            <input type="hidden" name="idAddress" value="{{ $address->id }}">
                                            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                                                <div class="md:col-span-1">
                                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">CEP</label>
                                                    <input type="text" name="zip_code" value="{{ $address->zip_code }}" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                </div>
                                                <div class="md:col-span-4">
                                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Rua / Logradouro</label>
                                                    <input type="text" name="street" value="{{ $address->street }}" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                </div>
                                                <div class="md:col-span-1">
                                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nº</label>
                                                    <input type="text" name="number" value="{{ $address->number }}" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Complemento</label>
                                                    <input type="text" name="complement" value="{{ $address->complement }}" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bairro</label>
                                                    <input type="text" name="neighborhood" value="{{ $address->neighborhood }}" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                </div>
                                                <div class="grid grid-cols-3 gap-2">
                                                    <div class="col-span-2">
                                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Cidade</label>
                                                        <input type="text" name="city" value="{{ $address->city }}" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                    <div class="col-span-1">
                                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">UF</label>
                                                        <input type="text" name="state" value="{{ $address->state }}" maxlength="2" class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white text-center font-bold">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="flex justify-end space-x-3 mt-4">
                                            <button type="button" @click="editId = null" class="text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition">Cancelar</button>
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg shadow-lg text-xs font-bold uppercase tracking-widest transition active:scale-95">
                                                Atualizar Fornecedor
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-50 p-4 border-t border-slate-200 flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                <span>Total de Fornecedores: {{ $suppliers->count() }}</span>
                <span>Farmácia Pai e Filha - ERP v1.5</span>
            </div>
        </div>
    </div>
@endsection