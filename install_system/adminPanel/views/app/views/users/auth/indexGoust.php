<use layout="index" />

<block name="index">
    <div class="container">
        <div class="register-form mt-1">
            <form method="post">
                <csrf type="input" name="auth"/>
                <input name="auth" value="1" hidden/>
                <div class="mb-3">
                    <input class="form-control" type="text" name="login" placeholder="<?=lang('register', 'login')?>" value="<?=$login?>">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="email" name="email" placeholder="<?=lang('register', 'email')?>" value="<?=$email?>">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="password" name="pass" placeholder="<?=lang('register', 'pass')?>" required>
                </div>  
                <div class="mb-3">
                    <input class="btn btn-primary" type="submit" value="<?=lang('global', 'login')?>">
                </div>
            </form>
        </div>
    </div>
</block>