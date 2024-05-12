<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Новая запись 
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <csrf type="input" name="blogCreate" />
                        <input name="referal" value="<?= isset($_GET['referal']) ? $_GET['referal'] : referal_url() ?>" hidden>

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->title ?>" name="title" placeholder="title" value="<?= $return->data->title ?>">
                            <label for="">Title</label>
                            <div class="invalid-feedback"><?= $return->error->title ?></div>
                        </div>
                        <div class="mb-3">


                            <?php
                            function categoriesTree($arr, $return)
                            {
                                $str = '<ul>';
                                foreach ($arr as $i) {
                                    $checked = $return->data->category_id == $i->id ? 'checked' : '';
                                    $str .= '<li>
<div class="form-check form-switch">
  <input class="form-check-input" type="radio" role="switch" id="cat' . $i->id . '" name="category" value="' . $i->id . '" ' . $checked . '>
  <label class="form-check-label" for="cat' . $i->id . '">' . $i->name . '</label>
</div>
</li>';
                                    if ($i->children) {
                                        $str .= categoriesTree($i->children, $return);
                                    }
                                }
                                $str .= '</ul>';
                                return $str;
                            }
                            ?>
                            <?= categoriesTree($categoriesTree, $return); ?>
                        </div>
                        <div class="mb-3">
                            <?php foreach ($blogTags as $tag) : ?>
                                <label class="btn btn-sm btn-light" for="tag<?= $tag->id ?>">
                                    <?php $checked = (new \app\models\blog_tag)->where('blog_id', $return->data->id)->where('tag_id', $tag->id)->get() ? 'checked' : '' ?>
                                    <input id="tag<?= $tag->id ?>" type="checkbox" name="tag[<?= $tag->id ?>]" value="<?= $tag->id ?>" <?= $checked ?>>
                                    <?= $tag->name ?></label>
                            <?php endforeach; ?>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->description ?>" name="description" placeholder="description" value="<?= $return->data->description ?>">
                            <label for="">Description</label>
                            <div class="invalid-feedback"><?= $return->error->description ?></div>
                        </div>

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->url ?>" name="url" placeholder="url" value="<?= $return->data->url ?>">
                            <label for="">Url</label>
                            <div class="invalid-feedback"><?= $return->error->url ?></div>
                        </div>

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->name ?>" name="name" placeholder="name" value="<?= $return->data->name ?>">
                            <label for="">Name</label>
                            <div class="invalid-feedback"><?= $return->error->name ?></div>
                        </div>

                        <div class="mb-3 form-check">
                            <?php $checked = $return->data->active == 1 ? 'checked' : ''; ?>
                            <input id="active" type="checkbox" class="form-check-input" name="active" value="1" <?=$checked?>>
                            <label for="active">active</label>
                        </div>

                        <div class="mb-3">
                            <textarea id="contentBlog" class="form-control" name="content" rows="20"><?= $return->data->content ?></textarea>
                        </div>
                        <?php if ($images && count($images) > 0) : ?>
                            <div class="mb-3 row">
                                <?php foreach ($images as $i) : ?>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="/images/thumbnail/mini/<?= $i->id ?>.png" class="card-img-top" alt="">
                                            <div class="card-body">
                                                <div class="mb-3 d-flex justify-content-between">
                                                    <div class="form-check mb-3">
                                                        <input id="imgBlog<?= $i->id ?>" type="radio" name="image" value="<?= $i->id ?>" <?= $i->id == $return->data->image_id ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="imgBlog<?= $i->id ?>">Обложка</label>
                                                    </div>
                                                    <div>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Ссылки
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                <?php foreach ($imagesSizes as $s) : ?>
                                                                    <li>
                                                                        <input class="dropdown-item form-control form-control-sm" type="text" value="/images/thumbnail/<?= $s->slug ?>/<?= $i->id ?>.png">
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <a class="btn btn-danger btn-sm" href="/admin/images/delete/<?= $i->id ?>?referal=/admin/blogs/edit/<?= $return->data->id ?>">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Добавить изображение</label>
                            <input class="form-control" type="file" name="image">
                        </div>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" name="telegram" type="checkbox" value="1" id="telegram">
                            <label class="form-check-label" for="telegram">
                                Отправить в телеграм
                            </label>
                        </div>
                        <div class="mb-3">
                            <input class="btn btn-primary" type="submit" value="Сохранить">
                            <input class="btn btn-primary" type="submit" name="save_and_next" value="Сохранить и продолжить">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/admin/lessons/img');

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({
                        message: 'HTTP Error: ' + xhr.status,
                        remove: true
                    });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        });

        tinymce.init({
            selector: '#contentBlog',
            language: 'ru',
            plugins: 'code, codesample, lists, image, link, visualblocks, table, fullscreen',
            toolbar: [`undo redo styleselect bold italic alignleft aligncenter alignright alignjustify | 
            bullist numlist outdent indent image link visualblocks forecolor backcolor fontsizeinput blocks, fullscreen`,
                `table tabledelete | tableprops tablerowprops tablecellprops | 
            tableinsertrowbefore tableinsertrowafter tabledeleterow | 
            tableinsertcolbefore tableinsertcolafter tabledeletecol`
            ],
            images_upload_handler: example_image_upload_handler,
            relative_urls: false,
        });
    </script>
</block>