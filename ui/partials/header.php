<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <?php // Check if there are multiple CSS files to include
    if (isset($css) && is_array($css)): ?>

        <?php foreach ($css as $cssFile): ?>
            <link rel="stylesheet" href="<?= $cssFile ?>">
        <?php endforeach; ?>

    <?php else: ?>
        <link rel="stylesheet" href="<?= $css ?>">
    <?php  endif;?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        @font-face {
            font-family: 'Times';
            src: url('font/Times.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <?php if ($title === "Create Post" ) : ?>
        <script src="https://cdn.tailwindcss.com"></script>
    <?php  endif;?>
</head>

<body>
