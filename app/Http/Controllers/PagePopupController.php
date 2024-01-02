<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PagePopups;
use App\Models\Popup;
use Illuminate\Http\Request;

class PagePopupController extends Controller
{
    public function index($page_id)
    {
        $Popups = Popup::with('pages')->where('id',$page_id)->first();
        // return $Popups;
        $pages = Page::paginate(10);

        
        return view('pages.pages_popups.index')->with(['Popup'=>$Popups ,'pages' => $pages]);
    }
    public function assignPopupToPage(Request $request , $popup_id ,$page_id)
    {
        $Popups_pages = PagePopups::where('popup_id',$popup_id)->where('page_id', $page_id)->first();
        if(is_null($Popups_pages))
        {
            $Popups_pages = new PagePopups();
            $Popups_pages->page_id = $request->page_id;
            $Popups_pages->popup_id = $request->popup_id;
            $Popups_pages->save();
            return redirect('popup_pages/index/'.$popup_id)->with('message', 'assigned succesfully!');
        }

        return redirect('popup_pages/index/'.$popup_id)->with('message_worng', 'sorry assigned before!');

    }
    public function delete($popup_id ,$page_id)
    {
        $Popups_pages = PagePopups::where('popup_id',$popup_id)->where('page_id', $page_id)->first();
        $Popups_pages->delete();

        return redirect('popup_pages/index/'.$popup_id)->with('message', 'deleted assigned successfully!');

    }
}
