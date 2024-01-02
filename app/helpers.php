<?php
use App\Models\Page;
///hahaha this is helper functionssss

// For add'active' class for activated route nav-item
function active_class($path, $active = 'active') {
  return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

// For checking activated route
function is_active_route($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

// For add 'show' class for activated route collapse
function show_class($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}


function checkAndDisplayAlert()
{
    $routeName = Route::currentRouteName();

    $page = Page::where('title', $routeName)->first();
    $page_popup = Page::with('popups')->where('title',$routeName)->first();

    if (isset($page_popup->popups) && count($page_popup->popups) > 0) {
        return $page_popup->popups;
    }

    return null;
}
