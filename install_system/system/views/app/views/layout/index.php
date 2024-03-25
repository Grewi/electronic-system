<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <meta property="og:title" content="<?= $title ?>">
<?php if (isset($meta_description) && !empty($meta_description)) : ?>
    <meta property="og:description" content="<?= $meta_description ?>">
    <meta name="description" content="<?= $meta_description ?>">
<?php endif; ?>
<?php if (isset($meta_images) && !empty($meta_images)) : ?>
    <meta property="og:image" content="<?=$meta_images?>">
<?php endif; ?>
<?php if(isset($meta_url) && !empty($meta_url)): ?>
<meta property="og:url" content="<?=$meta_url?>">
<?php endif; ?>
</head>

<body>
    <block name="index" />
</body>
</html>