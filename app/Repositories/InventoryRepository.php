<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Inventory\Inventory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class InventoryRepository.
 */
class InventoryRepository extends BaseRepository
{
    /**
     * InventoryRepository constructor.
     *
     * @param  Inventory  $model
     */
    public function __construct(Inventory $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function getInventory(): Collection
    {
        return $this->all();
    }

    /**
     * @return Collection
     */
    public function getItemById($id): Inventory
    {
        return $this->model::find($id);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param array $data
     *
     * @throws \Exception
     * @throws \Throwable
     * @return Inventory
     */
    public function create(array $data): Inventory
    {
        return DB::transaction(function () use ($data) {
            $inventory = $this->model::create([
                'name' => $data['name'],
                'stocks' => $data['stocks']
            ]);

            if ($inventory) {
                return $inventory;
            }

            throw new GeneralException("Something went wrong while adding the item. Please try again.");
        });
    }

    /**
     * @param Inventory  $inventory
     * @param array $data
     *
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     * @return Inventory
     */
    public function update(array $data, $inventory): Inventory
    {
        return DB::transaction(function () use ($inventory, $data) {
            if ($inventory->update([
                'name' => $data['name']
            ])) {
                return $inventory;
            }

            return json_encode("Something went wrong while updating the item. Please try again.");
        });
    }

    public function addStocks($item, array $data)
    {
        return DB::transaction(function () use ($item, $data) {
            if ($item->update([
                'stocks' => $item->stocks + $data['stocks']
            ])) {
                return $item;
            }

            return json_encode("Something went wrong while updating the item's stocks. Please try again.");
        });
    }
}
