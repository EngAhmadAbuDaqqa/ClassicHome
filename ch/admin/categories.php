<?php
    ob_start();
    session_start();
    $pageTitle = 'Categories';
    if (isset($_SESSION['Username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage') {
        $sort = 'DESC';
        $sort_array = array('ASC', 'DESC');
        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
            $sort = $_GET['sort'];

        }
        $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");
        $stmt2->execute();
        $cats = $stmt2->fetchAll(); 
        if (! empty($cats)) {
        ?>
<h1 class="text-center">Manage Categories</h1>
<div class="container categories">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-edit"></i> Manage Categories
            <div class="option">
                <i class="fa fa-sort"></i> Ordering: [
                <a class="<?php if ($sort == 'ASC') {echo 'active';} ?>" href="?sort=ASC">Asc</a> |
                <a class="<?php if ($sort == 'DESC') {echo 'active';} ?>" href="?sort=DESC">Desc</a> ]
                <i class="fa fa-eye"></i> View: [
                <span class="active" data-view="full">Full</span> |
                <span data-view="classic">Classic</span> ]
            </div>
        </div>
        <div class="panel-body bg-white">
            <?php 
                foreach($cats as $cat) {
                    echo  "<div class='cat'>";
                        echo  "<div class='hidden-buttons'>";
                            echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                            echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='btn btn-xs btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                        echo  "</div>";
                        echo  "<h3>" . $cat['Name'] . "</h3>";
                        echo "<div class='full-view'>";
                            echo  "<p>"; if($cat['Description'] == '') {echo 'This category has no description';} else { echo $cat['Description'];}  echo "</p>";
                            if($cat['Visibilty'] == 1) {echo '<span class="visibilty"><i class="fa fa-eye"></i> Hidden</span>'; } 
                            if($cat['Allow_Comment'] == 1) {echo '<span class="comment"><i class="fa fa-close"></i> Comment Disabled</span>'; } 
                            if($cat['Allow_Ads'] == 1) {echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disabled</span>'; } 
                        echo "</div>";
                        $childCats = getAllFrom("*", "categories", "ID", "where parent = {$cat['ID']}", "", "ASC");
                        if (!empty($childCats)) {
                            echo "<h4 class='child-head'>Child Categories</h4>"; 
                            echo "<ul class='list-unstyled child-cats'>";
                            foreach ($childCats as $c) {
                                echo  "<li class='child-link'>
                                <a href='categories.php?do=Edit&catid=" . $c['ID'] . "'>" . $c['Name'] . "</a>
                                <a href='categories.php?do=Delete&catid=" . $c['ID'] . "' class='show-delete confirm'> Delete</a>
                                </li>";
                            }
                            echo "</ul>";
                        }
                    echo "</div>";
                    echo "<hr>";
                }
            ?>
        </div>
    </div>
    <a class="btn btn-primary mt-4 mb-4" href="categories.php?do=Add"> <i class="fa fa-plus"></i> Add New Category</a>
</div>
<?php } else {
                echo '<div class="container">';
                    echo '<div class="nice-message">There\'s No Categories To Show</div>';
                    echo '<a href="categories.php?do=Add" class="btn btn-primary "> <i class="fa fa-plus"></i> New Category</a>';
                    echo '</div>';
            } ?>
<?php    
    } elseif ($do == 'Add')      { ?>

<h1 class="text-center">Add New Category</h1>
<div class="container edit-username">
    <form class="from-horizontal" action="?do=Insert" method="POST">
        <!-- start Name field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="name" class="form-control" autocomplete="off" required="required"
                    placeholder="Name Of The Category">
            </div>
        </div>
        <!-- End Name field -->
        <!-- start Description field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-5">
                <input type="text" name="description" class="form-control" placeholder="Describe The Category">
            </div>
        </div>
        <!-- End Description field -->
        <!-- start Ordering field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10 col-md-5">
                <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories">
            </div>
        </div>
        <!-- End Ordering field -->
        <!-- start category type field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Parent?</label>
            <div class="col-sm-10 col-md-5">
                <select name="parent">
                    <option value="0">None</option>
                    <?php
                        $allCats = getAllFrom("*", "categories", "ID", "where parent = 0", "", "ASC");
                        foreach($allCats as $cat) {
                            echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <!-- End category type field -->
        <!-- start Visibilty field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Visible</label>
            <div class="col-sm-10 col-md-5">
                <div>
                    <input id="vis-yes" type="radio" name="Visibilty" value="0" checked>
                    <label for="vis-yes">Yes</label>
                </div>
                <div>
                    <input id="vis-no" type="radio" name="Visibilty" value="1">
                    <label for="vis-no">No</label>
                </div>
            </div>
        </div>
        <!-- End Visibilty field -->
        <!-- start Comment field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Allow Comment</label>
            <div class="col-sm-10 col-md-5">
                <div>
                    <input id="com-yes" type="radio" name="comment" value="0" checked>
                    <label for="com-yes">Yes</label>
                </div>
                <div>
                    <input id="com-no" type="radio" name="comment" value="1">
                    <label for="com-no">No</label>
                </div>
            </div>
        </div>
        <!-- End Comment field -->
        <!-- start Ads field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-5">
                <div>
                    <input id="ads-yes" type="radio" name="ads" value="0" checked>
                    <label for="ads-yes">Yes</label>
                </div>
                <div>
                    <input id="ads-no" type="radio" name="ads" value="1">
                    <label for="ads-no">No</label>
                </div>
            </div>
        </div>
        <!-- End Ads field -->
        <!-- start submit field -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 ">
                <input type="submit" value="Add category" class="btn btn-primary ">
            </div>
        </div>
        <!-- End submit field -->
    </form>
</div>

<?php
    } elseif ($do == 'Insert')   {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo  "<h1 class='text-center'>Insert Category</h1>";
            echo  "<div class='container'>";

            $name      = $_POST['name'];
            $desc      = $_POST['description'];
            $parent    = $_POST['parent'];
            $order     = $_POST['ordering'];
            $Visible   = $_POST['Visibilty'];
            $comment   = $_POST['comment'];
            $ads       = $_POST['ads'];

            $check = checkItem("Name", "categories", $name);
            if ($check == 1) {
                $theMsg = '<div class="alert alert-danger">Sorry This Category Is Exist</div>';
                redirectHome($theMsg, 'back');
            } else {
                // insert Category in database 
                $stmt = $con->prepare("INSERT INTO 
                    categories(Name, Description, parent, Ordering, Visibilty, Allow_Comment, Allow_Ads) 
                VALUES(:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads)");
                $stmt->execute(array(
                    'zname'      => $name,
                    'zdesc'      => $desc,
                    'zparent'    => $parent,
                    'zorder'     => $order,
                    'zvisible'   => $Visible,
                    'zcomment'   => $comment,
                    'zads'       => $ads
                ));
                //echo success message
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                redirectHome($theMsg, 'back', 3);

                }

            } else { 
                echo "<div class='container'>";
                $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                redirectHome($theMsg, 'back', 3);
                echo "</div>";
            }
            echo "</div>";
            

    } elseif ($do == 'Edit')     { 
        
            // التحقق من انه رقم ولا يوجد به حروف  واحضر لي قيمته
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
            // IDاختر جميع الداتا بتعتي بناء على ال 
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
            //EXECUTE QUERY
            $stmt->execute(array($catid));
            // جلب البيانات
            $cat = $stmt->fetch();
            // لو الأيدي موجود بالداتا فعلا ام لا
            $count = $stmt->rowCount();   

            // لو الأيدي موجود اظهر الفورم

            if ($count> 0) {  ?>

<h1 class="text-center">Edit Category</h1>
<div class="container edit-username">
    <form class="from-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="catid" value="<?php echo $catid ?>">
        <!-- start Name field -->
        <div class="form-group ">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-5 ">
                <input type="text" name="name" class="form-control" required="required"
                    placeholder="Name Of The Category" value="<?php echo $cat['Name'] ?>">
            </div>
        </div>
        <!-- End Name field -->
        <!-- start Description field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-5">
                <input type="text" name="description" class="form-control" placeholder="Describe The Category"
                    value="<?php echo $cat['Description'] ?>">
            </div>
        </div>
        <!-- End Description field -->
        <!-- start Ordering field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10 col-md-5">
                <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories"
                    value="<?php echo $cat['Ordering'] ?>">
            </div>
        </div>
        <!-- End Ordering field -->
        <!-- start category type field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Parent?</label>
            <div class="col-sm-10 col-md-5">
                <select name="parent">
                    <option value="0">None</option>
                    <?php
                        $allCats = getAllFrom("*", "categories", "ID", "where parent = 0", "", "ASC");
                        foreach($allCats as $c) {
                            echo "<option value='" . $c['ID'] . "'";
                                if ($cat['parent'] == $c['ID']) {
                                    echo ' selected';
                                }
                            echo ">" . $c['Name'] . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <!-- End category type field -->
        <!-- start Visibilty field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Visible</label>
            <div class="col-sm-10 col-md-5">
                <div>
                    <input id="vis-yes" type="radio" name="Visibilty" value="0"
                        <?php if ($cat['Visibilty'] == 0){ echo 'checked';} ?>>
                    <label for="vis-yes">Yes</label>
                </div>
                <div>
                    <input id="vis-no" type="radio" name="Visibilty" value="1"
                        <?php if ($cat['Visibilty'] == 1){ echo 'checked';} ?>>
                    <label for="vis-no">No</label>
                </div>
            </div>
        </div>
        <!-- End Visibilty field -->
        <!-- start Comment field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Allow Comment</label>
            <div class="col-sm-10 col-md-5">
                <div>
                    <input id="com-yes" type="radio" name="comment" value="0"
                        <?php if ($cat['Allow_Comment'] == 0){ echo 'checked';} ?>>
                    <label for="com-yes">Yes</label>
                </div>
                <div>
                    <input id="com-no" type="radio" name="comment" value="1"
                        <?php if ($cat['Allow_Comment'] == 1){ echo 'checked';} ?>>
                    <label for="com-no">No</label>
                </div>
            </div>
        </div>
        <!-- End Comment field -->
        <!-- start Ads field -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-5">
                <div>
                    <input id="ads-yes" type="radio" name="ads" value="0"
                        <?php if ($cat['Allow_Ads'] == 0){ echo 'checked';} ?>>
                    <label for="ads-yes">Yes</label>
                </div>
                <div>
                    <input id="ads-no" type="radio" name="ads" value="1"
                        <?php if ($cat['Allow_Ads'] == 1){ echo 'checked';} ?>>
                    <label for="ads-no">No</label>
                </div>
            </div>
        </div>
        <!-- End Ads field -->
        <!-- start submit field -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 ">
                <input type="submit" value="Save" class="btn btn-primary ">
            </div>
        </div>
        <!-- End submit field -->
    </form>
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
    } elseif ($do == 'Update')   { 
        echo  "<h1 class='text-center'>Update Category</h1>";
        echo  "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id     = $_POST['catid'];
            $name   = $_POST['name'];
            $desc  = $_POST['description'];
            $order   = $_POST['ordering'];
            $parent   = $_POST['parent'];
            $Visible   = $_POST['Visibilty'];
            $comment   = $_POST['comment'];
            $ads   = $_POST['ads'];

            // update the database with this info 
            $stmt = $con->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering = ?, parent = ?, Visibilty = ?, Allow_Comment = ?, Allow_Ads = ? WHERE ID = ?");
            $stmt->execute(array($name, $desc, $order, $parent, $Visible, $comment, $ads, $id));

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
            redirectHome($theMsg, 'back', 3);
            
        } else { 
            $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
            redirectHome($theMsg);
        }
        echo "</div>";

    } elseif ($do == 'Delete')   { 
        echo  "<h1 class='text-center'>Delete Category</h1>";
        echo  "<div class='container'>";

        // التحقق من انه رقم ولا يوجد به حروف  واحضر لي قيمته
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        // IDاختر جميع الداتا بتعتي بناء على ال 
        $check = checkItem('ID', 'categories', $catid);
        // لو الأيدي موجود اظهر الفورم
        if ($check > 0) {  

        $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");
        $stmt->bindParam(":zid", $catid);
        $stmt->execute();

        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
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