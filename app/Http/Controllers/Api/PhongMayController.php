<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PhongMayRepositoryInterface;
use App\Repositories\Interfaces\PhongMayUserRelationRepositoryInterface;
use Illuminate\Http\Request;
use JWTAuth;

class PhongMayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $phongMay;
    private $phongMayUserRelation;

    public function __construct(PhongMayRepositoryInterface $phongMayRepository, PhongMayUserRelationRepositoryInterface $phongMayUserRelationRepository)
    {
        $this->phongMay = $phongMayRepository;
        $this->phongMayUserRelation = $phongMayUserRelationRepository;
    }

    public function index()
    {
        $data = $this->phongMay->all();
        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
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
            'mo_ta' => 'required',
            'so_may' => 'required',
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
            $savePM = $this->phongMay->save($data);
            try {
                if ($savePM) {
                    return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'mo_ta' => 'required',
            'so_may' => 'required',

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
            $updatePM = $this->phongMay->update($data, $id);
            try {
                if ($updatePM) {
                    return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
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

    }

    public function showMoTaID($id)
    {
        $data = $this->phongMayUserRelation->show($id);
        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }

        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
        }
    }

    public function getMoTaMay(Request $request)
    {
        $tokenHeader = $request->header('Authorization');
        $tokenUser = explode(' ', $tokenHeader, 2)[1];
        $user = JWTAuth::toUser($tokenUser);

        $data = $this->phongMayUserRelation->list($user);

        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }

        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
        }
    }

    public function addMoTaMay(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'phong_may_id' => 'required',
            'mota_gv' => 'required'

        ]);
        if ($validator->fails()) {

            $data_errors = $validator->errors();

            $array = [];

            foreach ($data_errors->messages() as $key => $error) {

                $array[] = ['key' => $key, 'mess' => $error];
            }

            return $this->dataError(Message::ERROR, $array, StatusCode::BAD_REQUEST);

        } else {

            $tokenHeader = $request->header('Authorization');
            $tokenUser = explode(' ', $tokenHeader, 2)[1];
            $user = JWTAuth::toUser($tokenUser);
            $data = $request->all();
            $data['gv_id'] = $user->id;
            $saveMoTa = $this->phongMayUserRelation->save($data);
            try {
                if ($saveMoTa) {
                    return $this->dataSuccess(Message::SUCCESS, true, StatusCode::CREATED);
                } else {
                    return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
                }

            } catch (\Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
            }
        }
    }

    public function gvUpdateMoTa(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            //'phong_may_id' => 'required',
            'mota_gv' => 'required',

        ]);
        if ($validator->fails()) {

            $data_errors = $validator->errors();

            $array = [];

            foreach ($data_errors->messages() as $key => $error) {

                $array[] = ['key' => $key, 'mess' => $error];
            }

            return $this->dataError(Message::ERROR, $array, StatusCode::BAD_REQUEST);

        } else {

            $tokenHeader = $request->header('Authorization');
            $tokenUser = explode(' ', $tokenHeader, 2)[1];
            $user = JWTAuth::toUser($tokenUser);
            $data = $request->all();

            try {
                if ($user->role_id == 1) {
                    $data['gv_id'] = $user->id;
                    $updateGV = $this->phongMayUserRelation->update($data, $id);
                    if ($updateGV) {
                        return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
                    } else {
                        return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
                    }
                } else {
                    return $this->dataError("Bạn không có quyền cập nhật chức năng này!", false, StatusCode::BAD_REQUEST);
                }

            } catch
            (\Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
            }
        }
    }

    public
    function ktvUpdateMoTa(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'phong_may_id' => 'required',
            'mota_ktv' => 'required',
            'status' => 'required',

        ]);
        if ($validator->fails()) {

            $data_errors = $validator->errors();

            $array = [];

            foreach ($data_errors->messages() as $key => $error) {

                $array[] = ['key' => $key, 'mess' => $error];
            }

            return $this->dataError(Message::ERROR, $array, StatusCode::BAD_REQUEST);

        } else {

            $tokenHeader = $request->header('Authorization');
            $tokenUser = explode(' ', $tokenHeader, 2)[1];
            $user = JWTAuth::toUser($tokenUser);
            $data = $request->all();
            try {
                if ($user->role_id == 2) {
                    $data['ktv_id'] = $user->id; //dd($data);
                    $updateKTV = $this->phongMayUserRelation->update($data, $id);
                    if ($updateKTV) {
                        return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
                    } else {
                        return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
                    }
                } else {
                    return $this->dataError("Bạn không có quyền cập nhật chức năng này", false, StatusCode::BAD_REQUEST);
                }
            } catch (\Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
            }
        }
    }

    public function deleteID($id)
    {
        $deleteID = $this->phongMayUserRelation->delete($id);
        try {
            if ($deleteID) {
                return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
        }
    }
}
