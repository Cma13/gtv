<div>
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Listado de puntos de interés</h1>

        <button type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ml-auto"
                wire:click="$emitTo('admin.point.create-point', 'openCreationModal')">
            Añadir
        </button>
    </div>

    <div class="mb-3">
        <div class="inline">
            <select class="text-black  bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto" wire:model="searchColumn">
                <option value="id">ID</option>
                <option value="name">NOMBRE</option>
                <option value="description">DESCRIPCIÓN</option>
                <option value="place_id">LUGAR</option>
                <option value="creator">CREADOR</option>
                <option value="updater">ACTUALIZADOR</option>
            </select>
        </div>

        <x-jet-input class="py-1 border-black" type="text" wire:model="search"
                     placeholder="Buscar ..."></x-jet-input>

        <x-jet-button wire:click="resetFilters">Eliminar filtros</x-jet-button>
    </div>

    @livewire('admin.point.create-point')

    @if(count($points))
        @livewire('admin.point.edit-point')

        <x-table>
            <x-slot name="thead">
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('id')">
                    ID
                    @if($sortField === 'id' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                            @elseif($sortField === 'id' && $sortDirection === 'desc')
                                <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('name')">
                    Nombre
                    @if($sortField === 'name' && $sortDirection === 'asc')
                    <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'name' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('description')">
                    Descripción
                    @if($sortField === 'description' && $sortDirection === 'asc')
                    <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'description' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('place_id')">
                    Lugar
                    @if($sortField === 'place_id' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                            @elseif($sortField === 'place_id' && $sortDirection === 'desc')
                                <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('creator')">
                    Creador
                    @if($sortField === 'creator' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                            @elseif($sortField === 'creator' && $sortDirection === 'desc')
                                <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('updater')">
                    Actualizador
                    @if($sortField === 'updater' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                            @elseif($sortField === 'updater' && $sortDirection === 'desc')
                                <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Actions</span>
                </th>
            </x-slot>

            <x-slot name="tbody">
                @foreach($points as $point)
                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{$point->id}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{$point->name}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{getDescripcionCorta(50, $point->description)}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{$point->place->name}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{\App\Models\User::find($point->creator)?->name}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            @if($point->updater)
                                {{\App\Models\User::find($point->updater)?->name}}
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap flex gap-4">
                            <span class="font-medium text-blue-600 cursor-pointer" wire:click="show('{{ $point->id }}')">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                            <span class="font-medium text-yellow-400 cursor-pointer"
                                  wire:click="$emitTo('admin.point.edit-point', 'openEditModal', '{{$point->id}}')">
                                <i class="fa-solid fa-pencil"></i>
                            </span>
                            <span class="font-medium text-red-500 cursor-pointer"
                                  wire:click="$emit('deletePoint', '{{$point->id}}')">
                                <i class="fa-solid fa-trash"></i>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>

        @if($points->hasPages())
            <div class="mt-6">
                {{ $points->links() }}
            </div>
        @endif
    @else
        <p class="mt-4">No se han encontrado resultados</p>
    @endif

    {{-- Modal show --}}
    <x-jet-dialog-modal wire:model="detailsModal.open">
        <x-slot name="title">
            <span class="text-2xl">Detalles del Punto de Interés #{{ $detailsModal['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <div>
                    <x-jet-label>
                        <span class="font-bold">Nombre:</span> {{ $detailsModal['name']}}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">Descripción:</span> {{ $detailsModal['description']}}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">Latitud:</span> {{ $detailsModal['latitude'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">Longitud:</span> {{ $detailsModal['longitude'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">Lugar:</span> {{ $detailsModal['placeName'] }} ({{ $detailsModal['placeId'] }})
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">Área/s Temática/s:</span>
                        @foreach ($detailsModal['thematicAreas'] as $thematicArea)
                            <span>{{ $thematicArea['name'] }} ({{ $thematicArea['id'] }}), </span>
                        @endforeach 
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">Creador:</span> {{ $detailsModal['creatorName'] }} ({{ $detailsModal['creatorId'] }})
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">Actualizador:</span>
                        @if($detailsModal['updaterName'])
                            {{ $detailsModal['updaterName'] }} ({{ $detailsModal['updaterId'] }})
                        @else
                            {{ 'ninguno' }}
                        @endif
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">Fecha de creación:</span> {{ $detailsModal['createdAt'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">Fecha de actualización:</span> {{ $detailsModal['updatedAt'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        <span class="font-bold">QR y mapa:</span>
                    </x-jet-label>
                    <div class="flex">
                        <div class="min-w-min flex-auto mr-4 self-center">{{ QrCode::geo($detailsModal['latitude'], $detailsModal['longitude']) }}</div>
                        <div class="w-full h-[250px] flex-auto">
                            <livewire:map-component :initial-points="\App\Models\PointOfInterest::all()"/>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('detailsModal.open', false)">
                Cerrar
            </x-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('scripts')
        <script>
            Livewire.on('deletePoint', pointId => {
                Swal.fire({
                    title: '¿Quieres eliminar este punto?',
                    text: 'Esta operación es irreversible',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.point.show-point', 'delete', pointId)
                        Swal.fire(
                            '¡Hecho!',
                            'El punto ha sido borrado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush
</div>
