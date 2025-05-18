<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SMART - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A premium admin dashboard template by Mannatthemes" name="description" />
    <meta content="Mannatthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.ico">

    <!-- App css -->
    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet" type="text/css" />

    <style>
        /* Untuk memperbaiki tampilan invalid feedback */
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #dc3545;
        }

        .auth-form .is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>
</head>

<body class="account-body accountbg">

    <!-- Log In page -->
    <div class="row vh-100 ">
        <div class="col-12 align-self-center">
            <div class="auth-page">
                <div class="card auth-card shadow-lg">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="auth-logo-box">
                                <a href="" class="logo logo-admin"><img src="../assets/images/logo-dark.png" height="70" width="70" alt="logo" class="auth-logo"></a>
                            </div>
                            <!--end auth-logo-box-->

                            <div class="text-center auth-logo-text">
                                <h4 class="mt-0 mb-3 mt-5">SPK SMART</h4>
                                <!-- <p class="text-muted mb-0">Sign in to continue to Metrica.</p> -->
                            </div> <!--end auth-logo-text-->

                            <!-- Error Message -->
                            <?php if (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= esc(session()->getFlashdata('error')) ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <!-- Success Message -->
                            <?php if (session()->getFlashdata('success')) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= esc(session()->getFlashdata('success')) ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <form class="form-horizontal auth-form my-4" action="<?= site_url('/login'); ?>" method="post">
                                <?= csrf_field() ?>

                                <!-- Email Input -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group mb-3">
                                        <span class="auth-form-icon">
                                            <i class="dripicons-user"></i>
                                        </span>
                                        <input type="email" class="form-control <?= (session('errors.email') ? 'is-invalid' : '') ?>"
                                            name="email" value="<?= old('email') ?>" placeholder="Enter email">
                                        <?php if (session('errors.email')) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors.email')) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div><!--end form-group-->

                                <!-- Password Input -->
                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <div class="input-group mb-3">
                                        <span class="auth-form-icon">
                                            <i class="dripicons-lock"></i>
                                        </span>
                                        <input type="password" class="form-control <?= (session('errors.password') ? 'is-invalid' : '') ?>"
                                            name="password" placeholder="Enter password">
                                        <?php if (session('errors.password')) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors.password')) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div><!--end form-group-->

                                <div class="form-group mb-0 row">
                                    <div class="col-12 mt-2">
                                        <button class="btn btn-primary btn-round btn-block waves-effect waves-light" type="submit">
                                            Log In <i class="fas fa-sign-in-alt ml-1"></i>
                                        </button>
                                    </div><!--end col-->
                                </div> <!--end form-group-->
                            </form><!--end form-->
                        </div><!--end /div-->

                        <div class="m-3 text-center text-muted">
                            <p class="">Belum punya akun ? <a href="register" class="text-primary ml-2">Daftar Gratis</a></p>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end auth-page-->
        </div><!--end col-->
    </div><!--end row-->
    <!-- End Log In page -->
    <!-- jQuery  -->
    <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/waves.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.slimscroll.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

</html>