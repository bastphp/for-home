<?php


namespace App\Repositories;
use App\Models\User;

class UserRepositories
{
    public static function update($data)
    {
        $id = $data['user_id'];
        unset($data['user_id']);
        $user_obj = User::find($id);
        foreach ($data as $key => $datum) {
            $user_obj->{$key} = $datum;
        }
        $user_obj->save();
    }

    public static function create($params)
    {
        $user_template = [
            'name'            => 0,
            'room'            => 0,
            'floor'           => 0,
            'phone'           => 0,
            'open_id'         => 0,
            'password'        => 0,
            'contract_no'     => 0,
            'related_user_id' => 0,
        ];
        $user_data = array_merge($user_template, $params);
        $result = User::create($user_data);
        return $result->id;
    }

    public static function openId($open_id)
    {
        return User::where('open_id', $open_id)->firstOr(function () use($open_id){
            return User::find(self::create(['open_id'=>$open_id]));
        });
    }
}