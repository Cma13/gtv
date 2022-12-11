<div>
	<div class="w-full h-[600px] mb-10">
		<livewire:map-component :initial-points="$initialPoints"/>
	</div>

	<div class="mb-3">
		<div class="inline">
			<select class="text-black bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto" wire:model="filters.place">
				<option value="">Todos los lugares</option>
				@foreach($places as $place)
					<option value="{{$place->id}}">{{$place->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="inline">
			<select class="text-black bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto" wire:model="filters.thematicArea">
				<option value="">Todas las áreas temáticas</option>
				@foreach($thematicAreas as $area)
					<option value="{{$area->id}}">{{$area->name}}</option>
				@endforeach
			</select>
		</div>

		<x-jet-input class="py-1 border-black" type="text" wire:model="filters.search" placeholder="Buscar punto de interés..."></x-jet-input>
	</div>

	@if(count($pointsList))
		<x-table>
			<x-slot name="thead">
				<th scope="col" class="px-6 py-3 whitespace-nowrap w-px">
					<input type="checkbox" class="mr-1.5" wire:model="selectAllMarkers"/>
					Seleccionar todos
				</th>
				<th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('point_of_interests.id')">
					ID
					@if($sort['field'] === 'point_of_interests.id' && $sort['direction'] === 'asc')
						<i class="fa-solid fa-arrow-up">
					@elseif($sort['field'] === 'point_of_interests.id' && $sort['direction'] === 'desc')
						<i class="fa-solid fa-arrow-down"></i>
					@endif
				</th>
				<th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('point_of_interests.name')">
					Nombre
					@if($sort['field'] === 'point_of_interests.name' && $sort['direction'] === 'asc')
						<i class="fa-solid fa-arrow-up">
					@elseif($sort['field'] === 'point_of_interests.name' && $sort['direction'] === 'desc')
						<i class="fa-solid fa-arrow-down"></i>
					@endif
				</th>
				<th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('places.name')">
					Lugar
					@if($sort['field'] === 'places.name' && $sort['direction'] === 'asc')
						<i class="fa-solid fa-arrow-up">
					@elseif($sort['field'] === 'places.name' && $sort['direction'] === 'desc')
						<i class="fa-solid fa-arrow-down"></i>
					@endif
				</th>
				<th scope="col" class="px-6 py-3">
					Áreas temáticas
				</th>
			</x-slot>

			<x-slot name="tbody">
				@foreach($pointsList as $point)
					<tr class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
						<td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
							<input type="checkbox" wire:model="activeMarkers" value="{{$point->id}}"/>
						</td>
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
							<ul class="grid grid-cols-2 gap-1 list-disc list-disc list-inside">
								@foreach($point->thematicAreas as $area)
									<li>{{$area->name}}</li>
								@endforeach
							</ul>
						</td>
					</tr>
				@endforeach
			</x-slot>
		</x-table>

		@if($pointsList->hasPages())
			<div class="mt-6">
				{{ $pointsList->links() }}
			</div>
		@endif
	@else
		<p class="mt-4">No se han encontrado resultados</p>
	@endif
</div>
