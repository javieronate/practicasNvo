<?php
/**
 *
 * Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit, S.C. / Dédalo (http://hasselbit.com)
 *
 * @author Javier Oñate Mendía (Dédalo)
 *
 */

?>


<!DOCTYPE html>
<html>
<head>
	<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
	<title>How to Create textarea into a rich content/text editor using jQuery</title>
	<script type="text/javascript" src="nicEdit-latest.js"></script>

</head>
<body>
<form action ="llenadoPracticas.php" method="post" name ="<?php echo (NOMBRE_FORMULARIO);?>" target="_self" enctype="multipart/form-data">
	<h4>How to Create textarea into a rich content/text editor using jQuery</h4>
	<div id="sample">
	  <h4>Simple textarea</h4>
	  <textarea name="area" id="area" style="width:70%;height:200px;">
		Some Initial Content was in this textarea
	</textarea>
	  <h4>textarea with complete panel</h4>
	  <textarea name="area1" id="area1" style="width:70%;height:200px;">
		Some Initial Content was in this textarea
	</textarea>
	</div>
</form>
</body>
</html>