<?php

namespace App\Http\Livewire\Admin\Photography;

use App\Jobs\ProcessPhotography;
use App\Models\Photography;
use App\Models\PointOfInterest;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Photographies extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $pointsOfInterest;

    public $listeners = ['delete'];

    public $search;
    public $searchColumn = 'id';

    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $queryString = ['search'];

    public $createForm = [
        'open' => false,
        'route' => null,
        'order' => '',
        'pointOfInterestId' => '',
    ];

    public $editForm = [
        'route' => null,
        'order' => '',
        'pointOfInterestId' => '',
    ];

    protected $rules = [
        'createForm.route' => 'image|mimes:png,jpg,jpeg|max:5120',
        'createForm.pointOfInterestId' => 'required|integer',
    ];

    protected $validationAttributes = [
        'createForm.route' => 'fotografía',
        'createForm.pointOfInterestId' => 'punto de interés',

        'editForm.route' => 'fotografía',
        'editForm.pointOfInterestId' => 'punto de interés',
    ];

    public $showModal = [
        'open' => false,
        'id' => null,
        'route' => null,
        'order' => null,
        'pointOfInterestId' => null,
        'creatorId' => null,
        'creatorName' => null,
        'updaterId' => null,
        'updaterName' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];

    public $editModal = [
        'open' => false,
        'id' => null,
        'route' => null,
        'order' => null,
        'pointOfInterestId' => null,
        'creatorId' => null,
        'creatorName' => null,
        'updaterId' => null,
        'updaterName' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];

    public function mount()
    {
        $this->getPointsOfInterest();
    }

    public function getPointsOfInterest()
    {
        $this->pointsOfInterest = PointOfInterest::all();
    }

	public function updatedCreateformRoute()
	{
		$this->withValidator(function (Validator $validator) {
			$validator->after(function ($validator) {
				if ($validator->failed()) {
					$this->createForm['route'] = null;
				}
			});
		})->validateOnly('createForm.route');
	}

    public function save()
    {
		$this->validate();

        if(auth()->user()->hasRole('Administrador')
            || auth()->user()->hasRole('Profesor')) {
                $this->createForm['route']->storeAs('public/photos', $this->createForm['route']->getFilename());

                $order = Photography::where('point_of_interest_id', $this->createForm['pointOfInterestId'])->count();
        
                $photography = Photography::create([
                    'route' => 'storage/photos/' . $this->createForm['route']->getFilename(),
                    'order' =>  $order + 1,
                    'point_of_interest_id' => $this->createForm['pointOfInterestId'],
                    'creator' => auth()->user()->id,
                    'updater' => null,
                    'updated_at' => null,
                    'verified' => true
                ]);
            } elseif(auth()->user()->hasRole('Alumno')) {
                $this->createForm['route']->storeAs('public/photos', $this->createForm['route']->getFilename());

                $order = Photography::where('point_of_interest_id', $this->createForm['pointOfInterestId'])->count();
        
                $photography = Photography::create([
                    'route' => 'storage/photos/' . $this->createForm['route']->getFilename(),
                    'order' =>  $order + 1,
                    'point_of_interest_id' => $this->createForm['pointOfInterestId'],
                    'creator' => auth()->user()->id,
                    'updater' => null,
                    'updated_at' => null,
                ]);
            }

        ProcessPhotography::dispatch($photography);

        $isCreated = $photography;

        if($isCreated) {
            Log::info('Photography with ID ' . $photography->id . ' was upload');
        }

        $this->reset('createForm');

        $this->emit('photographyCreated');
        $this->emitTo('admin.user-profile', 'render');
    }

    public function update(Photography $photography)
    {
        $this->validate([
            'editForm.route' => 'max:5120',
            'editForm.pointOfInterestId' => 'required|integer',
        ]);

        if (!is_null($this->editForm['route'])) {
            $this->editForm['route']->storeAs('public/photos', $this->editForm['route']->getFilename());

            $photography['route'] = 'storage/photos/' . $this->editForm['route']->getFilename();
        }

        $order = Photography::where('point_of_interest_id', $this->editForm['pointOfInterestId'])->count();

        $photography['order'] = $order + 1;
        $photography['point_of_interest_id'] = $this->editForm['pointOfInterestId'];
        $photography['updater'] = auth()->user()->id;

        $isUpdated = $photography->update();

        if($isUpdated) {
            Log::info('User with ID ' . auth()->user()->id . 'was updated a photography with ID ' . $photography->id . $photography);
        }

        $this->reset(['editForm']);
        $this->reset(['editModal']);

        $this->emit('photographyUpdated');
    }

    public function show(Photography $photography)
    {
        if (!is_null(User::find($photography->updater))) {
            $this->showModal['updaterId'] = User::find($photography->updater)->id;
            $this->showModal['updaterName'] = User::find($photography->updater)->name;
        } else {
            $this->showModal['updaterId'] = null;
            $this->showModal['updaterName'] = null;
        }

        $this->showModal['id'] = $photography->id;

        $this->showModal['route'] = $photography->route;
        $this->showModal['order'] = $photography->order;
        $this->showModal['pointOfInterestId'] = $photography['point_of_interest_id'];

	    if (!is_null(User::find($photography->updater))) {
		    $this->showModal['creatorId'] = User::find($photography->creator)->id;
		    $this->showModal['creatorName'] = User::find($photography->creator)->name;
	    } else {
		    $this->showModal['creatorId'] = null;
		    $this->showModal['creatorName'] = null;
	    }

        $this->showModal['createdAt'] = $photography->created_at;
        $this->showModal['updatedAt'] = $photography->updated_at;

        $this->showModal['open'] = true;
    }

    public function edit(Photography $photography)
    {
        $this->reset(['editForm']);

        $this->editForm['pointOfInterestId'] = $photography['point_of_interest_id'] ?? '';

        $this->editModal['id'] = $photography->id;
        $this->editModal['route'] = $photography->route;

        $this->editModal['open'] = true;
    }

    public function delete(Photography $photography)
    {
        $isDeleted = $photography->delete();

        if($isDeleted) {
            Log::alert('User with ID ' . auth()->user()->id . 'was deleted a photography with ID ' . $photography->id . $photography);
        }
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
        $this->reset(['page']);

        if (auth()->user()->hasRole('Alumno')) {
            $photographies = Photography::where('creator', auth()->user()->id)
                ->where($this->searchColumn, 'like', '%' . $this->search . '%')
                ->where('verified', true)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);
        } else {
            $photographies = Photography::where($this->searchColumn, 'like', '%' . $this->search . '%')
                ->where('verified', true)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);
        }

        return view('livewire.admin.photography.photographies', compact('photographies'));
    }
}
