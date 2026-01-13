<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\UserModel;
use App\Models\GroupModel;

class UserManagement extends BaseController
{
    protected $userModel;
    protected $groupModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
    }

    public function index()
    {
        $users = $this->userModel->findAll();

        // Attach groups to each user
        foreach ($users as &$user) {
            $user['groups'] = $this->userModel->getGroups($user['id']);
        }

        return view('users/index', [
            'users' => $users,
        ]);
    }

    public function edit($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound("User not found: $id");
        }

        $userGroups = $this->userModel->getGroups($id);
        // Flatten to array of IDs for easier checking in view
        $userGroupIds = array_column($userGroups, 'id');

        $groups = $this->groupModel->findAll();

        return view('users/edit', [
            'user' => $user,
            'userGroupIds' => $userGroupIds,
            'groups' => $groups,
        ]);
    }

    public function update($id = null)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found');
        }

        $rules = [
            'name' => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
        ];

        // Password optional check
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        // Update Groups
        $groups = $this->request->getPost('groups'); // Array of group IDs

        // Use Model method to sync
        $this->userModel->syncGroups($id, $groups ?? []);

        return redirect()->to('/users')->with('success', 'User updated successfully');
    }

    public function delete($id = null)
    {
        if ($this->userModel->delete($id)) {
            return redirect()->to('/users')->with('success', 'User deleted successfully');
        }

        return redirect()->to('/users')->with('error', 'Failed to delete user');
    }
}
