@extends('layouts.app')

@section('title', 'Dashboard - Farmácia')

@section('content')
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Bem-vindo ao sistema!</h3>
        <p class="text-gray-600">
            Olá {{ auth()->user()->name }}, seu nível de acesso é: 
            @switch(auth()->user()->idRoles)
                @case(1)
                    <span class="text-red-600 font-bold">Administrador</span>
                    @break
                @case(2)
                    <span class="text-green-600 font-bold">Funcionário</span>
                    @break
                @default
                    <span class="text-blue-600 font-bold">Cliente</span>
            @endswitch
        </p>
        
        @switch(auth()->user()->idRoles)
            @case(1)
                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <strong>Administrador</strong>: Você tem acesso total ao sistema.
                </div>
            @break
            @case(2)
                <div class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
                    <strong>Funcionário</strong>: Você pode realizar operações de cadastro e consulta.
                </div>
            @break
            @case(3)
                <div class="mt-4 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700">
                    <strong>Cliente</strong>: Você pode visualizar informações e realizar compras.
                </div>
            @break
        @endswitch
    </div>
@endsection