<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 * Base interface for repositories, defining common methods for data access and manipulation.
 *
 * @package App\Contracts
 */
interface RepositoryInterface
{
    /**
     * Get all records
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find a record by its ID
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id): Model | null;

    /**
     * Create a new record
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data): Model;

    /**
     * Update a record by its ID
     *
     * @param int $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(int $id, array $data): Model;

    /**
     * Delete a record by its ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
