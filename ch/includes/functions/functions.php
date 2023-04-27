<?php

// get all function v2.0 
// function to get all records from database
// لا يمكن الاجبارية تكون بعد الاختيارية
function getAllFrom($field, $table, $orderfield, $where = NULL, $and = NULL, $ordering = "DESC") {
    global $con;
    $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");
    $getAll->execute();
    $all = $getAll->fetchAll();
    return $all;
}


// ge categories function v1.0 
// function to get categories from database

// function getCat() {
//     global $con;
//     $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
//     $getCat->execute();
//     $cats = $getCat->fetchAll();
//     return $cats;
// }


// ge AD items function v1.0 
// function to get AD items from database

// function getItems($where, $value, $approve = NULL) {
//     global $con;
//     if($approve == NULL) {
//         $sql = 'AND Approve = 1';
//     } else {
//         $sql = NULL;
//     }
//     $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_ID DESC");
//     $getItems->execute(array($value));
//     $items = $getItems->fetchAll();
//     return $items;
// }

// check if user not active 
// function to check the regstatus of the user 
function checkUserStatus($user) {
    global $con;
    $stmtx = $con->prepare("SELECT Username, RegStatus FROM users WHERE Username = ? AND RegStatus = 0");
    $stmtx->execute(array($user));
    $status = $stmtx->rowCount();

    return $status;
}



// function to chech items in database 
// $select = the item to select [example: user, item, catageory]
// $from = the table to select from [example:users, items, categories]
// $value = the value of select[example: osama, box, electonics]

function checkItem($select, $from, $value) {
    global $con;
    $statemnt = $con->prepare("SELECT $select FROM $from Where $select = ?");
    $statemnt->execute(array($value));
    $count = $statemnt->rowCount();
    return $count;
}















// طباعة عنوان الصفحة
function getTitle() {
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}

// هذه الدالة ترجعك للصفحة المحددة من قبلك بسبب وجود خطأ تقبل منك الثواني ورسالة الخطأ v1
// ممكن تكون اي رسالة مو شرط خطأ ممكن تكون نجاح او تحذير v2

function redirectHome($theMsg, $url = null, $seconds = 3) {
    if ($url === null) {
        $url = 'index.php'; 
        $link = 'HomePage';
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Pervious Page';
        } else {
            $url = 'index.php';
            $link = 'HomePage';
        }
    }
    echo $theMsg;
    echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds seconds.</div>";
    header("refresh:$seconds;url=$url");
    exit();  
}


// count number of items function v1.0 
// $item = the item to count 
// $table = the table to choose from

function countItems($item, $table) {
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

// ge latest records function v1.0 
// function to get latest items from database [Users, Items, Comments]
// $select = filed to select 
// $table = the table to choose 
// number of records to get

function getLatest($select, $table, $order, $limit = 3) {
    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
}