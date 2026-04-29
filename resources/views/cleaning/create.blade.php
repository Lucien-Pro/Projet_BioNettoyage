<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div id="main-content">
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

                        <div id="form-container" class="space-y-6 opacity-20 blur-sm pointer-events-none transition-all duration-700">
                            <!-- Information de base -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <input type="hidden" name="location_id" id="location_id">
                                    <div id="location-placeholder" class="py-4 px-6 bg-indigo-50/50 rounded-2xl border-2 border-dashed border-indigo-100 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-8 h-8 text-indigo-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                            <p class="text-sm font-bold text-indigo-400">En attente du scan de la zone...</p>
                                        </div>
                                    </div>
                                    <div id="location-display" class="hidden">
                                        <div class="bg-white p-4 rounded-2xl border border-emerald-100 shadow-sm flex items-center gap-4">
                                            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Zone Identifiée</p>
                                                <p id="location-name" class="text-lg font-black text-gray-800"></p>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-md uppercase">Vérifié par QR</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Date & Heure</label>
                                    <input type="text" value="{{ now()->format('d/m/Y H:i') }}" disabled class="w-full rounded-xl border-gray-100 bg-gray-50 text-gray-500 shadow-sm">
                                </div>
                            </div>

                            @if($type === 'rooms')
                                <!-- Formulaire HE022 - Entretien des chambres -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                                    <div class="flex flex-col md:flex-row justify-between border-b border-gray-300 pb-4 mb-6 items-center">
                                        <div class="flex items-center gap-4 mb-4 md:mb-0">
                                            <div class="w-16 h-16 bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center justify-center">
                                                <x-application-logo class="w-10 h-10" />
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-800 uppercase leading-tight text-indigo-600">Traçabilité de l'entretien des chambres</h4>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest">N°: HE022 | Version: 3 | Page 2 sur 2</p>
                                                    <a href="http://srvwdoc01:8080/ennov/prod" target="_blank" class="group inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-indigo-50 to-blue-50 hover:from-indigo-100 hover:to-blue-100 text-indigo-800 text-[10px] font-semibold rounded-full transition-all duration-300 shadow-sm hover:shadow border border-indigo-100">
                                                        <svg class="w-3.5 h-3.5 text-indigo-500 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                                        Voir Protocole
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-[10px] text-gray-400 text-right space-y-1 w-full md:w-auto">
                                            <p>Nature: Enregistrement | Mise à jour le : 01/02/2015</p>
                                            <p>Saisie hebdomadaire | Diffusion interne</p>
                                        </div>
                                    </div>

                                    <div class="mb-6 grid grid-cols-1 md:grid-cols-1 gap-4">
                                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm text-center">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Semaine n°</span>
                                            <p class="font-bold text-indigo-600 text-xl">{{ $currentWeek }}</p>
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
                                                    <tr class="{{ $day == $currentDayName ? 'bg-indigo-50 border-x-2 border-indigo-200' : 'hidden' }} transition-colors">
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
                                    <div class="flex flex-col md:flex-row justify-between border-b border-gray-300 pb-4 mb-6 items-center">
                                        <div class="flex items-center gap-4 mb-4 md:mb-0">
                                            <div class="w-16 h-16 bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center justify-center">
                                                <x-application-logo class="w-10 h-10" />
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-800 uppercase leading-tight text-indigo-600">Traçabilité de l'entretien de la chambre mortuaire</h4>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest">N°: HE900 | Version: 1 | Page 1 sur 2</p>
                                                    <a href="http://srvwdoc01:8080/ennov/prod" target="_blank" class="group inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-indigo-50 to-blue-50 hover:from-indigo-100 hover:to-blue-100 text-indigo-800 text-[10px] font-semibold rounded-full transition-all duration-300 shadow-sm hover:shadow border border-indigo-100">
                                                        <svg class="w-3.5 h-3.5 text-indigo-500 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                                        Voir Protocole
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-[10px] text-gray-400 text-right space-y-1 w-full md:w-auto">
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


                                </div>
                            @elseif($type === 'offices')
                                <!-- Formulaire HE038 - Entretien des offices -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                                    <div class="flex flex-col md:flex-row justify-between border-b border-gray-300 pb-4 mb-6 items-center">
                                        <div class="flex items-center gap-4 mb-4 md:mb-0">
                                            <div class="w-16 h-16 bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center justify-center">
                                                <x-application-logo class="w-10 h-10" />
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-800 uppercase leading-tight text-indigo-600">Enregistrement de l'entretien des offices</h4>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest">N°: HE038 | Version: 2 | Page 1 sur 1</p>
                                                    <a href="http://srvwdoc01:8080/ennov/prod" target="_blank" class="group inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-indigo-50 to-blue-50 hover:from-indigo-100 hover:to-blue-100 text-indigo-800 text-[10px] font-semibold rounded-full transition-all duration-300 shadow-sm hover:shadow border border-indigo-100">
                                                        <svg class="w-3.5 h-3.5 text-indigo-500 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                                        Voir Protocole
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-[10px] text-gray-400 text-right space-y-1 w-full md:w-auto">
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
                                    </div>

                                    <div class="overflow-x-auto rounded-xl border border-gray-300 bg-white max-h-[600px] overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-slate-800 text-white sticky top-0 z-10 shadow-md">
                                                <tr>
                                                    <th class="px-4 py-4 text-left text-[11px] font-black uppercase tracking-widest text-slate-200">Jour</th>
                                                    <th class="px-4 py-4 text-center text-[11px] font-black uppercase tracking-widest text-slate-200">Meublants<br><span class="text-[9px] font-medium text-slate-400 lowercase tracking-normal">(T, C, Ar, E, Pt)</span></th>
                                                    <th class="px-4 py-4 text-center text-[11px] font-black uppercase tracking-widest text-slate-200">Matériel<br><span class="text-[9px] font-medium text-slate-400 lowercase tracking-normal">(P, Lv, Mo, C, Cl)</span></th>
                                                    <th class="px-4 py-4 text-center text-[11px] font-black uppercase tracking-widest text-slate-200">Chariot Petit Déj.</th>
                                                    <th class="px-4 py-4 text-center text-[11px] font-black uppercase tracking-widest text-slate-200">Réfrigérateur</th>
                                                    <th class="px-4 py-4 text-center text-[11px] font-black uppercase tracking-widest text-slate-200">Sols</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @for($i = 1; $i <= 31; $i++)
                                                    <tr class="{{ $i == $currentDay ? 'bg-indigo-50 border-y-2 border-indigo-200' : 'hidden' }} transition-colors">
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

                                    <div class="mt-8 grid grid-cols-1 gap-6 text-[10px] text-gray-500">
                                        <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100 italic space-y-2">
                                            <p><strong>Meublants :</strong> T=Table, C=chaises, Ar=Armoires de rangement, E=Evier et meuble sous évier, Pt=Plan de travail.</p>
                                            <p><strong>Matériel :</strong> P=Poubelles, Lv=Lave vaisselle, Mo=Four Micro-ondes, C=Cafetière, CI=Chauffe lait.</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($type === 'autolaveuse')
                                <!-- Formulaire HE024 - Autolaveuse -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                                    <div class="flex flex-col md:flex-row justify-between border-b border-gray-300 pb-4 mb-6 items-center">
                                        <div class="flex items-center gap-4 mb-4 md:mb-0">
                                            <div class="w-16 h-16 bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center justify-center">
                                                <x-application-logo class="w-10 h-10" />
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-800 uppercase leading-tight">Suivi plan de nettoyage - désinfection quotidien<br><span class="text-indigo-600">AUTO LAVEUSE</span></h4>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest">N°: HE024 | Version: 1 | Page 1 sur 1</p>
                                                    <a href="http://srvwdoc01:8080/ennov/prod" target="_blank" class="group inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-indigo-50 to-blue-50 hover:from-indigo-100 hover:to-blue-100 text-indigo-800 text-[10px] font-semibold rounded-full transition-all duration-300 shadow-sm hover:shadow border border-indigo-100">
                                                        <svg class="w-3.5 h-3.5 text-indigo-500 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                                        Voir Protocole
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-[10px] text-gray-400 text-right space-y-1 w-full md:w-auto">
                                            <p>Nature: Enregistrement</p>
                                            <p>Archivage: 10 ans</p>
                                            <p>Rédigé le: 09/01/2022 | CDS EOHH</p>
                                        </div>
                                    </div>

                                    <div class="mb-6 flex gap-4 max-w-md">
                                        <div class="flex-1 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Mois</span>
                                            <p class="font-bold text-indigo-600 text-sm">{{ $currentMonth }}</p>
                                            <input type="hidden" name="mois" value="{{ $currentMonth }}">
                                        </div>
                                        <div class="flex-1 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Année</span>
                                            <p class="font-bold text-indigo-600 text-sm">{{ $currentYear }}</p>
                                            <input type="hidden" name="annee" value="{{ $currentYear }}">
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto rounded-xl border border-gray-300 bg-white">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Surfaces / Tâches</th>
                                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Qui</th>
                                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Fréquence</th>
                                                    @for($i = 1; $i <= 31; $i++)
                                                        <th class="px-1 py-3 text-center text-[9px] font-bold {{ $i == $currentDay ? 'bg-indigo-600 text-white' : 'hidden' }}">{{ $i }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @php
                                                    $tasks = [
                                                        'raclette' => ['label' => 'Nettoyer la raclette', 'freq' => 'Après chaque utilisation'],
                                                        'vidange' => ['label' => 'Vidanger la machine (siphon)', 'freq' => '1/jour'],
                                                        'reservoir' => ['label' => 'Rincer le réservoir', 'freq' => '1/jour'],
                                                        'exterieur' => ['label' => 'Nettoyer l\'extérieur', 'freq' => '1/jour'],
                                                        'gants' => ['label' => 'Nettoyer les gants', 'freq' => 'Après nettoyage du matériel'],
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
                                                        <td class="px-2 py-2 text-[9px] text-gray-500 text-center font-bold">{{ $task['freq'] }}</td>
                                                        @for($i = 1; $i <= 31; $i++)
                                                            <td class="px-0 py-0 text-center {{ $i == $currentDay ? 'bg-indigo-50/50' : 'hidden' }}">
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
                                <button type="button" id="submit-trigger" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 transform hover:-translate-y-1 active:translate-y-0 transition-all flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                    Scanner pour enregistrer
                                </button>
                                <button type="submit" id="real-submit" class="hidden"></button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Message de verrouillage (Priorité Absolue) -->
    <div id="lock-message" class="fixed inset-0 flex items-center justify-center z-[9999] bg-slate-900/60 backdrop-blur-md transition-all duration-500">
        <div class="relative bg-white p-10 rounded-3xl shadow-[0_30px_100px_rgba(0,0,0,0.5)] border border-gray-100 text-center max-w-sm mx-4">
            <!-- Icône Stylisée -->
            <div class="relative w-20 h-20 mx-auto mb-8">
                <div class="absolute inset-0 bg-indigo-600 rounded-2xl rotate-6 opacity-20"></div>
                <div class="relative bg-indigo-600 w-full h-full rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                </div>
            </div>
    <!-- Message de verrouillage (Style Custom pour garantir l'affichage) -->
    <div id="lock-message" class="fixed inset-0 flex items-center justify-center z-[10000] transition-all duration-500" style="background-color: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px);">
        <div class="custom-lock-card w-full max-w-sm mx-4 text-center">
            <!-- Icône Premium -->
            <div class="mb-8 relative flex justify-center">
                <div class="custom-icon-container flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                </div>
            </div>

            <h3 class="custom-lock-title">Accès Sécurisé</h3>
            <p class="custom-lock-text">Veuillez flasher le QR Code du local pour déverrouiller l'accès au formulaire.</p>

            <button type="button" onclick="startScanner('START')" class="custom-lock-btn flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Scanner le QR Code
            </button>
        </div>
    </div>
    <!-- Modal du Scanner QR Code -->
    <div id="scanner-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="stopScanner()"></div>

            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-white/20">
                <div class="bg-indigo-600 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            </div>
                            <h3 class="text-xl font-black text-white" id="modal-title">Identification de la Zone</h3>
                        </div>
                        <button onclick="stopScanner()" class="text-white/70 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div id="qr-reader" class="rounded-2xl overflow-hidden border-4 border-gray-100 bg-gray-50 aspect-square flex items-center justify-center relative">
                        <div class="absolute inset-0 z-10 pointer-events-none border-[30px] border-black/40"></div>
                        <div class="absolute inset-[30px] z-10 pointer-events-none border-2 border-indigo-500 animate-pulse"></div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500 font-medium">Placez le QR code de la zone dans le cadre pour l'identifier automatiquement.</p>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex flex-col gap-3">
                    <p class="text-[10px] text-center text-gray-400 uppercase font-bold tracking-widest">Le scan est obligatoire pour la traçabilité</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script id="locations-data" type="application/json">
        {!! json_encode($locations->pluck('name', 'id')) !!}
    </script>
    <script>
        let html5QrCode = null;
        let scanStep = 'START';
        let initialLocationId = null;

        // On convertit la liste PHP en objet JS via le DOM pour éviter les erreurs de linting VS Code
        const locationsMap = JSON.parse(document.getElementById('locations-data').textContent);

        const scannerModal = document.getElementById('scanner-modal');
        const modalTitle = document.getElementById('modal-title');
        const formContainer = document.getElementById('form-container');
        const lockMessage = document.getElementById('lock-message');
        const locationInput = document.getElementById('location_id');
        const locationPlaceholder = document.getElementById('location-placeholder');
        const locationDisplay = document.getElementById('location-display');
        const locationName = document.getElementById('location-name');
        const submitTrigger = document.getElementById('submit-trigger');
        const realSubmit = document.getElementById('real-submit');

        function startScanner(step = 'START') {
            scanStep = step;
            modalTitle.innerText = (step === 'END') ? "Validation de Fin" : "Identification de la Zone";

            scannerModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            html5QrCode = new Html5Qrcode("qr-reader");
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };

            html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
            .catch(err => {
                console.error("Erreur caméra:", err);
                alert("Impossible d'accéder à la caméra. Vérifiez les permissions.");
                stopScanner();
            });
        }

        function stopScanner() {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    scannerModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
            } else {
                scannerModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        function onScanSuccess(decodedText) {
            let locationId = decodedText.startsWith('BNL_') ? decodedText.replace('BNL_', '') : decodedText;

            if (scanStep === 'START') {
                handleStartScan(locationId);
            } else {
                handleEndScan(locationId);
            }
        }

        function handleStartScan(locationId) {
            if (locationsMap[locationId]) {
                locationInput.value = locationId;
                locationName.innerText = locationsMap[locationId];
                initialLocationId = locationId;
                
                locationPlaceholder.classList.add('hidden');
                locationDisplay.classList.remove('hidden');
                
                // Déverrouillage du formulaire
                document.body.classList.remove('form-locked');
                formContainer.classList.remove('opacity-20', 'blur-sm', 'pointer-events-none');
                lockMessage.style.display = 'none';
                document.body.style.overflow = 'auto';
                
                stopScanner();
            } else {
                alert("Ce QR code ne correspond à aucune zone enregistrée.");
            }
        }

        function handleEndScan(locationId) {
            if (locationId == initialLocationId) {
                stopScanner();
                submitTrigger.innerHTML = '<svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Enregistrement...';
                submitTrigger.classList.replace('bg-indigo-600', 'bg-emerald-600');
                setTimeout(() => realSubmit.click(), 800);
            } else {
                alert("Erreur : Le QR code ne correspond pas à la zone de début !");
            }
        }

        function onScanFailure(error) { }

        submitTrigger.addEventListener('click', () => {
            if (!initialLocationId) {
                alert("Veuillez d'abord scanner la zone.");
                startScanner('START');
                return;
            }
            startScanner('END');
        });

        window.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add('form-locked');
            document.body.style.overflow = 'hidden'; // Bloque le scroll au départ
            setTimeout(() => startScanner('START'), 500);
        });
    </script>

    <style>
        /* Styles Custom pour la pop-up de verrouillage (garantit l'affichage sans compilation Tailwind) */
        .custom-lock-card {
            background-color: white;
            padding: 2.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #eef2ff;
            transform: scale(1);
            transition: all 0.3s ease;
            width: 90%;
            max-width: 400px;
            margin: 0 auto;
        }
        .custom-icon-container {
            width: 6rem;
            height: 6rem;
            background: linear-gradient(135deg, #6366f1, #9333ea);
            border-radius: 1.25rem;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
            transform: rotate(3deg);
            transition: transform 0.3s ease;
            margin: 0 auto;
        }
        .custom-icon-container:hover {
            transform: rotate(6deg);
        }

        .custom-lock-title {
            font-size: 1.5rem;
            font-weight: 900;
            color: #1e293b;
            margin-bottom: 0.75rem;
            letter-spacing: -0.025em;
        }
        .custom-lock-text {
            color: #64748b;
            font-size: 0.875rem;
            line-height: 1.625;
            margin-bottom: 2rem;
        }
        .custom-lock-btn {
            width: 100%;
            padding: 1rem 0;
            background: linear-gradient(to right, #4f46e5, #7e22ce);
            color: white;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 1.125rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }
        .custom-lock-btn:hover {
            background: linear-gradient(to right, #4338ca, #6b21a8);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* On cache totalement les en-têtes de tableau tant que la page est verrouillée */
        body.form-locked thead {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }

        #qr-reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 1rem !important;
        }
        #qr-reader {
            border: none !important;
        }
    </style>
</x-app-layout>
