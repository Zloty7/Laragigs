<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return json_encode($items);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Create Item
     * @OA\Post(
     *      path="/api/item",
     *      summary="Создание",
     *
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(
     *                  allOf={
     *                      @OA\Schema (
     *                          @OA\Property(property="name", type="string", example="some name")
     *                      )
     *                  }
     *              )
     *          )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *          description="ok"
     *     ),
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $item = Item::create($data);

        return [
            'name' => $item->name,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return json_encode($item);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        dd($request->all());
        $item->update($request->all());
        return $item->update($request->all());
//        $item->name = $data->name;
//        dd($data->name);
//        $item->save();
//
//        return $item->name . ' was updated';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item_name = $item->name;
        $item->delete();

        return $item_name . " was deleted";


    }
}
