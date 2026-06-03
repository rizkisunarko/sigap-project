<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        const viewButtons = document.querySelectorAll('.btn-view-pasien');
        viewButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const mrn = this.getAttribute('data-mrn');
                const nama = this.getAttribute('data-nama');
                const nik = this.getAttribute('data-nik'); // <-- NIK sekarang ditangkap
                const jk = this.getAttribute('data-jk');
                const asal = this.getAttribute('data-asal');
                const nohp = this.getAttribute('data-nohp');
                const tgllahir = this.getAttribute('data-tgllahir');
                const agama = this.getAttribute('data-agama');
                const statuskawin = this.getAttribute('data-statuskawin');
                const pekerjaan = this.getAttribute('data-pekerjaan');
                const alamat = this.getAttribute('data-alamat');
                const bpjs = this.getAttribute('data-bpjs');
                const goldarah = this.getAttribute('data-goldarah');
                const alergi = this.getAttribute('data-alergi');
                const kewarganegaraan = this.getAttribute('data-kewarganegaraan');
                const namawali = this.getAttribute('data-namawali');
                const statuswali = this.getAttribute('data-statuswali');
                const nikwali = this.getAttribute('data-nikwali');
                const alamatwali = this.getAttribute('data-alamatwali');

                if (document.getElementById('modalMrn')) document.getElementById('modalMrn').value = mrn || '-';
                if (document.getElementById('modalNamaLengkap')) document.getElementById('modalNamaLengkap').value = nama || '-';
                if (document.getElementById('modalNik')) document.getElementById('modalNik').value = nik || '-'; // <-- NIK sekarang disuntikkan
                if (document.getElementById('modalJk')) document.getElementById('modalJk').value = (jk == 'L' ? 'Laki-laki' : (jk == 'P' ? 'Perempuan' : '-'));
                if (document.getElementById('modalAsal')) document.getElementById('modalAsal').value = asal || '-';
                if (document.getElementById('modalNoHp')) document.getElementById('modalNoHp').value = nohp || '-';
                
                if (document.getElementById('modalTglLahir')) document.getElementById('modalTglLahir').value = tgllahir || '-';
                if (document.getElementById('modalAgama')) document.getElementById('modalAgama').value = agama || '-';
                if (document.getElementById('modalStatusKawin')) document.getElementById('modalStatusKawin').value = statuskawin || '-';
                if (document.getElementById('modalPekerjaan')) document.getElementById('modalPekerjaan').value = pekerjaan || '-';
                if (document.getElementById('modalAlamat')) document.getElementById('modalAlamat').value = alamat || '-';
                if (document.getElementById('modalBpjs')) document.getElementById('modalBpjs').value = bpjs || '-';
                if (document.getElementById('modalGolDarah')) document.getElementById('modalGolDarah').value = goldarah || '-';
                if (document.getElementById('modalAlergi')) document.getElementById('modalAlergi').value = alergi || '-';
                if (document.getElementById('modalKewarganegaraan')) document.getElementById('modalKewarganegaraan').value = kewarganegaraan || '-';
                if (document.getElementById('modalNamaWali')) document.getElementById('modalNamaWali').value = namawali || '-';
                if (document.getElementById('modalStatusWali')) document.getElementById('modalStatusWali').value = statuswali || '-';
                if (document.getElementById('modalNikWali')) document.getElementById('modalNikWali').value = nikwali || '-';
                if (document.getElementById('modalAlamatWali')) document.getElementById('modalAlamatWali').value = alamatwali || '-';
            });
        });

        const editButtons = document.querySelectorAll('.btn-edit-pasien');
        editButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const idrm = this.getAttribute('data-idrm');
                const username = this.getAttribute('data-username');
                const password = this.getAttribute('data-password');
                const nik = this.getAttribute('data-nik');
                const nama = this.getAttribute('data-nama');
                const asal = this.getAttribute('data-asal');
                const tgllahir = this.getAttribute('data-tgllahir');
                const jk = this.getAttribute('data-jk');
                const agama = this.getAttribute('data-agama');
                const statuskawin = this.getAttribute('data-statuskawin');
                const pekerjaan = this.getAttribute('data-pekerjaan');
                const alamat = this.getAttribute('data-alamat');
                
                const bpjs = this.getAttribute('data-bpjs');
                const goldarah = this.getAttribute('data-goldarah');
                const alergi = this.getAttribute('data-alergi');
                const kewarganegaraan = this.getAttribute('data-kewarganegaraan');
                const namawali = this.getAttribute('data-namawali');
                const statuswali = this.getAttribute('data-statuswali');
                const nikwali = this.getAttribute('data-nikwali');
                const nohpwali = this.getAttribute('data-nohpwali');
                const alamatwali = this.getAttribute('data-alamatwali');

                if (document.getElementById('editIdRM')) document.getElementById('editIdRM').value = idrm || '';
                if (document.getElementById('editUsername')) document.getElementById('editUsername').value = username || '';
                if (document.getElementById('editPassword')) document.getElementById('editPassword').value = password || '';
                if (document.getElementById('editNik')) document.getElementById('editNik').value = nik || '';
                if (document.getElementById('editNama')) document.getElementById('editNama').value = nama || '';
                if (document.getElementById('editAsal')) document.getElementById('editAsal').value = asal || '';
                if (document.getElementById('editTgllahir')) document.getElementById('editTgllahir').value = tgllahir || '';

                if (jk === 'L') {
                    if (document.getElementById('editJkLActive')) document.getElementById('editJkLActive').checked = true;
                } else if (jk === 'P') {
                    if (document.getElementById('editJkPActive')) document.getElementById('editJkPActive').checked = true;
                }

                if (document.getElementById('editAgama')) document.getElementById('editAgama').value = agama || '';
                if (document.getElementById('editStatusKawin')) document.getElementById('editStatusKawin').value = statuskawin || '';
                if (document.getElementById('editPekerjaan')) document.getElementById('editPekerjaan').value = pekerjaan || '';
                if (document.getElementById('editAlamat')) document.getElementById('editAlamat').value = alamat || '';
                
                if (document.getElementById('editBpjs')) document.getElementById('editBpjs').value = bpjs || '';
                if (document.getElementById('editGolDarah')) document.getElementById('editGolDarah').value = goldarah || '';
                if (document.getElementById('editAlergi')) document.getElementById('editAlergi').value = alergi || '';
                if (document.getElementById('editKewarganegaraan')) document.getElementById('editKewarganegaraan').value = kewarganegaraan || '';
                if (document.getElementById('editNamaWali')) document.getElementById('editNamaWali').value = namawali || '';
                if (document.getElementById('editStatusWali')) document.getElementById('editStatusWali').value = statuswali || '';
                if (document.getElementById('editNikWali')) document.getElementById('editNikWali').value = nikwali || '';
                if (document.getElementById('editNoHpWali')) document.getElementById('editNoHpWali').value = nohpwali || '';
                if (document.getElementById('editAlamatWali')) document.getElementById('editAlamatWali').value = alamatwali || '';
            });
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-edit-trigger')) {
                console.log("Tombol Edit diklik!");

                const id = e.target.getAttribute('data-id');
                console.log("ID Pasien yang diambil: " + id);

                const form = document.getElementById('editRekamMedisForm-' + id);
                console.log("Form ditemukan: ", form);

                if (form) {
                    console.log("Check Validity: " + form.checkValidity());
                    if (form.checkValidity()) {
                        const modalEditEl = document.getElementById('editRekamMedisModal-' + id);
                        console.log("Modal Edit ditemukan: ", modalEditEl);
                        
                        const confirmModalEl = document.getElementById('confirmSaveRekamMedisModal-' + id);
                        console.log("Modal Konfirmasi ditemukan: ", confirmModalEl);

                        if (confirmModalEl) {
                            new bootstrap.Modal(confirmModalEl).show();
                        } else {
                            console.error("Modal Konfirmasi tidak ditemukan, cek ID!");
                        }
                    } else {
                        form.reportValidity();
                    }
                } else {
                    console.error("Form editRekamMedisForm-" + id + " tidak ditemukan!");
                }
            }
        });

        const btnExitPasien = document.querySelectorAll('.btn-exit-pasien');
        btnExitPasien.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const idrm = this.getAttribute('data-idrm');
                if (document.getElementById('exitIdRekamMedis')) document.getElementById('exitIdRekamMedis').value = idrm || '';
                
                const modalEl = document.getElementById('confirmExitPatientModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });
        });

        const btnSimpanAktif = document.getElementById('btnSimpanPerubahanAktif');
        if (btnSimpanAktif) {
            btnSimpanAktif.addEventListener('click', function () {
                const editModal = bootstrap.Modal.getInstance(document.getElementById('patientEditModal'));
                if (editModal) editModal.hide();

                const confirmEl = document.getElementById('confirmSimpanPasienModalAktif');
                if (confirmEl) {
                    setTimeout(function() {
                        new bootstrap.Modal(confirmEl).show();
                    }, 300);
                }
            });
        }

        const btnTidakSimpanAktif = document.getElementById('btnTidakSimpanAktif');
        if (btnTidakSimpanAktif) {
            btnTidakSimpanAktif.addEventListener('click', function () {
                const confirmEl = document.getElementById('confirmSimpanPasienModalAktif');
                const confirmModal = bootstrap.Modal.getInstance(confirmEl);
                if (confirmModal) confirmModal.hide();

                setTimeout(function() {
                    const editEl = document.getElementById('patientEditModal');
                    if (editEl) new bootstrap.Modal(editEl).show();
                }, 300);
            });
        }
        
        const btnConfirmSubmitEdit = document.getElementById('btnConfirmSubmitEdit');
        if (btnConfirmSubmitEdit) {
            btnConfirmSubmitEdit.addEventListener('click', function() {
                document.getElementById('editPasienForm').submit();
            });
        }

        const detailLengkapButtons = document.querySelectorAll('.btn-detail-lengkap');
        detailLengkapButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah halaman melompat
                const idPasien = this.getAttribute('data-id');

                const modalPertamaEl = document.getElementById('patientDetailModal-' + idPasien);
                const modalPertama = bootstrap.Modal.getInstance(modalPertamaEl);
                
                if (modalPertama) {
                    modalPertama.hide();
                }

                modalPertamaEl.addEventListener('hidden.bs.modal', function handler() {
                    const modalKeduaEl = document.getElementById('detailLengkapModal-' + idPasien);
                    if (modalKeduaEl) {
                        new bootstrap.Modal(modalKeduaEl).show();
                    } else {
                        console.error("Pop-up detailLengkapModal-" + idPasien + " tidak ditemukan!");
                    }
                    
                    modalPertamaEl.removeEventListener('hidden.bs.modal', handler);
                });
            });
        });

        const detailRiwayatButtons = document.querySelectorAll('.btn-detail-riwayat');
        detailRiwayatButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault(); 
                const idPasien = this.getAttribute('data-idpasien');
                const idRm = this.getAttribute('data-idrm'); // Ambil ID spesifik rekam medis

                const modalPertamaEl = document.getElementById('patientDetailModal-' + idPasien);
                const modalPertama = bootstrap.Modal.getInstance(modalPertamaEl);
                if (modalPertama) modalPertama.hide();

                modalPertamaEl.addEventListener('hidden.bs.modal', function handler() {
                    
                    const modalKeduaEl = document.getElementById('riwayatPasienModal-' + idRm);
                    
                    if (modalKeduaEl) {
                        new bootstrap.Modal(modalKeduaEl).show();
                    } else {
                        console.error("Pop-up riwayatPasienModal-" + idRm + " tidak ditemukan!");
                    }
                    
                    modalPertamaEl.removeEventListener('hidden.bs.modal', handler);
                });
            });
        });

        const searchInput = document.getElementById('searchInput');
    
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const kataKunci = this.value.toLowerCase();
                    
                    const barisTabel = document.querySelectorAll('.table-custom tbody tr');

                    barisTabel.forEach(function(baris) {
                        const kolomNama = baris.querySelector('td:nth-child(2)');
                        
                        if (kolomNama) {
                            const teksNama = kolomNama.textContent || kolomNama.innerText;
                            
                            if (teksNama.toLowerCase().indexOf(kataKunci) > -1) {
                                baris.style.display = '';
                            } else {
                                baris.style.display = 'none';
                            }
                        }
                    });
                });
            }

        const labButtons = document.querySelectorAll('.btn-lab-pasien');
        labButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault(); 
                const idPasien = this.getAttribute('data-idpasien');

                // 1. Tangkap pop-up yang sedang terbuka (Misalnya sedang di pop-up Detail)
                const modalPertamaEl = document.getElementById('patientDetailModal-' + idPasien);
                
                // Cek apakah tombol ini memang diklik dari dalam modal pertama
                if (modalPertamaEl) {
                    const modalPertama = bootstrap.Modal.getInstance(modalPertamaEl);
                    if (modalPertama) {
                        modalPertama.hide();
                    }

                    // Tunggu modal pertama selesai tertutup, baru buka modal Lab
                    modalPertamaEl.addEventListener('hidden.bs.modal', function handler() {
                        const modalLabEl = document.getElementById('hasilLabModal-' + idPasien);
                        if (modalLabEl) {
                            new bootstrap.Modal(modalLabEl).show();
                        } else {
                            console.error("Pop-up hasilLabModal-" + idPasien + " tidak ditemukan!");
                        }
                        modalPertamaEl.removeEventListener('hidden.bs.modal', handler);
                    });
                } else {
                    // Jika diklik langsung dari tabel utama (tanpa ada modal yang terbuka)
                    const modalLabEl = document.getElementById('hasilLabModal-' + idPasien);
                    if (modalLabEl) {
                        new bootstrap.Modal(modalLabEl).show();
                    }
                }
            });
        });

        // Membersihkan pesan error dan input merah setiap kali pop-up ditutup
        // Membersihkan pesan error dan input merah setiap kali pop-up ditutup
        const allModals = document.querySelectorAll('.modal');
        allModals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function () {
                
                // 1. Hilangkan garis merah dan hapus value pada kotak yang error
                this.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                    el.value = ''; // Paksa hapus teks yang salah
                });
                
                // 2. Kosongkan teks pesan error-nya
                this.querySelectorAll('.text-danger, .invalid-feedback').forEach(el => {
                    if(el.tagName === 'DIV') el.innerHTML = '';
                });

                // 3. KHUSUS form input baru seperti Hasil Lab: Wajib kosongkan semua kotak!
                // Kita cek dari ID modalnya agar tidak merusak modal Edit Pasien
                if (this.id.includes('hasilLabModal')) {
                    this.querySelectorAll('input:not([type="hidden"])').forEach(input => {
                        input.value = ''; // Kosongkan semua input kecuali yang hidden
                    });
                }
                
            });
        });
    });
</script>