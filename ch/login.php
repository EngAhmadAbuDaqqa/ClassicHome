<?php 
    session_start();
    $pageTitle = 'Login';
    if (isset($_SESSION['user'])) {
        header('Location: index.php'); 
    }
    include 'init.php';

    
    //check if user coming from http post request

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['login'])) {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $hashedPass = sha1($pass);
            //check if the user exist in database

            $stmt = $con->prepare("SELECT UserID, Username, Password FROM users WHERE Username = ? AND Password = ?");
            $stmt->execute(array($user, $hashedPass));
            $get = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) {
                $_SESSION['user'] = $user; //register user name 
                $_SESSION['uid'] = $get['UserID']; //register user id
                header('Location: index.php');
                exit();
            }
            
        } else {
            // filter to dont use script and words < 4
            $formErrors = array();

            $username   = $_POST['username'];
            $password   = $_POST['password'];
            // $password2  = $_POST['password2'];
            $email      = $_POST['email'];

            if(isset($_POST['username'])) {
                // FILTER_SANITIZE_STRING
                $filterdUser = filter_var($_POST['username'], FILTER_UNSAFE_RAW);
                if (strlen($filterdUser) < 4) {
                    $formErrors[] = 'Username Must be larger than 4 character';
                }
            } 
            if(isset($password) && isset($_POST['password2'])) {
                if(empty($password)) {
                    $formErrors[] = 'sorry password cant be empty';
                }
                if (sha1($password) !== sha1($_POST['password2'])) {
                    $formErrors[] = 'Sorry Password is not match';
                }
            } 
            if(isset($email)) {
                $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
                    if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true){
                        $formErrors[] = 'This email is not valid';
                    }
            } 

                // check if there no error in the user add 
            if (empty($formErrors)) {
                $check = checkItem("Username", "users", $username);
                if ($check == 1) {
                    $formErrors[] = 'This user is exists';
                } else {
                    // insert userinfo in database 
                    $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, RegStatus , Date) 
                                        VALUES(:zuser, :zpass, :zemail, 0, now())");
                    $stmt->execute(array(
                    'zuser'  => $username,
                    'zpass'  => sha1($password),
                    'zemail' => $email
                    ));
                    //echo success message
                    $succesMsg = 'Congratolation you are register';
                }
            }
        }
    }
?>

<div class="container login-page" dir="ltr">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> |
        <span data-class="signup">Signup</span>
    </h1>
    <!-- start login form  -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-container">
            <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type your username"
                required>
        </div>
        <div class="form-container">
            <input class="form-control" type="password" name="password" autocomplete="new-password"
                placeholder="Type your password" required>
        </div>
        <input class="btn btn-primary" name="login" type="submit" value="Login">
    </form>
    <!-- end login form  -->
    <!-- start signup form  -->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-container">
            <input pattern=".{4,}" title="Username must be 4 chars" class="form-control" type="text" name="username"
                autocomplete="off" placeholder="Type your username" required>
        </div>
        <div class="form-container">
            <input minlength="4" class="form-control" type="password" name="password" autocomplete="new-password"
                placeholder="Type a complex password" required>
        </div>
        <div class="form-container">
            <input minlength="4" class="form-control" type="password" name="password" autocomplete="new-password"
                placeholder="Type password again" required>
        </div>
        <div class="form-container">
            <input class="form-control" type="email" name="email" placeholder="Type a vaild email" required>
        </div>
        <input class="btn btn-success" name="signup" type="submit" value="Sign Up">
    </form>
    <!-- end signup form  -->
    <div class="the-errors text-center">
        <?php 
            if (!empty($formErrors)) {
                foreach($formErrors as $error) {
                    echo '<div class="msg error">' . $error . '</div>';
                }
            }
            if(isset($succesMsg)){
                echo '<div class="msg succes">' . $succesMsg . '</div>';
            }
        ?>
    </div>
</div>


<?php 
    include $tpl . 'footer.php'; 
    ob_end_flush();
?>