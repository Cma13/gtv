<div>
    <h1 class="text-2xl font-semibold text-gray-700">Bienvenido, <span class="text-blue-500 font-bold">{{ auth()->user()->name }}</span></h1>

    @role('Usuario sin verificar')

        <h1 class="text-2xl font-semibold text-gray-700 mt-2">Su usuario aún no ha sido verificado</h1>
    @else
        <div class="mt-6 space-y-10">
            @role('Administrador')

                {{-- TABLA USUARIOS   ID-NOMBRE-EMAIL --}}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" colspan="3">
                                    ÚLTIMOS USUARIOS REGISTRADOS
                                </th>
                                <th scope="col" class="px-6 py-3 text-right" colspan="2">
                                    TOTAL - {{ $countusers }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-6 py-3">
                                    FOTO
                                </td>
                                <td class="px-6 py-3">
                                    ID
                                </td>
                                <td class="px-6 py-3">
                                    NOMBRE
                                </td>
                                <td class="px-6 py-3">
                                    EMAIL
                                </td>
                            </tr>
                            @foreach ($users as $user)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        @if ($user->profile_photo_path)
                                            <img class="w-10 h-10 rounded-full" src="{{ $user->profile_photo_path }}"
                                                alt="User avatar">
                                        @else
                                            <div
                                                class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mx-auto">
                                                <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button wire:click="showUsers('{{ $user->id }}')"
                                            class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                            Ver más
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endrole

            @hasanyrole('Administrador|Profesor')



                {{-- TABLA ÁREAS TEMÁTICAS   ID-NOMBRE-DESCRIPCIÓN --}}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" colspan="2">
                                    ÚLTIMAS ÁREAS TEMÁTICAS CREADAS
                                </th>
                                <th scope="col" class="px-6 py-3 text-right" colspan="2">
                                    TOTAL - {{ $countareas }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-6 py-3">
                                    ID
                                </td>
                                <td class="px-6 py-3">
                                    NOMBRE
                                </td>
                                <td class="px-6 py-3">
                                    DESCRIPCIÓN
                                </td>
                            </tr>
                            @foreach ($thematicAreas as $thematicArea)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        {{ $thematicArea->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $thematicArea->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $thematicArea->description }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button wire:click="showAreas('{{ $thematicArea->id }}')"
                                            class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                            Ver más
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endhasanyrole

            {{-- TABLA PUNTOS DE INTERÉS   ID-DISTANCIA-LUGAR --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3" colspan="2">
                                ÚLTIMOS PUNTOS DE INTERÉS CREADOS
                            </th>
                            <th scope="col" class="px-6 py-3 text-right" colspan="2">
                                TOTAL - {{ $countpoints }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-6 py-3">
                                ID
                            </td>
                            <td class="px-6 py-3">
                                LUGAR
                            </td>
                        </tr>
                        @foreach ($points as $point)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    {{ $point->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $point->place->name }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button wire:click="showPoints('{{ $point->id }}')"
                                        class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                        Ver más
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @hasanyrole('Administrador|Profesor')
                {{-- TABLA LUGARES   ID-NOMBRE-DESCRIPCION --}}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" colspan="2">
                                    ÚLTIMOS LUGARES CREADOS
                                </th>
                                <th scope="col" class="px-6 py-3 text-right" colspan="2">
                                    TOTAL - {{ $countplaces }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-6 py-3">
                                    ID
                                </td>
                                <td class="px-6 py-3">
                                    NOMBRE
                                </td>
                                <td class="px-6 py-3">
                                    DESCRIPCIÓN
                                </td>
                            </tr>
                            @foreach ($places as $place)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        {{ $place->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $place->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $place->description }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button wire:click="showPlaces('{{ $place->id }}')"
                                            class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                            Ver más
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endhasanyrole

            {{-- TABLA VIDEOS   ID-DESCRIPCIÓN-AREA --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3" colspan="2">
                                ÚLTIMOS VIDEOS SUBIDOS
                            </th>
                            <th scope="col" class="px-6 py-3 text-right" colspan="2">
                                TOTAL - {{ $countvideos }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-6 py-3">
                                ID
                            </td>
                            <td class="px-6 py-3">
                                DESCRIPCIÓN
                            </td>
                        </tr>
                        @foreach ($videos as $video)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    {{ $video->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $video->description }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button wire:click="showVideos('{{ $video->id }}')"
                                        class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                        Ver más
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- TABLA FOTOGRAFÍAS   ID-PUNTO INTERÉS-ÁREA TEMÁTICA --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3" colspan="2">
                                ÚLTIMAS FOTOGRAFÍAS SUBIDAS
                            </th>
                            <th scope="col" class="px-6 py-3 text-right" colspan="2">
                                TOTAL - {{ $countphotographies }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-6 py-3">
                                ID
                            </td>
                            <td class="px-6 py-3">
                                PUNTO INTERÉS
                            </td>
                        </tr>
                        @foreach ($photographies as $photography)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    {{ $photography->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $photography->point_of_interest_id }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button wire:click="showPhotographies('{{ $photography->id }}')"
                                        class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                        Ver más
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



        {{-- Modal showVideos --}}
        <x-jet-dialog-modal wire:model="detailsModalVideos.open">
            <x-slot name="title">
                <span class="text-2xl">Detalles del vídeo #{{ $detailsModalVideos['id'] }}</span>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-3">
                    @if ($detailsModalVideos['route'] !== null)
                        @livewire('admin.video.video-preview', ['route' => $detailsModalVideos['route']])
                    @endif
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Descripción:</span> {{ $detailsModalVideos['description'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Ruta:</span> {{ $detailsModalVideos['route'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Orden:</span> {{ $detailsModalVideos['order'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Punto de interés:</span> {{ $detailsModalVideos['pointOfInterest'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Creador:</span> {{ $detailsModalVideos['creatorName'] }} ({{ $detailsModalVideos['creatorId'] }})
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Actualizador:</span>
                            @if ($detailsModalVideos['updaterName'])
                                {{ $detailsModalVideos['updaterName'] }} ({{ $detailsModalVideos['updaterId'] }})
                            @else
                                {{ 'ninguno' }}
                            @endif
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Fecha de creación:</span> {{ $detailsModalVideos['createdAt'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Fecha de actualización:</span> {{ $detailsModalVideos['updatedAt'] }}
                        </x-jet-label>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button wire:click="$set('detailsModalVideos.open', false)">
                    Cerrar
                </x-button>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Modal showTemathicAreas --}}
        <x-jet-dialog-modal wire:model="detailsModalAreas.open">
            <x-slot name="title">
                <span class="text-2xl">Detalle del área temática #{{ $detailsModalAreas['id'] }}</span>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Nombre:</span> {{ $detailsModalAreas['name'] }}
                        </x-jet-label>
                    </div>

                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Descripción:</span> {{ $detailsModalAreas['description'] }}
                        </x-jet-label>
                    </div>

                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Fecha de creación:</span> {{ $detailsModalAreas['createdAt'] }}
                        </x-jet-label>
                    </div>

                    <div class="mb-4">
                        @if ($detailsModalAreas['updatedAt'] == null)
                            <x-jet-label>
                                <span class="font-bold">Fecha de actualización:</span> No se ha actualizado
                            </x-jet-label>
                        @else
                            <x-jet-label>
                                <span class="font-bold">Fecha de actualización:</span> {{ $detailsModalAreas['updatedAt'] }}
                            </x-jet-label>
                        @endif
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button wire:click="$toggle('detailsModalAreas.open')">
                    Cerrar
                </x-button>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Modal showUsers --}}
        <x-jet-dialog-modal wire:model="detailsModalUsers.open">
            <x-slot name="title">
                <span class="text-2xl">Detalles del usuario #{{ $detailsModalUsers['id'] }}</span>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-3">
                    <div class="my-8">
                        @if ($detailsModalUsers['avatar'])
                            <img class="w-36 h-36 rounded-full mx-auto" src="{{ $detailsModalUsers['avatar'] }}"
                                alt="User avatar">
                        @else
                            <div
                                class="relative w-36 h-36 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mx-auto">
                                <svg class="w-36 h-36 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Nombre:</span> {{ $detailsModalUsers['name'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Email:</span> {{ $detailsModalUsers['email'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Rol:</span> {{ $detailsModalUsers['rol'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Fecha de creación:</span> {{ $detailsModalUsers['createdAt'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Fecha de actualización:</span> {{ $detailsModalUsers['updatedAt'] }}
                        </x-jet-label>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button wire:click="$set('detailsModalUsers.open', false)">
                    Cerrar
                </x-button>
            </x-slot>
        </x-jet-dialog-modal>


        {{-- Modal showPoints --}}
        <x-jet-dialog-modal wire:model="detailsModalPoints.open">
            <x-slot name="title">
                <span class="text-2xl">Detalles del Punto de Interés #{{ $detailsModalPoints['id'] }}</span>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Nombre:</span> {{ $detailsModalPoints['name'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Descripción:</span> {{ $detailsModalPoints['description'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Latitud:</span> {{ $detailsModalPoints['latitude'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Longitud:</span> {{ $detailsModalPoints['longitude'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Lugar:</span> {{ $detailsModalPoints['placeName'] }} ({{ $detailsModalPoints['placeId'] }})
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Área/s Temática/s:</span>
                            @foreach ($detailsModalPoints['thematicAreas'] as $thematicArea)
                                <span>{{ $thematicArea['name'] }} ({{ $thematicArea['id'] }}), </span>
                            @endforeach
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Creador:</span> {{ $detailsModalPoints['creatorName'] }} ({{ $detailsModalPoints['creatorId'] }})
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Actualizador:</span>
                            @if ($detailsModalPoints['updaterName'])
                                {{ $detailsModalPoints['updaterName'] }} ({{ $detailsModalPoints['updaterId'] }})
                            @else
                                {{ 'ninguno' }}
                            @endif
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Fecha de creación:</span> {{ $detailsModalPoints['createdAt'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Fecha de actualización:</span> {{ $detailsModalPoints['updatedAt'] }}
                        </x-jet-label>
                    </div>
                    <div class="flex flex-col">
                        <x-jet-label>
                            <span class="font-bold">Código del punto de interés:</span>
                        </x-jet-label>
                        <span class="mx-auto">{{ QrCode::geo($detailsModalPoints['latitude'], $detailsModalPoints['longitude']); }}</span>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button wire:click="$set('detailsModalPoints.open', false)">
                    Cerrar
                </x-button>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Modal showPlaces --}}
        <x-jet-dialog-modal wire:model="detailsModalPlaces.open">
            <x-slot name="title">
                <span class="text-2xl">Detalles del lugar #{{ $detailsModalPlaces['id'] }}</span>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <x-jet-label>
                            <span class="font-bold">ID:</span> {{ $detailsModalPlaces['id'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Nombre:</span> {{ $detailsModalPlaces['name'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Descripción:</span> {{ $detailsModalPlaces['description'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Creador:</span> {{ $detailsModalPlaces['creatorName'] }} ({{ $detailsModalPlaces['creatorId'] }})
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Actualizador:</span>
                            @if ($detailsModalPlaces['updaterName'])
                                {{ $detailsModalPlaces['updaterName'] }} ({{ $detailsModalPlaces['updaterId'] }})
                            @else
                                {{ 'ninguno' }}
                            @endif
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Fecha de creación:</span> {{ $detailsModalPlaces['createdAt'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Última actualización:</span> {{ $detailsModalPlaces['updatedAt'] }}
                        </x-jet-label>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button wire:click="$set('detailsModalPlaces.open', false)">
                    Cerrar
                </x-button>
            </x-slot>
        </x-jet-dialog-modal>

        {{-- Modal showPhotographies --}}
        <x-jet-dialog-modal wire:model="detailsModalPhotographies.open">
            <x-slot name="title">
                <span class="text-2xl">Detalle de la fotografía #{{ $detailsModalPhotographies['id'] }}</span>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    <div class="mb-4">
                        <a class="max-w-xs" href="{{ $detailsModalPhotographies['route'] }}" target="_blank">
                            <img src="{{ $detailsModalPhotographies['route'] }}">
                        </a>
                    </div>

                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Ruta:</span> {{ $detailsModalPhotographies['route'] }}
                        </x-jet-label>
                    </div>

                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Orden:</span> {{ $detailsModalPhotographies['order'] }}
                        </x-jet-label>
                    </div>

                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Punto de interes:</span> {{ $detailsModalPhotographies['pointOfInterestId'] }}
                        </x-jet-label>
                    </div>

                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Creador:</span> {{ $detailsModalPhotographies['creatorName'] }} (ID:
                            {{ $detailsModalPhotographies['creatorId'] }})
                        </x-jet-label>
                    </div>

                    @if (!is_null($detailsModalPhotographies['updaterId']))
                        <div class="mb-4">
                            <x-jet-label>
                                <span class="font-bold">Actualizador:</span> {{ $detailsModalPhotographies['updaterName'] }} (ID:
                                {{ $detailsModalPhotographies['updaterId'] }})
                            </x-jet-label>
                        </div>
                    @endif

                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Fecha de creación:</span> {{ $detailsModalPhotographies['createdAt'] }}
                        </x-jet-label>
                    </div>

                    @if (!is_null($detailsModalPhotographies['updaterId']))
                        <div class="mb-4">
                            <x-jet-label>
                                <span class="font-bold">Fecha de actualización:</span> {{ $detailsModalPhotographies['updatedAt'] }}
                            </x-jet-label>
                        </div>
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button wire:click="$toggle('detailsModalPhotographies.open')">
                    Cerrar
                </x-button>
            </x-slot>
        </x-jet-dialog-modal>

    @endrole
</div>
