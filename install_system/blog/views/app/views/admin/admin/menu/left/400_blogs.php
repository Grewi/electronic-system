<?php 
    $app = \system\core\app\app::app();
    $active = isset($app->request->params['2']) && $app->request->params['2'] == 'blogs' ? 'active' : '';
    $show = $active == '' ? '' : 'show'; 
    $dropElement = 'blogDrop'; 
?>
<li>
    <a class="<?=$active?>" data-bs-toggle="collapse" data-bs-target="#<?= $dropElement ?>" aria-expanded="false" aria-controls="<?= $dropElement ?>">
        <?=lang('blogs', 'blogs')?> <i class="bi bi-caret-down-fill"></i>
    </a>
</li>
<div class="collapse text-bg-secondary <?=$show?>" id="<?= $dropElement ?>">
    <a class="" href="/<?= ADMIN ?>/blogs"><?=lang('blogs', 'blogs')?></a>
    <a class="" href="/<?= ADMIN ?>/blogs/categories">Категории</a>
    <a class="" href="/<?= ADMIN ?>/blogs/tags">Теги</a>
</div>
<?php unset($dropElement, $active, $show); ?>

