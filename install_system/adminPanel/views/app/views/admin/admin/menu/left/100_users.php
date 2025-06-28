<?php $dropElement = 'userDrop'; ?>
<li>
    <a class="" data-bs-toggle="collapse" data-bs-target="#<?=$dropElement?>" aria-expanded="false" aria-controls="<?=$dropElement?>">
        Пользователи
    </a>
</li>
<div class="collapse" id="<?=$dropElement?>">
    <a class="" href="/<?= ADMIN ?>/users">Пользователи</a>
    <a class="" href="/<?= ADMIN ?>/roles">Роли</a>
</div>
<?php unset($dropElement); ?>