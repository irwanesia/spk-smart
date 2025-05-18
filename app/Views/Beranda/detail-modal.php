 <!-- Modal Detail Mobil -->
 <?php foreach ($mobil_terbaru as $item): ?>
     <div class="modal fade" id="detailModal<?= $item['id_mobil'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-dialog-centered">
             <div class="modal-content">
                 <div class="modal-header bg-light text-white">
                     <h5 class="modal-title">Detail <?= $item['nama_mobil'] ?></h5>
                     <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-6">
                             <img src="<?= base_url('/uploads/' . ($item['gambar'] ?: 'default.png')) ?>" class="img-fluid rounded mb-3" alt="<?= $item['nama_mobil'] ?>">

                             <div class="specifications mb-4">
                                 <h5 class="border-bottom pb-2">Spesifikasi</h5>
                                 <ul class="list-group list-group-flush">
                                     <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                         <span>Merk</span>
                                         <span class="font-weight-bold"><?= $item['merk'] ?></span>
                                     </li>
                                     <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                         <span>Tahun</span>
                                         <span class="font-weight-bold"><?= $item['tahun'] ?></span>
                                     </li>
                                     <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                         <span>Harga</span>
                                         <span class="font-weight-bold">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                                     </li>
                                     <li class="list-group-item d-flex justify-content-between align-items-center px-2">
                                         <span>Ketersediaan</span>
                                         <span class="badge badge-<?= $item['tersedia'] == '1' ? 'success' : 'danger' ?>">
                                             <?= $item['tersedia'] == '1' ? 'Tersedia' : 'Habis' ?>
                                         </span>
                                     </li>
                                 </ul>
                             </div>
                         </div>

                         <div class="col-md-6">
                             <div class="features mb-4">
                                 <h5 class="border-bottom pb-2">Deskripsi</h5>
                                 <p><?= $item['deskripsi'] ? nl2br(esc($item['deskripsi'])) : 'Tidak ada deskripsi' ?></p>
                             </div>

                             <div class="actions mt-4">
                                 <?php if ($item['tersedia'] == '1'): ?>
                                     <button type="button" class="btn btn-sm btn-primary btn-block" data-dismiss="modal" data-toggle="modal" data-target="#purchaseModal<?= md5($item['nama_mobil']) ?>">
                                         <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                                     </button>
                                 <?php endif; ?>
                                 <button type="button" class="btn btn-sm btn-outline-secondary btn-block mt-2" data-dismiss="modal">
                                     <i class="fas fa-times mr-2"></i>Tutup
                                 </button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 <?php endforeach; ?>