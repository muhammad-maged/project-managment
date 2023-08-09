<?php

namespace App\Http\Controllers;

use App\Sprint;
use App\Repositories\SprintRepository;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    protected $sprintRepository;

    public function __construct(SprintRepository $sprintRepository)
    {
        $this->sprintRepository = $sprintRepository;
    }

    public function index()
    {
        return $this->sprintRepository->getAll();
    }

    public function show($id)
    {
        return $this->sprintRepository->getById($id);
    }

    public function store(Request $request)
    {
        $this->sprintRepository->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $this->sprintRepository->update($request->all(), $id);
    }

    public function destroy($id)
    {
        $this->sprintRepository->delete($id);
    }
}