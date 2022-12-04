<div>
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Verificación de usuarios</h1>
    </div>

    <div class="mb-3">
        <div class="inline">
            <select class="text-black  bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto" wire:model="searchColumn">
                <option value="name">NOMBRE</option>
                <option value="email">EMAIL</option>
            </select>
        </div>

        <x-jet-input class="py-1 border-black" type="text" wire:model="search"
                     placeholder="Buscar ..."></x-jet-input>

        <x-jet-button wire:click="resetFilters">Eliminar filtros</x-jet-button>
    </div>

    @if(count($users))
        <x-table>
            <x-slot name="thead">
                <th scope="col" class="px-6 py-3"></th>
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
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('email')">
                    Email
                    @if($sortField === 'email' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                    @elseif($sortField === 'email' && $sortDirection === 'desc')
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
                    <span class="sr-only">Actions</span>
                </th>
            </x-slot>

            <x-slot name="tbody">
                @foreach($users as $user)
                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            @if($user->profile_photo_path)
                                <img class="w-10 h-10 rounded-full" src="{{ $user->profile_photo_path }}" alt="User avatar">
                            @else
                                <div class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mx-auto">
                                    <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $user->id }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $user->created_at }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $user->updated_at }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap flex gap-4 mt-2">
                            <span class="font-medium text-blue-600 cursor-pointer" wire:click="show('{{ $user->id }}')">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                            <span class="font-medium text-green-500 cursor-pointer"
                                  wire:click="$emit('verifyUser', '{{ $user->id }}')">
                                <i class="fa-regular fa-circle-check"></i>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>

        @if($users->hasPages())
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @endif
    @else
        <p class="mt-4">No hay usuarios sin verificar</p>
    @endif

    {{-- Modal show --}}
    <x-jet-dialog-modal wire:model="detailsModal.open">
        <x-slot name="title">
            <span class="text-2xl">Detalles del usuario #{{ $detailsModal['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <div class="my-8">
                    @if($detailsModal['avatar'])
                        <img class="w-36 h-36 rounded-full mx-auto" src="{{ $detailsModal['avatar'] }}" alt="User avatar">
                    @else
                        <div class="relative w-36 h-36 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mx-auto">
                            <svg class="w-36 h-36 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                    @endif
                </div>
                <div>
                    <x-jet-label>
                        Nombre: {{ $detailsModal['name']}}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Email: {{ $detailsModal['email'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Rol: {{ isset($user) ? $user->roles->first()->name : ''}}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Fecha de creación: {{ $detailsModal['createdAt'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Fecha de actualización: {{ $detailsModal['updatedAt'] }}
                    </x-jet-label>
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
            Livewire.on('verifyUser', userId => {
                Swal.fire({
                    title: '¿Quieres verificar este alumno?',
                    icon: 'question',
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: '#028f39',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Verificar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.verify-user.verify-user', 'verify', userId)
                        Swal.fire(
                            '¡Hecho!',
                            'El alumno ha sido verificado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush
</div>
