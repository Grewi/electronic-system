    <a class="siteName" href="/" target="_blank">
        <?= config('globals', 'title'); ?>
    </a>
    <ul class="adm-menu-list">
        <li><a class="" href="/<?= ADMIN ?>">Админка</a></li>

        <?php
        $leftMenuDir = APP . '/views/admin/admin/menu/left';
        if (file_exists($leftMenuDir)) {
            $filesArr = scandir($leftMenuDir);
            foreach ($filesArr as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                includeFile($leftMenuDir . '/' . $file);
            }
        }
        ?>
    </ul>