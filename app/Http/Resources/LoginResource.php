<?php

namespace App\Http\Resources;

use App\Laravue\Models\Member;
use App\Laravue\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'success' => true,
            'data' => [
                'id' => $this->id,
                'memberId' => User::find($this->id)->member->id,
                'username' => $this->username,
                'email' => $this->email,
                'roles' => array_map(
                    function ($role) {
                        return $role['name'];
                    },
                    $this->roles->toArray()
                ),
                'permissions' => array_map(
                    function ($permission) {
                        return $permission['name'];
                    },
                    $this->getAllPermissions()->toArray()
                ),
                'avatar' => 'https://i.pravatar.cc',
            ],
        ];
    }
}
