<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name', 'email', 'password', 'is_active'];

    public function getGroups(int $userId): array
    {
        return $this->db->table('groups_users')
            ->select('groups.id, groups.name')
            ->join('groups', 'groups.id = groups_users.group_id')
            ->where('groups_users.user_id', $userId)
            ->get()
            ->getResultArray();
    }
}