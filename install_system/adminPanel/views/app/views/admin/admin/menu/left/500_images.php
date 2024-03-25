<?php $admMenuImages = strpos(request('global', 'url'), ADMIN . '/images') === 0 ? true : false; ?>
<li class="<?=$admMenuImages ? 'active' : ''?>">
    <a class=" " href="/<?= ADMIN ?>/images">Изображения</a>
    <?php if($admMenuImages): ?>
    <ul>
        <!-- <li><a href="/<?= ADMIN ?>/images/categories">Категории</a></li>
        <li><a href="/<?= ADMIN ?>/images/tags">Теги</a></li> -->
    </ul>
    <?php endif; ?>
</li>