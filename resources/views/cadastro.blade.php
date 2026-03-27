@extends('layouts.site')

@section('title', 'Criar Conta - Farmácia Pai e Filha')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-blue-700 p-4">
                <h2 class="text-white text-xl font-bold flex items-center gap-2">
                    <i class="fas fa-user-plus"></i> Cadastro de Cliente
                </h2>
            </div>

            <form action="{{ route('store_customer') }}" method="POST" class="p-8 space-y-6">
                @csrf
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2">Dados de Acesso</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome Completo</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Senha</label>
                            <input type="password" name="password"
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                            @error('password')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
                            <input type="password" name="password_confirmation"
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2">Dados Pessoais</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">CPF</label>
                            <input type="text" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00"
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('cpf') border-red-500 @enderror">
                            @error('cpf')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Telefone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="(71) 99999-9999"
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <label class="text-xs font-bold text-slate-600 uppercase mb-1">Data de Nascimento</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                                class="w-full px-3 py-2 rounded border border-slate-300 focus:border-blue-500 outline-none text-sm">
                        </div>

                    </div>
                </div>

                <div class="pt-6 border-t">
                    <button type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                        FINALIZAR MEU CADASTRO
                    </button>
                    <p class="text-center text-sm text-gray-500 mt-4">
                        Já tem uma conta? <a href="{{ route('login') }}"
                            class="text-blue-700 font-semibold hover:underline">Entre aqui</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
