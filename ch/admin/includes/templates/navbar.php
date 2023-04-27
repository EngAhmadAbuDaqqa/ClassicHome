

<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container">
    <a class="navbar-brand text-light" href="dashboard.php"><?php echo lang('HOME_ADMIN') ?> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa-solid fa-bars text-light"></i>
      </button>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item"><a class="nav-link text-light" href="categories.php"><?php echo lang('CATEGORIES')?></a></li>
      <li class="nav-item"><a class="nav-link text-light" href="items.php"><?php echo lang('ITEMS')?></a></li>
      <li class="nav-item"><a class="nav-link text-light" href="members.php"><?php echo lang('MEMBERS')?></a></li>
      <li class="nav-item"><a class="nav-link text-light" href="comments.php"><?php echo lang('COMMENTS')?></a></li>
      </ul>
      <li class="nav navbar-nav navbar-right dropdown ">
          <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Ahmed
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
            <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
    </div>
  </div>
</nav>
