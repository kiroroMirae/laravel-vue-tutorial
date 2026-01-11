<?php

namespace App\Actions;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAction {

    public static function getUserList($params)
    {
        // Main query
        $data = User::select(['users.*']);

        // Filtering
        if ($params['search'] != '') {
            $data = $data->where(function($q) use ($params)
            {
                $q->where('users.name', 'like', "%{$params['search']}%")
                ->orWhere('users.email', 'like', "%{$params['search']}%");
            });
        }
        // Ordering
        $direction = strtoupper($params['order'][0]['dir']);
        switch ($params['order'][0]['column']) {
            case '0':
                $data = $data->orderBy('id', $direction);
                break;
            case '1':
                $data = $data->orderBy('users.name', $direction);
                break;
            case '2':
                $data = $data->orderBy('users.email', $direction);
                break;
            default:
                $data = $data->orderBy('id', $direction);
                break;
        }
        // Pagination
        $dataCount = $data->count();
        if ($params['start'] != '0') {
            $offset = $params['start'];
            $data = $data->offset($offset)->limit($params['length']);
        } else {
            $data = $data->limit($params['length']);
        }

        // Get data
        $data = $data->get();

        $result = [];
        foreach ($data->toArray() as $index => $item) {
            // additional data formatting eg.. adding index
            $edit = route('user.edit', ['user' => $item['id']]);
            $delete = route('user.destroy', ['user' => $item['id']]);

            $item['index'] = $params['start']+1;
            $item['edit'] = $edit;
            $item['delete'] = $delete;

            $result[] = $item;
            $params['start']++;
        }
        // Prepare response
        $response = array(
            "draw" => $params['draw'],
            "iTotalRecords" => $dataCount,
            "iTotalDisplayRecords" =>  $dataCount,
            "aaData" => $result
        );

        return $response;
    }
    public static function createUser($params)
    {
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $params['name'];
            $user->email = $params['email'];
            $user->password = Hash::make($params['password']);
            $user->save();

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function updateUser($params, User $user)
    {

        try {
            DB::beginTransaction();

            $user->name = $params['name'];
            $user->email = $params['email'];
            if (isset($params['new_password']) && $params['new_password'] != '') {
                $user->password = Hash::make($params['new_password']);
            }
            $user->save();

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
