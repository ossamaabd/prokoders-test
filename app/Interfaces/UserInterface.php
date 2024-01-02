<?php

namespace App\Interfaces;

interface UserInterface
{
    public function allUserGroups() ;
    public function allUserFiles() ;
    public function ViewAddFile() ;
    public function adminAllFiles();
    public function user_register($attribute);
    public function admin_register($attribute);
    public function login($attribute);
    public function allUserOwnedGroups();
}
