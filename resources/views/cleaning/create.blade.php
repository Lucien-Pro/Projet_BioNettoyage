<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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

                            @if($type === 'autolaveuse')
                                <!-- Formulaire HE024 - Autolaveuse -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                                    <div class="flex flex-col md:flex-row justify-between border-b border-gray-300 pb-4 mb-6">
                                        <div class="mb-4 md:mb-0">
                                            <h4 class="text-lg font-bold text-gray-800 uppercase leading-tight">Suivi plan de nettoyage - désinfection quotidien<br><span class="text-indigo-600">AUTO LAVEUSE</span></h4>
                                            <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-widest">N°: HE024 | Version: 1 | Page 1 sur 1</p>
                                        </div>
                                        <div class="text-[10px] text-gray-400 text-right space-y-1">
                                            <p>Nature: Enregistrement</p>
                                            <p>Archivage: 10 ans</p>
                                            <p>Rédigé le: 09/01/2022 | CDS EOHH</p>
                                        </div>
                                    </div>

                                    <div class="mb-6 flex gap-4 max-w-md">
                                        <div class="flex-1 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Mois</span>
                                            <input type="text" name="mois" value="{{ $currentMonth }}" class="w-full border-none p-0 focus:ring-0 font-bold text-indigo-600 text-sm">
                                        </div>
                                        <div class="flex-1 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Année</span>
                                            <input type="text" name="annee" value="{{ $currentYear }}" class="w-full border-none p-0 focus:ring-0 font-bold text-indigo-600 text-sm">
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto rounded-xl border border-gray-300 bg-white">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Surfaces / Tâches</th>
                                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Qui</th>
                                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Fréq.</th>
                                                    @for($i = 1; $i <= 31; $i++)
                                                        <th class="px-1 py-3 text-center text-[9px] font-bold {{ $i == $currentDay ? 'bg-indigo-600 text-white' : 'text-gray-400 border-l border-gray-100' }}">{{ $i }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @php
                                                    $tasks = [
                                                        'raclette' => ['label' => 'Nettoyer la raclette', 'freq' => 'Util.'],
                                                        'vidange' => ['label' => 'Vidanger la machine (siphon)', 'freq' => '1/j'],
                                                        'reservoir' => ['label' => 'Rincer le réservoir', 'freq' => '1/j'],
                                                        'exterieur' => ['label' => 'Nettoyer l\'extérieur', 'freq' => '1/j'],
                                                        'gants' => ['label' => 'Nettoyer les gants', 'freq' => 'Util.'],
                                                    ];
                                                @endphp

                                                @foreach($tasks as $key => $task)
                                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                                        <td class="px-3 py-2 text-[11px] font-medium text-gray-700">{{ $task['label'] }}</td>
                                                        <td class="px-2 py-1 text-center">
                                                            <div class="relative inline-block w-16">
                                                                <select name="qui_{{ $key }}" class="appearance-none w-full bg-indigo-50 border-none text-indigo-700 text-[10px] font-bold px-2 py-1 rounded-full text-center focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                                                                    <option value="ASH">ASH</option>
                                                                    <option value="AE">AE</option>
                                                                    <option value="ST">ST</option>
                                                                    <option value="AS">AS</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="px-2 py-2 text-[9px] text-gray-400 text-center font-bold uppercase">{{ $task['freq'] }}</td>
                                                        @for($i = 1; $i <= 31; $i++)
                                                            <td class="px-0 py-0 text-center {{ $i == $currentDay ? 'bg-indigo-50/50' : 'border-l border-gray-50' }}">
                                                                <input type="checkbox" name="{{ $key }}_{{ $i }}" 
                                                                    {{ $i == $currentDay ? 'checked' : '' }} 
                                                                    class="h-3.5 w-3.5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition-transform hover:scale-110">
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-8 flex flex-col md:flex-row justify-between items-start gap-6 text-[10px] text-gray-500">
                                        <div class="max-w-md bg-white p-3 rounded-xl border border-gray-200">
                                            <p class="font-bold text-gray-700 mb-1 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"></path></svg>
                                                Informations
                                            </p>
                                            <p><strong>Tenue :</strong> Gants de ménage, blouse, chaussures et protections adaptées.</p>
                                            <p class="mt-1"><strong>Légende :</strong> ASH (Hospitalier), AE (Entretien), ST (Technique), AS (Aide Soignante)</p>
                                        </div>
                                        <div class="flex gap-8 w-full md:w-auto">
                                            <div class="border-t-2 border-gray-200 pt-3 flex-1 md:flex-none md:min-w-[140px] text-center">
                                                <p class="font-bold text-gray-700">Mme le Dr HUBERT</p>
                                                <p class="text-[9px]">Présidente CLIN</p>
                                                <div class="h-8 italic text-gray-300 flex items-center justify-center">Signature</div>
                                            </div>
                                            <div class="border-t-2 border-gray-200 pt-3 flex-1 md:flex-none md:min-w-[140px] text-center">
                                                <p class="font-bold text-gray-700">Mme DOUEZ</p>
                                                <p class="text-[9px]">Directrice</p>
                                                <div class="h-8 italic text-gray-300 flex items-center justify-center">Signature</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Section des champs spécifiques (Placeholder) -->
                                <div class="bg-indigo-50/50 p-8 rounded-2xl border-2 border-dashed border-indigo-100 text-center">
                                    <div class="text-indigo-600 font-bold mb-2 text-lg">Les formulaires "{{ $title }}" arrivent bientôt.</div>
                                    <p class="text-sm text-gray-500 italic max-w-md mx-auto">Je suis en train d'intégrer vos documents pour qu'ils soient aussi complets que celui de l'autolaveuse.</p>
                                </div>
                            @endif

                            <!-- Commentaire général -->
                            <div class="mt-8">
                                <label for="commentaires" class="block text-sm font-bold text-gray-700 mb-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                    Observations / Commentaires
                                </label>
                                <textarea name="commentaires" id="commentaires" rows="3" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm bg-gray-50/30" placeholder="Ex: Rien à signaler, problème de fuite..."></textarea>
                            </div>

                            <div class="pt-6 flex items-center justify-end border-t border-gray-100">
                                <a href="{{ route('cleaning.index') }}" class="px-6 py-2 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors mr-auto">
                                    Annuler
                                </a>
                                <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 transform hover:-translate-y-1 active:translate-y-0 transition-all flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
