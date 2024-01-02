<?php

namespace App\Interfaces;

interface FileInterface
{
    public function upload($attribute);
    public function update($attribute,$id);
    public function changeReserved($attribute,$id);
    public function delete($id);
    public function readfile($id);
    public function checkIn($id);
    public function checkout($id);
    public function BulkcheckIn($attribute);
    public function filestate($id);
    public function filereport($id);

}
