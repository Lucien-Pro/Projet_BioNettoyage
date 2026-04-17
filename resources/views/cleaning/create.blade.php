<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('cleaning.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-bold flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    Retour au choix de la tâche
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('cleaning.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div class="space-y-6">
                            <!-- Information de base -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="location_id" class="block text-sm font-bold text-gray-700 mb-1">Local / Zone</label>
                                    <select name="location_id" id="location_id" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all">
                                        <option value="">-- Sélectionner un lieu (optionnel) --</option>
                                        @foreach($locations as $loc)
                                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Date & Heure</label>
                                    <input type="text" value="{{ now()->format('d/m/Y H:i') }}" disabled class="w-full rounded-xl border-gray-100 bg-gray-50 text-gray-500 shadow-sm">
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <!-- Section des champs spécifiques (Placeholder) -->
                            <div class="bg-indigo-50/50 p-8 rounded-2xl border-2 border-dashed border-indigo-100 text-center">
                                <div class="text-indigo-600 font-bold mb-2">Les champs spécifiques du formulaire "{{ $title }}" arrivent bientôt.</div>
                                <p class="text-sm text-gray-500 italic">Dès que vous m'aurez transmis les modèles papier ou Excel, je les intégrerai ici avec des cases à cocher, des sélecteurs et des champs de texte.</p>
                            </div>

                            <!-- Commentaire général -->
                            <div>
                                <label for="commentaires" class="block text-sm font-bold text-gray-700 mb-1">Observations / Commentaires</label>
                                <textarea name="commentaires" id="commentaires" rows="3" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Ex: Rien à signaler, problème de fuite..."></textarea>
                            </div>

                            <div class="pt-4 flex items-center justify-end space-x-3">
                                <a href="{{ route('cleaning.index') }}" class="px-6 py-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">
                                    Annuler
                                </a>
                                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transform hover:-translate-y-0.5 transition-all">
                                    Enregistrer la tâche
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
