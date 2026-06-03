<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['perawat_id']) || empty($_SESSION['user']['nama'])) {
    header('Location: ' . BASEURL . '/divisionRMFO-255');
    exit;
}

$userName = $_SESSION['user']['nama'];
$userRole = $_SESSION['user']['role'];
$userShift = $_SESSION['user']['shift'];
$userInitial = strtoupper(substr($userName, 0, 1));

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Rumah Sakit</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #ffffff; }
        
        /* Komponen Visual Khusus (Non-Layout) */
        .sidebar { background-color: #043622; color: #fff; width: 240px; min-height: 100vh; font-size: 0.95rem; }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; display: block; padding: 15px 24px; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.1); color: #fff; }
        .sidebar-bottom { background-color: #20c997; padding: 16px 24px; color: #fff; }
        
        .stat-card { border: 1px solid #cce3d8; border-radius: 8px; box-shadow: none; }
        .stat-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .table-custom th { font-weight: 600; color: #444; border-bottom: 1px solid #eaeaea; font-size: 0.75rem; padding: 14px 16px; }
        .table-custom td { font-size: 0.85rem; vertical-align: middle; padding: 14px 16px; border-bottom: 1px solid #eaeaea; color: #111; font-weight: 600; }
        .table-custom td span.desk { font-weight: 500; }
        .task-card { border: 1px solid #111; border-radius: 6px; padding: 12px 16px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; }
        .header-title { font-size: 1.1rem; color: #111; font-weight: 700; margin-bottom: 6px; }
        .section-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 16px; color: #111; }
        .value-huge { font-size: 3.2rem; font-weight: 800; line-height: 1; letter-spacing: -1px; }
        .text-urgensi { font-weight: 700; color: #333; }
        .task-checked { text-decoration: line-through; color: #888 !important; }
        .progress-bar-custom { height: 10px; background-color: #eaeaea; border-radius: 5px; overflow: hidden; }
        .progress-bar-fill { height: 100%; background-color: #20c997; }
        .header-info { padding: 25px 40px 15px; border-bottom: 2px solid #f1f1f1; }
        .header-title-top { font-size: 1.25rem; color: #111; font-weight: 800; margin-bottom: 2px; text-transform: uppercase; }
        .header-subtitle { font-size: 0.85rem; font-weight: 600; color: #777; }
        
        .content-area { padding: 30px 40px; }
        
        .search-box { position: relative; width: 300px; margin-bottom: 20px; }
        .search-box input { border-radius: 6px; padding: 8px 15px 8px 35px; border: 1px solid #ddd; font-size: 0.85rem; width: 100%; color: #555; }
        .search-box input:focus { border-color: #20c997; box-shadow: 0 0 0 0.2rem rgba(32, 201, 151, 0.25); outline: none; }
        .search-box input::placeholder { color: #aaa; }
        .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 0.85rem; }
        
        .table-container { border: 1px solid #52cba1; border-radius: 8px; overflow: hidden; }
        .table-custom { margin-bottom: 0; }
        .table-custom th { background-color: #f9f9f9; font-weight: 700; color: #444; border-bottom: 1px solid #eaeaea; font-size: 0.7rem; padding: 16px; text-align: center; }
        .table-custom th.text-start { text-align: left; }
        .table-custom td { font-size: 0.75rem; vertical-align: middle; padding: 16px; border-bottom: 1px solid #eaeaea; color: #111; font-weight: 700; text-align: center; }
        .table-custom td.text-start { text-align: left; font-weight: 800; }
        .table-custom tr:last-child td { border-bottom: none; }
        
        .action-icons { display: flex; justify-content: center; gap: 12px; }
        .action-icons i { font-size: 1.1rem; cursor: pointer; color: #555; }
        .action-icons i:hover { color: #111; }
        .action-icons i.text-danger { color: #dc3545; }
        .action-icons i.text-danger:hover { color: #b02a37; }
        .form-card { 
            background: #fff; 
            border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            padding: 40px 50px; 
            max-width: 850px; 
            margin: 0 auto; 
        }
        .form-header { 
            font-size: 1.5rem; 
            font-weight: 800; 
            color: #043622; 
            margin-bottom: 5px; 
            text-transform: uppercase; 
        }
        .form-subtitle {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 20px;
        }
        .form-divider-top { 
            border-top: 3px solid #043622; 
            margin-bottom: 35px; 
        }

        /* Notifikasi Error Utama */
        .alert-error {
            background-color: #fde8e8;
            border-left: 4px solid #f98080;
            color: #c81e1e;
            padding: 12px 16px;
            margin-bottom: 25px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Elemen Form Milikmu */
        .section-title {  
            font-size: 1.1rem; 
            font-weight: bold; 
            color: #333; 
            margin-top: 35px; 
            margin-bottom: 8px; 
        }
        .section-divider {
            border-top: 1px solid #a8b0a9;
            margin-bottom: 20px;
        }
        
        .form-row { 
            display: flex; 
            align-items: flex-start; 
            margin-bottom: 15px; 
        }
        .label-col { 
            flex: 0 0 220px; 
            padding-top: 6px;
        }
        .custom-label { 
            font-size: 0.95rem; 
            font-weight: 600; 
            color: #222; 
        }
        .input-col { 
            flex-grow: 1; 
        }
        .custom-input { 
            width: 100%;
            border: 1px solid #777; 
            border-radius: 0; 
            padding: 8px 12px; 
            font-size: 0.9rem; 
            outline: none; 
            box-sizing: border-box;
            background-color: transparent;
        }
        .custom-input:focus { 
            border-color: #043622; 
            box-shadow: 0 0 4px rgba(4, 54, 34, 0.3); 
        }
        textarea.custom-input { 
            min-height: 80px; 
            resize: vertical; 
        }

        /* Baris Input Ganda (Asal & Tgl Lahir) */
        .multi-input-row { 
            display: flex; 
            gap: 20px; 
        }
        .multi-input-group { 
            flex: 1; 
            display: flex;
            align-items: flex-start;
            flex-direction: column;
        }
        .multi-input-group label.multi-label {
             
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 5px;
            color: #222;
        }

        /* Radio Group */
        .radio-group { 
            display: flex; 
            gap: 25px; 
            align-items: center; 
            padding-top: 6px;
        }
        .radio-item { 
            font-size: 0.9rem; 
            cursor: pointer; 
            color: #333;
        }

        /* Canvas TTD */
        .canvas-container { 
            border: 1px solid #777; 
            border-radius: 4px; 
            position: relative; 
            height: 150px; 
            background: #fafafa; 
            overflow: hidden; 
        }
        .canvas-container canvas { 
            width: 100%; 
            height: 100%; 
            cursor: crosshair; 
        }

        /* Syarat dan Ketentuan */
        .terms-row { 
            display: flex; 
            gap: 12px; 
            align-items: flex-start; 
            margin-top: 40px; 
        }
        .terms-row input[type="checkbox"] { 
            margin-top: 3px; 
        }
        .terms-text { 
            font-size: 0.85rem; 
            color: #333; 
            line-height: 1.5; 
        }

        /* Tombol */
        .btn-wrapper { 
            display: flex; 
            justify-content: center; 
            gap: 15px;
            margin-top: 40px; 
        }
        .btn-submit { 
            background-color: #20c997; 
            border: none; 
            color: #111; 
            font-weight: bold; 
            padding: 12px 30px; 
            border-radius: 4px; 
            font-size: 0.95rem; 
            cursor: pointer;
            transition: background 0.2s; 
        }
        .btn-submit:hover { background-color: #1bb78a; }
        
        .btn-back {
            background-color: #dc3545; 
            border: none; 
            color: #fff; 
            font-weight: bold; 
            padding: 12px 30px; 
            border-radius: 4px; 
            font-size: 0.95rem; 
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s; 
        }
        .btn-back:hover { background-color: #b02a37; }

        @media (max-width: 768px) {
            .form-row { flex-direction: column; }
            .label-col { margin-bottom: 8px; }
            .multi-input-row { flex-direction: column; }
        }
    </style>
</head>

<body class="flex overflow-hidden h-screen w-full">
    
    <?php require_once __DIR__ . '/../layouts/sidebar_perawat.php'; ?>

    <main class="flex-1 p-8 overflow-y-auto bg-white">
        <?php 
            
            require_once $view_content; 
        ?>
    </main>
    
    <div class="modal fade" id="staffAccountModal" tabindex="-1" aria-labelledby="staffAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered max-w-[400px]">
            <div class="modal-content px-4 py-3 rounded-xl border-none shadow-[0_10px_30px_rgba(0,0,0,0.15)]">
                
                <div class="modal-header border-0 pb-1 px-0 flex justify-between items-center">
                    <h5 class="modal-title m-0 text-[#043622] font-extrabold text-lg" id="staffAccountModalLabel">STAFF ACCOUNT</h5>
                    <span data-bs-dismiss="modal" aria-label="Close" class="cursor-pointer text-xl font-extrabold text-[#111]">X</span>
                </div>
                
                <hr class="border-t-[1.5px] border-[#111] opacity-100 m-0 mb-8">
                
                <div class="modal-body p-0">
                    <form id="staffUpdateForm" method="POST" action="<?= BASEURL; ?>/perawat/dashboard">
                        <input type="hidden" name="update_staff" value="1">
                        
                        <div class="row mb-3 items-center">
                            <label class="col-4 col-form-label text-end pe-2 text-[#043622] font-medium text-sm">Nama Lengkap :</label>
                            <div class="col-8 ps-2">
                                <input type="text" name="namaLengkap" class="form-control rounded-full border border-[#111] py-1 px-4 font-medium text-sm" value="<?= htmlspecialchars($userName) ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="row mb-3 items-center">
                            <label class="col-4 col-form-label text-end pe-2 text-[#043622] font-medium text-sm">Divisi :</label>
                            <div class="col-8 ps-2">
                                <select name="divisi" class="form-select text-dark rounded-full border border-[#111] py-1 px-4 font-medium text-sm bg-white cursor-not-allowed bg-none" disabled>
                                    <option value="Rekam Medis" <?= ($userRole == 'Rekam Medis') ? 'selected' : '' ?>>Rekam Medis</option>
                                    <option value="Front Officer" <?= ($userRole == 'Front Officer') ? 'selected' : '' ?>>Front Officer</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-4 items-center">
                            <label class="col-4 col-form-label text-end pe-2 text-[#043622] font-medium text-sm">Shift :</label>
                            <div class="col-8 ps-2">
                                <?php $currentShift = $_SESSION['user']['shift'] ?? 'Shift 2'; ?>
                                <select name="shift" class="form-select text-dark rounded-full border border-[#111] py-1 px-4 font-medium text-sm bg-white cursor-not-allowed bg-none" disabled>
                                    <option value="Shift 1" <?= ($currentShift == 'Shift 1') ? 'selected' : '' ?>>Shift 1</option>
                                    <option value="Shift 2" <?= ($currentShift == 'Shift 2') ? 'selected' : '' ?>>Shift 2</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 items-center mt-12 mb-2">
                            <button type="button" id="btnEditSave" class="btn bg-[#20c997] text-white border border-[#111] font-bold w-[65%] rounded-lg p-2 text-sm tracking-wide">EDIT</button>
                            <a href="<?= BASEURL; ?>/divisionRMFO-255/logout" class="btn bg-[#dc3545] text-white border border-[#111] font-bold w-[65%] rounded-lg p-2 text-sm text-center tracking-wide no-underline">LOGOUT</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnEditSave = document.getElementById('btnEditSave');
            const updateForm = document.getElementById('staffUpdateForm');
            const inputs = updateForm.querySelectorAll('input[type="text"], select');

            btnEditSave.addEventListener('click', function() {
                if (btnEditSave.innerText.trim() === 'EDIT') {
                    inputs.forEach(input => {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                        input.style.borderColor = '#13c898';
                        input.style.boxShadow = '0 0 5px rgba(19, 200, 152, 0.5)';
                        input.style.backgroundColor = '#fdfdfd';
                    });
                    
                    const selects = updateForm.querySelectorAll('select');
                    selects.forEach(sel => {
                        sel.style.backgroundImage = '';
                        sel.style.cursor = 'pointer';
                    });

                    inputs[0].focus();
                    btnEditSave.innerText = 'SAVE';
                } else {
                    updateForm.submit();
                }
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>