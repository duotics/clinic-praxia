<?php require('../../../init.php');
$id = $_REQUEST['id'];
include(root['f'] . 'head.php'); ?>

<h1>SUBIR IMAGEN <?php echo $id ?></h1>
<div id="imagecapture_container">
    <div id="capture_main" class="capture_cont" align="center">
        <h2>Cargar una Imagen</h2>
        <div style="padding:0 5px;">
            <form id="dataForm" name="dataForm">
                <input name="imageDescription" type="hidden" id="imageDescription" value="<?php echo $id ?>" size="30" />
            </form>
            <form id="imageForm" name="imageForm" enctype="multipart/form-data" action="pacImgUplServ.php" method="POST" target="uploadedImage">
                <input name="idpac" type="hidden" value="<?php echo $id ?>" />
                <!-- Next field limits the maximum size of the selected file to 2MB.
           If exceded the size, an error will be sent with the file. -->
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                <input name="imageToUpload" id="imageToUpload" type="file" onchange="uploadImage();" size="30" value="" />
                <input name="oldImageToDelete" type="hidden" disabled="disabled" id="oldImageToDelete" size="50" />
            </form>
            <form>
                <input type="button" onclick="submitForm();" value="GUARDAR" style="background:#036; color:#FFF; padding:4px; margin:4px; border:1px solid #333; font-weight:bold;" />
            </form>
        </div>
        <div id="divResult"></div>
    </div>
    <div id="capture_result" class="capture_cont">
        <iframe id="uploadedImage" name="uploadedImage" src="" style="width:320px; height:280px" frameborder="0" marginheight="0" marginwidth="0" scrolling="auto"></iframe>
    </div>
</div>