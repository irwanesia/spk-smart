<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="#" class="logo">
            <span>
                <img src="<?= base_url() ?>/img/logo.png" alt="logo-small" class="logo-sm rounded-b-full">
            </span>
            <span class="text-white fs-1">
                <!-- <img src="/img/logo.png" alt="logo-large" class="logo-lg" width="110" height="50">
                <img src="/img/logo.png" alt="logo-large" class="logo-lg logo-dark" width="110" height="50"> -->
                SPK SMART
            </span>
        </a>
    </div>
    <!--end logo-->
    <!-- Navbar -->
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">

            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <!-- <img src="<?php // base_url() 
                                    ?>/assets/images/users/user-4.jpg" alt="profile-user" class="rounded-circle" /> -->
                    <span class="ml-1 nav-user-name hidden-sm"><?= ucfirst($_SESSION['nama']) ?> <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- <a class="dropdown-item" href="#"><i class="dripicons-user text-muted mr-2"></i> Profile</a> -->
                    <a class="dropdown-item" href="<?= site_url('/logout') ?>"><i class="dripicons-exit text-muted mr-2"></i> Logout</a>
                </div>
            </li>
        </ul><!--end topbar-nav-->

        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <button class="button-menu-mobile nav-link waves-effect waves-light">
                    <i class="dripicons-menu nav-icon"></i>
                </button>
            </li>
            <li class="hide-phone app-search">
                <!-- <form role="search" class="">
                    <input type="text" placeholder="Search..." class="form-control">
                    <a href=""><i class="fas fa-search"></i></a>
                </form> -->
            </li>
        </ul>
    </nav>
    <!-- end navbar-->
</div>
<!-- Top Bar End -->