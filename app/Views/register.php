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
    <div class="row vh-100">
        <div class="col-12 align-self-center">
            <div class="auth-page">
                <div class="card auth-card shadow-lg">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="text-center auth-logo-text">
                                <h4 class="mt-0">Form Registrasi</h4>
                                <p class="text-muted mb-0">Dapatkan akun gratis sekarang!</p>
                            </div> <!--end auth-logo-text-->

                            <form class="form-horizontal auth-form my-4" action="users/simpan" method="post">
                                <?= csrf_field() ?>
                                <input type="text" name="role" value="pelanggan" hidden>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <div class="input-group mb-3">
                                        <span class="auth-form-icon">
                                            <i class="dripicons-user"></i>
                                        </span>
                                        <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>" name="nama" value="<?= old('nama') ?>" placeholder="Masukan nama" autofocus>
                                        <?php if (session('errors.nama')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('errors.nama') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div><!--end form-group-->

                                <div class="form-group">
                                    <label for="useremail">Email</label>
                                    <div class="input-group mb-3">
                                        <span class="auth-form-icon">
                                            <i class="dripicons-mail"></i>
                                        </span>
                                        <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" placeholder="Masukan email" value="<?= old('email') ?>">
                                        <?php if (session('errors.email')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('errors.email') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div><!--end form-group-->

                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <div class="input-group mb-3">
                                        <span class="auth-form-icon">
                                            <i class="dripicons-lock"></i>
                                        </span>
                                        <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" placeholder="Password">
                                        <?php if (session('errors.password')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('errors.password') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div><!--end form-group-->

                                <div class="form-group">
                                    <label for="conf_password">Ulangi Password</label>
                                    <div class="input-group mb-3">
                                        <span class="auth-form-icon">
                                            <i class="dripicons-lock-open"></i>
                                        </span>
                                        <input type="password" class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>" name="confirm_password" placeholder="Ulangi password">
                                        <?php if (session('errors.confirm_password')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('errors.confirm_password') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-location"></i>
                                            </span>
                                            <input type="text" name="alamat" class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>" value="<?= old('alamat') ?>" placeholder="Masukan alamat">
                                            <?php if (session('errors.alamat')): ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.alamat') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div><!--end form-group-->
                                </div><!--end form-group-->

                                <div class="form-group mb-0 row">
                                    <div class="col-12 mt-2">
                                        <button class="btn btn-primary btn-round btn-block waves-effect waves-light" type="submit">Daftar <i class="fas fa-sign-in-alt ml-1"></i></button>
                                    </div><!--end col-->
                                </div> <!--end form-group-->
                            </form><!--end form-->
                        </div><!--end /div-->

                        <div class="m-3 text-center text-muted">
                            <p class="">Sudah punya akun ? <a href="login" class="text-primary ml-2">Log in</a></p>
                        </div>
                    </div><!--end card-body-->
                </div>
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