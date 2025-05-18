<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?= $title ?? null ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="A premium admin dashboard template by Mannatthemes" name="description" />
  <meta content="Mannatthemes" name="author" />

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.ico">
  <link href="<?= base_url() ?>/assets/plugins/footable/css/footable.bootstrap.css" rel="stylesheet" type="text/css">

  <!-- DataTables -->
  <link href="<?= base_url() ?>/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url() ?>/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="<?= base_url() ?>/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Letakkan di bagian head -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- App css -->
  <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url() ?>/assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet" type="text/css" />

  <style>
    .left-sidenav-menu li .nav-link.active {
      color: blue;
    }

    /* Style untuk modal detail */
    .modal-detail .card {
      border: none;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .modal-detail .card-header {
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .modal-detail dt {
      font-weight: 500;
      color: #6c757d;
    }

    .modal-detail dd {
      margin-bottom: 0.5rem;
    }
  </style>

</head>

<body>

  <!-- ======= Header/Topbar ======= -->
  <?= $this->include('Layout/header') ?>

  <div class="page-wrapper">

    <!-- ======= sidebar ======= -->
    <!-- Left Sidenav -->
    <?= $this->include('Layout/sidebar') ?>
    <!-- End Left Sidenav -->

    <!-- Page Content-->
    <div class="page-content">
      <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <div class="page-title-box">
              <div class="float-right">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0);">SPK SMART</a></li>
                  <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
              </div>
              <h4 class="page-title"><?= $title != 'Dashboard' ? $title : '' ?></h4>
            </div><!--end page-title-box-->
          </div><!--end col-->
        </div>
      </div>
      <!-- end page title end breadcrumb -->
      <?= $this->renderSection('content') ?>

      <!-- footer -->
      <?= $this->include('Layout/footer') ?>
      <!-- end footer  -->
    </div>
    <!-- end page content -->
  </div>
  <!-- end page-wrapper -->

  <!-- jQuery  -->
  <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/metisMenu.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/waves.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/jquery.slimscroll.min.js"></script>

  <!-- Required datatable js -->
  <script src="<?= base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Buttons examples -->
  <script src="<?= base_url() ?>/assets/plugins/datatables/dataTables.buttons.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/jszip.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/pdfmake.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/vfs_fonts.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.html5.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.print.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.colVis.min.js"></script>
  <!-- Responsive examples -->
  <script src="<?= base_url() ?>/assets/plugins/footable/js/footable.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/moment/moment.js"></script>
  <script src="<?= base_url() ?>/assets/pages/jquery.footable.init.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/dataTables.responsive.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/assets/pages/jquery.datatable.init.js"></script>

  <script src="<?= base_url() ?>/assets/plugins/apexcharts/apexcharts.min.js"></script>
  <script src="<?= base_url() ?>/assets/pages/jquery.analytics_dashboard.init.js"></script>
  <!-- Di footer sebelum script delete confirmation -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- App js -->
  <script src="<?= base_url() ?>/assets/js/app.js"></script>

  <script>
    // $(document).ready(function() {
    //   // Buka modal jika ada error dan show_modal = 'add'
    //   <?php if (session('errors') && session('show_modal') == 'add'): ?>
    //     $('.modal.add').modal('show');
    //     // Auto-focus ke field pertama yang error
    //     const firstErrorField = $('.modal.add .is-invalid').first();
    //     if (firstErrorField.length) {
    //       firstErrorField.focus();
    //     }
    //   <?php endif; ?>

    //   // Reset form saat modal ditutup
    //   $('.modal.add').on('hidden.bs.modal', function() {
    //     $(this).find('form')[0].reset();
    //     $(this).find('.is-invalid').removeClass('is-invalid');
    //     $(this).find('.invalid-feedback').remove();
    //   });

    //   // Handle form submission (disable button)
    //   $('form').submit(function() {
    //     $(this).find('[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
    //   });
    // });

    $(document).ready(function() {
      // Buka modal jika ada error (support add/edit)
      <?php if (session('errors') && session('show_modal')): ?>
        const modalType = '<?= session("show_modal") ?>'; // 'add' atau 'edit'
        console.log(modalType);
        if (modalType === 'edit' && '<?= session("edit_id") ?>') {
          // Buka modal edit spesifik berdasarkan ID
          $(`#editModal<?= session("edit_id") ?>.edit-modal`).modal('show');
        } else {
          // Buka modal add universal
          $('.modal.add').modal('show');
        }

        // Auto-focus ke field error pertama
        $(`.${modalType === 'edit' ? 'edit-modal' : 'add'} .is-invalid`).first().focus();
      <?php endif; ?>

      // Reset form saat modal ditutup (hanya untuk add)
      $('.modal.add').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').remove();
      });

      // Disable button saat submit (semua form)
      $('form').submit(function() {
        $(this).find('[type="submit"]').prop('disabled', true)
          .html('<i class="fa fa-spinner fa-spin"></i> Processing...');
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      // Fungsi ini bisa digunakan di semua halaman
      function initDeleteConfirmation(selector = '.delete-btn', itemNameAttr = 'data-name') {
        $(selector).click(function(e) {
          e.preventDefault();
          const form = $(this).closest('form');
          const itemName = $(this).attr(itemNameAttr) || 'data ini';
          const itemType = $(this).attr('data-type') || 'Data';

          Swal.fire({
            title: `Konfirmasi Hapus ${itemType}`,
            text: `Apakah Anda yakin ingin menghapus ${itemType.toLowerCase()} ${itemName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      }

      // Inisialisasi untuk semua tombol delete
      initDeleteConfirmation();

      // Jika perlu custom selector:
      // initDeleteConfirmation('.custom-delete-btn', 'data-custom-name');
    });
  </script>

  <?= $this->renderSection('scripts') ?>

</body>

</html>