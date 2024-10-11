<?php if (!empty($bc)) : ?>
    <?php
    $pop = array_pop($bc);
    ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <?php if(is_iterable($bc)): foreach ($bc as $a => $i) : ?>
                <li class="breadcrumb-item"><a href="<?= $i['url'] ?>"><?= $i['name'] ?></a></li>
            <?php endforeach; endif;?>
            <li class="breadcrumb-item active" aria-current="page"><?=$pop['name']?></li>
        </ol>
    </nav>
<?php endif; ?>