<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/" target="_blank">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-hand-pointer" aria-hidden="true"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Electronic</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="/<?=ADMIN?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Админка</span></a>
    </li>

    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Пользователи</span>
        </a>
        <div id="collapseUser" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/<?=ADMIN?>/users">Пользователи</a>
                <a class="collapse-item" href="/<?=ADMIN?>/roles">Роли</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePg" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-file" aria-hidden="true"></i>
            <span>Генератор страниц</span>
        </a>
        <div id="collapsePg" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/<?=ADMIN?>/pg">Страницы</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/<?=ADMIN?>/settings">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span>Настройки</span></a>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link" href="/<?=ADMIN?>/ban">
            <i class="fa fa-ban" aria-hidden="true"></i>
            <span>Бан лист</span></a>
    </li> -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>