<?php if (isset($pagin) && count($pagin['line']) > 0) : ?>
    <nav class="d-flex flex-column justify-content-center align-items-center" style="margin: 25px 0;">
        <ul class="pagination pagination-sm">
            <li class="page-item <?php if (!$pagin['priv']  > 0) : ?>disabled<?php endif; ?>">
                <a class="page-link" href="<?= eGetReplace('str', $pagin['priv']) ?>" tabindex="-1" aria-disabled="true">&laquo;</a>
            </li>
                <?php
                //Если текущая страница рядом с концом или началом увеличиваем край
                    $countLi =count($pagin['line']);
                    $min = $pagin['actual'] > 2 ? 2 : 6;
                    $max = $pagin['actual'] < $countLi - 2 ? $countLi - 2 : $countLi - 6;
                ?>
            <?php foreach ($pagin['line'] as $key => $i) : ?>
                <!-- Первые, последние и рядом с актуальной страницей -->
                <?php if ($key <= $min || ($key >= $pagin['actual'] - 3 && $key <= $pagin['actual'] + 3) || $key > $max) : ?>
                    <?php if ($i == 'active') : ?>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="<?= eGetReplace('str', $key) ?>"><?= $key ?></a>
                        </li>
                    <?php else : ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= eGetReplace('str', $key) ?>"><?= $key ?></a>
                        </li>
                    <?php endif; ?>
                <!-- Многоточие -->
                <?php else : ?>
                    <?php if($key == $min+1 || $key == $pagin['actual'] + 4): ?>
                        <li class="page-item"><span class="page-link disabled">...</span></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <li class="page-item  <?php if (!$pagin['next']  > 0) : ?>disabled<?php endif; ?>">
                <a class="page-link" href="<?= eGetReplace('str', $pagin['next']) ?>">&raquo;</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>