<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DangKyMuonPhongRepositoryInterface;
use App\Repositories\Interfaces\TuanMuonPhongRelationRepositoryInterface;
use DateTime;
use Illuminate\Http\Request;
use JWTAuth;

class MuonPhongController extends Controller
{
    private $dkMuonPhong;
    private $tuanMuonPhong;

    public function __construct(DangKyMuonPhongRepositoryInterface $dkMuonPhong, TuanMuonPhongRelationRepositoryInterface $tuanMuonPhongRelationRepository)
    {
        $this->dkMuonPhong = $dkMuonPhong;
        $this->tuanMuonPhong = $tuanMuonPhongRelationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->dkMuonPhong->getDataMuonPhong($request->all());
        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::NOT_FOUND);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
        }
    }

    public function getDkMuonPhongFromGv(Request $request)
    {
        $tokenHeader = $request->header('Authorization');
        $tokenUser = explode(' ', $tokenHeader, 2)[1];
        $user = JWTAuth::toUser($tokenUser);
        $data = $this->dkMuonPhong->getDKMuonPhongFromGV($request->all(), $user);
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tokenHeader = $request->header('Authorization');
        $tokenUser = explode(' ', $tokenHeader, 2)[1];
        $user = JWTAuth::toUser($tokenUser);
        $data = $request->all();
        $now = new DateTime();
        $dateNow = $now->format('Y-m-d');
        $dateDb = $request->ngay_muon;
        if ($dateNow < $dateDb) {
            $data['status'] = 1;
            $data['user_id'] = $user->id;
            $dkMuonPhong = $this->dkMuonPhong->save($data);
            $this->tuanMuonPhong->save(['tuan_id' => $request->tuan_id, 'muon_phong_id' => $dkMuonPhong->id, 'status' => 'x']);
            $dataSubmit = $this->dkMuonPhong->getDataSubmit($dkMuonPhong->id);
            try {
                if ($dataSubmit) {
                    return $this->dataSuccess(Message::SUCCESS, $dataSubmit, StatusCode::CREATED);
                } else {
                    return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
                }
            } catch (\Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
            }
        } else {
            return $this->dataError('Không thể đăng ký mượn phòng thấp hơn ngày hiện tại!', false, StatusCode ::BAD_REQUEST);
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
        $now = new DateTime();
        $dateNow = $now->format('Y-m-d');
        $dateDb = $this->dkMuonPhong->get($id);
        if ($dateNow < $dateDb->ngay_muon) {
            $data = $this->tuanMuonPhong->getByColumn('muon_phong_id', $id);
            try {
                if ($data) {
                    $deleteTuanMP = $this->tuanMuonPhong->delete($data->id);
                    if ($deleteTuanMP) {
                        $deleteMP = $this->dkMuonPhong->delete($id);
                        if ($deleteMP) {
                            return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
                        } else {
                            return $this->dataError(Message::ERROR, false, StatusCode ::BAD_REQUEST);
                        }
                    }
                }
            } catch (\Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
            }
        } else {
            return $this->dataError('Không thể xóa!', false, StatusCode ::BAD_REQUEST);
        }
    }

    public function getDSMuonPhong(Request $request)
    {
        $tokenHeader = $request->header('Authorization');
        $tokenUser = explode(' ', $tokenHeader, 2)[1];
        $user = JWTAuth::toUser($tokenUser);
        $data = $this->dkMuonPhong->getDSMuonPhong($user);
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

    public function updateStatus(Request $request, $id)
    {
        $data = $request->all();
        $now = new DateTime();
        $dateNow = $now->format('Y-m-d');
        $dateDb = $this->dkMuonPhong->get($id);
        if ($dateNow <= $dateDb->ngay_muon) {
            $data['status'] = 0;
            $updateStatus = $this->dkMuonPhong->update($data, $id);
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
