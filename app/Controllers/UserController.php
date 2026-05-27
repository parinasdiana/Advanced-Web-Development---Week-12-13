<?php
namespace App\Controllers;
use App\Models\UserModel;

class UserController extends BaseController
{
    // TASK 3: Paginate User List & Search
    public function index()
    {
        $model = new UserModel();
        
        // Grab the search keyword safely from the URL (GET request)
        $search = $this->request->getGet('search');
        
        if ($search) {
            // Apply search filter if a keyword was entered
            $model->like('name', $search);
        }

        $data = [
            // Get 5 users per page
            'users'  => $model->paginate(5),
            // Pass the pager object to generate navigation links
            'pager'  => $model->pager,
            'search' => $search
        ];

        return view('user_view', $data);
    }

    // TASK 2: Validate & Move File
    public function upload()
    {
        // 1 & 2. Validate file is an image, check MIME type and size (Max 2MB)
        $rules = [
            'name'   => 'required',
            'avatar' => 'uploaded[avatar]|max_size[avatar,2048]|ext_in[avatar,png,jpg,jpeg]|mime_in[avatar,image/png,image/jpeg,image/jpg]'
        ];

        if (!$this->validate($rules)) {
            // Validation failed, return back to the form
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('avatar');
        $name = $this->request->getPost('name');

        if ($file->isValid() && !$file->hasMoved()) {
            // Generate a secure, randomized filename
            $newName = $file->getRandomName();
            
            // 3. Move the file to public/uploads/ (FCPATH points to the public folder)
            $file->move(FCPATH . 'uploads', $newName);
            
            // 4. Store the path/filename in the database
            $model = new UserModel();
            $model->save([
                'name'   => $name,
                'avatar' => $newName
            ]);

            return redirect()->to(base_url('users'));
        }
    }
}