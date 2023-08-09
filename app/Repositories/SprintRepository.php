<?php

namespace App\Repositories;

use App\Sprint;

class SprintRepository
{
    /**
     * Get all sprints.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Sprint::all();
    }

    /**
     * Get a sprint by ID.
     *
     * @param int $id
     * @return \App\Sprint|null
     */
    public function getById($id)
    {
        return Sprint::find($id);
    }

    /**
     * Create a new sprint.
     *
     * @param array $data
     * @return \App\Sprint
     */
    public function create(array $data)
    {
        return Sprint::create($data);
    }

    /**
     * Update a sprint.
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, $id)
    {
        $sprint = Sprint::find($id);

        if (!$sprint) {
            return false;
        }

        return $sprint->update($data);
    }

    /**
     * Delete a sprint.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $sprint = Sprint::find($id);

        if (!$sprint) {
            return false;
        }

        return $sprint->delete();
    }
}