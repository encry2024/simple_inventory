<?php

namespace App\Http\Controllers;

use App\Repositories\InventoryRepository;
use App\Http\Requests\Inventory\StoreInventoryRequest;
use App\Http\Requests\Inventory\EditInventoryRequest;
use Illuminate\View\View;
use App\Models\Inventory\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected $inventoryRepository;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInventoryRequest $request)
    {
        $inventory = $this->inventoryRepository->create($request->only(
            'name',
            'stocks'
        ));

        return json_encode($inventory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('inventory.show');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditInventoryRequest $request, Inventory $item)
    {
        $itemName = $item->name;

        $item = $this->inventoryRepository->update($request->only('name'), $item);

        return json_encode("Item {$itemName} name was successfully updated to {$item->name}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $id)
    {
        $itemName = $id->name;

        $this->inventoryRepository->deleteById($id->id);

        return json_encode('Item "' . $itemName . '" was successfully deleted');
    }

    public function getInventory()
    {
        $inventory = $this->inventoryRepository->getInventory();

        return $inventory;
    }

    public function getItemById($id)
    {
        $item = $this->inventoryRepository->getItemById($id);

        return $item;
    }

    public function addStocks(Inventory $item, Request $request)
    {
        $item = $this->inventoryRepository->addStocks($item, $request->only('stocks'));

        return json_encode('Item "' . $item->name . '" stocks was successfully updated');
    }
}
