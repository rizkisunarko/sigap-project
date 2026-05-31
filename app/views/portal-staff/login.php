<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Staff - Hospital</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffffff; /* Pure white background like screenshot */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-custom {
            background-color: #043622; /* Dark teal/green color */
            color: white;
            padding: 0 40px;
            height: 72px;
            display: flex;
            align-items: center;
        }
        .navbar-custom .navbar-brand {
            color: white;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 20px;
            background-color: #ffffff;
        }
        .login-card {
            background: white;
            border: 1px solid rgba(4, 54, 34, 0.15); /* Light border matching theme */
            border-radius: 24px; /* More rounded corners like screenshot */
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.05); /* Premium soft shadow */
            width: 100%;
            max-width: 820px;
            margin: 0 auto;
            overflow: hidden;
        }
        .login-header {
            text-align: center;
            padding: 24px 20px;
            border-bottom: 1.5px solid rgba(4, 54, 34, 0.15); /* Sleek dividing line */
        }
        .login-header h2 {
            color: #043622;
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            font-weight: 700;
            font-size: 38px;
            letter-spacing: 0.5px;
        }
        .login-body {
            padding: 48px 120px 56px; /* Generous side padding to match screenshot gutters */
        }
        
        /* Adjust for smaller screens to stay fully responsive */
        @media (max-width: 768px) {
            .login-body {
                padding: 32px 40px 40px;
            }
        }
        
        .form-group label {
            color: #043622; /* Dark green label matching header */
            font-weight: 600; /* Semi-bold */
            margin-bottom: 10px;
            font-size: 15px;
            display: inline-block;
        }
        .form-control-custom {
            box-sizing: border-box; /* Agar padding tidak merusak width 100% */
            display: block;
            border: 1.5px solid #13c898; /* Thin light-green border from screenshot */
            border-radius: 999px; /* Pill-shaped */
            padding: 12px 26px;
            width: 100%;
            outline: none;
            transition: all 0.2s ease-in-out;
            font-size: 16px;
            color: #123; 
            background-color: #fff;
        }
        .form-control-custom:focus {
            border-color: #043622;
            box-shadow: 0 0 0 3px rgba(4, 54, 34, 0.1); /* Subtle premium focus ring */
        }
        
        select.form-control-custom {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23043622' stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 22px center;
            background-size: 14px 10px;
            padding-right: 48px;
            cursor: pointer;
        }

        .btn-custom {
            background-color: #043622; /* Dark green button */
            color: white;
            border-radius: 999px; /* Pill-shaped button */
            padding: 10px 48px;
            border: none;
            font-weight: 700;
            margin-top: 15px;
            font-size: 16px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 6px 18px rgba(4, 54, 34, 0.15);
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }
        .btn-custom:hover {
            background-color: #0b5b3b;
            color: white;
            transform: scale(1.02); /* Modern micro-interaction scale */
            box-shadow: 0 8px 22px rgba(4, 54, 34, 0.25);
        }
        .btn-custom:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>

    <nav class="navbar-custom">
        <a href="<?= BASEURL; ?>" class="navbar-brand">
            <img src="<?= BASEURL; ?>/assets/img/logo.png" width="34" height="34" alt="Logo" class="d-inline-block align-text-top me-2">
            <span>HOSPITAL</span>
        </a>
    </nav>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Portal Staff</h2>
            </div>
            <div class="login-body">
            
                <?php if(isset($_SESSION['error_staff'])): ?>
                    <div class="alert alert-danger" style="background-color: #ffe6e6; color: #cc0000; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: center; ">
                        <?= $_SESSION['error_staff']; ?>
                    </div>
                    <?php unset($_SESSION['error_staff']); ?>
                <?php endif; ?>

                <form action="<?= BASEURL; ?>/divisionRMFO-255" method="POST">
                    
                    <div class="form-group mb-4">
                        <label for="namaLengkap">Nama Lengkap :</label>
                        <input type="text" id="namaLengkap" name="namaLengkap" class="form-control-custom" autocomplete="off" required>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="divisi">Divisi :</label>
                        <select id="divisi" name="divisi" class="form-control-custom" required>
                            <option value="" disabled selected>Pilih Divisi</option>
                            <option value="Rekam Medis">Rekam Medis</option>
                            <option value="Front Officer">Front Officer</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="shift">Shift :</label>
                        <select id="shift" name="shift" class="form-control-custom" required>
                            <option value="" disabled selected>Pilih Shift</option>
                            <option value="Shift 1">Shift 1</option>
                            <option value="Shift 2">Shift 2</option>
                        </select>
                    </div>
                    
                    <div style="display: flex; justify-content: center; margin-top: 30px;">
                        <button type="submit" class="btn-custom" style="margin-top: 0;">Masuk</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</html>