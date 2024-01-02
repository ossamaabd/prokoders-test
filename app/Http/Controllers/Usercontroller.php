<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class Usercontroller extends Controller
{
    private $repo;
    public function  __construct(UserInterface $userRepositry)
    {
        $this->repo = $userRepositry;
    }


    
    public function allUserGroups(){
        return $this->repo->allUserGroups();
    }

    public function allUserOwnedGroups(){
        return $this->repo->allUserOwnedGroups();
    }

    public function allUserFiles(){
        return $this->repo->allUserFiles();
    }
    public function ViewAddFile(){
        return $this->repo->ViewAddFile();
    }

    public function adminAllFiles(){
        return $this->repo->adminAllFiles();
    }

    public function user_register(Request $request)
    {
        return $this->repo->user_register($request);
    }

    public function admin_register(Request $request)
    {
        return $this->repo->admin_register($request);
    }

    public function login(Request $request)
    {
        return $this->repo->login($request);
    }


}
