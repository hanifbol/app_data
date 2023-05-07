<?php 
include __DIR__ . "/../libs/url.php";

if (!isset($_SESSION) || !is_array($_SESSION)) {
    session_start();
}

if (is_null($_SESSION['IdPengguna'])) {
	header('Location: ' . url('login.php'));
}
?>

<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo url('assets/vendor/bootstrap/css/bootstrap.min.css');?>">
    <link href="<?php echo url('assets/vendor/fonts/circular-std/style.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url('assets/libs/css/style.css')?>">
    <link rel="stylesheet" href="<?php echo url('assets/vendor/fonts/fontawesome/css/fontawesome-all.css')?>">
    <link rel="stylesheet" href="<?php echo url('assets/vendor/datatables/css/dataTables.bootstrap4.css')?>">
    <link rel="stylesheet" href="<?php echo url('assets/vendor/datatables/css/buttons.bootstrap4.css')?>">
	<link rel="stylesheet" href="<?php echo url('assets/vendor/datatables/css/select.bootstrap4.css')?>">
	<link rel="stylesheet" href="<?php echo url('assets/vendor/datatables/css/fixedHeader.bootstrap4.css')?>">
    <link rel="stylesheet" href="<?php echo url('assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css')?>">
    <link rel="stylesheet" href="<?php echo url('assets/vendor/fonts/flag-icon-css/flag-icon.min.css')?>">
    <title>Concept - Bootstrap 4 Admin Dashboard Template</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="<?php echo url('index.php'); ?>">Concept</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"><?php echo $_SESSION['NamaDepan'] .  " " . $_SESSION['NamaBelakang']; ?></h5>
                                    <span class="status"></span><span class="ml-2"><?php echo $_SESSION['HakAkses']; ?></span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a id="logout" class="dropdown-item" href="#"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->