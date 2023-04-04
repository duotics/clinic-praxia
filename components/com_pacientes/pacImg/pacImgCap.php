<?php include_once('../../../init.php') ?>
<?php include_once(RAIZf . 'head.php') ?>
<link rel="stylesheet" href="style.css">
<div class="layout">
  <div id="newImages"></div>
  <input type="hidden" id="idPacPic" value="<?php echo $id ?>">
  <div class="row">
    <div class="col-sm-6">
      <video id="player" autoplay></video>
    </div>
    <div class="col-sm-6">
      <canvas id="canvas" width="512px" height="288px"></canvas>
    </div>
  </div>
  <div class="center">
    <button class="btn btn-primary" id="capture-btn">Capture</button>
  </div>
  <div id="pick-image">
    <label>Video is not supported. Pick an Image instead</label>
    <input type="file" accept="image/*" id="image-picker">
  </div>
</div>
<!--<script src="script.js"></script>-->