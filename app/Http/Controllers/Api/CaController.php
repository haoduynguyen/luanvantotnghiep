<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CaRepositoryInterface;
use App\Repositories\Interfaces\UserProfileRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Client;
use DB;
use Illuminate\Http\Request;
use JWTAuth;

class CaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $ca;
    private $user;
    private $userProfile;

    public function __construct(CaRepositoryInterface $caRepository,
                                UserRepositoryInterface $userRepository,
                                UserProfileRepositoryInterface $userProfileRepository)
    {
        $this->ca = $caRepository;
        $this->user = $userRepository;
        $this->userProfile = $userProfileRepository;
    }

    public function index()
    {
        $data = $this->ca->all();
        try {
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (Exception $e) {
            return $this->dataSuccess(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
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
        try {
            $data = $this->ca->get($id);
            if ($data) {
                return $this->dataSuccess(Message::SUCCESS, $data, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (Exception $e) {
            return $this->dataSuccess(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
        }
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

    public function google(Request $request)
    {

        //return $data;
        $client = new \GuzzleHttp\Client();

        $res = $client->request('GET', 'https://www.googleapis.com:443/oauth2/v1/userinfo?access_token=' . $request->access_token,
            ['verify' => false,
                'headers' => ['Authorization' => "ApiKey"]
            ]);
        //getBody() lay content data json
        //Json_decode convert json thành mãng(assoc true) hoặc object(assoc false)
        $data = json_decode($res->getBody(), true);
        DB::beginTransaction();
        try {
            if ($data) {
                $user = $this->user->getByColumn('email', $data['email']);
                if ($user) {
                    try {
                        $user['user'] = $this->user->get($user->id);
                        $user['profile'] = $user->profile;
                        $user['token'] = JWTAuth::fromUser($user);
                        $list = $user;
                        DB::commit();
                        return $this->dataSuccess(Message::SUCCESS, $list, StatusCode::SUCCESS);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
                    }
                } else {
                        return $this->dataError('Email của bạn không tồn tại', false, StatusCode::BAD_REQUEST);
                    }
                }
            }  catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
        }

    }
    public function facebook(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        $res = $client->request('GET', 'https://graph.facebook.com/me?fields=id,name,address,birthday,context,email,about,first_name,gender,inspirational_people,last_name&access_token=' . $request->access_token,
            ['verify' => false,
                'headers' => ['Authorization' => "ApiKey"]
            ]);
        //getBody() lay content data json
        //Json_decode convert json thành mãng(assoc true) hoặc object(assoc false)
        $data = json_decode($res->getBody(), true);
        DB::beginTransaction();
        try {
            if ($data) {
                $user = $this->user->getByColumn('email', $data['email']);
                if ($user) {
                    try {
                        $user['user'] = $this->user->get($user->id);
                        $user['profile'] = $user->profile;
                        $user['token'] = JWTAuth::fromUser($user);
                        $list = $user;
                        DB::commit();
                        return $this->dataSuccess(Message::SUCCESS, $list, StatusCode::SUCCESS);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
                    }
                } else {
//                    $userFb = $this->user->save(['email'=>$data['email'],'role_id'=>'1']);
//                    $this->userProfile->save(['first_name'=>$data['first_name'],'last_name'=>$data['last_name'],'gender'=>1,'user_id'=>$userFb->id]);
//                    DB::commit();
                    return $this->dataError('Email của bạn không tồn tại', false, StatusCode::BAD_REQUEST);
                }
            }
        }  catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
        }
    }
}
