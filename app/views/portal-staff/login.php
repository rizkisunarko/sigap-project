<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perawat - Hospital</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: #0b4a33;
            color: white;
            padding: 15px 30px;
        }
        .navbar-custom .navbar-brand {
            color: white;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            font-family: 'Courier New', Courier, monospace;
        }
        .login-container {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
            padding: 0;
        }
        .login-header {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #0b4a33;
        }
        .login-header h2 {
            color: #0b4a33;
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }
        .login-body {
            padding: 40px 50px 30px;
        }
        .form-group label {
            color: #0b4a33;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-control-custom {
            border: 1px solid #48c7a3;
            border-radius: 20px;
            padding: 10px 20px;
            width: 100%;
            outline: none;
            transition: all 0.3s;
        }
        .form-control-custom:focus {
            border-color: #0b4a33;
            box-shadow: 0 0 5px rgba(11, 74, 51, 0.3);
        }
        .btn-custom {
            background-color: #0b4a33;
            color: white;
            border-radius: 20px;
            padding: 10px 40px;
            border: none;
            font-weight: bold;
            margin-top: 20px;
            font-family: 'Courier New', Courier, monospace;
        }
        .btn-custom:hover {
            background-color: #083826;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <nav class="navbar-custom d-flex align-items-center">
        <div class="d-flex align-items-center">
            <!-- Icon -->
            <img src="<?= BASEURL; ?>/assets/img/logo.png" width="34" height="34" alt="Logo" class="d-inline-block align-text-top me-2">
            <span class="navbar-brand mb-0 h1">HOSPITAL</span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Portal Staff</h2>
            </div>
            <div class="login-body">
                <form action="<?= BASEURL; ?>/perawat/dashboard" method="GET">
                    <div class="form-group mb-4">
                        <label for="namaLengkap">Nama Lengkap :</label>
                        <input type="text" id="namaLengkap" name="namaLengkap" class="form-control-custom" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="divisi">Divisi :</label>
                        <input type="text" id="divisi" name="divisi" class="form-control-custom" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="shift">Shift :</label>
                        <input type="text" id="shift" name="shift" class="form-control-custom" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-custom">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>