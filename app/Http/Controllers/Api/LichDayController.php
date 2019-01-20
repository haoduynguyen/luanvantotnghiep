<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CaRepositoryInterface;
use App\Repositories\Interfaces\HocKyRepositoryInterface;
use App\Repositories\Interfaces\LichDayRepositoryInterface;
use App\Repositories\Interfaces\LichDayTuanRelationRepositoryInterface;
use App\Repositories\Interfaces\MonHocRepositoryInterface;
use App\Repositories\Interfaces\NhomLopRepositoryInterface;
use App\Repositories\Interfaces\PhongMayRepositoryInterface;
use App\Repositories\Interfaces\ThuRepositoryInterface;
use App\Repositories\Interfaces\TuanRepositoryInterface;
use App\Repositories\Interfaces\UserProfileRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\UserRoleRelationRepositoryInterface;
use Excel;
use Hash;
use Illuminate\Http\Request;
use JWTAuth;

class LichDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $monHoc;
    private $nhomLop;
    private $phongMay;
    private $hocKy;
    private $ca;
    private $user;
    private $thu;
    private $lichDay;
    private $userProfile;
    private $tuan;
    private $lichDayTuan;
    private $userRole;

    public function __construct(MonHocRepositoryInterface $monHocRepository,
                                NhomLopRepositoryInterface $nhomLopRepository,
                                PhongMayRepositoryInterface $phongMayRepository,
                                HocKyRepositoryInterface $hocKyRepository,
                                CaRepositoryInterface $caRepository,
                                UserRepositoryInterface $userRepository,
                                ThuRepositoryInterface $thuRepository,
                                LichDayRepositoryInterface $lichDayRepository,
                                UserProfileRepositoryInterface $userProfileRepository,
                                TuanRepositoryInterface $tuanRepository,
                                LichDayTuanRelationRepositoryInterface $lichDayTuanRelationRepository,
                                UserRoleRelationRepositoryInterface $userRoleRelationRepository)
    {
        $this->nhomLop = $nhomLopRepository;
        $this->monHoc = $monHocRepository;
        $this->phongMay = $phongMayRepository;
        $this->hocKy = $hocKyRepository;
        $this->ca = $caRepository;
        $this->user = $userRepository;
        $this->thu = $thuRepository;
        $this->lichDay = $lichDayRepository;
        $this->userProfile = $userProfileRepository;
        $this->tuan = $tuanRepository;
        $this->lichDayTuan = $lichDayTuanRelationRepository;
        $this->userRole = $userRoleRelationRepository;
    }

    public function index(Request $request)
    {
        $data = $this->lichDay->getLichDay($request->all());
        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            }
            return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, [], StatusCode::SERVER_ERROR);
        }
    }

    public function getLichDayFromGv(Request $request)
    {
        $tokenHeader = $request->header('Authorization');
        $tokenUser = explode(' ', $tokenHeader, 2)[1];
        $user = JWTAuth::toUser($tokenUser);
        $data = $this->lichDay->getLichDayFromGv($request->all(), $user);
        try {
            if (!empty($data)) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            }
            return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, [], StatusCode::SERVER_ERROR);
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

    protected function editTypeDate($thoigianhoc)
    {
        $date = explode('/', $thoigianhoc);
        $afterEdit = "20" . $date[2] . '-' . $date[1] . '-' . $date[0]; //YYYY-mm-dd
        return $afterEdit;
    }

    public function import(Request $request)
    {

        $lichDay['hk_id'] = $request->hoc_ky;
        $hocKy = $this->hocKy->get($lichDay['hk_id']);
        $lichDayExists = $this->lichDay->getByColumn('hk_id', $lichDay['hk_id']);
        //nhớ bắt validate học kỳ
        $date = date("Y-m-d");
        if ($date > $hocKy->ngay_bat_dau && $date < $hocKy->ngay_ket_thuc && !empty($lichDayExists)) {
            return $this->dataError('Học kỳ đã bắt đầu học không thể thay đổi', false, StatusCode::BAD_REQUEST);
        } elseif ($date > $hocKy->ngay_ket_thuc && !empty($lichDayExists)) {
            return $this->dataError('Học kỳ đã kết thúc không thể thay đổi', false, StatusCode::BAD_REQUEST);
        } elseif ($date < $hocKy->ngay_bat_dau && !empty($lichDayExists) && $request->tiep_tuc != 1) {
            return response()->json(['warn' => 'Học kỳ này đã được import lịch. Nếu nhấn Yes dữ liệu cũ của học kỳ này sẽ được thay thế bằng dữ liệu mới'], 200);
        }
        if ($request->tiep_tuc == 1) {
            $lichDays = $this->lichDay->getListByColumn('hk_id', $lichDay['hk_id'])->toArray();
            foreach ($lichDays as $item) {
                $lichDayTuanID = $this->lichDayTuan->getListByColumn('lich_day_id', $item['id'])->toArray();
                if ($lichDayTuanID) {
                    $data['list_id'] = array_pluck($lichDayTuanID, 'id');
                    $this->lichDayTuan->deleteMulti($data);
                }
            }
            $data['list_id'] = array_pluck($lichDays, 'id');
            $this->lichDay->deleteMulti($data);
        }
        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = \Excel::load($path, function ($reader) {
            })->get();
           // $totalData = count($data);
            dd($data[0]);
            if ($data) {
                foreach ($data as $item) {
                    $findNgayBatDau = (explode('-', $item['f_tghoc']));
                    $ngayBatDau[] = $this->editTypeDate($findNgayBatDau['0']);
                }
                //Tìm ngày thấp nhất trong excel
                $minDate = $ngayBatDau[0];
                foreach ($ngayBatDau as $itemNgayBatDau) {
                    if ($itemNgayBatDau < $minDate) {
                        $minDate = $itemNgayBatDau;
                    }
                }
//                for ($i = 0; $i < $totalData - 1; $i++) {
//                    $min = $ngayBatDau[$i];
//                    $temp = $ngayBatDau[$i + 1];
//                    if ($min > $temp) {
//                        $minDate = $temp;
//                    }
//                }
                $thangBatDau = date('Y-m-d', strtotime($minDate . '+' . ' 294 days'));
                $tuan = $this->tuan->all();
                $i = 0;
                foreach ($tuan as $itemTuan) {
                    $ngay_bat_dau = date('Y-m-d', strtotime($thangBatDau . '+' . $i . 'days'));
                    $ngay_ket_thuc = date('Y-m-d', strtotime($ngay_bat_dau . ' + 6 days'));
                    $i += 7;
                    $this->tuan->update(['ngay_bat_dau' => $ngay_bat_dau, 'ngay_ket_thuc' => $ngay_ket_thuc], $itemTuan->id);
                }

                foreach ($data as $item) {
                    $thoigianhoc = explode('-', $item->f_lichin);
                    $monHocExists = $this->monHoc->getByColumn('ma_mon_hoc', $item->f_mamh);
                    try {
                        if ($monHocExists) {
                            $lichDay['mon_hoc_id'] = $monHocExists->id;
                        } else {
                            $saveMonhoc = $this->monHoc->save(['ma_mon_hoc' => $item->f_mamh, 'name' => $item->f_tenmhvn, 'ngay_bat_dau' => $this->editTypeDate($thoigianhoc['0']), 'ngay_ket_thuc' => $this->editTypeDate($thoigianhoc['1'])]);
                            $lichDay['mon_hoc_id'] = $saveMonhoc->id;
                        }
                    } catch (\Exception $e) {
                        return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
                    }
                    $thuExists = $this->thu->get($item->f_thu);
                    try {
                        if ($thuExists) {
                            $lichDay['thu_id'] = $thuExists->id;
                        } else {
                            return $this->dataError('không có thứ này trong tuần', false, StatusCode::BAD_REQUEST);
                        }
                    } catch (\Exception $e) {
                        return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
                    }

                    $phongMayExists = $this->phongMay->getByColumn('name', $item->f_tenph);
                    try {
                        if ($phongMayExists) {
                            $lichDay['phong_may_id'] = $phongMayExists->id;
                        } else {
                            return $this->dataError('không có phòng máy' . $item->f_tenph . 'trong danh sách vui lòng thêm mới', false, StatusCode::BAD_REQUEST);
                        }
                    } catch (\Exception $e) {
                        return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
                    }
                    $nhomLop = $this->nhomLop->getByColumn('name', str_replace('_x000D_', ' ', $item->f_malps));
                    try {
                        if ($nhomLop) {
                            $lichDay['nhom_lop_id'] = $nhomLop->id;
                        } else {
                            $this->nhomLop->save(['name' => str_replace('_x000D_', ' ', $item->f_malps), 'si_so' => $item->f_sisoin]);
                        }
                    } catch (\Exception $e) {
                        return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
                    }
                    $hoLotEmail = preg_replace('/\s+/', '', $item->f_holotemail);
                    $userEmail = $item->f_tenemail . '.' . $hoLotEmail . '@stu.edu.vn';
                    $user = $this->user->getByColumn('email', $userEmail);
                    if ($user) {
                        $lichDay['user_id'] = $user->id;
                    } else {
                        $user = $this->user->save(['email' => $userEmail, 'role_id' => 1, 'password' => Hash::make($item->f_manv)]);
                        $this->userProfile->save(['first_name' => $item->f_holotcbv, 'last_name' => $item->f_tencbv, 'user_id' => $user->id, 'ma_nhan_vien' => $item->f_manv]);
                        $lichDay['user_id'] = $user->id;
                    }
                    switch ($item->f_tiethoc) {
                        case "-23456---------":
                            for ($i = 1; $i <= 2; $i++) {
                                $lichDay['ca_id'] = $i;
                                $saveLichDay = $this->lichDay->save($lichDay);
                                if ($saveLichDay) {
                                    for ($j = 1; $j <= 25; $j++) {
                                        $t = 't' . $j;
                                        $tuan = $this->tuan->getByColumn('name', $t);
                                        if ($item[$t] == "") {
                                            $item[$t] = '0';
                                        }
                                        $this->lichDayTuan->save(['tuan_id' => $tuan->id, 'lich_day_id' => $saveLichDay->id, 'status' => $item[$t]]);
                                    }
                                }
                            }
                            break;
                        case "------78901----":
                            try {
                                for ($i = 3; $i <= 4; $i++) {
                                    $lichDay['ca_id'] = $i;
                                    $saveLichDay = $this->lichDay->save($lichDay);
                                    if ($saveLichDay) {
                                        for ($j = 1; $j <= 25; $j++) {
                                            $t = 't' . $j;
                                            $tuan = $this->tuan->getByColumn('name', $t);
                                            if ($item[$t] == "") {
                                                $item[$t] = '0';
                                            }
                                            $this->lichDayTuan->save(['tuan_id' => $tuan->id, 'lich_day_id' => $saveLichDay->id, 'status' => $item[$t]]);
                                        }
                                    }
                                }
                                break;
                            } catch (\Exception $e) {
                                return $e;
                            }
                        default:
                            try {
                                $ca = $this->ca->getByColumn('description', $item->f_tiethoc);
                                if ($ca) {
                                    $lichDay['ca_id'] = $ca->id;
                                    $saveLichDay = $this->lichDay->save($lichDay);
                                    if ($saveLichDay) {
                                        for ($j = 1; $j <= 25; $j++) {
                                            $t = 't' . $j;
                                            $tuan = $this->tuan->getByColumn('name', $t);
                                            if ($item[$t] == "") {
                                                $item[$t] = '0';
                                            }
                                            $this->lichDayTuan->save(['tuan_id' => $tuan->id, 'lich_day_id' => $saveLichDay->id, 'status' => $item[$t]]);
                                        }
                                    }
                                } else {
                                    return $item->f_tiethoc;
                                }
                            } catch (\Exception $e) {
                                return $e;
                            }

                    }
                }

                return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
            }
        }
    }
}
