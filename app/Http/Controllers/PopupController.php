<?php

namespace App\Http\Controllers;

use App\Interfaces\PopupInterface;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    private $repo;
    public function  __construct(PopupInterface $popupRepository)
    {
        $this->repo = $popupRepository;
    }

    public function index(){
        return $this->repo->index();
    }

    public function ViewAddPopup(){
        return $this->repo->ViewAddPopup();
    }
    public function ViewEditPopup($popupId){
        return $this->repo->ViewEditPopup($popupId);
    }

    public function create(Request $request){
        return $this->repo->create( $request);
    }
    public function update(Request $request , $popupId){
        return $this->repo->update( $request ,$popupId);
    }
    public function getPopupById(Request $request){
        return $this->repo->getPopupById($request);
    }
}
