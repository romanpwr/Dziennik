<?php

function getbrowser() {
    if(isset($_SERVER['HTTP_USER_AGENT'])) {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        // Firefox
        if(strpos($agent, 'Firefox'))
           $browser = 'firefox';
           // Chrome
        elseif(strpos($agent, 'Chrome'))
           $browser = 'chrome';
           // Safari
        elseif(strpos($agent, 'Safari'))
        $browser = 'safari';
           // Opera
        elseif(strpos($agent, 'Opera'))
           $browser = 'opera';
           // Internet Explorer
        elseif(strpos($agent, 'MSIE'))
           $browser = 'ie';
        else
           $browser = false;
        return $browser;
     } else {
        return false;
   }
 }
 
 ?>