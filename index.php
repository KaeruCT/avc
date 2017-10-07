<?php
    $langs = array('en' => 'English', 'es' => 'Espa&ntilde;ol');
    $lang = isset($_GET['es']) ? 'es' : 'en';
    $dir = __DIR__.'/'.$lang.'/';
    $sections = array();
    $files = array_diff(scandir($dir), array('.', '..'));
    sort($files);

    foreach ($files as $file) {
        $lines = file($dir.$file);
        $file = substr($file, strpos($file, '.')+1);
        $sections[$file] = array(
            'id' => $file,
            'title' => array_shift($lines),
            'content' => join('', $lines),
            'default' => ($file === 'cv' ? 'current' : '')
        );
    }
?>
<!doctype html>
<html lang="<?php echo $lang; ?>">
<head>
    <title>Andr&eacute;s Villarreal</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
</head>
<body>

<div id="page-container">
    <div id="language-switcher">
        <?php foreach ($langs as $i => $l): ?>
            <a <?php echo ($lang === $i ? 'class="current"' : ''); ?>
                href="?<?php echo $i; ?>"><?php echo $l; ?></a>
        <?php endforeach; ?>
    </div>
    <div id="content">
        <section class="main">
            <h1>Andr&eacute;s Villarreal</h1>

            <img src="./img/face.jpg" class="face" alt="face">

            <div class="info">
                <h2><?php echo $sections['info']['title']; ?></h2>
                <?php echo $sections['info']['content']; ?>
                <ul class="nav links">
                    <?php foreach ($sections as $i => $p): if ($i === 'info') continue; ?>
                        <li><a class="<?php echo $p['default']; ?>"
                            data-title="<?php echo $p['id']; ?>"
                            href="#">
                            <?php echo $p['title']; ?>
                        </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <?php foreach ($sections as $i => $p): if ($i === 'info') continue; ?>
            <section class="content <?php echo $p['default'] ? 'default' : ''; ?> <?php echo $p['id']; ?>">
                <h2><?php echo $p['title']; ?></h2>
                <?php echo $p['content']; ?>
            </section>
        <?php endforeach; ?>

        <div class="clear"></div>
    </div>
</div>

<footer>
    <div class="inner-footer">
        <div>
            <p>
                &copy; villarreal.co.cr <?php echo date('Y'); ?>
            </p>
            <ul class="links">
                <li><a href="http://twitter.com/KaeruCT">Twitter</a></li>
            </ul>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
    var $navlinks = $('[data-title]');
    $navlinks.on('click', function (e) {
        var $content = $('.'+$(this).attr('data-title'));
        e.preventDefault();

        $navlinks.removeClass('current');
        $(this).addClass('current');
        $('section.content').not($content).slideUp(700);
        $content.slideDown(700);
        $('html, body').animate({
            scrollTop: $(this).offset().top
        }, 700);
    });
</script>

<noscript>
    <style type="text/css">section.content {display: block;}</style>
</noscript>
</body>
</html>
