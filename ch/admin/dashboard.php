<?php
    ob_start();
    session_start();
    if (isset($_SESSION['Username'])) {

        $pageTitle = 'Dashboard';

        include 'init.php';

        // Start dashboard page 
        $numUsers = 4; 

        $latestUsers = getLatest("*", "users", "UserID", $numUsers); //latest users array 

        $numItems = 4;

        $latestItems = getLatest("*", 'items', 'Item_ID', $numItems); //latest items array 

        ?>
<div class="container home-states text-center">
    <h1>Dashboard</h1>
    <div class="row">
        <div class="col-md-3">
            <div class="state st-members">
                <i class="fa fa-users"></i>
                <div class="info">
                    Total Members
                    <span>
                        <a href="members.php"><?php echo countItems('UserID', 'users') ?></a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="state st-pending">
                <i class="fa fa-user-check"></i>
                <div class="info">
                    Pending Members
                    <span>
                        <a href="members.php?do=Manage&page=Pending">
                            <?php echo checkItem("RegStatus", "users", 0) ?>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="state st-items">
                <i class="fa fa-tags"></i>
                <div class="info">
                    Total Items
                    <span>
                        <a href="items.php"><?php echo countItems('Item_ID', 'items') ?></a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="state st-comments">
                <i class="fa fa-comments"></i>
                <div class="info">
                    Total Comments
                    <span>
                        <a href="comments.php"><?php echo countItems('c_id', 'comments') ?></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container latest">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-users"></i> Latest <?php echo $numUsers ?> Registerd Users
                    <span class="toggle-info">
                        <i class="fa fa-plus fa-lg"></i>
                    </span>
                </div>
                <div class="panel-body bg-white">
                    <ul class="list-unstyled latest-users">
                        <?php
                                if (! empty($latestUsers)) {
                                    foreach ($latestUsers as $user) {
                                        echo '<li>';
                                        echo $user['Username'];
                                            echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                                                echo'<span class="btn btn-success btn-edit">';
                                                    echo '<i class="fa fa-edit"></i> Edit';
                                                    if ($user['RegStatus'] == 0) {
                                                        echo "<a href='members.php?do=Activate&userid=" . $user['UserID'] . "' class='btn btn-info text-light btn-active'><i class='fa fa-close'></i> Activate</a>";
                                                    }
                                                echo '</span>';
                                            echo '</a>';
                                        echo '</li>';
                                    }
                                } else {
                                    echo 'There\'s No Users To Show';
                                }
                                ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-tags"></i> Latest <?php echo $numItems ?> Items
                    <span class="toggle-info">
                        <i class="fa fa-plus fa-lg"></i>
                    </span>
                </div>
                <div class="panel-body bg-white">
                    <ul class="list-unstyled latest-users">
                        <?php
                                    if (! empty($latestItems)) {
                                        foreach ($latestItems as $item) {
                                            echo '<li>';
                                            echo $item['Name'];
                                                echo '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
                                                    echo'<span class="btn btn-success btn-edit">';
                                                        echo '<i class="fa fa-edit"></i> Edit';
                                                        if ($item['Approve'] == 0) {
                                                            echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
                                                            class='btn btn-info text-light btn-active'>
                                                            <i class='fa fa-check'></i> Approve</a>";
                                                        }
                                                    echo '</span>';
                                                echo '</a>';
                                            echo '</li>';
                                        }
                                    } else {
                                        echo 'There\'s No Items To Show';
                                    }
                                    ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- start latest comments  -->
        <div class="row mt-3 mb-5">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-comments"></i> Latest Comments
                        <span class="toggle-info">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body bg-white latest-comment">
                        <?php 
                            // select all user except admin
                            $stmt = $con->prepare("SELECT comments.*, users.Username AS Member FROM comments
                                                    INNER JOIN users ON users.UserID = comments.user_id");
                            $stmt->execute();
                            $comments = $stmt->fetchAll();
                            if (!empty($comments)) {    
                                foreach ($comments as $comment) {
                                    echo '<div class="comment-box">';
                                        echo '<span class="member-n">
                                        <a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
                                        ' . $comment['Member'] . '</a></span>';
                                        echo '<p class="member-c">' . $comment['comment'] . '</p>';
                                    echo '</div>';
                                }
                            } else {
                                echo 'There\'s No Ccomments To Show';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- end latest comments  -->

        </div>
    </div>

    <?php
        // End dashboard page 

        include $tpl . 'footer.php'; 

    } else {

        header('Location: index.php');

        exit();
    } 
    ob_end_flush();
?>