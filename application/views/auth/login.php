<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-4/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome-5/css/all.min.css') ?>">
    <!-- Custom Style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/styleAuth.css') ?>">
</head>

<body>
    <div class="bg">
        <div class="logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/8b/Logo_Badan_Kepegawaian_Negara.png" alt="BKN Logo">
        </div>
        <div class="title-wrapper">
            <h1 class="title-ekinerja">Ekinerja</h1>
            <h4 class="title-ppnpn">PPNPN</h4>
        </div>

        <!-- Sign In -->
        <div class="card">
            <h3 class="text-center mb-4">Sign In</h3>
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                <!-- <div class="text-center mt-3">
                    <a href="#" class="form-link">Forgot password?</a>
                </div>
                <div class="text-center mt-2">
                    <span>Don't have an account? </span><a href="#" class="form-link">Register</a>
                </div> -->
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url('assets/vendor/jQuery/jquery.min.js') ?>"></script>
    <!-- Popper -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="<?= base_url('assets/vendor/bootstrap-4/js/bootstrap.min.js') ?>"></script>
</body>

</html>