@extends('layouts.app')

@section('title', 'Dashboard - Farmácia')

@section('content')
    {{-- CARD DE BEM-VINDO E NÍVEL DE ACESSO --}}
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

    {{-- ALERTA DE ESTOQUE DINÂMICO --}}
    @if (in_array(auth()->user()->idRoles, [1, 2]))
        <div x-data="{
            alerts: [],
            loading: true,
            
            // Busca os produtos com estoque baixo ou zerado
            fetchAlerts() {
                fetch('{{ route('api.alerts.stock') }}?t=' + new Date().getTime())
                    .then(res => res.json())
                    .then(data => {
                        this.alerts = data;
                        this.loading = false;
                    })
                    .catch(err => {
                        console.error('Erro na task:', err);
                        this.loading = false;
                    });
            },

            // Função para desativar todos os lotes ativos do produto
            deactivateBatch(productId) {
                if(!confirm('Deseja realmente desativar os lotes deste produto? Ele sumirá dos alertas até que um novo lote seja cadastrado.')) return;

                // Prepara a URL substituindo o placeholder pelo ID real
                let url = '{{ route('deactivate_batches', ['id' => ':id']) }}';
                url = url.replace(':id', productId);

                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        // Remove o item da lista local para o card sumir imediatamente
                        this.alerts = this.alerts.filter(a => a.id !== productId);
                    }
                })
                .catch(err => {
                    console.error('Erro ao desativar lote:', err);
                    alert('Erro técnico ao tentar desativar o lote.');
                });
            }
        }" 
        x-init="fetchAlerts(); setInterval(() => fetchAlerts(), 5000)" 
        class="grid grid-cols-1 gap-6 mt-6">

            <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="font-bold text-slate-700 flex items-center">
                        <span class="mr-2">⚠️</span> Alertas de Inventário
                        <span x-show="loading" class="ml-2 inline-block animate-spin text-blue-500">
                            <i class="fa-solid fa-circle-notch text-xs"></i>
                        </span>
                    </h3>
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest italic">Task ativa (5s)</span>
                    </div>
                </div>

                <div class="p-6">
                    {{-- LISTA DE ALERTAS --}}
                    <template x-if="alerts.length > 0">
                        <div class="space-y-4">
                            <template x-for="item in alerts" :key="item.id">
                                <div class="flex items-center justify-between p-4 border rounded-lg transition-all duration-500"
                                    :class="item.saldo == 0 ? 'bg-red-50 border-red-100' : 'bg-amber-50 border-amber-100'">

                                    <div class="flex items-center gap-4">
                                        {{-- Ícone do Status --}}
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                            :class="item.saldo == 0 ? 'bg-red-200 text-red-700' : 'bg-amber-200 text-amber-700'">
                                            <i class="fa-solid" :class="item.saldo == 0 ? 'fa-box-open' : 'fa-layer-group'"></i>
                                        </div>

                                        <div>
                                            <p class="text-sm font-bold text-slate-800" x-text="item.name"></p>
                                            <p class="text-[11px] text-slate-500">
                                                <span x-text="item.category"></span> > <span x-text="item.subclass"></span>
                                            </p>

                                            {{-- BOTÃO DE AÇÃO --}}
                                            <button @click="deactivateBatch(item.id)" 
                                                class="mt-2 text-[10px] font-black uppercase tracking-tighter text-red-500 hover:text-red-700 flex items-center gap-1 transition-colors outline-none">
                                                <i class="fa-solid fa-ban"></i> Desativar Lote
                                            </button>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-[10px] uppercase font-bold text-slate-400">Saldo Atual</p>
                                        <p class="text-lg font-black"
                                            :class="item.saldo == 0 ? 'text-red-600' : 'text-amber-600'"
                                            x-text="item.saldo + ' un.'"></p>
                                        <span class="text-[9px] italic text-slate-400">
                                            Mínimo sugerido: <span x-text="item.min"></span>
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    {{-- MENSAGEM QUANDO TUDO ESTÁ OK --}}
                    <template x-if="!loading && alerts.length === 0">
                        <div class="text-center py-8 text-emerald-600 font-medium flex flex-col items-center justify-center gap-2">
                            <i class="fa-solid fa-circle-check text-3xl opacity-20 mb-2"></i>
                            <span>Tudo em dia! O estoque está acima do mínimo.</span>
                        </div>
                    </template>
                </div>
                
                <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                    <a href="{{ route('select_all_products') }}" class="text-blue-600 text-[10px] font-bold uppercase hover:underline tracking-widest">
                        Ver estoque completo →
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection