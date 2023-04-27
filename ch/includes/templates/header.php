<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php getTitle() ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?php echo $css; ?>frontend.css">


</head>

<body>
    <!-- Start navbar -->
    <nav class="navbar navbar-expand-lg nav-pc">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 text-center align-items-center col-md-12 ">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <img class="logo" src="images/logo.png" alt=""></a>
                    </li>
                    <li class="nav-item  ms-4">
                        <a class="nav-link text-light fw-bold" href="index.php">الرئيسية <i
                                class="fa-solid fa-store me-1"></i></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-light" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">التصنيفات <i class="fa-solid fa-layer-group me-1"></i></a>
                        <ul class="dropdown-menu ">
                            <?php
                            $allCats = getAllFrom("*", "categories", "ID", "where parent = 0", "", "ASC");
                            foreach ($allCats as $cat) {
                                echo '<li class="nav-item "><a class="nav-link text-dark " href="categories.php?pageid=' . $cat['ID'] . '">
                    ' . $cat['Name'] . '</a></li>';
                            }
                            ?>
                            <li class="nav-item ">
                                <a class="position-absolute ps-5 start-0 nav-link text-light fw-bold" href="#"> خيارك
                                    الأول لشراء الأدوات المنزلية
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item serache col-xl-5 col-md-3">
                        <form class="nav-link  position-relative  d-flex text-center " role="search">
                            <input class="form-control rounded-pill" list="datalistOptions" id="exampleDataList"
                                placeholder="اكتب للبحث...">
                            <button class="btn btn-search position-absolute start-0" type="submit"><i
                                    class="fa-solid fa-magnifying-glass text-light"></i></button>
                            <datalist id="datalistOptions">
                                <option value="San Francisco">
                                <option value="New York">
                                <option value="Seattle">
                                <option value="Los Angeles">
                                <option value="Chicago">
                            </datalist>
                        </form>
                    </li>
                    <li class="nav-item  me-3">
                        <a class="nav-link text-light fw-bold" href="#">المفضلة <i
                                class="fa-regular fa-heart me-1"></i></a>
                    </li>
                    <li class="nav-item">
                        <div class="login-bar">
                            <?php
                            if (isset($_SESSION['user'])) { ?>
                            <img class="my-image img-thumbnail rounded-circle" src="avatar.png" alt="">
                            <div class="btn-group my-info">
                                <span class="btn dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                    aria-expanded="false">
                                    <?php echo $sessionUser ?>
                                    <span class="caret"></span>
                                </span>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                    <li><a class="dropdown-item" href="newad.php">New Item</a></li>
                                    <li><a class="dropdown-item" href="profile.php#myads">My Items</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                            <?php
                            } else {
                            ?>
                            <a href="login.php">
                                <span class="nav-link text-light fw-bold  me-3">تسجيل الدخول <i
                                        class="fa-solid fa-user me-1"></i></span>
                            </a>
                            <?php } ?>
                        </div>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link text-light" aria-current="page" href="#">$0.00 <i
                                class="fa-solid fa-cart-plus fa-xl text-light"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <hr>
    <!-- End navbar -->
    <!-- Start nav-udner -->
    <nav class="navbar navbar-expand-lg nav-udner pe-4">
        <div class="container-fluid">
            <div class=" navbar-expand" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php
                        $allCats = getAllFrom("*", "categories", "ID", "where parent = 0", "", "ASC");
                        foreach ($allCats as $cat) {
                            echo '<li class="nav-item"><a class="nav-link text-light " href="categories.php?pageid=' . $cat['ID'] . '">
                    ' . $cat['Name'] . '</a></li>';
                        }
                        ?>
                    </ul>
                    <li class="nav-item ">
                        <a class="position-absolute ps-5 start-0 nav-link text-light fw-bold" href="#"> خيارك
                            الأول لشراء الأدوات المنزلية
                        </a>
                    </li>
                </div>
            </div>
        </div>
    </nav>
    <!-- End nav-udner -->
    <!-- Start nav-mobile -->
    <nav class="navbar fixed-top nav-ipad ps-4 pe-4 position-absolute">
        <div class="container-fluid">
            <a class="nav-link" href="#">
                <img class="logo" src="images/logo.png" alt=""></a>
            <form class="nav-link col-md-8  position-relative  d-flex text-center " role="search">
                <input class="form-control rounded-pill" list="datalistOptions" id="exampleDataList"
                    placeholder="اكتب للبحث...">
                <button class="btn btn-search position-absolute start-0" type="submit"><i
                        class="fa-solid fa-magnifying-glass text-light"></i></button>
                <datalist id="datalistOptions">
                    <option value="San Francisco">
                    <option value="New York">
                    <option value="Seattle">
                    <option value="Los Angeles">
                    <option value="Chicago">
                </datalist>
            </form>
            <a class="navbar-brand text-light" aria-current="page" href="#"><i
                    class="fa-solid fa-cart-plus fa-xl text-light"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Toggle navigation">
                <i class="fas fa-bars fa-lg"></i> </button>
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex mt-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- End nav-mobile -->
    <!-- Start nav-mobile -->
    <div class="nav-mobile">
        <div class="container-fluid">
            <div class="row bar">
                <div class="col bar-logo">
                    <a class="logo-text ms-2" href="index.php">
                        Classic Home</a>
                    <nav class="bars">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                                aria-label="Toggle navigation">
                                <i class="fas fa-bars fa-lg"></i> </button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                                aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Dropdown
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <form class="d-flex mt-3" role="search">
                                        <input class="form-control me-2" type="search" placeholder="Search"
                                            aria-label="Search">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="col">
                    <ul class="navbar-nav nave mb-2 mb-lg-0 text-center align-items-center col-md-12 ">
                        <li class="nav-item">
                            <a class="text-light" aria-current="page" href="#"><i
                                    class="fa-solid fa-cart-plus fa-xl text-light"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="login-bar">
                                <?php
                                if (isset($_SESSION['user'])) { ?>
                                <img class="my-image img-thumbnail rounded-circle" src="avatar.png" alt="">
                                <div class="btn-group my-info">
                                    <span class="btn dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                        aria-expanded="false">
                                        <?php echo $sessionUser ?>
                                        <span class="caret"></span>
                                    </span>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                        <li><a class="dropdown-item" href="newad.php">New Item</a></li>
                                        <li><a class="dropdown-item" href="profile.php#myads">My Items</a></li>
                                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                    </ul>
                                </div>
                                <?php
                                } else {
                                ?>
                                <a href="login.php">
                                    <span class="nav-link text-light fw-bold sign-in me-3">تسجيل الدخول <i
                                            class="fa-solid fa-user me-1"></i></span>
                                </a>
                                <?php } ?>
                            </div>
                        </li>

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form class="position-relative  d-flex text-center " role="search">
                        <input class="form-control rounded-pill" list="datalistOptions" id="exampleDataList"
                            placeholder="اكتب للبحث...">
                        <button class="btn btn-search position-absolute start-0" type="submit"><i
                                class="fa-solid fa-magnifying-glass text-light"></i></button>
                        <datalist id="datalistOptions">
                            <option value="San Francisco">
                            <option value="New York">
                            <option value="Seattle">
                            <option value="Los Angeles">
                            <option value="Chicago">
                        </datalist>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- End nav-mobile -->