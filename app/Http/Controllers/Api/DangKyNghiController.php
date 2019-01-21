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
    public function checkLichDayUser($user, $lichDay, $lichDays, $tuan_id, $ngay_nghi, $lich_day_id)
    {
        if ($user->id == $lichDay->user_id) {
            if ($lichDays) {
                foreach ($lichDays as $item) {
                    $saveDangKyNghi[] = $this->dangKyNghi->save(['gv_id' => $item->user_id, 'lich_day_id' => $item->id, 'status' => 1, 'tuan_id' => $tuan_id, 'ngay_nghi' => $ngay_nghi]);
                }
                if ($saveDangKyNghi) {
                    return $this->dataSuccess(Message::SUCCESS, $saveDangKyNghi, StatusCode::SUCCESS);
                }
            } else {
                //dd('aaaa');
                $saveDangKyNghi[] = $this->dangKyNghi->save(['gv_id' => $lichDays->user_id, 'lich_day_id' => $lich_day_id, 'status' => 1, 'tuan_id' => $tuan_id, 'ngay_nghi' => $ngay_nghi]);
                if ($saveDangKyNghi) {
                    //dd('aaa');
                    return $this->dataSuccess(Message::SUCCESS, $saveDangKyNghi, StatusCode::SUCCESS);
                }
            }
        } else {
            return $this->dataError('Bạn không có quyền đăng ký nghỉ cho lịch này', false, StatusCode::BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {
        $startTime = date("06:30");
        $endTime = date("12:30");
        $currentDate = date("Y-m-d");
        $tokenHeader = $request->header('Authorization');
        $tokenUser = explode(' ', $tokenHeader, 2)[1];
        $user = JWTAuth::toUser($tokenUser);
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
            //dd($request->ngay_nghi);
            if ($request->lich_day_id) {
                $lichDay = $this->lichDay->get($request->lich_day_id);
                $lichDays = $this->lichDay->getListDoubleLichDay($lichDay, $data);
                if ($request->ngay_nghi > $currentDate) {
                    try {
                        return $this->checkLichDayUser($user, $lichDay, $lichDays, $request->tuan_id, $request->ngay_nghi, $request->lich_day_id);
                    } catch (Exception $e) {
                        return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
                    }
                } elseif ($request->ngay_nghi == $currentDate) {
                    if ($request->timeDKN < $startTime) {
                        try {
                            return $this->checkLichDayUser($user, $lichDay, $lichDays, $request->tuan_id, $request->ngay_nghi, $request->lich_day_id);
                        } catch (Exception $e) {
                            return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
                        }
                    } elseif (($request->ca_id == 3 || $request->ca_id == 4) && $request->timeDKN > $startTime && $request->timeDKN < $endTime) {
                        return $this->checkLichDayUser($user, $lichDay, $lichDays, $request->tuan_id, $request->ngay_nghi, $request->lich_day_id);
                    } else {
                        return $this->dataError('Quá giờ báo nghỉ vui lòng liên hệ KTV', false, StatusCode::BAD_REQUEST);
                    }
                } else {
                    return $this->dataError('Lịch này đã được dạy không thể báo nghỉ', false, StatusCode::BAD_REQUEST);
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
        $now = new DateTime();
        $dateNow = $now->format('Y-m-d');
        try {
            $data = $this->dangKyNghi->get($id);
            if ($dateNow < $data->ngay_nghi) {
                $deleteDkNghi = $this->dangKyNghi->delete($id);
                if ($deleteDkNghi) {
                    return $this->dataSuccess(Message::SUCCESS, $deleteDkNghi, StatusCode::SUCCESS);
                } else {
                    return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
                }
            } else {
                return $this->dataError('Không được xóa những ngày đã nghỉ', false, StatusCode::BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
        }

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
        try {
            $data = $this->dangKyNghi->getDSNghi($user);
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $startTime = date("06:30");
        $endTime = date("12:30");
        $currentDate = date("Y-m-d");
        $data = $request->all();
        $now = new DateTime();
        $dateDb = $this->dangKyNghi->get($id);
        if ($currentDate <= $dateDb->ngay_nghi) {
            $data['status'] = 0;
            $updateStatus = $this->dangKyNghi->update($data, $id);
            try {
                if ($updateStatus) {
                    return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
                } else {
                    return $this->dataError(Message::ERROR, 'false', StatusCode::BAD_REQUEST);
                }
            } catch (\Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, 'false', StatusCode::SERVER_ERROR);
            }
        } else {
            return $this->dataError('Không thể xóa vì đăng ký đã hết hạn!', false, StatusCode::BAD_REQUEST);
        }
    }

}
