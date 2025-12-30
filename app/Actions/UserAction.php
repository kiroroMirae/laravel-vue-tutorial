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
            $item['index'] = $params['start']+1;
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

}
