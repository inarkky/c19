<!DOCTYPE html>
<html>

<head>
    <?php include_once(HEAD) ?>
    <?php include_once(CSS_INCLUDES) ?>
    <?php include_once(JS_INCLUDES) ?>
</head>

<body class="theme-teal">
    <?php include_once(HEADER) ?>
    <?php include_once(SIDEBAR) ?>

    <section class="content">
        <div class="container-fluid">
            <?php echo $content; ?>
        </div>
    </section>
    
</body>

</html>