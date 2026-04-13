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

    <!-- Modals -->
    <!-- Modal Ajouter un Agent (Existé déjà) -->
    <div id="add-agent-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Ajouter un Agent</h3>
                <form action="{{ route('agents.store') }}" method="POST" class="mt-4 text-left">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                        <input type="text" name="nom" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
                        <input type="text" name="prenom" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Initiales</label>
                        <input type="text" name="initiales" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Mot de passe provisoire</label>
                        <input type="password" name="password" required minlength="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p class="text-xs text-gray-500 mt-1">L'agent devra changer ce mot de passe à sa première connexion.</p>
                    </div>
                    @if(Auth::user()->role === 'super_admin')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Rôle</label>
                        <select name="role" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="utilisateur">Agent (Utilisateur)</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                    @endif
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Statut</label>
                        <select name="statut" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="actif">Actif</option>
                            <option value="inactif">Inactif</option>
                        </select>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="button" onclick="document.getElementById('add-agent-modal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2 transition">Annuler</button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmation de Suppression -->
    <div 
        id="delete-confirm-modal" 
        class="hidden fixed inset-0 z-50 overflow-y-auto" 
        aria-labelledby="modal-title" role="dialog" aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hideDeleteModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Icon Alert -->
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Supprimer cet agent ?</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Êtes-vous sûr de vouloir supprimer <span id="delete-agent-name" class="font-bold text-gray-800"></span> ? Cette action supprimera également son compte utilisateur associé et est irréversible.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <form id="delete-agent-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Supprimer définitivement
                        </button>
                    </form>
                    <button type="button" onclick="hideDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editAgent(agentId) {
            alert('Fonction de modification pour l\'agent ID: ' + agentId);
        }

        function showDeleteModal(agentId, agentName) {
            const modal = document.getElementById('delete-confirm-modal');
            const form = document.getElementById('delete-agent-form');
            const nameSpan = document.getElementById('delete-agent-name');
            
            // Mettre à jour l'action du formulaire et le nom
            form.action = `/agents/${agentId}`;
            nameSpan.innerText = agentName;
            
            // Afficher le modal
            modal.classList.remove('hidden');
        }

        function hideDeleteModal() {
            document.getElementById('delete-confirm-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>
