<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    private $itemSvc;

    public function __construct()
    {
        $this->itemSvc = new ItemService();
    }

    public function fetchAll()
    {
        return $this->itemSvc->fetchAll();
    }

    public function fetchOne(Request $request, int $id)
    {
        return $this->itemSvc->fetchOne($request, $id);
    }

    public function create(Request $request)
    {
        return $this->itemSvc->create($request);
    }

    public function update(Request $request, int $id)
    {
        return $this->itemSvc->update($request, $id);
    }

    public function delete(int $id)
    {
        return $this->itemSvc->delete($id);
    }
}
