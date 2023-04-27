<?php
    session_start();
    $pageTitle = 'Members';
    if (isset($_SESSION['Username'])) {
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage')         { //manage Members page
            $query = '';
            if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
                $query = 'AND RegStatus = 0';
            }
            // select all user except admin
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
            $stmt->execute();
            $members = $stmt->fetchAll();

            if (! empty($members)) {
            ?>

<h1 class="text-center">Manage Members</h1>
<div class="container">
    <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            <tr class="bg-dark text-light">
                <td>#ID</td>
                <td>Avatar</td>
                <td>Username</td>
                <td>Email</td>
                <td>Full Name</td>
                <td>Registerd Date</td>
                <td>Control</td>
            </tr>
            <?php
                        foreach($members as $member) {
                            echo "<tr>";
                                echo "<td>" . $member['UserID'] . "</td>";
                                echo "<td>";
                                if(empty($member['avatar'])) {
                                    echo "<img src='uploads/avatars/avatar.png' alt='' >";
                                } else {
                                    echo "<img src='uploads/avatars/" . $member['avatar'] . "' alt='' >";
                                }
                                echo "</td>";
                                echo "<td>" . $member['Username'] . "</td>";
                                echo "<td>" . $member['Email'] . "</td>";
                                echo "<td>" . $member['FullName'] . "</td>";
                                echo "<td>" . $member['Date'] ."</td>";
                                echo "<td>
                                <a href='members.php?do=Edit&userid=" . $member['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                <a href='members.php?do=Delete&userid=" . $member['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                
                                if ($member['RegStatus'] == 0) {
                                    echo "<a href='members.php?do=Activate&userid=" . $member['UserID'] . "' class='btn btn-info text-light'><i class='fa fa-check'></i> Activate</a>";
                                }
                                echo "</td>";
                            echo "</tr>";
                        }
                        ?>
            </tr>
        </table>
    </div>
    <a href="members.php?do=Add" class="btn btn-primary addmember mb-4"> <i class="fa fa-plus"></i> New Member</a>
</div>
<?php } else {
                echo '<div class="container ">';
                    echo '<div class="nice-message">There\'s No Members To Show</div>';
                    echo '<a href="members.php?do=Add" class="btn btn-primary "> <i class="fa fa-plus"></i> New Member</a>';
                    echo '</div>';
            } ?>
<?php 

        } elseif ($do == 'Add')      { //add member page ?>
<h1 class="text-center">Add New Member</h1>
<div class="container edit-username add-member">
    <form class="from-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
        <!-- start username field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="username" class="form-control" autocomplete="off" required="required"
                    placeholder="">
            </div>
        </div>
        <!-- End username field -->
        <!-- start Password field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-5">
                <input type="password" name="password" class="password form-control" autocomplete="new-password"
                    required="required" placeholder="">
                <i class="show-pass fa fa-eye"></i>
            </div>
        </div>
        <!-- End Password field -->
        <!-- start Email field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-5">
                <input type="email" name="email" class="form-control" required="required" placeholder="">
            </div>
        </div>
        <!-- End Email field -->
        <!-- start Full Name field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-10 col-md-5">
                <input type="text" name="full" class="form-control" required="required" placeholder="">
            </div>
        </div>
        <!-- End Full Name field -->
        <!-- start avatar field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">User Avatar</label>
            <div class="col-sm-10 col-md-5">
                <input type="file" name="avatar" class="form-control" required="required">
            </div>
        </div>
        <!-- End avatar field -->
        <!-- start submit field -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 ">
                <input type="submit" value="Add Member" class="btn btn-primary ">
            </div>
        </div>
        <!-- End submit field -->
    </form>
</div>
<?php
        } elseif ($do == 'Insert')   { //Insert page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo  "<h1 class='text-center'>Insert Member</h1>";
        echo  "<div class='container'>";

        //upload variables
        $avatarName = $_FILES['avatar']['name'];
        $avatarSize = $_FILES['avatar']['size'];
        $avatarTmp  = $_FILES['avatar']['tmp_name'];
        $avatarType = $_FILES['avatar']['type'];
        
        //list of allowed file typed to upload
        $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

        //get avatar Extension 
        $avatarExplode = explode('.', $avatarName);
        $avatarEnd = end($avatarExplode);
        $avatarExtension = strtolower($avatarEnd);
        
        $user   = $_POST['username'];
        $pass   = $_POST['password'];
        $email  = $_POST['email'];
        $name   = $_POST['full'];

        $hashPass = sha1($_POST['password']);

        //validate the form

        $formErrors = array();
        if (strlen($user) < 4) {
            $formErrors[] = 'username can be less than <strong>4 characters</strong>';
        }
        if(empty($user)) {
            $formErrors[] = 'Username cant be <strong>empty</strong>';
        }
        if(empty($name)) {
            $formErrors[] = 'Name cant be <strong>empty</strong>';
        }
        if(empty($pass)) {
            $formErrors[] = 'password cant be <strong>empty</strong>';
        }
        if(empty($email)) {
            $formErrors[] = 'Email cant be <strong>empty</strong>';
        }
        if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
            $formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
        }
        if(empty($avatarName)) {
            $formErrors[] = 'Avatar Is <strong>Required</strong>';
        }
        if($avatarSize > 4194304) {
            $formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
        }
        // loop into errors array
        foreach($formErrors as $error) {
            $theMsg = '<div class="alert alert-danger">' . $error . '</div>';
            redirectHome($theMsg, 'back', 4);
        }
    
        if (empty($formErrors)) {
            $avatar = rand(0, 10000000) . '_' . $avatarName;
            move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);

            //check if user exist in database
            $check = checkItem("Username", "users", $user);
            if ($check == 1) {
                $theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
                redirectHome($theMsg, 'back');
            } else {
                // insert userinfo in database 
                $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus , Date, avatar) 
                                    VALUES(:zuser, :zpass, :zemail, :zname, 1, now(), :zavatar) ");
                $stmt->execute(array(
                'zuser'   => $user,
                'zpass'   => $hashPass,
                'zemail'  => $email,
                'zname'   => $name,
                'zavatar' => $avatar
                ));

                //echo success message
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                redirectHome($theMsg, 'back', 3);
        }}

        } else { 
            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
            redirectHome($theMsg);
            echo "</div>";
        }
        echo "</div>";
        

        } elseif ($do == 'Edit')     { //edit page

            // التحقق من انه رقم ولا يوجد به حروف  واحضر لي قيمته
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            // IDاختر جميع الداتا بتعتي بناء على ال 
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
            //EXECUTE QUERY
            $stmt->execute(array($userid));
            // جلب البيانات
            
            $row = $stmt->fetch();
            // لو الأيدي موجود بالداتا فعلا ام لا
            $count = $stmt->rowCount();   
            // لو الأيدي موجود اظهر الفورم
            if ($count> 0) {  ?>

<h1 class="text-center">Edit Member</h1>
<div class="container edit-username">
    <div class="row">
        <div class="avatar col-lg-6 text-center">
            <?php
                if(empty($row['avatar'])) {
                echo "<img src='uploads/avatars/avatar.png' alt=''>";
                } else {
                echo "<img src='uploads/avatars/" . $row['avatar'] . "' alt='' >" ; 
                } 
            ?>
        </div>
        <div class="col-lg-6">
            <form class="from-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid ?>">
                <!-- start username field -->

                <div class="form-group">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-10 col-lg-10">
                        <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>"
                            autocomplete="off" required="required">
                    </div>
                </div>
                <!-- End username field -->
                <!-- start Password field -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-10 col-lg-10">
                        <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
                        <input type="password" name="newpassword" class="form-control" autocomplete="new-password"
                            placeholder="New Password">
                    </div>
                </div>
                <!-- End Password field -->
                <!-- start Email field -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-10 col-lg-10">
                        <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control"
                            required="required">
                    </div>
                </div>
                <!-- End Email field -->
                <!-- start Full Name field -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-10 col-lg-10">
                        <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control"
                            required="required">
                    </div>
                </div>
                <!-- End Full Name field -->
                <!-- start avatar field -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">User Avatar</label>
                    <div class="col-sm-10 col-md-10 col-lg-10">
                        <input type="file" name="avatar" value="<?php echo $row['avatar'] ?>" class="form-control">
                    </div>
                </div>
                <!-- End avatar field -->
                <!-- start submit field -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 ">
                        <input type="submit" value="Save" class="btn btn-primary ">
                    </div>
                </div>
                <!-- End submit field -->
            </form>
        </div>
    </div>
</div>
<?php  
            }
            // لو الأيدي مش موجود اظهر لي هذه الرسالة
            else {
            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger">Theres No Such Id</div>';
            redirectHome($theMsg, 3);
            echo "</div>";
            }
        
        } elseif ($do == 'Update')   { // Update Member page 
            echo  "<h1 class='text-center'>Update Member</h1>";
            echo  "<div class='container'>";
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $id     = $_POST['userid'];
            $user   = $_POST['username'];
            $email  = $_POST['email'];
            $name   = $_POST['full'];
            $avatar = $_POST['avatar'];

            //password  trick

            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

            //validate the form

            $formErrors = array();


            if (strlen($user) < 4) {
            $formErrors[] = 'username can be less than <strong>4 characters</strong>';
            }
            if(empty($user)) {
            $formErrors[] = 'Username cant be <strong>empty</strong>';
            }
            if(empty($name)) {
            $formErrors[] = 'Name cant be <strong>empty</strong>';
            }
            if(empty($email)) {
            $formErrors[] = 'Email cant be <strong>empty</strong>';
            }

            // loop into errors array
            foreach($formErrors as $error) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
            }

            if (empty($formErrors)) {
                //check if there's no error proced the update operation
                $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
                $stmt2->execute(array($user, $id));
                $count = $stmt2->rowCount();

                if ($count == 1) {

                    $theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
                    redirectHome($theMsg, 'back');

                } else {
                    // update the database with this info 
                    $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ?, avatar = ? WHERE UserID = ?");
                    $stmt->execute(array($user, $email, $name, $pass, $avatar, $id));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
                    redirectHome($theMsg, 'back');
                }
            }

            } else { 
                $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                redirectHome($theMsg);

            }
            echo "</div>";

        } elseif ($do == 'Delete')   { // Delete Member page
            echo  "<h1 class='text-center'>Delete Member</h1>";
            echo  "<div class='container'>";

            // التحقق من انه رقم ولا يوجد به حروف  واحضر لي قيمته
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            // IDاختر جميع الداتا بتعتي بناء على ال 
            $check = checkItem('userid', 'users', $userid);
            // لو الأيدي موجود اظهر الفورم
            if ($check > 0) {  

            $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
            $stmt->bindParam(":zuser", $userid);
            $stmt->execute();

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($theMsg, 'back');

            } else {
                $theMsg = '<div class="alert alert-danger">This ID Not Exist</div>';
                redirectHome($theMsg);
            }
            echo "</div>";
        } elseif ($do == 'Activate') { // Activate Member page
            echo  "<h1 class='text-center'>Activate Member</h1>";
            echo  "<div class='container'>";

            // التحقق من انه رقم ولا يوجد به حروف  واحضر لي قيمته
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            // IDاختر جميع الداتا بتعتي بناء على ال 
            $check = checkItem('userid', 'users', $userid);
            // لو الأيدي موجود اظهر الفورم
            if ($check > 0) {  

            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
            $stmt->execute(array($userid));

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
            redirectHome($theMsg, 'back');

            } else {
                $theMsg = '<div class="alert alert-danger">This ID Not Exist</div>';
                redirectHome($theMsg);
            }
            echo "</div>";
        }

        include $tpl . 'footer.php'; 
        } else {
        header('Location: index.php');
        exit();
    } 