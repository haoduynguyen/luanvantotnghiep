<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserProfileRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\UserRoleRelationRepositoryInterface;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $user;
    private $userProfile;
    private $userRole;

    public function __construct(UserRepositoryInterface $userRepositoryInterface,
                                UserProfileRepositoryInterface $userProfileRepository,
                                UserRoleRelationRepositoryInterface $userRoleRelationRepository)
    {
        $this->user = $userRepositoryInterface;
        $this->userProfile = $userProfileRepository;
        $this->userRole = $userRoleRelationRepository;
    }

    public function index()
    {
        $user = $this->user->getUser();
        try {
            if ($user) {
                return $this->dataSuccess(Message::SUCCESS, $user, StatusCode::SUCCESS);
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
            'first_name' => 'required',
            'last_name' => 'required',
            "email" => 'required|email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|numeric',
            'gender' => 'required',
            'role_id' => 'required|exists:api_role,id'
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
            try {
                $user = $this->user->save(['email' => $request->email, 'password' => Hash::make($request->password), 'name' => $request->first_name]);
                if ($user) {
                    $userProfile = $this->userProfile->save($data);
                    $userProfile->update(['user_id' => $user->id]);
                    $this->userRole->save(['user_id' => $user->id, "role_id" => $request->role_id]);
                }
                return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
            } catch (Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
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
        $data = $this->user->getUserFromID($id);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function changePassword(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {

            $data_errors = $validator->errors();

            $array = [];

            foreach ($data_errors->messages() as $key => $error) {

                $array[] = ['key' => $key, 'mess' => $error];
            }

            return $this->dataError(Message::ERROR, $array, StatusCode::BAD_REQUEST);

        } else {
            $data = $this->user->get($id);
            //dd(Hash::make($request->old_password));
            try {
                if (Hash::check($request->get("old_password"),$data->password)) {
                    $newPassword = $this->user->update(['password' => Hash::make($request->new_password)], $id);
                    if ($newPassword) {
                        return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
                    } else {
                        return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
                    }
                } else {
                    return $this->dataError("Mat Khau Khong Dung", false, StatusCode::BAD_REQUEST);
                }

            } catch (\Exception $e) {
                return $this->dataError(Message::SERVER_ERROR, $e->getMessage(), StatusCode::SERVER_ERROR);
            }
        }
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validator = \Validator::make($request->all(), [
            //'first_name' => 'required',
            //'last_name' => 'required',
            //"email" => 'required',
            //'password' => '
            //|confirmed|min:6',
            //'phone' => 'required|numeric',
            //'gender' => 'required',
            //'role_id' => 'required|exists:api_role,id'
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
            $list = $this->userProfile->getByColumn("user_id", $id);
            $updateProfile = $this->userProfile->update($data, $list->id);
            try {
                if ($updateProfile) {
                    return $this->dataSuccess(Message::SUCCESS, $updateProfile, StatusCode::SUCCESS);
                } else {
                    return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
                }
            } catch (\Exception $e) {
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
        $dataProFile = $this->userProfile->getByColumn("user_id", $id);
        if ($dataProFile) {
            $deleteProfile = $this->userProfile->delete($dataProFile->id);
        }
        $dataRole = $this->userRole->getListByColumn('user_id', $id)->toArray();
        $data["list_id"] = array_pluck($dataRole, 'id');
        if ($dataRole) {
            $deleteRole = $this->userRole->deleteMulti($data);
        }


        /*try {
            if ($deleteUser) {
                return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, false, StatusCode::SERVER_ERROR);
        }*/
    }
}
