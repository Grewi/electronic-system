<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Создание пользователя
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <csrf type="input" name="userCreate" />
                        <div class="mb-3">
                            <input type="email" class="form-control <?= $class_email ?>" name="email" placeholder="email" value="<?= $email ?>">
                            <div class="invalid-feedback"><?= $error_email ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_password ?>" name="password" placeholder="password">
                            <div class="invalid-feedback"><?= $error_password ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_login ?>" name="login" placeholder="login" value="<?= $login ?>">
                            <div class="invalid-feedback"><?= $error_login ?></div>
                        </div>
                        <div class="mb-3 form-check">
                            <input id="active" type="checkbox" class="form-check-input" name="active" value="1" checked>
                            <label for="active">active</label>
                        </div>
                        <div class="mb-3">
                            <select name="user_role_id" class="form-select <?= $class_user_role_id ?>">
                                <option disabled selected>Роль пользователя</option>
                                <?php foreach ($userRoles as $role) : ?>
                                    <option value="<?= $role->id ?>"><?= $role->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $error_user_role_id ?></div>
                        </div>
                        <div class="mb-3">
                            <input class="btn btn-primary" type="submit" value="Сохранить">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</block>