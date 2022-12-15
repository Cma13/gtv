<div>
    @if (countVerifyElementsHelper())
        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Elementos por verificar:</h1>
            <a href="{{ route('deleted-verify.index') }}"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <i class="fa-solid fa-trash"></i>
            </a>
        </div>

        <div class="mb-3">
            <div class="inline">
                <select
                    class="text-black  bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                        font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                        focus:outline-none dark:focus:ring-blue-800 ml-auto"
                    wire:model="searchColumn">
                    <option value="" disabled selected>Selecciona un filtro</option>
                    <option value="points_of_interest">PUNTOS DE INTERÉS</option>
                    <option value="places">LUGARES</option>
                    <option value="videos">VIDEOS</option>
                    <option value="photos">FOTOGRAFÍAS</option>
                </select>
            </div>

            <x-jet-input class="py-1 border-black" type="text" wire:model="search" placeholder="Buscar ...">
            </x-jet-input>

            <x-jet-button wire:click="resetFilters">Eliminar filtros</x-jet-button>
        </div>

        @if (!!count($points) || !!count($places) || !!count($videos) || !!count($photos))
            <div class="mt-6 space-y-10">
                @if (count($points))
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" colspan="10">
                                        PUNTOS DE INTERÉS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($pointHeaders as $pointHeader)
                                        <td class="px-6 py-3">
                                            {{ $pointHeader }}
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($points as $point)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $point->id }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $point->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ getDescripcionCorta(50, $point->description) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $point->place->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ \App\Models\User::find($point->creator)->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            @if ($point->updater)
                                                {{ \App\Models\User::find($point->updater)->name }}
                                            @else
                                                <span>Ninguno</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap float-right">
                                            <span class="text-2xl text-blue-600 cursor-pointer"
                                                wire:click="showPoints({{ $point->id }})">
                                                <i class="fa-solid fa-eye"></i>
                                            </span>
                                            <span class="text-2xl text-green-400 cursor-pointer"
                                                wire:click="verifyElement({{ $point->id }}, 'point')">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </span>
                                            <span class="text-2xl text-red-500 cursor-pointer"
                                                wire:click="moveToTrash('{{ $point->id }}', 'point')">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if (count($places))
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" colspan="10">
                                        LUGARES
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($placeHeaders as $placeHeader)
                                        <td class="px-6 py-3">
                                            {{ $placeHeader }}
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($places as $place)
                                    <tr
                                        class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $place->id }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $place->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $place->description }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ \App\Models\User::find($place->creator)->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ \App\Models\User::find($place->updater)->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $place->created_at }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap float-right">
                                            <span class="text-2xl text-blue-600 cursor-pointer"
                                                wire:click="showPlaces({{ $place->id }})">
                                                <i class="fa-solid fa-eye"></i>
                                            </span>
                                            <span class="text-2xl text-green-400 cursor-pointer"
                                                wire:click="verifyElement({{ $place->id }}, 'place')">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </span>
                                            <span class="text-2xl text-red-500 cursor-pointer"
                                                wire:click="moveToTrash('{{ $place->id }}', 'place')">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if (count($videos))

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" colspan="10">
                                        VIDEOS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($videoHeaders as $videoHeader)
                                        <td class="px-6 py-3">
                                            {{ $videoHeader }}
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($videos as $video)
                                    <tr
                                        class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $video->id }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $video->description }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            @if (!is_null($video->pointOfInterest))
                                                {{ $video->pointOfInterest->id }}
                                            @else
                                                <span>Ninguno</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $video->order }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap float-right">
                                            <span class="text-2xl text-blue-600 cursor-pointer"
                                                wire:click="showVideos({{ $video->id }})">
                                                <i class="fa-solid fa-eye"></i>
                                            </span>
                                            <span class="text-2xl text-green-400 cursor-pointer"
                                                wire:click="verifyElement({{ $video->id }}, 'video')">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </span>
                                            <span class="text-2xl text-red-500 cursor-pointer"
                                                wire:click="moveToTrash('{{ $video->id }}', 'video')">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if (count($photos))

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" colspan="10">
                                        FOTOGRAFIAS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($photoHeaders as $photoHeader)
                                        <td class="px-6 py-3">
                                            {{ $photoHeader }}
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($photos as $photo)
                                    <tr
                                        class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $photo->id }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            <a class="max-w-xs" href="{{ $photo->route }}" target="_blank">
                                                <img src="{{ $photo->route }}">
                                            </a>
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $photo->order }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            @if (!empty($photo->point_of_interest_id))
                                                {{ $photo->point_of_interest_id }}
                                            @else
                                                <span class="text-red-600">Ninguno</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ \App\Models\User::find($photo->creator)->name }}
                                            @role('Administrador')
                                                (ID: {{ \App\Models\User::find($photo->creator)->id }})
                                            @endrole
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            @if ($photo->updater)
                                                {{ \App\Models\User::find($photo->updater)->name }}
                                                @role('Administrador')
                                                    (ID: {{ \App\Models\User::find($photo->updater)->id }})
                                                @endrole
                                            @else
                                                <span>Sin actualizar</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $photo->created_at }}
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            @if ($photo->updater)
                                                {{ $photo->updated_at }}
                                            @else
                                                <span>Sin actualizar</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap mr-0">
                                            <span class="text-2xl text-blue-600 cursor-pointer"
                                                wire:click="showPhotographies({{ $photo->id }})">
                                                <i class="fa-solid fa-eye"></i>
                                            </span>
                                            <span class="text-2xl text-green-400 cursor-pointer"
                                                wire:click="verifyElement({{ $photo->id }}, 'photo')">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </span>
                                            <span class="text-2xl text-red-500 cursor-pointer"
                                                wire:click="moveToTrash('{{ $photo->id }}', 'photo')">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @else
            <div
                class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    ¡No hay elementos que coincidan con tu búsqueda!
                </h5>
            </div>
        @endif



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
                            <span class="font-bold">Punto de interés:</span>
                            {{ $detailsModalVideos['pointOfInterest'] }}
                        </x-jet-label>
                    </div>
                    <div>
                        <x-jet-label>
                            <span class="font-bold">Creador:</span> {{ $detailsModalVideos['creatorName'] }}
                            ({{ $detailsModalVideos['creatorId'] }})
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
                            <span class="font-bold">Fecha de actualización:</span>
                            {{ $detailsModalVideos['updatedAt'] }}
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
                            <span class="font-bold">Lugar:</span> {{ $detailsModalPoints['placeName'] }}
                            ({{ $detailsModalPoints['placeId'] }})
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
                            <span class="font-bold">Creador:</span> {{ $detailsModalPoints['creatorName'] }}
                            ({{ $detailsModalPoints['creatorId'] }})
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
                            <span class="font-bold">Fecha de actualización:</span>
                            {{ $detailsModalPoints['updatedAt'] }}
                        </x-jet-label>
                    </div>
                    <div class="flex flex-col">
                        <x-jet-label>
                            <span class="font-bold">Código del punto de interés:</span>
                        </x-jet-label>
                        <span
                            class="mx-auto">{{ QrCode::geo($detailsModalPoints['latitude'], $detailsModalPoints['longitude']) }}</span>
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
                            <span class="font-bold">Creador:</span> {{ $detailsModalPlaces['creatorName'] }}
                            ({{ $detailsModalPlaces['creatorId'] }})
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
                            <span class="font-bold">Última actualización:</span>
                            {{ $detailsModalPlaces['updatedAt'] }}
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
                            <span class="font-bold">Punto de interes:</span>
                            {{ $detailsModalPhotographies['pointOfInterestId'] }}
                        </x-jet-label>
                    </div>

                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Creador:</span> {{ $detailsModalPhotographies['creatorName'] }}
                            (ID:
                            {{ $detailsModalPhotographies['creatorId'] }})
                        </x-jet-label>
                    </div>

                    @if (!is_null($detailsModalPhotographies['updaterId']))
                        <div class="mb-4">
                            <x-jet-label>
                                <span class="font-bold">Actualizador:</span>
                                {{ $detailsModalPhotographies['updaterName'] }} (ID:
                                {{ $detailsModalPhotographies['updaterId'] }})
                            </x-jet-label>
                        </div>
                    @endif

                    <div class="mb-4">
                        <x-jet-label>
                            <span class="font-bold">Fecha de creación:</span>
                            {{ $detailsModalPhotographies['createdAt'] }}
                        </x-jet-label>
                    </div>

                    @if (!is_null($detailsModalPhotographies['updaterId']))
                        <div class="mb-4">
                            <x-jet-label>
                                <span class="font-bold">Fecha de actualización:</span>
                                {{ $detailsModalPhotographies['updatedAt'] }}
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
    @else
        <div
            class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    ¡No hay elementos por verificar!
                </h5>
                <a href="{{ route('deleted-verify.index') }}"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </div>
            <a href="{{ route('welcome') }}"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Volver al inicio
            </a>
        </div>
    @endif
</div>
