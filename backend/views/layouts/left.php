<?php // dmstr\widgets\Menu::widget(include 'menu.php') ?>

<ul class="sidebar navbar-nav" data-widget="tree">
    <li class="nav-item active"><a class="nav-link" href="/"><i class="fa fa-circle-o"></i> <span>Доска</span></a>
    </li>
    <li class="nav-item"><a class="nav-link" href="/salepoint"><i class="fa fa-circle-o"></i> <span>Точки продаж</span></a>
    </li>
    <li class="nav-item"><a class="nav-link" href="/retail"><i class="fa fa-circle-o"></i> <span>Розница</span></a></li>
    <li class="nav-item"><a class="nav-link" href="/onec"><i class="fa fa-circle-o"></i> <span>Розница 1с</span></a></li>
    <li class="nav-item"><a class="nav-link" href="/employees?class=nav-link"><i class="fa fa-circle-o"></i> <span>Сотрудники</span></a>
    </li>
    <li class="nav-item"><a class="nav-link" href="/analytics"><i class="fa fa-circle-o"></i>
            <span>Аналитика</span></a></li>
    <li class="nav-item"><a class="nav-link" href="/logistics"><i class="fa fa-circle-o"></i> <span>Логистика</span></a>
    </li>
    <li class="nav-item"><a class="nav-link" href="/customers"><i class="fa fa-circle-o"></i> <span>Клиенты</span></a>
    </li>
    <li class="nav-item"><a class="nav-link" href="/callcenter"><i class="fa fa-circle-o"></i>
            <span>Колл центр</span></a></li>
    <li class="nav-item"><a class="nav-link" href="/finance"><i class="fa fa-circle-o"></i> <span>Финансы</span></a>
    </li>
    <li class="nav-item"><a class="nav-link" href="/marketing"><i class="fa fa-circle-o"></i> <span>Маркетинг</span></a>
    </li>
    <li class="nav-item"><a class="nav-link" href="/maps"><i class="fa fa-file-code-o"></i> <span>Карта</span></a></li>
    <li class="nav-item"><a class="nav-link" href="/gii"><i class="fa fa-file-code-o"></i> <span>Gii</span></a></li>
    <li class="nav-item"><a class="nav-link" href="/debug"><i class="fa fa-dashboard"></i> <span>Debug</span></a></li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Login Screens:</h6>
            <a class="dropdown-item" href="login.html">Login</a>
            <a class="dropdown-item" href="register.html">Register</a>
            <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Other Pages:</h6>
            <a class="dropdown-item" href="404.html">404 Page</a>
            <a class="dropdown-item" href="blank.html">Blank Page</a>
        </div>
    </li>
</ul>
