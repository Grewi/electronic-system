<use layout="index" />

<block name="index">
    <div class="alert alert-success" role="alert">
        Поздравляем с успешной установкой системы!
        <?php if(user_id() == 0): ?>
        <div>
            <a class="btn btn-sm btn-success" href="/auth">Вход</a>
            <a class="btn btn-sm btn-primary" href="/register">Регистрация</a>
        </div>
        <?php elseif($userRole && $userRole->slug == 'admin'): ?>
            <a class="btn btn-sm btn-success" href="/<?=ADMIN?>">Админ-панель</a>
            <a class="btn btn-sm btn-primary" href="/?exit">Выход</a>
        <?php else: ?>
            <a class="btn btn-sm btn-primary" href="/?exit">Выход</a>
        <?php endif; ?>
    </div>
</block>