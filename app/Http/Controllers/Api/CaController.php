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

    public function google(Request $request)
    {

        //return $data;
        $client = new \GuzzleHttp\Client();

        $res = $client->request('GET', 'https://www.googleapis.com:443/oauth2/v1/userinfo?access_token=' . $request->access_token,
            ['verify' => false,
                'headers' => ['Authorization' => "ApiKey"]
            ]);
        $data = json_decode($res->getBody(), true);
        DB::beginTransaction();
        try {
            if ($data) {
                $user = $this->user->getByMultiColumn(['google_id' => $data['id'],
                    'email' => $data['email']]);
                if ($user) {
                    try {
                        $user['user'] = $this->user->get($user->id);
                        $user['profile'] = $user->profile;
                        $user['token'] = JWTAuth::fromUser($user);
                        $list = $user;
                        return $this->dataSuccess(Message::SUCCESS, $list, StatusCode::SUCCESS);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
                    }
                } else {
                    $saveUser = $this->user->save(['email' => $data['email'], 'role_id' => 1, 'google_id' => $data['id']]);
                    if ($saveUser) {
                        $user = $this->user->get($saveUser->id);
                        $user['token'] = JWTAuth::fromUser($saveUser);
                        $this->userProfile->save(['first_name' => $data['family_name'], 'last_name' => $data['given_name'], 'user_id' => $saveUser->id]);
                        $user['profile'] = $saveUser->profile;
                        $list = $user;
                        DB::commit();
                        return $this->dataSuccess(Message::SUCCESS, $list, StatusCode::SUCCESS);
                    }
                }
            } else {
                DB::rollback();
                return $this->dataError('tài khoản google không tồn tại', false, StatusCode::NOT_FOUND);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
        }

    }
}
