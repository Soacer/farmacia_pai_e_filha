@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 px-4 pb-12" x-data="{ mostrarInativos: true, editId: null }">
        <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg border border-slate-200">

            <div class="bg-slate-50 border-b border-slate-200 p-4 flex justify-between items-center rounded-t-lg">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 flex items-center">
                        <span class="text-blue-600 mr-2">📑</span>
                        Gestão de Lotes
                    </h2>
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Rastreabilidade e Controle de Validades</p>
                </div>

                <div class="flex items-center space-x-3">
                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" x-model="mostrarInativos" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-xs font-bold text-slate-600 uppercase">Mostrar Inativos</span>
                    </label>
                </div>
            </div>

            @include('partials._alerts')

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[10px] uppercase font-bold text-slate-500">
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Cód. Lote / Produto</th>
                            <th class="px-6 py-4 text-center">Validade</th>
                            <th class="px-6 py-4 text-center">Qtd Atual</th>
                            <th class="px-6 py-4 text-center">Custo Unit.</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($batches as $batch)
                            <tr x-show="mostrarInativos || {{ $batch->isActive ? 'true' : 'false' }}" 
                                class="hover:bg-slate-50/50 transition duration-150"
                                :class="editId === '{{ $batch->id }}' ? 'bg-blue-50/50' : (!{{ $batch->isActive ? 'true' : 'false' }} ? 'opacity-60 bg-slate-50' : '')">
                                
                                <td class="px-6 py-4 text-center">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $batch->isActive ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-slate-300' }} inline-block"></span>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-700 leading-tight uppercase">{{ $batch->batch_code }}</p>
                                    <p class="text-[11px] text-blue-600 font-medium italic">{{ $batch->product->name ?? '---' }}</p>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @php 
                                        $vencido = \Carbon\Carbon::parse($batch->expiration_date)->isPast();
                                    @endphp
                                    <span class="text-xs font-bold {{ $vencido ? 'text-red-600 bg-red-50 px-2 py-1 rounded' : 'text-slate-600' }}">
                                        {{ date('d/m/Y', strtotime($batch->expiration_date)) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-black {{ $batch->quantity_now <= 5 ? 'text-red-600' : 'text-slate-700' }}">
                                        {{ $batch->quantity_now }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center text-xs font-mono text-slate-500">
                                    R$ {{ number_format($batch->cost_price, 2, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="editId = (editId === '{{ $batch->id }}' ? null : '{{ $batch->id }}')" 
                                            class="text-slate-400 hover:text-blue-600 transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        
                                        <form action="{{ route('batches.toggle', $batch->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-slate-400 hover:{{ $batch->isActive ? 'text-red-600' : 'text-green-600' }} transition">
                                                <i class="fa-solid {{ $batch->isActive ? 'fa-trash-can' : 'fa-rotate-left' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Form de Edição Rápida --}}
                            <tr x-show="editId === '{{ $batch->id }}'" x-transition x-cloak class="bg-blue-50/40">
                                <td colspan="6" class="p-6 border-l-4 border-blue-500">
                                    <form action="{{ route('batches.update', $batch->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                                        @csrf @method('PUT')
                                        
                                        <div class="md:col-span-1">
                                            <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Cód. Lote</label>
                                            <input type="text" name="batch_code" value="{{ $batch->batch_code }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Qtd Atual</label>
                                            <input type="number" name="quantity_now" value="{{ $batch->quantity_now }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Validade</label>
                                            <input type="date" name="expiration_date" value="{{ $batch->expiration_date }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-blue-700 uppercase mb-1">Custo (R$)</label>
                                            <input type="text" name="cost_price" value="{{ number_format($batch->cost_price, 2, ',', '.') }}" class="w-full px-3 py-2 rounded border border-blue-200 text-sm outline-none font-bold text-blue-600">
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded shadow hover:bg-blue-700 transition font-bold text-xs uppercase">Salvar</button>
                                            <button type="button" @click="editId = null" class="bg-slate-200 text-slate-600 px-4 py-2 rounded hover:bg-slate-300 transition">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="bg-slate-50 p-4 border-t border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                Total de Registros: {{ $batches->count() }}
            </div>
        </div>
    </div>
@endsection