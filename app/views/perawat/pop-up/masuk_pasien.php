<?php defined('BASEURL') OR exit(header("HTTP/1.1 404 Not Found") . "<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p></body></html>"); ?>
<div class="modal fade" id="masukPasienModal-<?= $patient['id_pasien'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content" style="border-radius: 12px; border: none; padding: 25px 20px;">
            <div class="modal-body text-center">
                <i class="bi bi-person-fill-check" style="font-size: 5rem; color: #20c997;"></i>
                <h5 class="mt-2 mb-4" style="color: #111; font-weight: 700; font-size: 1.15rem;">Aktivasi Pasien Baru?</h5>
                
                <div style="border: 1px solid #111; padding: 15px; margin-bottom: 25px;">
                    <p style="margin: 0; font-size: 0.95rem; color: #111; line-height: 1.5;">Sebelum melanjutkan,<br>Pastikan pasien telah berada di ruangan<br>dan siap untuk menerima perawatan.</p>
                </div>

                <form action="<?= BASEURL; ?>/perawat/masuk_pasien" method="POST">
                    <input type="hidden" name="id_pasien" value="<?= $patient['id_pasien'] ?>">
                    
                    <div class="d-flex justify-content-center gap-4">
                        <button type="submit" class="btn" style="background-color: #20c997; color: #111; border: 1px solid #111; font-weight: 600; width: 130px; border-radius: 8px; padding: 8px 0;">Ya, teruskan</button>
                        <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #dc3545; color: #111; border: 1px solid #111; font-weight: 600; width: 130px; border-radius: 8px; padding: 8px 0;">Kembali</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>