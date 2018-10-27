<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRoleRelationRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $role;
    private $roleRelation;

    public function __construct(RoleRepositoryInterface $roleRepository, UserRoleRelationRepositoryInterface $relationRepository)
    {
        $this->role = $roleRepository;
        $this->roleRelation = $relationRepository;
    }

    public function index()
    {
        $data = $this->role->all();
        return $this->dataSuccess('success', $data, 200);
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
        $data = $request->all();
        $saveRole = $this->role->save($data);
        try {
            if ($saveRole) {
                return $this->dataSuccess(Message::SUCCESS, $saveRole   , StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
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
        $data = $request->all();
        $updateRole = $this->role->update($data, $id);
        try {
            if ($updateRole) {
                return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
            } else {
                return $this->dataError(Message::ERROR, false, StatusCode::BAD_REQUEST);
            }
        } catch (Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
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
        $data = $this->roleRelation->getByColumn("role_id", $id);
        //array_pluck($data,'id');
        //dd($data);

        try {
            if ($data) {
                return $this->dataError("Ko the xoa vi co ton tai khoa ngoai!", false, StatusCode::BAD_REQUEST);
            } else {
                $deleteRole = $this->role->delete($id);
                if($deleteRole)
                {
                    return $this->dataSuccess(Message::SUCCESS, true, StatusCode::SUCCESS);
                }
                else{
                    return $this->dataError("ID khong ton tai!",false, StatusCode::BAD_REQUEST);
                }
            }
        } catch
            (Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
        }
    }
}
