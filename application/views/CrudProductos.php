<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Administración Productos Copy Bily Paper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php 
        foreach($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>

        <?php foreach($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
</head>
<body>
    <?php
    echo $output; 
    ?>
    <a class="nav-link" href="<?= site_url().'/Productos/index/'?>">Volver al inicio</a>   
</body>
</html>