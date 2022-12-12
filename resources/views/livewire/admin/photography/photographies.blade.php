<div>
    <div>
        <div class="flex items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Listado de fotografías</h1>

            <button wire:click="$toggle('createForm.open')" type="button" class="text-white bg-blue-700
                hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm
                px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none
                dark:focus:ring-blue-800 ml-auto">
                Añadir
            </button>
        </div>

        <div class="mb-3">
            <div class="inline">
                <select class="text-black  bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto" wire:model="searchColumn">
                    <option value="id">ID</option>
                    <option value="point_of_interest_id">PUNTO DE INTERÉS</option>
                    @hasanyrole('Administrador|Profesor')
                        <option value="creator">CREADOR</option>
                        <option value="Updater">ACTUALIZADOR</option>
                    @endhasanyrole
                    <option value="created_at">FECHA DE CREACIÓN</option>
                    <option value="updated_at">FECHA DE ACTUALIZACIÓN</option>
                </select>
            </div>

            <x-jet-input class="py-1 border-black" type="text" wire:model="search"
                placeholder="Buscar ..."></x-jet-input>

            <x-jet-button wire:click="resetFilters">Eliminar filtros</x-jet-button>
        </div>

        @if(count($photographies))
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
                    <th scope="col" class="px-6 py-3">
                        Ruta
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('order')">
                        Orden
                        @if($sortField === 'order' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'order' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('point_of_interest_id')">
                        Punto de interés
                        @if($sortField === 'point_of_interest_id' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'point_of_interest_id' && $sortDirection === 'desc')
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
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('created_at')">
                        Fecha creación
                        @if($sortField === 'created_at' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'created_at' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('updated_at')">
                        Fecha actualización
                        @if($sortField === 'updated_at' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'updated_at' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </x-slot>

                <x-slot name="tbody">
                    @foreach($photographies as $photography)
                        <tr class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $photography->id }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                <a class="max-w-xs" href="{{ $photography->route }}" target="_blank">
                                    <img src="{{ $photography->route }}">
                                </a>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $photography->order }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                @if( ! empty($photography->point_of_interest_id))
                                    {{ $photography->point_of_interest_id }}
                                @else
                                    <span class="text-red-600">Ninguno</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ \App\Models\User::find($photography->creator)->name }}
                                @role('Administrador')
                                    (ID: {{ \App\Models\User::find($photography->creator)->id }})
                                @endrole
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                @if($photography->updater)
                                    {{ \App\Models\User::find($photography->updater)->name }}
                                    @role('Administrador')
                                    (ID: {{ \App\Models\User::find($photography->updater)->id }})
                                    @endrole
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $photography->created_at }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                @if($photography->updater)
                                    {{ $photography->updated_at }}
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                <span class="font-medium text-blue-600 cursor-pointer mr-3"
                                      wire:click="show('{{ $photography->id }}')">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                                <span class="font-medium text-yellow-400 cursor-pointer mr-3"
                                      wire:click="edit('{{ $photography->id }}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </span>
                                <span class="font-medium text-red-500 cursor-pointer"
                                      wire:click="$emit('deletePhotography', '{{ $photography->id }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>

            @if($photographies->hasPages())
                <div class="mt-6">
                    {{ $photographies->links() }}
                </div>
            @endif
        @else
            <p class="mt-4">No se han encontrado resultados</p>
        @endif
    </div>

    <x-jet-dialog-modal wire:model="showModal.open">
        <x-slot name="title">
            <span class="text-2xl">Detalle de la fotografía #{{ $showModal['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="mb-4">
                    <a class="max-w-xs" href="{{ $showModal['route'] }}" target="_blank">
                        <img src="{{ $showModal['route'] }}">
                    </a>
                </div>

                <div class="mb-4">
                    <x-jet-label>
                        Ruta: {{ $showModal['route'] }}
                    </x-jet-label>
                </div>

                <div class="mb-4">
                    <x-jet-label>
                        Orden: {{ $showModal['order'] }}
                    </x-jet-label>
                </div>

                @if( ! empty($showModal['pointOfInterestId']))
                    <div class="mb-4">
                        <x-jet-label>
                            Punto de interés: {{ $showModal['pointOfInterestId'] }}
                        </x-jet-label>
                    </div>
                @else
                    <div class="mb-4">
                        <x-jet-label>
                            Punto de interés: <span class="text-red-600">Ninguno</span>
                        </x-jet-label>
                    </div>
                    <div class="mb-4">
                        <x-jet-label>
                            Área temática: <span class="text-red-600">Ninguna</span>
                        </x-jet-label>
                    </div>
                @endif

                <div class="mb-4">
                    <x-jet-label>
                        Creador: {{ $showModal['creatorName'] }} (ID: {{ $showModal['creatorId'] }})
                    </x-jet-label>
                </div>

                @if( ! is_null($showModal['updaterId']))
                    <div class="mb-4">
                        <x-jet-label>
                            Actualizador: {{ $showModal['updaterName'] }} (ID: {{ $showModal['updaterId'] }})
                        </x-jet-label>
                    </div>
                @endif

                <div class="mb-4">
                    <x-jet-label>
                        Fecha de creación: {{ $showModal['createdAt'] }}
                    </x-jet-label>
                </div>

                @if( ! is_null($showModal['updaterId']))
                    <div class="mb-4">
                        <x-jet-label>
                            Fecha de actualización: {{ $showModal['updatedAt'] }}
                        </x-jet-label>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$toggle('showModal.open')">
                Cerrar
            </x-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="createForm.open">
        <x-slot name="title">
            <span class="text-2xl">Crear fotografía</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">

                @if ($this->createForm['route'])
                    Preview
                    <img src="{{ $this->createForm['route']->temporaryUrl() }}">
                @endif

                <div class="mb-6">
                    <label for="Fotografía" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        Fotografía
                    </label>

                    <input type="file" wire:model="createForm.route" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-1"></input>

                    <x-jet-input-error for="createForm.route" class="mt-2" />
                </div>
                <div class="mb-6">
                    <label for="pointsOfInterest" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                        Punto de interés
                    </label>
                    <select id="pointsOfInterest" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            wire:model="createForm.pointOfInterestId">
                        <option value="">Seleccione un punto de interés</option>
                        @foreach ($pointsOfInterest as $pointOfInterest)
                            <option value="{{ $pointOfInterest->id}}">{{ $pointOfInterest->name }}</option>
                        @endforeach
                    </select>
                    @error('createForm.pointOfInterestId') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save">
                Crear
            </x-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="editModal.open">
        <x-slot name="title">
            <span class="text-2xl">Actualizar fotografía #{{ $this->editModal['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="mb-4">
                    @if ($this->editForm['route'])
                        Preview:
                        <img src="{{ $this->editForm['route']->temporaryUrl() }}">
                    @else
                        <a class="max-w-xs" href="{{ $this->editModal['route'] }}" target="_blank">
                            <img src="{{ $this->editModal['route'] }}">
                        </a>
                    @endif
                </div>
                <div class="mb-4">
                    <x-jet-label>
                        Cambiar fotografía
                    </x-jet-label>

                    <x-jet-input class="w-full"  type="file" wire:model="editForm.route"></x-jet-input>

                    <x-jet-input-error for="editForm.route" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-jet-label>
                        Punto de interés
                    </x-jet-label>

                    <select wire:model="editForm.pointOfInterestId" class="bg-gray-50 border border-gray-300
                            text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full
                            p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                            dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1">
                        @foreach($pointsOfInterest as $pointOfInterest)
                            <option value="{{ $pointOfInterest->id }}">{{ $pointOfInterest->name }}</option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="editForm.pointOfInterest" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button style="margin-right: 10px;" wire:click="update({{ $editModal['id'] }})">
                Actualizar
            </x-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('scripts')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            Livewire.on('photographyCreated', () => {
                Swal.fire(
                    '¡Hecho!',
                    'La fotografía ha sido creada.',
                    'success'
                )
            });
        </script>

        <script>
            Livewire.on('photographyUpdated', () => {
                Swal.fire(
                    '¡Hecho!',
                    'La fotografía ha sido actualizada.',
                    'success'
                )
            });
        </script>

        <script>
            Livewire.on('deletePhotography', photographyId => {
                Swal.fire({
                    title: '¿Quieres eliminar esta fotografía?',
                    text: 'Esta operación es irreversible',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.photography.photographies', 'delete', photographyId)
                        Swal.fire(
                            '¡Hecho!',
                            'La fotografía ha sido eliminada.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush
</div>
