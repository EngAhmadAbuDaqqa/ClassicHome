<?php
    ob_start();
    session_start();
    $pageTitle = 'Items';
    if (isset($_SESSION['Username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage') {

        // select all user except admin
        $stmt = $con->prepare("SELECT items.*,
                                categories.Name AS category_name,
                                users.Username FROM items
                                INNER JOIN categories ON categories.ID = items.Cat_ID
                                INNER JOIN users ON users.UserID = items.Member_ID");
        $stmt->execute();
        $items = $stmt->fetchAll();
        if(! empty($items)) {
        ?>
<h1 class="text-center">Manage Items</h1>
<div class="container">
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr class="bg-dark text-light">
                <td>#ID</td>
                <td>Name</td>
                <td>Description</td>
                <td>Price</td>
                <td>Adding Date</td>
                <td>Category</td>
                <td>Username</td>
                <td>Control</td>
            </tr>
            <?php
                    foreach($items as $item) {
                        echo "<tr>";
                            echo "<td>" . $item['Item_ID'] . "</td>";
                            echo "<td>" . $item['Name'] . "</td>";
                            echo "<td>" . $item['Description'] . "</td>";
                            echo "<td>" . $item['Price'] . "</td>";
                            echo "<td>" . $item['Add_Date'] ."</td>";
                            echo "<td>" . $item['category_name'] ."</td>";
                            echo "<td>" . $item['Username'] ."</td>";
                            echo "<td>
                            <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                            <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                            if ($item['Approve'] == 0) {
                                echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info text-light'><i class='fa fa-check'></i> Approve</a>";
                            }
                            echo "</td>";
                        echo "</tr>";
                    }
                    ?>
            </tr>
        </table>
    </div>
    <a href="items.php?do=Add" class="btn btn-primary addmember mb-4"> <i class="fa fa-plus"></i> New Item</a>
</div>
<?php } else {
                echo '<div class="container">';
                    echo '<div class="nice-message">There\'s No Items To Show</div>';
                    echo '<a href="items.php?do=Add" class="btn btn-primary "> <i class="fa fa-plus"></i> New Item</a>';
                    echo '</div>';
            } ?>
<?php 

    } elseif ($do == 'Add')      { ?>

<h1 class="text-center">Add New Item</h1>
<div class="container edit-username">
    <form class="form-horizontal" action="?do=Insert" method="POST">
        <!-- start Name field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Item">
            </div>
        </div>
        <!-- End Name field -->
        <!-- start Description field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="description" class="form-control" required="required"
                    placeholder="Description Of The Item">
            </div>
        </div>
        <!-- End Description field -->
        <!-- start Price field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="price" class="form-control" required="required"
                    placeholder="Price Of The Item">
            </div>
        </div>
        <!-- End Price field -->
        <!-- start Country field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="country" class="form-control" placeholder="Country Of Made"
                    required="required">
            </div>
        </div>
        <!-- End Country field -->
        <!-- start Status field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-5 ">
                <select name="status">
                    <option value="0">...</option>
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Very Old</option>
                </select>
            </div>
        </div>
        <!-- End Status field -->
        <!-- start members field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Member</label>
            <div class="col-sm-10 col-md-5 ">
                <select name="member">
                    <option value="0">...</option>
                    <?php
                    $allMembers = getAllFrom("*", "users", "UserID");
                    foreach ($allMembers as $user) {
                        echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                    }

                ?>
                </select>
            </div>
        </div>
        <!-- End members field -->
        <!-- start categouries field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10 col-md-5 ">
                <select name="category">
                    <option value="0">...</option>
                    <?php
                    $allCats = getAllFrom("*", "categories", "ID", "where parent = 0");
                    foreach ($allCats as $cat) {
                        echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                        $childCats = getAllFrom("*", "categories", "ID", "where parent = {$cat['ID']}");
                        foreach ($childCats as $child) {
                            echo "<option value='" . $child['ID'] . "'>**" . $child['Name'] . "</option>";
                        }
                    }

                ?>
                </select>
            </div>
        </div>
        <!-- End categouries field -->
        <!-- start Tags field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma (,)">
            </div>
        </div>
        <!-- End Tags field -->
        <!-- start submit field -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 ">
                <input type="submit" value="Add Item" class="btn btn-primary">
            </div>
        </div>
        <!-- End submit field -->
    </form>
</div>

<?php
    } elseif ($do == 'Insert')   {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo  "<h1 class='text-center'>Insert Item</h1>";
            echo  "<div class='container'>";
    
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $price      = $_POST['price'];
            $country    = $_POST['country'];
            $status     = $_POST['status'];
            $member     = $_POST['member'];
            $cat        = $_POST['category'];
            $tags       = $_POST['tags'];
            //validate the form
    
            $formErrors = array();
            if(empty($name)) {
                $formErrors[] = 'Name Cant Be <strong>Empty</strong>';
            }
            if(empty($desc)) {
                $formErrors[] = 'Description Cant Be <strong>Empty</strong>';
            }
            if(empty($price)) {
                $formErrors[] = 'Price Cant Be <strong>Empty</strong>';
            }
            if(empty($country)) {
                $formErrors[] = 'Country Cant Be <strong>Empty</strong>';
            }
            if($status == 0) {
                $formErrors[] = 'You Must Choose The <strong>Status</strong>';
            }
            if($member == 0) {
                $formErrors[] = 'You Must Choose The <strong>member</strong>';
            }
            if($cat == 0) {
                $formErrors[] = 'You Must Choose The <strong>category</strong>';
            }
            // loop into errors array
            foreach($formErrors as $error) {
                $theMsg = '<div class="alert alert-danger">' . $error . '</div>';
                redirectHome($theMsg, 'back', 4);
            }
    
            if (empty($formErrors)) {
                    // insert userinfo in database 
                    $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, tags) 
                                        VALUES(:zname, :zdesc, :zprice, :zcountry , :zstatus, now(), :zcat, :zmember, :ztags)");
                    $stmt->execute(array(
                    'zname'  => $name,
                    'zdesc'  => $desc,
                    'zprice' => $price,
                    'zcountry'  => $country, 
                    'zstatus' => $status,
                    'zcat'  => $cat, 
                    'zmember'  => $member,
                    'ztags'    => $tags

                    ));
                    //echo success message
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                    redirectHome($theMsg, 'back');
    
                }
    
            } else { 
                echo "<div class='container'>";
                $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                redirectHome($theMsg);
                echo "</div>";
            }
            echo "</div>";
            
    } elseif ($do == 'Edit')     { 
        
        // التحقق من انه رقم ولا يوجد به حروف  واحضر لي قيمته
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        // IDاختر جميع الداتا بتعتي بناء على ال 
        $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
        //EXECUTE QUERY
        $stmt->execute(array($itemid));
        // جلب البيانات
        $item = $stmt->fetch();
        // لو الأيدي موجود بالداتا فعلا ام لا
        $count = $stmt->rowCount();   
        // لو الأيدي موجود اظهر الفورم
        if ($count> 0) {  ?>

<h1 class="text-center">Edit Item</h1>
<div class="container edit-username">
    <form class="from-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
        <!-- start Name field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Item"
                    value="<?php echo $item['Name'] ?>">
            </div>
        </div>
        <!-- End Name field -->
        <!-- start Description field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="description" class="form-control" required="required"
                    placeholder="Description Of The Item" value="<?php echo $item['Description'] ?>">
            </div>
        </div>
        <!-- End Description field -->
        <!-- start Price field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="price" class="form-control" required="required" placeholder="Price Of The Item"
                    value="<?php echo $item['Price'] ?>">
            </div>
        </div>
        <!-- End Price field -->
        <!-- start Country field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="country" class="form-control" placeholder="Country Of Made"
                    value="<?php echo $item['Country_Made'] ?>">
            </div>
        </div>
        <!-- End Country field -->
        <!-- start Status field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-5 ">
                <select name="status">
                    <option value="1" <?php if($item['Status'] == 1) {echo 'selected';} ?>>New</option>
                    <option value="2" <?php if($item['Status'] == 2) {echo 'selected';} ?>>Like New</option>
                    <option value="3" <?php if($item['Status'] == 3) {echo 'selected';} ?>>Used</option>
                    <option value="4" <?php if($item['Status'] == 4) {echo 'selected';} ?>>Very Old</option>
                </select>
            </div>
        </div>
        <!-- End Status field -->
        <!-- start members field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Member</label>
            <div class="col-sm-10 col-md-5 ">
                <select name="member">
                    <?php
                    $allMembers = getAllFrom("*", "users", "UserID");
                    foreach ($allMembers as $user) {
                        echo "<option value='" . $user['UserID'] . "'"; 
                        if($item['Member_ID'] == $user['UserID']) {echo 'selected'; } 
                        echo ">" . $user['Username'] . "</option>";
                    }
                ?>
                </select>
            </div>
        </div>
        <!-- End members field -->
        <!-- start categouries field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10 col-md-5 ">
                <select name="category">
                    <?php
                    $stmt2 = $con->prepare("SELECT * FROM categories ");
                    $stmt2->execute();
                    $cats = $stmt2->fetchAll();
                    foreach ($cats as $cat) {
                        echo "<option value='" . $cat['ID'] . "'";
                        if($item['Cat_ID'] == $cat['ID']) {echo 'selected'; }  
                        echo ">" . $cat['Name'] . "</option>";
                    }
                ?>
                </select>
            </div>
        </div>
        <!-- End categouries field -->
        <!-- start Tags field -->
        <div class="form-group ">
            <label class=" col-sm-2 control-label ">Tags</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma (,)"
                    value="<?php echo $item['tags'] ?>">
            </div>
        </div>
        <!-- End Tags field -->
        <!-- start submit field -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 ">
                <input type="submit" value="Save Item" class="btn btn-primary">
            </div>
        </div>
        <!-- End submit field -->
    </form>

    <?php
            // select all user except admin
            $stmt = $con->prepare("SELECT comments.*, users.Username AS Member FROM comments
                                    INNER JOIN users ON users.UserID = comments.user_id 
                                    WHERE item_id = ?");
            $stmt->execute(array($itemid));
            $rows = $stmt->fetchAll();

            if (! empty($rows)) {
            ?>
    <h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr class="bg-dark text-light">
                <td>Comment</td>
                <td>User Name</td>
                <td>Added Date</td>
                <td>Control</td>
            </tr>
            <?php
                        foreach($rows as $row) {
                            echo "<tr>";
                                echo "<td>" . $row['comment'] . "</td>";
                                echo "<td>" . $row['Member'] . "</td>";
                                echo "<td>" . $row['comment_date'] ."</td>";
                                echo "<td>
                                <a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                <a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                
                                if ($row['status'] == 0) {
                                    echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='btn btn-info text-light'><i class='fa fa-check'></i> Approve</a>";
                                }
                                echo "</td>";
                            echo "</tr>";
                        }
        ?>
            </tr>
        </table>
    </div>
    <?php } ?>
</div>
<?php  
            // لو الأيدي مش موجود اظهر لي هذه الرسالة
            } else {
                echo "<div class='container'>";
                $theMsg = '<div class="alert alert-danger">Theres No Such Id</div>';
                redirectHome($theMsg, 3);
                echo "</div>";
            }
        
    } elseif ($do == 'Update')   { 
        
        echo  "<h1 class='text-center'>Update Item</h1>";
        echo  "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id     = $_POST['itemid'];
        $name   = $_POST['name'];
        $desc  = $_POST['description'];
        $price   = $_POST['price'];
        $country   = $_POST['country'];
        $status  = $_POST['status']; 
        $cat    = $_POST['category'];
        $member   = $_POST['member'];
        $tags   = $_POST['tags'];

        //validate the form    
        $formErrors = array();
        if(empty($name)) {
            $formErrors[] = 'Name Cant Be <strong>Empty</strong>';
        }
        if(empty($desc)) {
            $formErrors[] = 'Description Cant Be <strong>Empty</strong>';
        }
        if(empty($price)) {
            $formErrors[] = 'Price Cant Be <strong>Empty</strong>';
        }
        if(empty($country)) {
            $formErrors[] = 'Country Cant Be <strong>Empty</strong>';
        }
        if($status == 0) {
            $formErrors[] = 'You Must Choose The <strong>Status</strong>';
        }
        if($member == 0) {
            $formErrors[] = 'You Must Choose The <strong>member</strong>';
        }
        if($cat == 0) {
            $formErrors[] = 'You Must Choose The <strong>category</strong>';
        }
        // loop into errors array
        foreach($formErrors as $error) {
            $theMsg = '<div class="alert alert-danger">' . $error . '</div>';
            redirectHome($theMsg, 'back');
        }

        if (empty($formErrors)) {
        // update the database with this info 
        $stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, Member_ID = ?, tags = ? WHERE Item_ID = ?");
        $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));

        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
        redirectHome($theMsg, 'back', 3);
        }

        } else { 
            $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
            redirectHome($theMsg);

        }
        echo "</div>";
       
    } elseif ($do == 'Delete')   { 
        
        echo  "<h1 class='text-center'>Delete Item</h1>";
        echo  "<div class='container'>";

        // التحقق من انه رقم ولا يوجد به حروف  واحضر لي قيمته
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        // IDاختر جميع الداتا بتعتي بناء على ال 
        $check = checkItem('Item_ID', 'items', $itemid);
        // لو الأيدي موجود اظهر الفورم
        if ($check > 0) {  

        $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");
        $stmt->bindParam(":zid", $itemid);
        $stmt->execute();

        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
        redirectHome($theMsg, 'back');

        } else {
            $theMsg = '<div class="alert alert-danger">This ID Not Exist</div>';
            redirectHome($theMsg);
        }
        echo "</div>";
    } elseif ($do == 'Approve')  { 

        echo  "<h1 class='text-center'>Approve Member</h1>";
        echo  "<div class='container'>";

        // التحقق من انه رقم ولا يوجد به حروف  واحضر لي قيمته
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        // IDاختر جميع الداتا بتعتي بناء على ال 
        $check = checkItem('Item_ID', 'items', $itemid);
        // لو الأيدي موجود اظهر الفورم
        if ($check > 0) {  

        $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
        $stmt->execute(array($itemid));

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
    ob_end_flush();
?>