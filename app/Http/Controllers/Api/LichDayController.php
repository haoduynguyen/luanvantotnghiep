<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CaRepositoryInterface;
use App\Repositories\Interfaces\HocKyRepositoryInterface;
use App\Repositories\Interfaces\LichDayRepositoryInterface;
use App\Repositories\Interfaces\MonHocRepositoryInterface;
use App\Repositories\Interfaces\NhomLopRepositoryInterface;
use App\Repositories\Interfaces\PhongMayRepositoryInterface;
use App\Repositories\Interfaces\ThuRepositoryInterface;
use App\Repositories\Interfaces\UserProfileRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Excel;
use Illuminate\Http\Request;

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

    public function __construct(MonHocRepositoryInterface $monHocRepository,
                                NhomLopRepositoryInterface $nhomLopRepository,
                                PhongMayRepositoryInterface $phongMayRepository,
                                HocKyRepositoryInterface $hocKyRepository,
                                CaRepositoryInterface $caRepository,
                                UserRepositoryInterface $userRepository,
                                ThuRepositoryInterface $thuRepository,
                                LichDayRepositoryInterface $lichDayRepository,
                                UserProfileRepositoryInterface $userProfileRepository)
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
    }

    public function index()
    {
        $data = $this->lichDay->getLichDay();
        return $data;
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
        if ($request->hasFile('file_import')) {
            $path = $request->file('file_import')->getRealPath();
            $data = \Excel::load($path, function ($reader) {
            })->get();

            foreach ($data as $item) {
                try {
                    $tuanHoc = [];
                    for ($i = 1; $i <= 60; $i++) {
                        $t = 't' . $i;
                        if ($item[$t] == "") {
                            $item[$t] = '0';
                        }
                        $tuanHoc[] = $item[$t];
                    }
                } catch (\Exception $e) {
                    return $e;
                }
                $lichDay['tuan_hoc'] = implode($tuanHoc, ', ');
                $lichDay['hk_id'] = $request->hoc_ky;
                //nhớ bắt validate học kỳ
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
                $lichDay['user_id'] = 1;

                try {
                    switch ($item->f_tiethoc) {

                        case "-23456---------":
                            for ($i = 1; $i <= 2; $i++) {
                                $lichDay['ca_id'] = $i;
                                $this->lichDay->save($lichDay);
                            }
                            break;
                        case "'------78901----'":
                            for ($i = 3; $i <= 4; $i++) {
                                $lichDay['ca_id'] = $i;
                                $this->lichDay->save($lichDay);
                            }
                            break;
                        default:
                            $this->ca->getByColumn('description', $item->f_tiethoc);
                            $this->lichDay->save($lichDay);
                            break;
                    }
                } catch (\Exception $e) {
                    return $e;
                }

            }

        }
    }
}
