<?php

namespace App\Http\Controllers\Api;


use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MonHocRepositoryInterface;
use Illuminate\Http\Request;

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

        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (Exception $e) {
            return $this->dataSuccess(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
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
        $validator = \Validator::make($request->all(), [
            'ma_mon_hoc' => 'required',
            'name' => 'required',
//            'ngay_bat_dau' => 'required',
//            'ngay_ket_thuc' => 'required',
            //'gv_id' => 'required|exists:users',
        ]);
        if ($validator->fails()) {

            $data_errors = $validator->errors();

            $array = [];

            foreach ($data_errors->messages() as $key => $error) {

                $array[] = ['key' => $key, 'mess' => $error];
            }

            return $this->dataError(Message::ERROR, $array, StatusCode::BAD_REQUEST);

        } else {
            $data = $request->all();
            $saveMonHoc = $this->monHoc->save($data);
            try {
                if ($saveMonHoc) {
                    return $this->dataSuccess(Message::SUCCESS, $saveMonHoc, StatusCode::CREATED);
                } else {
                    return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
                }
            } catch (Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        try {
            $monHoc = $this->monHoc->get($id);
            if ($monHoc) {
                return $this->dataSuccess(Message::SUCCESS, $monHoc, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)

    {
        $validator = \Validator::make($request->all(), [
            'ma_mon_hoc' => 'required',
            'name' => 'required',
//            'ngay_bat_dau' => 'required',
//            'ngay_ket_thuc' => 'required',
            //'gv_id' => 'required|exists:users',
        ]);
        if ($validator->fails()) {

            $data_errors = $validator->errors();

            $array = [];

            foreach ($data_errors->messages() as $key => $error) {

                $array[] = ['key' => $key, 'mess' => $error];
            }

            return $this->dataError(Message::ERROR, $array, StatusCode::BAD_REQUEST);

        } else {
            $data = $request->all();
            $saveMonHoc = $this->monHoc->update($data,$id);
            try {
                if ($saveMonHoc) {
                    return $this->dataSuccess(Message::SUCCESS, $saveMonHoc, StatusCode::SUCCESS);
                } else {
                    return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
                }
            } catch (Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delMonHoc = $this->monHoc->delete($id);
        try {
            if ($delMonHoc) {
                return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
        }
    }
}
