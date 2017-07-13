﻿<?php require_once("../php/global.php") ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset=utf-8 />
  <title>Video.js Example Embed</title>

  <link href="videojs/video-js.css" rel="stylesheet">
  <link href="videojs/video-js-custom.css" rel="stylesheet">
  <script src="videojs/video.js"></script>
  <style></style>
</head>
<body>
<?php include("../nav.php") ?>
<h1>Video.js Example Embed</h1>
<video id="video_1" class="video-js" controls preload="auto" width="640" height="268" data-setup="{}" >
  <source src="<?php echo generateResourceUrl("/test.mp4") ?>" type="video/mp4">
</video>





</body>
</html>