@extends('layouts.site')

@section('title', 'Criar Conta - Farmácia Pai e Filha')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-5xl mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden border border-slate-100">
            
            <div class="bg-blue-600 p-6">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-white text-2xl font-bold uppercase tracking-tight">Cadastro de Cliente</h2>
                        <p class="text-blue-100 text-xs font-medium uppercase tracking-widest opacity-80">Crie sua conta em segundos e aproveite ofertas em Salvador</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('store_customer') }}" method="POST" class="p-8">
                @csrf

                @include('partials._alerts')

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    
                    <div class="lg:col-span-7 space-y-10">
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                                <span class="bg-blue-100 text-blue-600 p-1.5 rounded-md text-[10px]">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <h3 class="font-bold text-slate-700 uppercase text-xs tracking-widest">Credenciais de Acesso</h3>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">E-mail para Login</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-slate-50/50">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Senha</label>
                                        <input type="password" name="password" required
                                            class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition bg-slate-50/50">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Confirmar Senha</label>
                                        <input type="password" name="password_confirmation" required
                                            class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition bg-slate-50/50">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                                <span class="bg-blue-100 text-blue-600 p-1.5 rounded-md text-[10px]">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <h3 class="font-bold text-slate-700 uppercase text-xs tracking-widest">Informações Pessoais</h3>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nome Completo</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">CPF</label>
                                        <input type="text" name="cpf" value="{{ old('cpf') }}" required
                                            class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition"
                                            placeholder="000.000.000-00">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Telefone</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" required
                                            class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition"
                                            placeholder="(71) 99999-9999">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Data de Nascimento</label>
                                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                                        class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5 bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-5">
                        <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                            <span class="bg-blue-600 text-white p-1.5 rounded-md text-[10px]">
                                <i class="fas fa-truck"></i>
                            </span>
                            <h3 class="font-bold text-slate-700 uppercase text-xs tracking-widest">Onde Entregamos?</h3>
                        </div>

                        <div class="grid grid-cols-4 gap-4">
                            <div class="col-span-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">CEP</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code') }}" required
                                    class="w-full border border-slate-300 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="00000-000">
                            </div>
                            <div class="col-span-1">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">UF</label>
                                <input type="text" name="state" value="{{ old('state', 'BA') }}" maxlength="2"
                                    class="w-full border border-slate-300 rounded-lg p-2.5 text-sm text-center font-bold outline-none bg-slate-100 uppercase">
                            </div>
                            
                            <div class="col-span-4">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Rua / Logradouro</label>
                                <input type="text" name="street" value="{{ old('street') }}" required
                                    class="w-full border border-slate-300 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nº</label>
                                <input type="text" name="number" value="{{ old('number') }}" required
                                    class="w-full border border-slate-300 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="col-span-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Complemento</label>
                                <input type="text" name="complement" value="{{ old('complement') }}"
                                    class="w-full border border-slate-300 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Apto, Bloco, etc.">
                            </div>

                            <div class="col-span-4">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bairro</label>
                                <input type="text" name="neighborhood" value="{{ old('neighborhood') }}" required
                                    class="w-full border border-slate-300 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="col-span-4">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Cidade</label>
                                <input type="text" name="city" value="{{ old('city', 'Salvador') }}" required
                                    class="w-full border border-slate-300 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-100 text-center space-y-6">
                    <button type="submit"
                        class="w-full md:w-2/3 lg:w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-2xl shadow-xl shadow-blue-200 transition duration-300 transform active:scale-95 uppercase tracking-widest text-sm">
                        Finalizar e Criar minha Conta
                    </button>
                    
                    <div class="text-sm text-slate-500">
                        Já possui um registro conosco? 
                        <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline ml-1">Fazer Login</a>
                    </div>
                </div>
            </form>
        </div>
        
        <p class="text-center text-[10px] text-slate-400 mt-8 uppercase tracking-[0.2em]">
            Ambiente seguro com criptografia ponta a ponta • Farmácia Pai e Filhos
        </p>
    </div>
@endsection