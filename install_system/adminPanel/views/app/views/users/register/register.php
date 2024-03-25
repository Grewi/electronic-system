<use layout="index" />

<block name="index">
    <div class="container">
        <div class="register-form mt-1">
            <form class="r-f" method="post">
                <csrf type="input" name="register">
                <div class="mb-3 r-a">
                    <input class="form-control <?=$data->class->login?>" type="text" name="login" placeholder="<?=lang('register', 'login')?>"  value="<?=$return->data->login?>">
                    <div class="invalid-feedback"><?=$data->error->login?></div>
                </div>
                <div class="mb-3">
                    <input class="form-control <?=$data->class->login?>" type="text" name="loginUser" placeholder="<?=lang('register', 'login')?>" required value="<?=$return->data->login?>">
                    <div class="invalid-feedback"><?=$data->error->login?></div>
                </div>
                <div class="mb-3 r-a">
                    <input class="form-control <?=$data->class->email?>" type="email" name="email" placeholder="<?=lang('register', 'email')?>"  value="<?=$return->data->email?>">
                    <div class="invalid-feedback"><?=$data->error->email?></div>
                </div>
                <div class="mb-3">
                    <input class="form-control <?=$data->class->email?>" type="email" name="emailUser" placeholder="<?=lang('register', 'email')?>" required value="<?=$return->data->email?>">
                    <div class="invalid-feedback"><?=$data->error->email?></div>
                </div>                
                <div class="mb-3">
                    <input class="form-control <?=$data->class->pass?>" type="password" name="pass" placeholder="<?=lang('register', 'pass')?>" required value="<?=$return->data->pass?>">
                    <div class="invalid-feedback"><?=$data->error->pass?></div>
                </div>
                <div class="mb-3">
                    <input class="form-control <?=$class_confirm?>" type="password" name="confirm" placeholder="<?=lang('register', 'confirm')?>" required >
                    <div class="invalid-feedback"><?=$data->error->confirm?></div>
                </div>
                <div class="mb-3">
                    <input class="btn btn-primary" type="submit" value="<?=lang('register', 'register')?>">
                </div>
            </form>
        </div>
    </div>
</block>