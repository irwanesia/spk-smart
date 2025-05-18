<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?= $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="A premium admin dashboard template by Mannatthemes" name="description" />
  <meta content="Mannatthemes" name="author" />

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.ico">
  <link href="<?= base_url() ?>/assets/plugins/footable/css/footable.bootstrap.css" rel="stylesheet" type="text/css">

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

    .navbar-nav .nav-item .nav-link.active {
      font-weight: bold;
      color: #007bff;
    }

    .modal-detail-img {
      max-height: 400px;
      object-fit: contain;
    }

    .specifications .list-group-item {
      padding: 0.75rem 0;
      border-color: rgba(0, 0, 0, 0.05);
    }

    .features p {
      text-align: justify;
      line-height: 1.6;
    }

    /* .card {
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    } */
  </style>

</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url() ?>">AutoCompare</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPelanggan" aria-controls="navbarPelanggan" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarPelanggan">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item <?= uri_string() == '' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('/') ?>">Beranda</a>
          </li>
          <li class="nav-item <?= uri_string() == 'bandingkan' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('/bandingkan') ?>">Bandingkan Mobil</a>
          </li>
          <li class="nav-item <?= uri_string() == 'riwayat-pembelian' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('/riwayat-pembelian') ?>">Riwayat Pembelian</a>
          </li>
          <?php if (session()->get('logged_in')) : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('/logout') ?>">Logout</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('/login') ?>">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('/register') ?>">Daftar</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <?= $this->renderSection('content-utama') ?>

  <!-- jQuery  -->
  <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/metisMenu.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/waves.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/jquery.slimscroll.min.js"></script>

  <!-- Di footer sebelum script delete confirmation -->

  <!-- App js -->
  <script src="<?= base_url() ?>/assets/js/app.js"></script>

  <script>
    $(document).ready(function() {
      // Inisialisasi variabel
      let selectedCars = [];
      const maxCompare = 3; // Maksimal mobil yang bisa dibandingkan

      // Format harga
      function formatHarga(harga) {
        return 'Rp ' + harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      // Update tampilan filter harga
      $('#hargaRange').on('input', function() {
        const harga = $(this).val();
        $('#hargaValue').text(formatHarga(harga));

        // Filter mobil berdasarkan harga
        $('.card').each(function() {
          const cardHarga = parseInt($(this).find('.card-text span').text().replace(/\D/g, ''));
          if (cardHarga <= harga) {
            $(this).parent().show();
          } else {
            $(this).parent().hide();
          }
        });
      });

      $('#compareBtn').click(function() {
        if (selectedCars.length > 1) {
          // Simpan teks asli dan icon
          const originalHtml = $(this).html();

          // Tampilkan loading
          $(this).prop('disabled', true)
            .html('<i class="mdi mdi-loading mdi-spin mr-1"></i> Memproses...');

          // Redirect setelah delay kecil (bisa disesuaikan)
          setTimeout(() => {
            window.location.href = '/proses-perbandingan?cars=' + selectedCars.join(',');
          }, 500);

          // Optional: Untuk handle jika redirect gagal
          setTimeout(() => {
            $(this).prop('disabled', false).html(originalHtml);
          }, 3000);
        } else {
          alert('Pilih minimal 2 mobil untuk dibandingkan');
        }
      });

      // Tombol tambah ke perbandingan
      $(document).on('click', '.add-to-compare', function() {
        const carId = $(this).data('id');
        const card = $(this).closest('.card');
        const index = selectedCars.indexOf(carId);

        if (index === -1) {
          if (selectedCars.length < maxCompare) {
            selectedCars.push(carId);
            $(this).html('<i class="fa fa-check"></i> Terpilih');
            $(this).removeClass('btn-outline-primary').addClass('btn-success');
          } else {
            alert(`Maksimal ${maxCompare} mobil yang bisa dibandingkan`);
            return;
          }
        } else {
          selectedCars.splice(index, 1);
          $(this).html('<i class="fa fa-plus"></i> Bandingkan');
          $(this).removeClass('btn-success').addClass('btn-outline-primary');
        }

        // Update counter dan tombol bandingkan
        updateCompareUI();
      });

      // Update UI perbandingan
      function updateCompareUI() {
        const count = selectedCars.length;
        if (count > 0) {
          $('#compareCounter').text(count).show();
          $('#compareBtn').prop('disabled', false);
        } else {
          $('#compareCounter').hide();
          $('#compareBtn').prop('disabled', true);
        }
      }

      // Tombol bandingkan sekarang
      $('#compareBtn').click(function() {
        if (selectedCars.length > 1) {
          // Redirect ke halaman perbandingan dengan parameter mobil yang dipilih
          window.location.href = '/proses-perbandingan?cars=' + selectedCars.join(',');
        } else {
          alert('Pilih minimal 2 mobil untuk dibandingkan');
        }
      });

      // Tombol beli
      $(document).on('click', '.btn-primary:not(.add-to-compare):not(#compareBtn):not(#submitPurchase)', function() {
        // Cek apakah user sudah login
        // Jika belum, redirect ke halaman login
        // if (!isLoggedIn) {
        //   window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
        //   return;
        // }

        // Jika sudah login, tampilkan modal pembelian
        const card = $(this).closest('.card');
        const carName = card.find('.card-title').text();
        const carPrice = card.find('.card-text span').text();

        $('#carModel').val(`${carName} (${carPrice})`);
        $('#purchaseModal').modal('show');
      });

      // Submit form pembelian
      $('#submitPurchase').click(function() {
        // Validasi form
        if ($('#purchaseForm')[0].checkValidity()) {
          // Simpan data pembelian (AJAX atau form submission)
          alert('Pembelian berhasil disimpan!');
          $('#purchaseModal').modal('hide');

          // Redirect ke halaman riwayat pembelian
          // window.location.href = '/riwayat';
        } else {
          $('#purchaseForm')[0].reportValidity();
        }
      });
    });
  </script>

  <script>
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

  <?= $this->renderSection('scripts') ?>

</body>

</html>