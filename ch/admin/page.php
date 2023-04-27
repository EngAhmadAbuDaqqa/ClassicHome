<?php

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if($do == 'Manage') {
        echo "Weclome You Are In Manage Category Page";
        echo '<a href="?do=Insert">Add New Category +</a>';

    } elseif ($do == 'Add') {

        echo "Weclome You Are In Add Category Page";

    } elseif ($do == 'Insert') {

        echo "Weclome You Are In Insert Category Page";

    } elseif ($do == 'Edit') {

        echo "Weclome You Are In Edit Category Page";

    } else {

        echo "Error There\'s No Page With This Name";

    }   
    
?>