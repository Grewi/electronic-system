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
                            <input type="email" class="form-control <?= $return->class->email ?>" name="email" placeholder="email" value="<?= $return->data->email ?>">
                            <div class="invalid-feedback"><?= $return->error->email ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->password ?>" name="password" placeholder="password">
                            <div class="invalid-feedback"><?= $return->error->password ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->login ?>" name="login" placeholder="login" value="<?= $return->data->login ?>">
                            <div class="invalid-feedback"><?= $return->error->login ?></div>
                        </div>
                        <div class="mb-3 form-check">
                            <input id="active" type="checkbox" class="form-check-input" name="active" value="1" checked>
                            <label for="active">active</label>
                        </div>
                        <div class="mb-3">
                            <select name="user_role_id" class="form-select <?= $return->class->user_role_id ?>">
                                <option disabled selected>Роль пользователя</option>
                                <?php foreach ($userRoles as $role) : ?>
                                    <option value="<?= $role->id ?>"><?= $role->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $return->error->user_role_id ?></div>
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