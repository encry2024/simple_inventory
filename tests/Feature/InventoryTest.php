<?php

namespace Tests\Feature;

use App\Models\Inventory\Inventory;
use App\Repositories\InventoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    /**
     * @var InventoryRepository
     */
    protected $inventoryRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->inventoryRepository = $this->app->make(InventoryRepository::class);
    }

    protected function getValidInventory($inventory = [])
    {
        return array_merge([
            'name' => 'Microsoft Visual Studio',
            'stocks' => '10',
        ], $inventory);
    }

    /** @test */
    public function it_can_create_new_inventory()
    {
        $this->assertEquals(0, Inventory::count());

        $this->inventoryRepository->create($this->getValidInventory());

        $this->assertEquals(1, Inventory::count());
    }

    /** @test */
    public function it_can_delete_inventory()
    {
        $this->assertEquals(0, Inventory::count());

        $item = $this->inventoryRepository->create($this->getValidInventory());

        $this->assertEquals(1, Inventory::count());

        $this->inventoryRepository->deleteById($item->id);

        $this->call('DELETE', '/item/' . $item->id . '/delete', ['_token' => csrf_token()]);

        $this->assertSoftDeleted('inventories', $this->getValidInventory());
    }

    /** @test */
    public function it_can_add_stocks_inventory()
    {
        $this->assertEquals(0, Inventory::count());

        $item = $this->inventoryRepository->create($this->getValidInventory());

        $this->assertEquals(1, Inventory::count());

        $this->inventoryRepository->addStocks($item, array('stocks' => 5));

        $this->assertEquals(15, $item->stocks);
    }

    /** @test */
    public function it_can_update_inventory_name()
    {
        $this->assertEquals(0, Inventory::count());

        $item = $this->inventoryRepository->create($this->getValidInventory());

        $this->assertEquals(1, Inventory::count());

        $this->inventoryRepository->update(array('name' => "Test Item"), $item);

        $this->assertEquals("Test Item", $item->name);
    }
}
