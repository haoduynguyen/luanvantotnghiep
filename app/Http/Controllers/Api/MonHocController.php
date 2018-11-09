<?php

namespace App\Http\Controllers\Api;
use App\Constants\Message;
use App\Constants\StatusCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MonHocRepositoryInterface;

class MonHocController extends Controller
{
    private $monHoc;
    public function __construct(MonHocRepositoryInterface $monHocRepository)
    {
        $this->monHoc = $monHocRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->monHoc->all();

        try{
            if($data)
            {
                return $this->dataSuccess(Message::SUCCESS, $data,StatusCode::SUCCESS);
            }
            else
            {
                return $this->dataError(Message::ERROR,false, StatusCode::BAD_REQUEST);
            }
        }
        catch (Exception $e)
        {
            return $this->dataSuccess(Message::SERVER_ERROR, false,StatusCode::SERVER_ERROR);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
