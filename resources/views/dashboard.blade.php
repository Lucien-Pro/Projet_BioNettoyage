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
                    Alertes <span class="ml-2 py-0.5 px-2 bg-red-100 text-red-600 rounded-full text-xs">3</span>
                </button>
            </div>

            <!-- Tab Content: Mes Locaux -->
            <div x-show="activeTab === 'locaux'" class="space-y-6">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                        <div class="text-3xl font-bold text-green-600">31</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider font-semibold">Faits</div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-amber-500">
                        <div class="text-3xl font-bold text-amber-600">4</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider font-semibold">En attente</div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500">
                        <div class="text-3xl font-bold text-red-600">1</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider font-semibold">En retard</div>
                    </div>
                </div>

                <!-- Global Progress -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progression globale</span>
                        <span class="text-sm font-bold text-indigo-600">86% — 36/36</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 86%"></div>
                    </div>
                </div>

                <!-- Locaux List -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Locaux assignés</h3>
                            <div class="relative">
                                <input type="text" placeholder="Rechercher..." class="pl-8 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <span class="absolute left-2.5 top-2.5 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <!-- Card 1 -->
                            <div class="flex items-center p-4 border border-gray-100 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <div class="bg-red-50 p-3 rounded-lg mr-4">🏥</div>
                                <div class="flex-grow">
                                    <div class="font-bold text-gray-900">Salle de soins 2B</div>
                                    <div class="text-xs text-gray-500">Priorité haute · Prévu 08h30</div>
                                </div>
                                <span class="px-2 py-1 text-xs font-bold bg-red-100 text-red-700 rounded uppercase">En retard</span>
                            </div>
                            <!-- Card 2 -->
                            <div class="flex items-center p-4 border border-gray-100 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <div class="bg-amber-50 p-3 rounded-lg mr-4">🚪</div>
                                <div class="flex-grow">
                                    <div class="font-bold text-gray-900">Couloir Est — Étage 3</div>
                                    <div class="text-xs text-gray-500">Standard · Prévu 10h00</div>
                                </div>
                                <span class="px-2 py-1 text-xs font-bold bg-amber-100 text-amber-700 rounded uppercase">À faire</span>
                            </div>
                            <!-- Card 3 -->
                            <div class="flex items-center p-4 border border-gray-100 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <div class="bg-green-50 p-3 rounded-lg mr-4">🚿</div>
                                <div class="flex-grow">
                                    <div class="font-bold text-gray-900">Sanitaires bloc C</div>
                                    <div class="text-xs text-gray-500">Fait à 09h12 · M. Dupont</div>
                                </div>
                                <span class="px-2 py-1 text-xs font-bold bg-green-100 text-green-700 rounded uppercase">Validé</span>
                            </div>
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
                    @php
                        $agents_demo = [
                            ['avatar' => 'MD', 'name' => 'Marie Dupont', 'prog' => '36/36', 'pct' => 100, 'color' => 'bg-green-500'],
                            ['avatar' => 'JL', 'name' => 'Jean Lefebvre', 'prog' => '29/36', 'pct' => 80, 'color' => 'bg-amber-500'],
                            ['avatar' => 'SB', 'name' => 'Sophie Bernard', 'prog' => '31/36', 'pct' => 86, 'color' => 'bg-amber-500'],
                            ['avatar' => 'KA', 'name' => 'Karim Amrani', 'prog' => '24/36', 'pct' => 67, 'color' => 'bg-red-500'],
                            ['avatar' => 'PN', 'name' => 'Pauline Nguyen', 'prog' => '34/36', 'pct' => 94, 'color' => 'bg-green-500'],
                        ];
                    @endphp

                    @foreach($agents_demo as $agent)
                        <div class="bg-white p-4 rounded-lg shadow-sm flex items-center">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold mr-4">
                                {{ $agent['avatar'] }}
                            </div>
                            <div class="flex-grow">
                                <div class="font-semibold">{{ $agent['name'] }}</div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-32 bg-gray-200 rounded-full h-1.5 mt-1">
                                        <div class="{{ $agent['color'] }} h-1.5 rounded-full" style="width: {{ $agent['pct'] }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $agent['prog'] }}</span>
                                </div>
                            </div>
                            <div class="text-sm font-bold {{ str_contains($agent['color'], 'green') ? 'text-green-600' : (str_contains($agent['color'], 'amber') ? 'text-amber-600' : 'text-red-600') }}">
                                {{ $agent['pct'] }}%
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tab Content: Alertes -->
            <div x-show="activeTab === 'alertes'" class="space-y-4">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500 flex items-start">
                    <div class="w-3 h-3 rounded-full bg-red-500 mt-1.5 mr-4 shrink-0 shadow-[0_0_8px_rgba(239,68,68,0.5)]"></div>
                    <div>
                        <div class="font-bold text-gray-900">Salle de soins 2B — Nettoyage non effectué</div>
                        <div class="text-sm text-gray-500">Prévu à 08h30 · Retard de 1h45</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500 flex items-start">
                    <div class="w-3 h-3 rounded-full bg-red-500 mt-1.5 mr-4 shrink-0 shadow-[0_0_8px_rgba(239,68,68,0.5)]"></div>
                    <div>
                        <div class="font-bold text-gray-900">Thomas Martin — Avancement faible (50%)</div>
                        <div class="text-sm text-gray-500">Dernière action il y a 42 min</div>
                    </div>
                </div>

                <div class="bg-amber-50 p-6 rounded-lg shadow-sm border border-amber-200 border-l-4 border-amber-500 flex items-start">
                    <div class="w-3 h-3 rounded-full bg-amber-500 mt-1.5 mr-4 shrink-0"></div>
                    <div>
                        <div class="font-bold text-amber-900">Produit P3 — Stock bas signalé</div>
                        <div class="text-sm text-amber-700">Mis à jour il y a 20 min</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
