<?php
    require_once("../php/config.php")

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>play</title>
    <link href="web/videojs/video-js.css" rel="stylesheet">
    <link href="web/videojs/video-js-custom.css" rel="stylesheet">
    <script src="web/videojs/video.js"></script>
</head>
<body>
    <?php include("../nav.php") ?>

    <video class="video-js" controls preload="auto" width="640" height="268" data-setup="{}" >
        <source src="<?php echo generateResourceUrl("/test.mp4") ?>" type="video/mp4">
    </video>


    <input type="text"><button id="bg-submit">提交</button>

    <textarea></textarea><button id="cm-submit">提交</button>


    <script src="web/js/page.js"></script>
</body>
</html>