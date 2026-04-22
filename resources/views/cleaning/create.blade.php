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

                            @if($type === 'rooms')
                                <!-- Formulaire HE022 - Entretien des chambres -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                                    <div class="flex flex-col md:flex-row justify-between border-b border-gray-300 pb-4 mb-6">
                                        <div class="mb-4 md:mb-0">
                                            <h4 class="text-lg font-bold text-gray-800 uppercase leading-tight text-indigo-600">Traçabilité de l'entretien des chambres</h4>
                                            <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-widest">N°: HE022 | Version: 3 | Page 2 sur 2</p>
                                        </div>
                                        <div class="text-[10px] text-gray-400 text-right space-y-1">
                                            <p>Nature: Enregistrement | Mise à jour le : 01/02/2015</p>
                                            <p>Saisie hebdomadaire | Diffusion interne</p>
                                        </div>
                                    </div>

                                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm text-center">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Semaine n°</span>
                                            <p class="font-bold text-indigo-600 text-xl">{{ $currentWeek }}</p>
                                        </div>
                                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Unité (Secteur)</span>
                                            <input type="text" name="unite" placeholder="Saisir l'unité..." class="w-full border-none p-0 focus:ring-0 font-bold text-gray-700 text-sm">
                                        </div>
                                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Chambre n°</span>
                                            <input type="text" name="chambre" placeholder="Ex: 204..." class="w-full border-none p-0 focus:ring-0 font-bold text-gray-700 text-sm">
                                        </div>
                                    </div>

                                    <!-- Légende Codes -->
                                    <div class="flex flex-wrap gap-4 mb-6 bg-white p-4 rounded-xl border border-gray-100 shadow-sm text-[10px]">
                                        <div class="flex items-center"><span class="w-4 h-4 bg-blue-600 text-white flex items-center justify-center rounded mr-2 font-bold">M</span> Mobilier, meublants</div>
                                        <div class="flex items-center"><span class="w-4 h-4 bg-emerald-600 text-white flex items-center justify-center rounded mr-2 font-bold">S</span> Sanitaires, lavabo, WC</div>
                                        <div class="flex items-center"><span class="w-4 h-4 bg-amber-600 text-white flex items-center justify-center rounded mr-2 font-bold">G</span> Nettoyage avec la gaze</div>
                                        <div class="flex items-center"><span class="w-4 h-4 bg-rose-600 text-white flex items-center justify-center rounded mr-2 font-bold">F</span> Nettoyage avec la frange</div>
                                    </div>

                                    <div class="overflow-x-auto rounded-xl border border-gray-300 bg-white">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Jour de la semaine</th>
                                                    <th class="px-6 py-3 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Entretien réalisé (MSGF)</th>
                                                    <th class="px-6 py-3 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Visa agent</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @php
                                                    $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                                                    $currentDayName = ucfirst(now()->locale('fr')->isoFormat('dddd'));
                                                @endphp
                                                @foreach($days as $day)
                                                    <tr class="{{ $day == $currentDayName ? 'bg-indigo-50 border-x-2 border-indigo-200' : 'hover:bg-gray-50/50' }} transition-colors">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $day == $currentDayName ? 'text-indigo-700' : 'text-gray-900' }}">
                                                            {{ $day }}
                                                        </td>
                                                        <td class="px-6 py-4 text-center">
                                                            <div x-data="{ 
                                                                items: [],
                                                                toggle(val) {
                                                                    if (this.items.includes(val)) {
                                                                        this.items = this.items.filter(i => i !== val);
                                                                    } else {
                                                                        this.items.push(val);
                                                                    }
                                                                }
                                                            }" class="flex justify-center gap-2">
                                                                <template x-for="val in ['M', 'S', 'G', 'F']">
                                                                    <button type="button" 
                                                                        @click="toggle(val)"
                                                                        :class="{
                                                                            'bg-blue-600 text-white shadow-md': val === 'M' && items.includes(val),
                                                                            'bg-emerald-600 text-white shadow-md': val === 'S' && items.includes(val),
                                                                            'bg-amber-600 text-white shadow-md': val === 'G' && items.includes(val),
                                                                            'bg-rose-600 text-white shadow-md': val === 'F' && items.includes(val),
                                                                            'bg-gray-100 text-gray-400 hover:bg-gray-200': !items.includes(val)
                                                                        }"
                                                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-black transition-all duration-200"
                                                                        x-text="val">
                                                                    </button>
                                                                </template>
                                                                <input type="hidden" :name="'entretien_{{ $day }}[]'" :value="items.join(',')">
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 text-center text-[10px] uppercase font-bold {{ $day == $currentDayName ? 'text-indigo-400' : 'text-gray-200' }}">
                                                            @if($day == $currentDayName)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800">Visa OK</span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="mt-4 p-3 bg-white rounded-xl border border-gray-100 text-[10px] text-gray-400 italic">
                                        "Notez le nettoyage réalisé à gauche (M, S, G, F) après chaque intervention."
                                    </div>
                                </div>
                            @elseif($type === 'mortuary')
                                <!-- Formulaire HE900 - Chambre mortuaire -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                                    <div class="flex flex-col md:flex-row justify-between border-b border-gray-300 pb-4 mb-6">
                                        <div class="mb-4 md:mb-0">
                                            <h4 class="text-lg font-bold text-gray-800 uppercase leading-tight text-indigo-600">Traçabilité de l'entretien de la chambre mortuaire</h4>
                                            <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-widest">N°: HE900 | Version: 1 | Page 1 sur 2</p>
                                        </div>
                                        <div class="text-[10px] text-gray-400 text-right space-y-1">
                                            <p>Nature: Enregistrement | Archivage: 10 ans</p>
                                            <p>Date de rédaction: 23/03/2018 | Infirmière hygiéniste</p>
                                            <p>Noms: Mme BEN GHERBAL</p>
                                        </div>
                                    </div>

                                    <div class="max-w-2xl mx-auto py-8">
                                        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl text-center space-y-6">
                                            <div class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            
                                            <div>
                                                <h3 class="text-2xl font-black text-gray-900">Validation de l'entretien</h3>
                                                <p class="text-gray-500 mt-2">En enregistrant ce formulaire, vous attestez avoir effectué l'entretien complet de la chambre mortuaire ce jour.</p>
                                            </div>

                                            <div class="grid grid-cols-1 gap-4 text-left">
                                                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                                    <span class="block text-[10px] font-bold text-gray-400 uppercase">Agent d'entretien intervenant</span>
                                                    <p class="text-lg font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                                </div>
                                                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                                    <span class="block text-[10px] font-bold text-gray-400 uppercase">Horodatage de l'intervention</span>
                                                    <p class="text-lg font-bold text-gray-800">{{ ucfirst(now()->locale('fr')->isoFormat('dddd D MMMM YYYY - HH:mm')) }}</p>
                                                </div>
                                            </div>

                                            <div class="pt-4 italic text-[10px] text-gray-400">
                                                "Conformément au protocole HE900, l'entretien doit inclure la désinfection des surfaces et des sols."
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-8 flex justify-end items-end gap-4 text-[10px] text-gray-500">
                                        <div class="border-t-2 border-gray-200 pt-3 min-w-[140px] text-center">
                                            <p class="font-bold text-gray-700">Mme DOUEZ</p>
                                            <p class="text-[9px]">Directrice</p>
                                            <div class="h-8 italic text-gray-300 flex items-center justify-center">Visa Direction</div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($type === 'offices')
                                <!-- Formulaire HE038 - Entretien des offices -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                                    <div class="flex flex-col md:flex-row justify-between border-b border-gray-300 pb-4 mb-6">
                                        <div class="mb-4 md:mb-0">
                                            <h4 class="text-lg font-bold text-gray-800 uppercase leading-tight text-indigo-600">Enregistrement de l'entretien des offices</h4>
                                            <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-widest">N°: HE038 | Version: 2 | Page 1 sur 1</p>
                                        </div>
                                        <div class="text-[10px] text-gray-400 text-right space-y-1">
                                            <p>Nature: Enregistrement | Archivage: 10 ans</p>
                                            <p>Trame rédigée le: 29/11/2016 | CDS / Cadre de santé</p>
                                            <p>Noms: Mme CILIBERTO / Mme LEROY</p>
                                        </div>
                                    </div>

                                    <div class="mb-6 flex flex-wrap gap-4">
                                        <div class="flex-1 min-w-[150px] bg-white p-3 rounded-xl border border-gray-200 shadow-sm text-center">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Mois et Année</span>
                                            <p class="font-bold text-indigo-600 text-sm capitalize">{{ $currentMonth }} {{ $currentYear }}</p>
                                        </div>
                                        <div class="flex-1 min-w-[200px] bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Unité (Secteur)</span>
                                            <input type="text" name="unite" placeholder="Saisir l'unité..." class="w-full border-none p-0 focus:ring-0 font-bold text-gray-700 text-sm">
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto rounded-xl border border-gray-300 bg-white max-h-[600px] overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-100 sticky top-0 z-10">
                                                <tr>
                                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Jour</th>
                                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Meublants<br><span class="text-[8px] font-normal lowercase">(T, C, Ar, E, Pt)</span></th>
                                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Matériel<br><span class="text-[8px] font-normal lowercase">(P, Lv, Mo, C, Cl)</span></th>
                                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Chariot Petit Déj.</th>
                                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Réfrigérateur</th>
                                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Sols</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @for($i = 1; $i <= 31; $i++)
                                                    <tr class="{{ $i == $currentDay ? 'bg-indigo-50 border-y-2 border-indigo-200' : 'hover:bg-gray-50/50' }} transition-colors">
                                                        <td class="px-3 py-3 text-center text-sm font-bold {{ $i == $currentDay ? 'text-indigo-700' : 'text-gray-400' }}">
                                                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                        </td>
                                                        <td class="px-1 py-3 text-center">
                                                            <div x-data="{ 
                                                                items: [],
                                                                toggle(val) {
                                                                    if (this.items.includes(val)) {
                                                                        this.items = this.items.filter(i => i !== val);
                                                                    } else {
                                                                        this.items.push(val);
                                                                    }
                                                                }
                                                            }" class="flex flex-wrap justify-center gap-1 min-w-[120px]">
                                                                <template x-for="val in ['T', 'C', 'Ar', 'E', 'Pt']">
                                                                    <button type="button" 
                                                                        @click="toggle(val)"
                                                                        :class="items.includes(val) ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-400 hover:bg-gray-200'"
                                                                        class="w-6 h-6 flex items-center justify-center rounded-md text-[9px] font-bold transition-all duration-200"
                                                                        x-text="val">
                                                                    </button>
                                                                </template>
                                                                <input type="hidden" :name="'meublants_{{ $i }}[]'" :value="items.join(',')">
                                                            </div>
                                                        </td>
                                                        <td class="px-1 py-3 text-center">
                                                            <div x-data="{ 
                                                                items: [],
                                                                toggle(val) {
                                                                    if (this.items.includes(val)) {
                                                                        this.items = this.items.filter(i => i !== val);
                                                                    } else {
                                                                        this.items.push(val);
                                                                    }
                                                                }
                                                            }" class="flex flex-wrap justify-center gap-1 min-w-[120px]">
                                                                <template x-for="val in ['P', 'Lv', 'Mo', 'C', 'CI']">
                                                                    <button type="button" 
                                                                        @click="toggle(val)"
                                                                        :class="items.includes(val) ? 'bg-emerald-600 text-white shadow-md' : 'bg-gray-100 text-gray-400 hover:bg-gray-200'"
                                                                        class="w-6 h-6 flex items-center justify-center rounded-md text-[9px] font-bold transition-all duration-200"
                                                                        x-text="val">
                                                                    </button>
                                                                </template>
                                                                <input type="hidden" :name="'materiel_{{ $i }}[]'" :value="items.join(',')">
                                                            </div>
                                                        </td>
                                                        @php $cols = ['chariot', 'refrigerateur', 'sols']; @endphp
                                                        @foreach($cols as $col)
                                                            <td class="px-3 py-3 text-center items-center">
                                                                <input type="checkbox" name="{{ $col }}_{{ $i }}" 
                                                                    {{ $i == $currentDay ? 'checked' : '' }} 
                                                                    class="h-5 w-5 text-indigo-600 border-gray-300 rounded-md focus:ring-indigo-500 transition-transform hover:scale-110">
                                                                <span class="block text-[8px] mt-1 text-gray-400 uppercase font-bold {{ $i == $currentDay ? 'text-indigo-400' : 'hidden' }}">Visa OK</span>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-[10px] text-gray-500">
                                        <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100 italic space-y-2">
                                            <p><strong>Meublants :</strong> T=Table, C=chaises, Ar=Armoires de rangement, E=Evier et meuble sous évier, Pt=Plan de travail.</p>
                                            <p><strong>Matériel :</strong> P=Poubelles, Lv=Lave vaisselle, Mo=Four Micro-ondes, C=Cafetière, CI=Chauffe lait.</p>
                                        </div>
                                        <div class="flex gap-4 items-end justify-end">
                                            <div class="border-t-2 border-gray-200 pt-3 min-w-[120px] text-center">
                                                <p class="font-bold text-gray-700">Mme DOUEZ</p>
                                                <p class="text-[9px]">Directrice</p>
                                                <div class="h-8 italic text-gray-300 flex items-center justify-center">Signé le 08/12/16</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($type === 'autolaveuse')
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
