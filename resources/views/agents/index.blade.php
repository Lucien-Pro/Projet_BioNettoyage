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
                                            <button onclick="editAgent({{ $agent->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3 transition">Modifier</button>
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

    <script>
        function editAgent(agentId) {
            alert('Modification de l\'agent ID: ' + agentId);
        }

        function showDeleteModal(agentId, agentName) {
            const modal = document.getElementById('delete-confirm-modal');
            const form = document.getElementById('delete-agent-form');
            const nameSpan = document.getElementById('delete-agent-name');
            
            form.action = `/agents/${agentId}`;
            nameSpan.innerText = agentName;
            
            // Afficher avec une petite animation si possible (en changeant juste de classe ici)
            modal.classList.remove('hidden');
        }

        function hideDeleteModal() {
            document.getElementById('delete-confirm-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>
