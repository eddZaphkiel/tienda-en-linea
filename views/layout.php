<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edd n' dev</title>
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    
    <?php 
        include 'templates/nav.php';
        echo $content;
        include 'templates/footer.php';
    ?>
    <?php 
        echo $script ?? '';
    ?>
</body>
</html>