<?php

if (!function_exists('current_user_id')) {
    function current_user_id()
    {
        return session()->get('user_id');
    }
}

if (!function_exists('in_group')) {
    /**
     * Checks if the current user belongs to a specific group.
     *
     * @param string $groupName
     * @return bool
     */
    function in_group(string $groupName): bool
    {
        $userId = current_user_id();
        if (!$userId) {
            return false;
        }

        $db = \Config\Database::connect();

        // Query the pivot table joined with groups
        $builder = $db->table('groups_users');
        $builder->join('groups', 'groups.id = groups_users.group_id');
        $builder->where('groups_users.user_id', $userId);
        $builder->where('groups.name', $groupName);

        return $builder->countAllResults() > 0;
    }
}
