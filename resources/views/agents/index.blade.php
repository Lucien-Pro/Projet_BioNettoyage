<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Agents') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages de succès/erreur -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oups !</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>
                    window.onload = function() {
                        document.getElementById('add-agent-modal').classList.remove('hidden');
                    };
                </script>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Liste des agents</h3>
                        <button onclick="document.getElementById('add-agent-modal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                            + Ajouter un agent
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Initiales</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    @if(Auth::user()->role === 'super_admin')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($agents as $agent)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $agent->nom }} {{ $agent->prenom }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $agent->initiales }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $agent->email ?? '-' }}
                                        </td>
                                        @if(Auth::user()->role === 'super_admin')
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 uppercase">
                                                    {{ $agent->user->role ?? 'N/A' }}
                                                </span>
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $agent->statut === 'actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($agent->statut) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button 
                                                type="button" 
                                                onclick="showAssignmentModal({{ $agent->id }}, '{{ addslashes($agent->prenom) }} {{ addslashes($agent->nom) }}', {{ $agent->locations->pluck('id') }})" 
                                                class="text-green-600 hover:text-green-900 mr-3 transition font-semibold"
                                            >
                                                Zones
                                            </button>
                                            <button 
                                                onclick='editAgent({{ $agent->id }}, { id: {{ $agent->id }}, nom: "{{ addslashes($agent->nom) }}", prenom: "{{ addslashes($agent->prenom) }}", initiales: "{{ addslashes($agent->initiales) }}", email: "{{ addslashes($agent->email) }}", role: "{{ $agent->user->role ?? "utilisateur" }}", statut: "{{ $agent->statut }}" })' 
                                                class="text-indigo-600 hover:text-indigo-900 mr-3 transition font-semibold"
                                            >
                                                Modifier
                                            </button>
                                            <button 
                                                type="button" 
                                                onclick="showDeleteModal({{ $agent->id }}, '{{ addslashes($agent->prenom) }} {{ addslashes($agent->nom) }}')" 
                                                class="text-red-600 hover:text-red-900 transition"
                                            >
                                                Supprimer
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun agent trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'Ajout d'Agent (Premium) -->
    <div id="add-agent-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('add-agent-modal').classList.add('hidden')"></div>
            
            <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all max-w-2xl w-full overflow-hidden">
                <form action="{{ route('agents.store') }}" method="POST" class="p-8">
                    @csrf
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-extrabold text-gray-900 border-b-4 border-indigo-500 pb-1">Nouvel Agent</h3>
                        <button type="button" onclick="document.getElementById('add-agent-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold"><path d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Prénom</label>
                            <input type="text" name="prenom" required class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nom</label>
                            <input type="text" name="nom" required class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Initiales</label>
                            <input type="text" name="initiales" required maxlength="10" placeholder="ex: JD" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email (Identifiant)</label>
                            <input type="email" name="email" required class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/50">
                        </div>
                        
                        @if(Auth::user()->role === 'super_admin')
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Rôle</label>
                                <select name="role" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/50 font-semibold text-gray-700">
                                    <option value="utilisateur">Utilisateur (Agent standard)</option>
                                    <option value="admin">Administrateur (Gestionnaire)</option>
                                </select>
                            </div>
                        @endif

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Mot de passe provisoire</label>
                            <div class="relative">
                                <input type="text" name="password" required value="Bionet2026!" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/100 font-mono text-indigo-600 font-bold">
                                <p class="mt-1 text-[10px] text-gray-400 italic">L'agent devra changer son mot de passe à la première connexion.</p>
                            </div>
                        </div>

                        <input type="hidden" name="statut" value="actif">
                    </div>

                    <div class="mt-10 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('add-agent-modal').classList.add('hidden')" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Annuler</button>
                        <button type="submit" class="px-10 py-3 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-100">
                            Créer l'agent
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Modification d'Agent (Premium) -->
    <div id="edit-agent-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" x-data="{ agent: {} }" x-on:open-edit-modal.window="agent = $event.detail; document.getElementById('edit-agent-modal').classList.remove('hidden')">
        <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('edit-agent-modal').classList.add('hidden')"></div>
            
            <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all max-w-2xl w-full overflow-hidden">
                <form :action="'/agents/' + agent.id" method="POST" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-extrabold text-gray-900 border-b-4 border-indigo-500 pb-1">Modifier l'Agent</h3>
                        <button type="button" onclick="document.getElementById('edit-agent-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold"><path d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Prénom</label>
                            <input type="text" name="prenom" x-model="agent.prenom" required class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nom</label>
                            <input type="text" name="nom" x-model="agent.nom" required class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Initiales</label>
                            <input type="text" name="initiales" x-model="agent.initiales" required maxlength="10" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" x-model="agent.email" required class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-gray-50/50">
                        </div>
                        
                        @if(Auth::user()->role === 'super_admin')
                            <div class="md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Rôle</label>
                                <select name="role" x-model="agent.role" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 font-bold text-indigo-700">
                                    <option value="utilisateur">Utilisateur</option>
                                    <option value="admin">Administrateur</option>
                                </select>
                            </div>
                        @endif

                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Statut</label>
                            <select name="statut" x-model="agent.statut" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 font-bold transition-all" :class="agent.statut === 'actif' ? 'text-green-600' : 'text-red-600'">
                                <option value="actif">Actif</option>
                                <option value="inactif">Inactif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('edit-agent-modal').classList.add('hidden')" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Annuler</button>
                        <button type="submit" class="px-10 py-3 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-100">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmation de Suppression (Version Premium) -->
    <div 
        id="delete-confirm-modal" 
        class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
    >
        <!-- Backdrop avec flou -->
        <div 
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
            onclick="hideDeleteModal()"
        ></div>

        <!-- Contenu du Modal -->
        <div 
            class="relative bg-white rounded-2xl shadow-2xl transform transition-all sm:max-w-lg w-full overflow-hidden border border-gray-100"
        >
            <div class="px-6 pt-8 pb-6 text-center">
                <!-- Icone d'alerte stylisée -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-4 ring-8 ring-red-50/50">
                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>

                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Supprimer l'agent ?</h3>
                <p class="text-gray-500 text-sm leading-relaxed px-4">
                    Êtes-vous sûr de vouloir supprimer <span id="delete-agent-name" class="font-bold text-indigo-600"></span> ? <br>
                    Toutes ses données et son accès seront <span class="text-red-600 font-semibold italic">définitivement effacés</span>.
                </p>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
                <form id="delete-agent-form" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all shadow-lg shadow-red-200">
                        Confirmer la suppression
                    </button>
                </form>
                <button 
                    type="button" 
                    onclick="hideDeleteModal()" 
                    class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-gray-200 text-sm font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all focus:outline-none shadow-sm"
                >
                    Annuler
                </button>
            </div>
        </div>
    </div>

    <!-- Modal d'Affectation des Zones (Premium) -->
    <div 
        id="assignment-modal" 
        class="hidden fixed inset-0 z-50 overflow-y-auto" 
        x-data="{ 
            search: '', 
            selectedLocations: [],
            agentName: '',
            formAction: '',
            toggleLocation(id) {
                if (this.selectedLocations.includes(id)) {
                    this.selectedLocations = this.selectedLocations.filter(i => i !== id);
                } else {
                    this.selectedLocations.push(id);
                }
            }
        }"
        x-on:open-assignment-modal.window="
            selectedLocations = $event.detail.ids;
            agentName = $event.detail.name;
            formAction = $event.detail.action;
            document.getElementById('assignment-modal').classList.remove('hidden');
        "
    >
        <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="hideAssignmentModal()"></div>
            
            <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all max-w-4xl w-full overflow-hidden flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Affectation des Zones</h3>
                        <p class="text-sm text-gray-500">Agent : <span class="font-bold text-indigo-600" x-text="agentName"></span></p>
                    </div>
                    <button onclick="hideAssignmentModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Search bar -->
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="relative">
                        <input 
                            x-model="search"
                            type="text" 
                            placeholder="Rechercher un bâtiment ou une salle..." 
                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        >
                        <span class="absolute left-3 top-2.5 text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </span>
                    </div>
                </div>

                <!-- Content: Accordion List -->
                <div class="flex-grow overflow-y-auto p-6 space-y-4 bg-gray-50/30">
                    @foreach($buildings as $building)
                        <div 
                            x-data="{ open: false }" 
                            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"
                            x-show="search === '' || '{{ addslashes($building->name) }}'.toLowerCase().includes(search.toLowerCase()) || {{ count($building->children) > 0 ? 'true' : 'false' }}"
                        >
                            <div 
                                class="px-5 py-3 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition"
                                @click="open = !open"
                            >
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600 font-bold">🏢</div>
                                    <span class="font-bold text-gray-800">{{ $building->name }}</span>
                                    <span class="text-xs text-gray-400 uppercase tracking-tighter">{{ count($building->children) }} salles</span>
                                </div>
                                <svg 
                                    class="h-5 w-5 text-gray-400 transition-transform duration-200" 
                                    :class="{ 'rotate-180': open }"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <div x-show="open" x-transition class="px-5 pb-4 border-t border-gray-50">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3">
                                    @foreach($building->children as $room)
                                        <label 
                                            class="flex items-center p-3 rounded-lg border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition cursor-pointer"
                                            x-show="search === '' || '{{ addslashes($room->name) }}'.toLowerCase().includes(search.toLowerCase())"
                                        >
                                            <input 
                                                type="checkbox" 
                                                value="{{ $room->id }}"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                                :checked="selectedLocations.includes({{ $room->id }})"
                                                @change="toggleLocation({{ $room->id }})"
                                            >
                                            <span class="ml-3 text-sm text-gray-700 font-medium">{{ $room->name }}</span>
                                        </label>
                                    @endforeach
                                    
                                    @if(count($building->children) == 0)
                                        <label 
                                            class="col-span-2 flex items-center p-3 rounded-lg border border-indigo-100 bg-indigo-50/30 transition cursor-pointer"
                                        >
                                            <input 
                                                type="checkbox" 
                                                value="{{ $building->id }}"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                                :checked="selectedLocations.includes({{ $building->id }})"
                                                @change="toggleLocation({{ $building->id }})"
                                            >
                                            <span class="ml-3 text-sm text-indigo-700 font-bold italic">Bâtiment entier (Zone unique)</span>
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center gap-3">
                    <span class="text-xs text-gray-500 mr-auto">
                        <span x-text="selectedLocations.length" class="font-bold text-indigo-600"></span> zone(s) sélectionnée(s)
                    </span>
                    <button type="button" onclick="hideAssignmentModal()" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition">Annuler</button>
                    <form :action="formAction" method="POST">
                        @csrf
                        <template x-for="id in selectedLocations" :key="id">
                            <input type="hidden" name="locations[]" :value="id">
                        </template>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            Enregistrer les zones
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editAgent(agentId, agentData) {
            // Envoyer un événement pour Alpine.js dans le modal de modification
            window.dispatchEvent(new CustomEvent('open-edit-modal', {
                detail: agentData
            }));
        }

        function showAssignmentModal(agentId, agentName, assignedIds) {
            // Envoyer un événement personnalisé capté par Alpine.js
            window.dispatchEvent(new CustomEvent('open-assignment-modal', {
                detail: {
                    ids: assignedIds,
                    name: agentName,
                    action: `/agents/${agentId}/assignments`
                }
            }));
        }

        function hideAssignmentModal() {
            document.getElementById('assignment-modal').classList.add('hidden');
        }

        function showDeleteModal(agentId, agentName) {
            const modal = document.getElementById('delete-confirm-modal');
            const form = document.getElementById('delete-agent-form');
            const nameSpan = document.getElementById('delete-agent-name');
            
            form.action = `/agents/${agentId}`;
            nameSpan.innerText = agentName;
            
            modal.classList.remove('hidden');
        }

        function hideDeleteModal() {
            document.getElementById('delete-confirm-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>
