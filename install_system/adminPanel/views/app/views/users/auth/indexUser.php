<use layout="index" />

<block name="index">
    <div class="container">
        <div class="register-form mt-1">
            <form method="post">
                <csrf type="input" name="userPanel"/>
                <input name="auth" value="1" hidden/>
                <div class="mb-3">
                    <input class="form-control" type="text" placeholder="<?=lang('register', 'login')?>" value="<?=$user->login?>">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="email" name="email" placeholder="<?=lang('register', 'email')?>" value="<?=$user->email?>">
                </div>
                <div class="mb-3">
                    <!-- <input class="form-control" type="password" name="pass" placeholder="<?=lang('register', 'pass')?>" required> -->
                </div>
                <div class="mb-3">
                    <input class="form-control" type="date" placeholder="<?=lang('register', 'dateRegister')?>" value="<?=eDate($user->date_create, 'Y-m-d')?>">
                </div>
                <div class="mb-3">
                    <!-- <input class="btn btn-primary" type="submit" value="<?=lang('global', 'login')?>"> -->
                </div>
            </form>
        </div>
    </div>
</block>