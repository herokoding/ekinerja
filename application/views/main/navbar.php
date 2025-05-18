<!-- Navbar -->
<nav class="main-header navbar navbar-magenta navbar-expand-md navbar-dark">
    <div class="container">
        <a href="<?= base_url(''); ?>" class="navbar-brand">
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/8b/Logo_Badan_Kepegawaian_Negara.png" alt="BKN Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Ekinerja PPNPN</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <!-- <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item">Some action </a></li>
                        <li><a href="#" class="dropdown-item">Some other action</a></li>

                        <li class="dropdown-divider"></li>

                        <li class="dropdown-submenu dropdown-hover">
                            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                                </li>

                                <li class="dropdown-submenu">
                                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                    </ul>
                                </li>

                                <li><a href="#" class="dropdown-item">level 2</a></li>
                                <li><a href="#" class="dropdown-item">level 2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
                <!-- Query Menu -->
                <?php foreach ($queryMenu as $menu) : ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="sub-menu" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                            <i class="fas fa-th-list"> <?= $menu['menu_name']; ?></i>
                        </a>

                        <ul class="dropdown-menu border-0 shadow" aria-labelledby="sub-menu">
                            <?php
                            $subMenu = $this->db->get_where('sub_menus', ['is_active' => 1, 'menu_id' => $menu['menu_id']])->result_array();
                            ?>

                            <?php foreach ($subMenu as $sub) :?>
                                <li><a class="dropdown-item" href="<?= base_url($sub['sub_url']) ?>"> <i class="<?= $sub['sub_icon'] ?>"></i> <?= $sub['sub_title'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="sub-profile" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                        <i class="fas fa-user"> Profile</i>
                    </a>
                    <ul aria-labelledby="sub-profile" class="dropdown-menu">
                        <li><a href="<?= base_url('user/show-profile') ?>" class="dropdown-item">Lihat Profil / Ubah Password</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <a href="<?= base_url('auth/logout') ?>" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
        <!-- /.navbar -->