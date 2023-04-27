<?php

function lang($pharse) {

    static $lang = array (

        //Navbar links
        'HOME_ADMIN' => 'Home',
        'CATEGORIES' => 'Categories',
        'ITEMS'      => 'Items',
        'MEMBERS'    => 'Members',
        'COMMENTS'    => 'Comments',
        'STATISTICS' => 'Statistics',
        'LOGS'       => 'Logs'
    );

    return $lang[$pharse];
}