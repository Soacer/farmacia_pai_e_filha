@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 px-4 pb-12" x-data="{ requiresCrf: false }">
        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg border border-slate-200">
            
            <div class="bg-slate-50 border-b border-slate-200 p-4 flex justify-between items-center rounded-t-lg">
                <h2 class="text-xl font-bold text-slate-800 flex items-center">
                    <span class="text-blue-600 mr-2">👤</span> Novo Funcionário
                </h2>
                <span class="text-[10px] font-bold bg-slate-200 text-slate-600 px-2 py-1 rounded uppercase tracking-wider">v1.5 - Compliance CLT</span>
            </div>

            <div class="p-6">
                @include('partials._alerts')

                <form action="{{ route('store_employee') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-4 bg-blue-600 rounded-full"></span>
                            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Acesso ao Sistema</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">E-mail Corporativo</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none focus:border-blue-500 shadow-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Senha Provisória</label>
                                    <input type="password" name="password" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Confirmar Senha</label>
                                    <input type="password" name="password_confirmation" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-4 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Dados Pessoais & Documentos</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nome Completo</label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Gênero</label>
                                <select name="gender" class="w-full px-3 py-2 rounded border border-slate-300 text-sm bg-white">
                                    <option value="">Selecione...</option>
                                    <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Feminino</option>
                                    <option value="Outro" {{ old('gender') == 'Outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Data de Nascimento</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">CPF</label>
                                <input type="text" name="cpf" value="{{ old('cpf') }}" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm" placeholder="000.000.000-00">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">RG (Identidade)</label>
                                <input type="text" name="rg" value="{{ old('rg') }}" class="w-full px-3 py-2 rounded border border-slate-300 text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Telefone / WhatsApp</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm" placeholder="(71) 90000-0000">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-lg border border-slate-200">
                            <div>
                                <label class="block text-[10px] font-bold text-indigo-700 uppercase mb-1">PIS / PASEP</label>
                                <input type="text" name="pis" value="{{ old('pis') }}" class="w-full px-3 py-2 rounded border border-indigo-200 text-sm bg-white" placeholder="000.00000.00-0">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-indigo-700 uppercase mb-1">CTPS (Nº e Série)</label>
                                <input type="text" name="ctps" value="{{ old('ctps') }}" class="w-full px-3 py-2 rounded border border-indigo-200 text-sm bg-white" placeholder="0000000 / 000-0">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-4 bg-emerald-600 rounded-full"></span>
                            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Contrato & Cargo</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Cargo / Ocupação</label>
                                <select name="idOccupation" required 
                                    @change="requiresCrf = $event.target.options[$event.target.selectedIndex].getAttribute('data-crf') === '1'"
                                    class="w-full px-3 py-2 rounded border border-slate-300 text-sm bg-white outline-none focus:border-emerald-500">
                                    <option value="">Selecione o cargo...</option>
                                    @foreach($occupations as $occ)
                                        <option value="{{ $occ->id }}" data-crf="{{ $occ->requires_crf }}" {{ old('idOccupation') == $occ->id ? 'selected' : '' }}>
                                            {{ $occ->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div x-show="requiresCrf" x-transition>
                                <label class="block text-[10px] font-bold text-red-600 uppercase mb-1">Registro CRF</label>
                                <input type="text" name="crf" value="{{ old('crf') }}" class="w-full px-3 py-2 rounded border border-red-200 text-sm bg-red-50/30 outline-none focus:border-red-500" placeholder="BA-00000">
                            </div>
                            <div :class="requiresCrf ? '' : 'md:col-span-1'">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Salário Base (R$)</label>
                                <input type="text" name="salary" value="{{ old('salary') }}" class="w-full px-3 py-2 rounded border border-slate-300 text-sm font-bold text-emerald-700" placeholder="0.000,00">
                            </div>
                            <div :class="requiresCrf ? 'md:col-span-1' : ''">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Data de Admissão</label>
                                <input type="date" name="hire_date" value="{{ old('hire_date', date('Y-m-d')) }}" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-4 bg-slate-600 rounded-full"></span>
                            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Endereço Residencial</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">CEP</label>
                                <input type="text" name="zip_code" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm shadow-sm" placeholder="00000-000">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Logradouro (Rua/Av)</label>
                                <input type="text" name="street" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm shadow-sm">
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nº</label>
                                <input type="text" name="number" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm shadow-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Complemento</label>
                                <input type="text" name="complement" class="w-full px-3 py-2 rounded border border-slate-300 text-sm shadow-sm" placeholder="Apto, Bloco...">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bairro</label>
                                <input type="text" name="neighborhood" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm shadow-sm">
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Cidade</label>
                                    <input type="text" name="city" value="Salvador" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm shadow-sm">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">UF</label>
                                    <input type="text" name="state" value="BA" maxlength="2" required class="w-full px-3 py-2 rounded border border-slate-300 text-sm text-center font-bold">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-3 rounded-lg font-bold text-sm transition uppercase tracking-widest shadow-lg transform active:scale-95">
                            Finalizar Cadastro e Contratação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection