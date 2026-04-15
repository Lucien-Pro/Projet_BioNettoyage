<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planning Hebdomadaire') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="planningManager()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Messages -->
            <div x-show="message.show" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="mb-4 p-4 rounded-xl border"
                 :class="message.type === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700'"
                 style="display: none;">
                <span x-text="message.text"></span>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-0">
                    <!-- Table Grid -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="p-4 border-b border-gray-100 text-left text-xs font-bold text-gray-400 uppercase tracking-widest w-48">Agent</th>
                                    @foreach($days as $num => $day)
                                        <th class="p-4 border-b border-gray-100 text-center text-xs font-bold text-gray-400 uppercase tracking-widest min-w-[150px]">
                                            <div class="text-gray-900">{{ $day['label'] }}</div>
                                            <div class="text-[10px] text-indigo-500 font-medium">{{ $day['date'] }}</div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($agents as $agent)
                                    <tr class="hover:bg-gray-50/30 transition-colors">
                                        <td class="p-4 font-bold text-gray-900 bg-gray-50/20">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs mr-3 uppercase">
                                                    {{ substr($agent->prenom, 0, 1) }}{{ substr($agent->nom, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm">{{ $agent->prenom }} {{ $agent->nom }}</div>
                                                    <div class="text-[10px] text-gray-400 font-normal uppercase italic tracking-tighter">{{ $agent->user->role ?? 'Agent' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        @foreach($days as $dayNum => $day)
                                            <td class="p-2 border-l border-gray-50 align-top">
                                                <div 
                                                    class="min-h-[80px] rounded-xl border-2 border-dashed border-gray-100 hover:border-indigo-200 hover:bg-white transition-all cursor-pointer p-2 flex flex-col gap-1"
                                                    @click="openSelector({{ $agent->id }}, {{ $dayNum }}, '{{ addslashes($agent->prenom) }} {{ addslashes($agent->nom) }}', '{{ $day['label'] }} {{ $day['date'] }}')"
                                                >
                                                    @php 
                                                        $dailyPlannings = $agent->plannings->where('day_of_week', $dayNum);
                                                    @endphp
                                                    
                                                    @forelse($dailyPlannings as $p)
                                                        @if($p->location)
                                                            <div class="flex items-center justify-between group px-2 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-[10px] font-bold border border-indigo-100 shadow-sm animate-fade-in hover:bg-indigo-100 transition-colors">
                                                                <span class="truncate">{{ $p->location->name }}</span>
                                                                <button 
                                                                    @click.stop="removeItem({{ $p->id }}, {{ $agent->id }}, {{ $dayNum }}, {{ $p->location->id }})" 
                                                                    class="text-red-400 hover:text-red-600 transition ml-1 p-0.5 hover:bg-red-50 rounded"
                                                                    title="Supprimer"
                                                                >
                                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12" /></svg>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @empty
                                                        <div class="flex-grow flex items-center justify-center">
                                                            <span class="text-[10px] text-gray-300 font-bold uppercase tracking-widest">+ Ajouter</span>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="p-12 text-center text-gray-400 italic">Aucun agent configuré.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selector Modal (Hierarchical) -->
        <div id="selector-modal" 
             class="hidden fixed inset-0 z-50 overflow-y-auto"
             x-show="modal.open"
             style="display: none;">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="closeSelector()"></div>
                
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden flex flex-col max-h-[85vh]">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-900">Affecter une Zone</h3>
                            <p class="text-sm text-gray-500">
                                <span x-text="modal.agentName" class="font-bold text-indigo-600"></span> 
                                <span class="mx-1 text-gray-300">|</span> 
                                <span x-text="modal.dayLabel" class="font-bold text-gray-700"></span>
                            </p>
                        </div>
                        <button @click="closeSelector()" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold"><path d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <!-- Search -->
                    <div class="px-6 py-4 border-b border-gray-100">
                        <input type="text" x-model="modal.search" placeholder="Rechercher une pièce..." class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <!-- Accordion Content -->
                    <div class="flex-grow overflow-y-auto p-6 space-y-4 bg-gray-50/20">
                        @foreach($buildings as $building)
                            <div x-data="{ collapsed: true }" 
                                 class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden"
                                 x-show="modal.search === '' || '{{ addslashes($building->name) }}'.toLowerCase().includes(modal.search.toLowerCase()) || {{ count($building->children) > 0 ? 'true' : 'false' }}">
                                
                                <div class="px-4 py-3 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition" @click="collapsed = !collapsed">
                                    <div class="flex items-center gap-3">
                                        <span class="text-lg">🏢</span>
                                        <span class="font-bold text-gray-800">{{ $building->name }}</span>
                                    </div>
                                    <svg class="h-4 w-4 text-gray-400 transition-transform" :class="{'rotate-180': !collapsed}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" /></svg>
                                </div>

                                <div x-show="!collapsed" x-transition class="px-4 pb-4 border-t border-gray-50 bg-gray-50/30">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 pt-3">
                                        @foreach($building->children as $room)
                                            <button 
                                                @click="addItem({{ $room->id }}, '{{ addslashes($room->name) }}')"
                                                class="flex items-center p-3 rounded-xl border border-white hover:border-indigo-200 hover:bg-white transition-all shadow-sm bg-white/50 text-left text-sm font-medium text-gray-700"
                                                x-show="modal.search === '' || '{{ addslashes($room->name) }}'.toLowerCase().includes(modal.search.toLowerCase())"
                                            >
                                                <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center text-[10px] mr-3">✔</span>
                                                {{ $room->name }}
                                            </button>
                                        @endforeach

                                        @if(count($building->children) == 0)
                                            <button 
                                                @click="addItem({{ $building->id }}, '{{ addslashes($building->name) }}')"
                                                class="col-span-2 flex items-center p-3 rounded-xl border border-white hover:border-indigo-200 hover:bg-white transition-all shadow-sm bg-white/50 text-left text-sm font-bold text-indigo-600 italic"
                                            >
                                                🏢 Bâtiment Entier
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(2px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.3s ease-out; }
    </style>

    <script>
        function planningManager() {
            return {
                modal: {
                    open: false,
                    agentId: null,
                    dayNum: null,
                    agentName: '',
                    dayLabel: '',
                    search: ''
                },
                message: { show: false, text: '', type: 'success' },

                openSelector(agentId, dayNum, agentName, dayLabel) {
                    this.modal.agentId = agentId;
                    this.modal.dayNum = dayNum;
                    this.modal.agentName = agentName;
                    this.modal.dayLabel = dayLabel;
                    this.modal.open = true;
                    document.getElementById('selector-modal').classList.remove('hidden');
                },

                closeSelector() {
                    this.modal.open = false;
                    document.getElementById('selector-modal').classList.add('hidden');
                },

                addItem(locationId, locationName) {
                    fetch('{{ route("planning.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            agent_id: this.modal.agentId,
                            location_id: locationId,
                            day_of_week: this.modal.dayNum
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.closeSelector();
                            location.reload(); // Rechargement simple pour mettre à jour la grille
                        } else {
                            alert(data.message || 'Erreur lors de l\'affectation');
                        }
                    });
                },

                removeItem(id, agentId, dayNum, locationId) {
                    if (!confirm('Retirer cette zone du planning ?')) return;

                    fetch('{{ route("planning.ajax-remove") }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            agent_id: agentId,
                            location_id: locationId,
                            day_of_week: dayNum
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
                }
            }
        }
    </script>
</x-app-layout>
