<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        // Create Groups
        $groups = [
            ['name' => 'admin'],
            ['name' => 'user'],
        ];

        $this->db->table('groups')->insertBatch($groups);

        // Create Users
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($users);

        // Assign Groups to Users
        // Assuming IDs are 1 and 2 respectively (auto-increment)
        $groupsUsers = [
            ['group_id' => 1, 'user_id' => 1], // Admin -> Admin User
            ['group_id' => 2, 'user_id' => 2], // User -> Regular User
        ];

        $this->db->table('groups_users')->insertBatch($groupsUsers);
    }
}
