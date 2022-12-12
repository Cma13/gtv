<div>
    @if (countVerifyElementsHelper())
        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Elementos por verificar:</h1>
            <a href="{{ route('deleted-verify.index') }}"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <i class="fa-solid fa-trash"></i>
            </a>
        </div>

        <div class="mt-6 space-y-10">
            @if (count($points))
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {!! QrCode::size(80)->generate(json_encode($point, JSON_PRETTY_PRINT)) !!}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $point->id }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $point->name }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $point->latitude }} / {{ $point->longitude }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $point->place->name }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ \App\Models\User::find($point->creator)->name }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @if ($point->updater)
                                            {{ \App\Models\User::find($point->updater)->name }}
                                        @else
                                            <span>Ninguno</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $point->created_at }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
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
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $place->id }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $place->name }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $place->description }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ \App\Models\User::find($place->creator)->name }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ \App\Models\User::find($place->updater)->name }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $place->created_at }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
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
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $video->id }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $video->description }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @if (!is_null($video->pointOfInterest))
                                            {{ $video->pointOfInterest->id }}
                                        @else
                                            <span>Ninguno</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $video->order }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ \App\Models\User::find($video->creator)->name }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @if ($video->updater)
                                            {{ \App\Models\User::find($video->updater)->name }}
                                        @else
                                            <span>Sin actualizar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $video->created_at }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
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
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $photo->id }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        <a class="max-w-xs" href="{{ $photo->route }}" target="_blank">
                                            <img src="{{ $photo->route }}">
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $photo->order }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @if (!empty($photo->point_of_interest_id))
                                            {{ $photo->point_of_interest_id }}
                                        @else
                                            <span class="text-red-600">Ninguno</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ \App\Models\User::find($photo->creator)->name }}
                                        @role('Administrador')
                                            (ID: {{ \App\Models\User::find($photo->creator)->id }})
                                        @endrole
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @if ($photo->updater)
                                            {{ \App\Models\User::find($photo->updater)->name }}
                                            @role('Administrador')
                                                (ID: {{ \App\Models\User::find($photo->updater)->id }})
                                            @endrole
                                        @else
                                            <span>Sin actualizar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $photo->created_at }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @if ($photo->updater)
                                            {{ $photo->updated_at }}
                                        @else
                                            <span>Sin actualizar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
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
