<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardRequest;
use App\Http\Requests\CardUpdateRequest;
use App\Models\Card;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Api;

class CardController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse(Card::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CardRequest $request)
    {
        Card::create($request->all());
        return $this->successResponse(null, '', 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->successResponse(Card::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CardUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CardUpdateRequest $request, int $id)
    {

        $card = Card::find($id);
        $card->title = $request->input('title');
        $card->description = $request->input('description');
        $card->save();

        return $this->successResponse(null, '', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Card::delete($id);
        return $this->successResponse(null, null, 204);
    }
}
