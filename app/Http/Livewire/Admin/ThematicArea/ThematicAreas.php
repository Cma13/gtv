<?php

namespace App\Http\Livewire\Admin\ThematicArea;

use App\Jobs\ProcessThematicArea;
use App\Models\ThematicArea;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ThematicAreas extends Component
{
    use WithPagination;

    public $listeners = ['delete'];

    public $search;
    public $searchColumn = 'id';

    public $sortField = 'id';
    public $sortDirection = 'asc';

    protected $queryString = ['search'];

    public $createForm = [
        'open' => false,
        'name' => '',
        'description' => '',
    ];
    public $editForm = [
        'name' => '',
        'description' => '',
    ];

    protected $rules = [
        'createForm.name' => 'required|max:45',
        'createForm.description' => 'required|max:2000',
    ];

    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'createForm.description' => 'descripción',

        'editForm.name' => 'nombre',
        'editForm.description' => 'descripción',
    ];

    public $showModal = [
        'open' => false,
        'id' => null,
        'name' => null,
        'description' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];

    public $editModal = [
        'open' => false,
        'id' => null,
    ];

    public function show(ThematicArea $thematicArea)
    {
        $this->showModal['id'] = $thematicArea->id;

        $this->showModal['name'] = $thematicArea->name;
        $this->showModal['description'] = $thematicArea->description;
        $this->showModal['createdAt'] = $thematicArea->created_at;
        $this->showModal['updatedAt'] = $thematicArea->updated_at;

        $this->showModal['open'] = true;
    }

    public function edit(ThematicArea $thematicArea)
    {
        $this->editModal['id'] = $thematicArea->id;

        $this->editForm['name'] = $thematicArea->name;
        $this->editForm['description'] = $thematicArea->description;

        $this->editModal['createdAt'] = $thematicArea->created_at;
        $this->editModal['updatedAt'] = $thematicArea->updated_at;

        $this->editModal['open'] = true;
    }

    public function save()
    {
        $this->validate();

        $thematicArea = ThematicArea::create([
            'name' => $this->createForm['name'],
            'description' => $this->createForm['description'],
            'updated_at' => null,
        ]);

        ProcessThematicArea::dispatch($thematicArea);

        $this->reset('createForm');

        $this->emit('thematicAreaCreated');

        $isCreated = $thematicArea;
        if ($isCreated) {
            Log::info('User with ID ' . auth()->user()->id . 'was created a thematic area with name ' . $thematicArea->name .$thematicArea);
        }
    }

    public function update(ThematicArea $thematicArea)
    {
        $this->validate([
            'editForm.name' => 'max:45',
            'editForm.description' => 'max:2000',
        ]);

        $thematicArea['name'] = $this->editForm['name'];
        $thematicArea['description'] = $this->editForm['description'];

        $isUpdated = $thematicArea->update();

        if ($isUpdated) {
            Log::info('User with ID ' . auth()->user()->id . 'was updated a thematic area with name ' . $thematicArea->name .$thematicArea);
        }

        $this->editModal['open'] = false;
        $this->reset(['editForm']);

        $this->emit('thematicAreaUpdated');
    }

    public function delete(ThematicArea $thematicArea)
    {
        $thematicArea->pointsOfInterest()->detach();

        $isDeleted = $thematicArea->delete();

        if($isDeleted) {
            Log::alert('Point with name ' . $thematicArea->name . ' was deleted by user with ID ' . auth()->user()->id .$thematicArea);
        }

        Log::info('Thematic area with ID ' . $thematicArea->id . ' was deleted ' . $thematicArea);
    }

    public function sort($field)
    {
        if ($this->sortField === $field && $this->sortDirection !== 'desc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'sortField', 'sortDirection']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (auth()->user()->hasRole('Administrador')
            || auth()->user()->hasRole('Profesor')) {

            $thematicAreas = ThematicArea::where($this->searchColumn, 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);

            return view('livewire.admin.thematic-area.thematic-areas', compact('thematicAreas'));
        }
    }
}
