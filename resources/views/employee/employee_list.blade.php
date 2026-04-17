@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 px-4 pb-12" x-data="{ mostrarInativos: true, editId: null, requiresCrf: false }">
        <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg border border-slate-200">

            <div
                class="bg-slate-50 border-b border-slate-200 p-4 flex justify-between items-center sticky top-0 z-10 rounded-t-lg">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 flex items-center">
                        <span class="text-blue-600 mr-2">👥</span>
                        Lista de Funcionários
                    </h2>
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Gestão de Colaboradores e
                        Acessos</p>
                </div>

                <div class="flex items-center space-x-3">
                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" x-model="mostrarInativos"
                            class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-xs font-bold text-slate-600 uppercase">Mostrar Inativos</span>
                    </label>
                    <a href="{{ route('create_employee') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-xs font-bold transition uppercase tracking-widest">
                        ✚ Novo Funcionário
                    </a>
                </div>
            </div>

            @include('partials._alerts')

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[10px] uppercase font-bold text-slate-500">
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Colaborador / Cargo</th>
                            <th class="px-6 py-4">Documentos (CPF/RG)</th>
                            <th class="px-6 py-4">Contato</th>
                            <th class="px-6 py-4 text-center">Salário / Admissão</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($employees as $employee)
                            @php $address = $employee->address; @endphp
                            <tr x-show="mostrarInativos || {{ $employee->isActive ? 'true' : 'false' }}"
                                class="hover:bg-slate-50/50 transition duration-150"
                                :class="editId === {{ $employee->id }} ? 'bg-blue-50/50' : (!
                                    {{ $employee->isActive ? 'true' : 'false' }} ?
                                    'opacity-60 grayscale-[0.5] bg-slate-50' : '')">

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="w-2.5 h-2.5 rounded-full {{ $employee->isActive ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-slate-300' }} inline-block"></span>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-700 leading-tight">{{ $employee->user->name }}
                                    </p>
                                    <p class="text-[11px] text-blue-600 font-bold uppercase tracking-tighter">
                                        {{ $employee->occupation->name ?? 'Não Definido' }}
                                        @if ($employee->crf)
                                            <span
                                                class="ml-1 text-red-500 text-[9px] font-medium border border-red-200 px-1 rounded">CRF:
                                                {{ $employee->crf }}</span>
                                        @endif
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-xs font-mono text-slate-600">{{ $employee->cpf }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase">RG: {{ $employee->rg ?? '---' }}</p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold text-slate-700">{{ $employee->phone }}</p>
                                    <p class="text-[10px] text-slate-400 lowercase">{{ $employee->user->email }}</p>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <p class="text-xs font-bold text-emerald-700">R$
                                        {{ number_format($employee->salary, 2, ',', '.') }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium italic">
                                        {{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}</p>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button
                                            @click="editId = (editId === {{ $employee->id }} ? null : {{ $employee->id }}); requiresCrf = '{{ $employee->occupation->requires_crf ?? 0 }}' == '1'"
                                            class="text-slate-400 hover:text-blue-600 transition"
                                            title="Editar Funcionário">
                                            <i class="fa-solid fa-user-pen"></i>
                                        </button>

                                        <form action="{{ route('deactivate_employee', $employee->id) }}" method="POST"
                                            onsubmit="return confirm('Deseja alterar o status deste funcionário?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-slate-400 hover:{{ $employee->isActive ? 'text-red-600' : 'text-green-600' }} transition">
                                                <i
                                                    class="fa-solid {{ $employee->isActive ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <tr x-show="editId === {{ $employee->id }}" x-transition class="bg-blue-50/40">
                                <td colspan="6" class="p-8 border-l-4 border-blue-500 shadow-inner">
                                    <form action="{{ route('update_employee', $employee->id) }}" method="POST"
                                        class="space-y-8">
                                        @csrf
                                        @method('PUT')

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="space-y-3">
                                                <h4
                                                    class="text-[10px] font-bold text-blue-700 uppercase tracking-widest border-b border-blue-100 pb-1">
                                                    Acesso</h4>
                                                <div>
                                                    <label
                                                        class="block text-[9px] font-bold text-slate-500 uppercase">E-mail
                                                        de Login</label>
                                                    <input type="email" name="email"
                                                        value="{{ $employee->user->email }}"
                                                        class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white">
                                                </div>
                                                <div>
                                                    <label class="block text-[9px] font-bold text-slate-500 uppercase">Nova
                                                        Senha (opcional)</label>
                                                    <input type="password" name="password"
                                                        placeholder="Deixe em branco para manter"
                                                        class="w-full px-3 py-2 rounded border border-blue-200 text-sm bg-white">
                                                </div>
                                            </div>

                                            <div class="space-y-3">
                                                <h4
                                                    class="text-[10px] font-bold text-indigo-700 uppercase tracking-widest border-b border-indigo-100 pb-1">
                                                    Contrato</h4>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <label
                                                            class="block text-[9px] font-bold text-slate-500 uppercase">Cargo</label>
                                                        <select name="idOccupation" required
                                                            @change="requiresCrf = $event.target.options[$event.target.selectedIndex].getAttribute('data-crf') === '1'"
                                                            class="w-full px-3 py-2 rounded border border-indigo-200 text-sm bg-white">
                                                            @foreach ($occupations as $occ)
                                                                <option value="{{ $occ->id }}"
                                                                    data-crf="{{ $occ->requires_crf }}"
                                                                    {{ $employee->idOccupation == $occ->id ? 'selected' : '' }}>
                                                                    {{ $occ->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div x-show="requiresCrf">
                                                        <label
                                                            class="block text-[9px] font-bold text-red-600 uppercase">CRF</label>
                                                        <input type="text" name="crf" value="{{ $employee->crf }}"
                                                            class="w-full px-3 py-2 rounded border border-red-200 text-sm bg-white">
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <label
                                                            class="block text-[9px] font-bold text-slate-500 uppercase">Salário
                                                            (R$)</label>
                                                        <input type="text" name="salary"
                                                            value="{{ number_format($employee->salary, 2, ',', '.') }}"
                                                            class="w-full px-3 py-2 rounded border border-indigo-200 text-sm bg-white font-bold text-emerald-700">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-[9px] font-bold text-slate-500 uppercase">Admissão</label>
                                                        <input type="date" name="hire_date"
                                                            value="{{ $employee->hire_date }}"
                                                            class="w-full px-3 py-2 rounded border border-indigo-200 text-sm bg-white">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="space-y-3">
                                                <h4
                                                    class="text-[10px] font-bold text-slate-700 uppercase tracking-widest border-b border-slate-200 pb-1">
                                                    Documentação</h4>
                                                <div>
                                                    <label
                                                        class="block text-[9px] font-bold text-slate-500 uppercase">RG</label>
                                                    <input type="text" name="rg" value="{{ $employee->rg }}"
                                                        class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <label
                                                            class="block text-[9px] font-bold text-slate-500 uppercase">PIS</label>
                                                        <input type="text" name="pis"
                                                            value="{{ $employee->pis }}"
                                                            class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-[9px] font-bold text-slate-500 uppercase">CTPS</label>
                                                        <input type="text" name="ctps"
                                                            value="{{ $employee->ctps }}"
                                                            class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-[10px] font-bold text-slate-500 uppercase mb-1">CPF</label>
                                                        <input type="text" name="cpf"
                                                            value="{{ $employee->cpf }}" required
                                                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($address)
                                            <div class="pt-4 border-t border-blue-100">
                                                <h4
                                                    class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">
                                                    Endereço Residencial</h4>
                                                <input type="hidden" name="idAddress" value="{{ $address->id }}">
                                                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                                                    <div class="md:col-span-1">
                                                        <label
                                                            class="block text-[9px] font-bold text-slate-400 uppercase">CEP</label>
                                                        <input type="text" name="zip_code"
                                                            value="{{ $address->zip_code }}"
                                                            class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                    <div class="md:col-span-3">
                                                        <label
                                                            class="block text-[9px] font-bold text-slate-400 uppercase">Rua</label>
                                                        <input type="text" name="street"
                                                            value="{{ $address->street }}"
                                                            class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                    <div class="md:col-span-1">
                                                        <label
                                                            class="block text-[9px] font-bold text-slate-400 uppercase">Bairro</label>
                                                        <input type="text" name="neighborhood"
                                                            value="{{ $address->neighborhood }}"
                                                            class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                    <div class="md:col-span-1">
                                                        <label
                                                            class="block text-[9px] font-bold text-slate-400 uppercase">Nº</label>
                                                        <input type="text" name="number"
                                                            value="{{ $address->number }}"
                                                            class="w-full px-3 py-2 rounded border border-slate-200 text-sm bg-white">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="flex justify-end space-x-3 mt-6">
                                            <button type="button" @click="editId = null"
                                                class="text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest">Cancelar</button>
                                            <button type="submit"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-2 rounded-lg shadow-lg text-xs font-bold uppercase tracking-widest transition active:scale-95">
                                                Salvar Dados do Funcionário
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div
                class="bg-slate-50 p-4 border-t border-slate-200 flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                <span>Total de Colaboradores: {{ $employees->count() }}</span>
                <span>Farmácia Pai e Filha - RH Corporativo</span>
            </div>
        </div>
    </div>
@endsection
