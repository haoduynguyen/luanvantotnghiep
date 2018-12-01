<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DangKyNghiRepositoryInterface;
use App\Repositories\Interfaces\LichDayRepositoryInterface;
use App\Repositories\Interfaces\LichDayTuanRelationRepositoryInterface;
use Illuminate\Http\Request;
use JWTAuth;
use DateTime;

class DangKyNghiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $dangKyNghi;
    private $lichDay;
    private $lichDayTuan;

    public function __construct(DangKyNghiRepositoryInterface $dangKyNghiRepository,
                                LichDayRepositoryInterface $lichDayRepository, LichDayTuanRelationRepositoryInterface $lichDayTuanRelationRepository)
    {
        $this->dangKyNghi = $dangKyNghiRepository;
        $this->lichDay = $lichDayRepository;
        $this->lichDayTuan = $lichDayTuanRelationRepository;
    }

    public function index()
    {
        $data = $this->dangKyNghi->getDSNghi();
        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (Exception $e) {
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
            'lich_day_id' => 'required',
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
            if ($request->lich_day_id) {
                $lichDay = $this->lichDay->get($request->lich_day_id);
                $lichDays = $this->lichDay->getListDoubleLichDay($lichDay, $data);
                $tokenHeader = $request->header('Authorization');
                $tokenUser = explode(' ', $tokenHeader, 2)[1];
                $user = JWTAuth::toUser($tokenUser);
                try {
                    if ($user->id == $lichDay->user_id) {
                        if ($lichDays) {
                            foreach ($lichDays as $item) {
                                $saveDangKyNghi[] = $this->dangKyNghi->save(['gv_id' => $item->user_id, 'lich_day_id' => $item->id, 'status' => 1, 'tuan_id' => $request->tuan_id]);
                            }
                            if ($saveDangKyNghi) {
                                return $this->dataSuccess(Message::SUCCESS, $saveDangKyNghi, StatusCode::SUCCESS);
                            }
                        } else {
                            $saveDangKyNghi[] = $this->dangKyNghi->save(['gv_id' => $lichDays->user_id, 'lich_day_id' => $request->lich_day_id, 'status' => 1, 'tuan_id' => $request->tuan_id]);
                            if ($saveDangKyNghi) {
                                return $this->dataSuccess(Message::SUCCESS, $saveDangKyNghi, StatusCode::SUCCESS);
                            }
                        }
                    } else {
                        return $this->dataError('Bạn không có quyền đăng ký nghỉ cho lịch này', false, StatusCode::BAD_REQUEST);
                    }

                } catch (Exception $e) {
                    return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
                }
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
            'user_id' => 'required|unique:api_lich_day',
            'status' => 'required',
            'description' => 'required',
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
            $updateDangKyNghi = $this->dangKyNghi->update($data, $id);
            try {
                if ($updateDangKyNghi) {
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
//        $now = new DateTime();
//        $dateNow = $now->format('Y-m-d');
//        $data = $this->dangKyNghi->get($id);


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function getDKNghi(Request $request)
    {
        $tokenHeader = $request->header('Authorization');
        $tokenUser = explode(' ', $tokenHeader, 2)[1];
        $user = JWTAuth::toUser($tokenUser);
        $data = $this->dangKyNghi->getDSNghi($user);
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
}
