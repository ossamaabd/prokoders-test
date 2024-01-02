<?php

namespace App\Interfaces;

interface GroupInterface 
{
    public function allGroupFiles($id) ;
    public function allGroupUsers($id);
    public function createGroup($attribute) ;
    public function deleteGroup($id) ;
    public function addFileToGroup($attribute,$id);
    public function deleteFilefromGroup($attribute,$id);
    public function addUserToGroup($attribute,$id);
    public function deleteUserFromGroup($attribute,$id);
    public function deleteCash();


}