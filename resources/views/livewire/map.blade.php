<div>
	<div class="flex items-center mb-6">
		<h1 class="text-2xl font-semibold text-gray-700">Mapa de puntos de interés</h1>
	</div>

	<div class="mb-3">
		<div class="inline">
			<select class="text-black  bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto" wire:model="searchColumn">
				<option value="id">ID</option>
				<option value="distance">DISTANCIA</option>
				<option value="latitude">LATITUD</option>
				<option value="longitude">LONGITUD</option>
				<option value="place_id">SITIO</option>
				<option value="creator">CREADOR</option>
				<option value="updater">ACTUALIZADOR</option>
				<option value="created_at">FECHA DE CREACIÓN</option>
				<option value="updated_at">FECHA DE ACTUALIZACIÓN</option>
			</select>
		</div>

		<x-jet-input class="py-1 border-black" type="text" wire:model="search"
		             placeholder="Buscar ..."></x-jet-input>

		<x-jet-button wire:click="resetFilters">Eliminar filtros</x-jet-button>
	</div>

	@if(count($points))
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
					Nombre
				</th>
				<th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('place_id')">
					Sitio
					@if($sortField === 'place_id' && $sortDirection === 'asc')
						<i class="fa-solid fa-arrow-up">
							@elseif($sortField === 'place_id' && $sortDirection === 'desc')
								<i class="fa-solid fa-arrow-down"></i>
					@endif
				</th>
				<th scope="col" class="px-6 py-3">
					Áreas temáticas
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
							{{$point->place->name}}
						</td>
						<td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
							@foreach($point->thematicAreas as $area)
								{{$area->name}}
							@endforeach
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

	<div class="w-full h-[400px]">
		<livewire:map-component></livewire:map-component>
	</div>
</div>
