<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Locaux') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        search: '',
        openBuildings: [],
        toggleBuilding(id) {
            if (this.openBuildings.includes(id)) {
                this.openBuildings = this.openBuildings.filter(i => i !== id);
            } else {
                this.openBuildings.push(id);
            }
        },
        isVisible(buildingsName, children) {
            if (this.search === '') return true;
            const searchLower = this.search.toLowerCase();
            if (buildingsName.toLowerCase().includes(searchLower)) return true;
            return children.some(child => child.name.toLowerCase().includes(searchLower));
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input 
                        type="text" 
                        x-model="search" 
                        placeholder="Rechercher un bâtiment ou une salle..." 
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                </div>
            </div>

            <div class="space-y-4">
                @forelse ($locations as $building)
                    <div 
                        x-show="isVisible('{{ addslashes($building->name) }}', {{ $building->children->toJson() }})"
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100"
                    >
                        <!-- Building Header -->
                        <div 
                            @click="toggleBuilding({{ $building->id }})"
                            class="p-4 flex justify-between items-center cursor-pointer hover:bg-gray-50 transition"
                            :class="openBuildings.includes({{ $building->id }}) ? 'bg-indigo-50' : ''"
                        >
                            <div class="flex items-center">
                                <span class="p-2 mr-3 bg-indigo-100 text-indigo-700 rounded-lg">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 uppercase">{{ $building->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $building->children->count() }} salles répertoriées</p>
                                </div>
                            </div>
                            <span>
                                <svg 
                                    class="h-6 w-6 text-gray-400 transition-transform duration-200"
                                    :class="openBuildings.includes({{ $building->id }}) ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>

                        <!-- Rooms List (Accordion Content) -->
                        <div 
                            x-show="openBuildings.includes({{ $building->id }}) || search !== ''"
                            x-collapse
                        >
                            <div class="border-t border-gray-100 bg-gray-50 p-4">
                                @if($building->children->isEmpty())
                                    <p class="text-sm text-gray-500 italic">Aucune salle spécifique pour ce bâtiment.</p>
                                @else
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($building->children as $room)
                                            <div 
                                                x-show="search === '' || '{{ addslashes($room->name) }}'.toLowerCase().includes(search.toLowerCase())"
                                                class="bg-white p-3 rounded border border-gray-200 shadow-sm flex flex-col justify-between hover:border-indigo-300 transition"
                                            >
                                                <div class="text-sm font-semibold text-gray-700 uppercase">{{ $room->name }}</div>
                                                <div class="text-[10px] text-gray-400 mt-1 uppercase">{{ $room->completename }}</div>
                                                @if($room->comment)
                                                    <div class="mt-2 text-[11px] text-indigo-500 italic bg-indigo-50 p-1 rounded">
                                                        {{ \Illuminate\Support\Str::limit($room->comment, 50) }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-12 text-center rounded-lg shadow">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun local trouvé</h3>
                                <p class="mt-1 text-sm text-gray-500">Assurez-vous d'avoir bien importé le fichier SQL glpi_locations.sql.</p>
                            </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
