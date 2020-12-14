<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColumnRequest;
use App\Models\Card;
use App\Models\Column;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\DbDumper\Databases\MySql;

class ColumnController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(Column::with('cards')->get());
    }

    /**
     * @param ColumnRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ColumnRequest $request)
    {
        return $this->successResponse(Column::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        foreach ($request->all() as $item) {
            $this->updateCards($item['cards'], $item['id']);
        }
        return $this->successResponse(null, '', 204);
    }

    public function updateCards(array $cards, int $id)
    {
        // clear cards
        Card::where('columns_id', $id)->delete();
        // mass insert new records
        foreach ($cards as $item) {
            Card::create([
                'title' => $item['title'],
                'description' => $item['description'],
                'columns_id' => $id,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $column = Column::find($id);
        $column->delete();

        return $this->successResponse(null, "",204);
    }

    public function download() {
        $file = public_path("dump.sql");
        $headers = array('Content-Type: application/octet-stream',);
        return response()->download($file, 'sql-dump.sql', $headers);
    }

    public function sqlDump() {
        MySql::create()
            ->setDumpBinaryPath('/usr/bin')
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->includeTables(['columns', 'cards'])
            ->dumpToFile('dump.sql');
        return $this->successResponse(null, '', 204);
    }
}
