<?php

namespace App\Interfaces;

interface PopupInterface
{
    public function index();
    public function ViewAddPopup();
    public function ViewEditPopup($popupId);
    public function create($attribute);
    public function getPopupById($attribute);
    public function update($attribute , $popupId);
    // public function update($attribute,$id);
    // public function changeReserved($attribute,$id);
    // public function delete($id);
    // public function readfile($id);
    // public function checkIn($id);
    // public function checkout($id);
    // public function BulkcheckIn($attribute);
    // public function filestate($id);
    // public function filereport($id);

}
