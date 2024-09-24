<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Mutation;
use App\Utils\HTTPResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemService
{
    public function fetchAll()
    {
        try {
            $items = Item::with('category')->get();

            return HTTPResponse::send('success', 'successfully fetch all items', 200, $items);
        } catch (Exception $e) {
            error_log("[ITEM SERVICE][fetchAll] error : " . $e->getMessage());
            return HTTPResponse::send('error', "failed to fetch all items", 500);
        }
    }

    public function fetchOne(Request $request, int $id)
    {
        try {
            $item = Item::with('category', 'mutations', 'mutations.type', 'mutations.user')
            ->where('id', '=', $id)->first();

            if (!isset($item))
            {
                return HTTPResponse::send('fail', 'failed fetch an item', 404, null, [
                    "item" => "item not found"
                ]);
            }

            return HTTPResponse::send('success', 'successfully fetch an item', 200, $item);
        } catch (Exception $e) {
            error_log("[ITEM SERVICE][fetchOne] error : " . $e->getMessage());
            return HTTPResponse::send('error', "failed to fetch item", 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required|min:3|max:150',
                'code' => 'required|min:3|max:150',
                'item_category' => 'required|exists:item_categories,id',
                'stock' => 'required|integer|min:1',
                'location' => 'required|string|min:3',
            ]);

            if ($validation->fails())
            {
                return HTTPResponse::send('fail', 'failed to create item', 400, null, $validation->errors());
            }

            Item::create($request->all());

            return HTTPResponse::send('success', 'successfully create item', 201);
        } catch (Exception $e) {
            error_log("[ITEM SERVICE][create] error : " . $e->getMessage());
            return HTTPResponse::send('error', "failed to create item", 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $item = Item::where('id', '=', $id)->first();

            if (!isset($item))
            {
                return HTTPResponse::send("fail", "failed to update item", 404, null, [
                    "item" => "item not found"
                ]);
            }

            $validation = Validator::make($request->all(), [
                'name' => 'min:3|max:150',
                'code' => 'min:3|max:150',
                'item_category' => 'exists:item_categories,id',
                'stock' => 'integer|min:1',
                'location' => 'string|min:3',
                'description' => 'required|min:3'
            ]);

            if ($validation->fails())
            {
                return HTTPResponse::send('fail', 'failed to update item', 400, null, $validation->errors());
            }

            $diff = $item->stock + $request->stock;

            $mutation = [
                'mutated_by' => $request->user()->id,
                'mutated_item' => $item->id,
                'mutation_type' => $diff < $item->stock ? 2 : 1,
                'description' => $request['description']
            ];

            DB::beginTransaction();

            $item->fill($request->all())->save();

            Mutation::create($mutation);

            DB::commit();

            return HTTPResponse::send('success', 'successfully update item', 200);

        } catch (Exception $e) {
            error_log("[ITEM SERVICE][update] error : " . $e->getMessage());
            return HTTPResponse::send('error', "failed to update item", 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $item = Item::where('id', '=', $id)->first();

            if (!isset($item))
            {
                return HTTPResponse::send("fail", "failed to delete item", 404, null, [
                    "item" => "item not found"
                ]);
            }

            $item->delete();

            return HTTPResponse::send('success', 'successfully delete item', 200);

        } catch (Exception $e) {
            error_log("[ITEM SERVICE][delete] error : " . $e->getMessage());
            return HTTPResponse::send('error', "failed to delete item", 500);
        }
    }
}
