<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de Bord — Bio-Nettoyage') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ activeTab: 'locaux' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tabs Navigation -->
            <div class="mb-6 flex space-x-4 border-b border-gray-200">
                <button @click="activeTab = 'locaux'" :class="activeTab === 'locaux' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200">
                    Mes Locaux
                </button>
                <button @click="activeTab = 'equipe'" :class="activeTab === 'equipe' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200">
                    Équipe
                </button>
                <button @click="activeTab = 'alertes'" :class="activeTab === 'alertes' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200">
                    Alertes <span class="ml-2 py-0.5 px-2 bg-gray-100 text-gray-400 rounded-full text-xs">0</span>
                </button>
            </div>

            <!-- Tab Content: Mes Locaux -->
            <div x-show="activeTab === 'locaux'" class="space-y-6">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-indigo-500">
                        <div class="text-3xl font-bold text-indigo-600">{{ $locations_count }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider font-semibold">Locaux Totaux</div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                        <div class="text-3xl font-bold text-green-600">{{ $agents_count }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider font-semibold">Agents Actifs</div>
                    </div>
                </div>

                <!-- Global Progress -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progression du jour</span>
                        <span class="text-sm font-bold text-indigo-600">0% — 0/{{ $locations_count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Locaux List -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold italic text-gray-800">
                                    📅 À faire aujourd'hui ({{ now()->translatedFormat('l d F') }})
                                </h3>
                                <p class="text-xs text-gray-400 mt-1">Consultez votre planning ou déclarez une tâche spécifique.</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('cleaning.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg shadow-indigo-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    Faire une tâche +
                                </a>
                                <div class="relative hidden md:block">
                                    <input type="text" placeholder="Rechercher..." class="pl-8 pr-4 py-2 border border-gray-100 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50/50">
                                    <span class="absolute left-2.5 top-2.5 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @php
                                $agent = Auth::user()->agent;
                                $tasks = $agent ? $agent->todayPlannings()->with('location.parent')->get() : collect();
                                $hasWeeklyAssignments = $agent ? $agent->plannings()->exists() : false;
                            @endphp

                            @forelse($tasks as $task)
                                <div class="p-4 rounded-xl border border-gray-100 bg-white hover:border-indigo-200 transition-all flex items-center justify-between group shadow-sm hover:shadow-md">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center font-bold">
                                            ✔
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $task->location->name }}</div>
                                            <div class="text-xs text-gray-400 uppercase tracking-tighter">
                                                @if($task->location->parent)
                                                    {{ $task->location->parent->name }}
                                                @else
                                                    Bâtiment principal
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-3 py-1 bg-gray-50 text-gray-400 rounded-full text-[10px] font-bold uppercase tracking-widest group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                            À faire
                                        </span>
                                        <button class="p-2 text-gray-300 hover:text-green-500 transition">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold"><path d="M5 13l4 4L19 7" /></svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                    <div class="text-4xl mb-3">☕</div>
                                    @if($hasWeeklyAssignments)
                                        <p class="text-gray-500 font-bold">Rien de prévu pour vous aujourd'hui !</p>
                                        <p class="text-xs text-gray-400 mt-1 italic">Mais vous avez des zones prévues d'autres jours de la semaine.</p>
                                    @else
                                        <p class="text-gray-500 font-bold">Aucune zone ne vous est encore attribuée.</p>
                                        @if(Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin')
                                            <p class="text-xs text-gray-400 mt-1 italic">Allez dans l'onglet <strong>Planning</strong> pour vous affecter des locaux.</p>
                                        @endif
                                    @endif
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Équipe -->
            <div x-show="activeTab === 'equipe'" class="space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Avancement de l'équipe</h3>
                    <div class="mb-2">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-600 font-bold">74% de l'objectif atteint</span>
                            <span class="text-gray-500">183 / 250 locaux</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
                            <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000" style="width: 74%"></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    @forelse($agents as $agent)
                        <div class="bg-white p-4 rounded-lg shadow-sm flex items-center hover:shadow-md transition">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold mr-4 uppercase">
                                {{ substr($agent->prenom, 0, 1) }}{{ substr($agent->nom, 0, 1) }}
                            </div>
                            <div class="flex-grow">
                                <div class="font-semibold">{{ $agent->prenom }} {{ $agent->nom }}</div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-400">{{ $agent->user->role ?? 'Agent' }}</span>
                                    @php
                                        $agentLocations = $agent->plannings->pluck('location')->filter()->unique('id');
                                    @endphp
                                    @if($agentLocations->count() > 0)
                                        <span class="text-gray-300">•</span>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($agentLocations->take(3) as $loc)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-600 border border-blue-100">
                                                    {{ $loc->name }}
                                                </span>
                                            @endforeach
                                            @if($agentLocations->count() > 3)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-50 text-gray-500 border border-gray-100">
                                                    +{{ $agentLocations->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-300">•</span>
                                        <span class="text-[10px] text-gray-400 italic">Aucune zone affectée</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-[10px] font-bold bg-green-50 text-green-600 rounded uppercase">En ligne</span>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-12 text-center rounded-lg shadow">
                            <p class="text-gray-500 italic">Aucun agent n'est enregistré pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div x-show="activeTab === 'alertes'" class="space-y-4">
                <div class="bg-white p-12 text-center rounded-lg shadow">
                    <div class="flex justify-center mb-4 text-green-500">
                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Aucune alerte active</h3>
                    <p class="mt-1 text-sm text-gray-500">Tout semble être en ordre pour le moment.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
