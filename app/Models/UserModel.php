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

    /**
     * Syncs user groups (removes old, adds new).
     *
     * @param int $userId
     * @param array $groupIds Array of Group IDs
     * @return bool
     */
    public function syncGroups(int $userId, array $groupIds): bool
    {
        $builder = $this->db->table('groups_users');

        // Remove all existing groups for this user
        $builder->where('user_id', $userId)->delete();

        // Insert new groups
        if (empty($groupIds)) {
            return true;
        }

        $data = [];
        foreach ($groupIds as $groupId) {
            $data[] = [
                'user_id' => $userId,
                'group_id' => (int) $groupId,
            ];
        }

        return $builder->insertBatch($data) > 0;
    }
}