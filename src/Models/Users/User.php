<?php

namespace App\Models\Users;

class User extends \App\Models\BaseModel
{
    protected $table = 'users';
    protected $column = ['id', 'name', 'username', 'email', 'password', 'phone', 'photo', 'active_token', 'is_active'];
    protected $check = ['username', 'email'];

    public function register(array $data)
    {
        $data = [
            'name'          =>  $data['name'],
            'username'      =>  $data['username'],
            'email'         =>  $data['email'],
            'password'      =>  password_hash($data['password'], PASSWORD_DEFAULT),
            'phone'         =>  $data['phone'],
            'active_token'  =>  md5(openssl_random_pseudo_bytes(12)),
        ];

        return $this->checkOrCreate($data);
    }

    public function resetPassword(array $data, $column, $value)
    {
        $data = [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ];

        return $this->update($data, $column, $value);
    }

    public function updateProfile($data, $id, $photo = null)
    {
        $data = [
            'name'  => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'photo' => $photo,
        ];

        if (!$data['email']) {
            unset($data['email']);
        }

        if ($photo == null) {
            unset($data['photo']);
        }

        return $this->checkOrUpdate($data, 'id', $id);
    }

    public function joinUserAndRole()
    {
        $qb = $this->getBuilder();
        $result = $qb->select('u.id, u.name, u.username, u.email')
            ->from($this->table, 'u')
            ->join('u', 'user_role', 'ur', 'u.id=ur.user_id')
            ->where('role_id = 3')
            ->execute();

        return $result->fetchAll();
    }

    public function joinUserAndPremiumUser($id)
    {

        $qb = $this->getBuilder();
        $result = $qb->select('u.id, u.name, u.username, u.email, u.password, u.phone, u.photo, u.active_token, u.is_active, p.start_at, p.end_at')
            ->from($this->table, 'u')
            ->join('u', 'premium_user', 'p', 'u.id=p.user_id')
            ->where('u.username = "'.$id.'"')
            ->execute();

        return $result->fetch();
    }
}

?>