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
    <meta property="description" content="Andr&eacute;s Villarreal, Software Engineer"/>
    <meta property="keywords" content="Software Engineer, Frontend Developer, Software Development, Open Source, Web Developer"/>
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
                        <li>
                            <a class="<?php echo $p['default']; ?>" href="#<?php echo $p['id']; ?>">
                                <?php echo $p['title']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <?php foreach ($sections as $i => $p): if ($i === 'info') continue; ?>
            <section class="content <?php echo $p['default'] ? 'default' : ''; ?> <?php echo $p['id']; ?>">
                <a name="<?php echo $p['id']; ?>"></a>
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
                <li><a href="https://soundcloud.com/try_andy/tracks">SoundCloud</a></li>
                <li><a href="https://tryandy.bandcamp.com/">Bandcamp</a></li>
            </ul>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
    function getNavLinks() {
        return $navlinks = $('.nav a');
    }
    function setHash(str) {
        if (history.pushState) {
            history.replaceState(null, null, str);
        } else {
            window.location.hash = str;
        }
    }
    function showSection(href, immediate) {
        var $navLinks = getNavLinks();
        var $content = $('.content.' + href.replace('#', ''));
        $navLinks.removeClass('current');
        $navLinks.filter('[href="' + href + '"]').addClass('current');
        var animationTime = immediate ? 0 : 500;
        $('section.content').not($content).hide();
        $content.fadeIn(animationTime);
        if (window.location.hash !== href) {
            setHash(href);
        }
    }

    $(function () {
        var hash = window.location.hash;
        if (hash) {
            showSection(hash, true);
        }
        getNavLinks().on('click', function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            showSection(href);
        });
    });
    
</script>

<noscript>
    <style type="text/css">section.content {display: block; margin-bottom: 2em;}</style>
</noscript>
</body>
</html>
