<?php
$emp_ses_username_RS_user_detail = "-1";
  $emp_ses_username_RS_user_detail = $_SESSION['dU']['NAME'];
$query_RS_user_detail = "SELECT * FROM db_user_system WHERE user_username='".$emp_ses_username_RS_user_detail."'";
$RS_user_detail = mysqli_query(conn,$query_RS_user_detail) or die(mysqli_error(conn));
$row_RS_user_detail = mysqli_fetch_assoc($RS_user_detail);
$totalRows_RS_user_detail = mysqli_num_rows($RS_user_detail);
$datausr=dataUser($emp_ses_username_RS_user_detail);
$dataemp=dataEmp($datausr['emp_cod']);
?>
<table align="center">
<tr>
	<td><!--Contenidos Head-->
		<table align="right">
        	<tr>
            	<td align="left" class="text_sec_blue_min2">Username:</td>
                <td align="left" class="text_sec_gray_min"><strong><?php echo $datausr['user_username']; ?></strong></td>
			</tr>
            <tr>
            	<td align="left" class="text_sec_blue_min2">Nombres:</td>
                <td align="left" class="text_sec_gray_min"><?php echo $dataemp['emp_nom'].' '.$dataemp['emp_ape']; ?> <?php echo $row_RS_user_detail['emp_ape']; ?></td>
			</tr>
            <tr>
            	<td align="left" class="text_sec_blue_min2">Acceso:</td>
                <td align="left" class="text_sec_gray_min"><?php echo $_SESSION['data_access']; ?></td>
			</tr>
	</table>
    </td>
    <!--Foto Usuario-->
    <td>
    	<a href="<?php fncImgExist($pathimag_db_emp,$row_RS_user_detail['emp_img']) ; ?>" rel="shadowbox">
        <img src="<?php fncImgExist($pathimag_db_emp,$row_RS_user_detail['emp_img']) ; ?>" height="65" />
        </a>
	</td>
</tr>
</table>
<?php
mysqli_free_result($RS_user_detail);
?>