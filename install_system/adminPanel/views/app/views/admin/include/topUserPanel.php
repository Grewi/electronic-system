<!-- Nav Item - User Information -->
<li class="btn-group">
    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user->email ?></span>
        <i class="bi bi-person-circle"></i>
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="userDropdown">

        <a class="dropdown-item" href="/?exit">
        <i class="bi bi-box-arrow-right"></i> Выйти
        </a>
    </div>
</li>