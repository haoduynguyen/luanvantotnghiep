<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\HocKyRepositoryInterface;
use Illuminate\Http\Request;

class HocKyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $hocky;

    public function __construct(HocKyRepositoryInterface $hocKyRepository)
    {
        $this->hocky = $hocKyRepository;
    }

    public function index()
    {
        $data = $this->hocky->all();
        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
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
            'name' => 'required',
            'nam_hoc' => 'required|min:9|max:9',
            'ngay_bat_dau' => 'required',
            'ngay_ket_thuc' => 'required',
        ]);
        if ($validator->fails()) {

            $data_errors = $validator->errors();

            $array = [];

            foreach ($data_errors->messages() as $key => $error) {

                $array[] = ['key' => $key, 'mess' => $error];
            }

            return $this->dataError(Message::ERROR, $array, StatusCode::BAD_REQUEST);

        } else {
            $namHoc = $request->nam_hoc;
            $namHoc = explode('-', $namHoc);
            if ($namHoc[1] - $namHoc[0] == 1) {
                //dd($request->nam_hoc);
                $data = $request->all();
                $saveHocKy = $this->hocky->save($data);
            } else {
                return $this->dataError("Nhap sai!", false, StatusCode::BAD_REQUEST);
            }
            try {
                if ($saveHocKy) {
                    return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
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
    public
    function edit($id)
    {
        try {
            $hocKy = $this->hocky->get($id);
            if ($hocKy) {
                return $this->dataSuccess(Message::SUCCESS, $hocKy, StatusCode::SUCCESS);
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
            'name' => 'required',
            'nam_hoc' => 'required|min:9|max:9',
            'ngay_bat_dau' => 'required',
            'ngay_ket_thuc' => 'required',
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
            $updateHocKy = $this->hocky->update($data, $id);
            try {
                if ($updateHocKy) {
                    return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
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
    public
    function destroy($id)
    {
        $deleteHocKy = $this->hocky->delete($id);
        try {
            if ($deleteHocKy) {
                return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
        }
    }
}
