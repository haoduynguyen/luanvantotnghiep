<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TuanRepositoryInterface;
use Illuminate\Http\Request;

class TuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $tuan;

    public function __construct(TuanRepositoryInterface $tuanRepository)
    {
        $this->tuan = $tuanRepository;
    }

    public function index()
    {
        $data = $this->tuan->all();
        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            }
            else {
                return $this->dataError(Message::ERROR , false, StatusCode::BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR , $e, StatusCode::SERVER_ERROR);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
