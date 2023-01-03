<?php
$responseText="";
?>

<!DOCTYPE html>
<html lang="se">
<head>
	<style>
		.container {
			width: 500px;
			height: 250px;
			margin: 50px;
			padding-left: 10em;
			padding-right: 10em;
			padding-top:2em;
			padding-bottom:2em;
		}


		table {
			border-collapse: collapse;
			width: 50em;
		}

		tr {
		}
		td {
			padding: 2px;
			border: 1pt solid silver;
		}
	</style>
</head>
<body>
<div class="container">

<h1>Upload your friends</h1>
<h3>They all want flowers on their very special day.</h3>
<p>Upload your file here.</p>
<form id="upload" enctype="multipart/form-data" method="post" action="">
    <p>
        <input type="hidden" name="fileIsUploaded" value="upload" />
        <label for="fileupload">Upload file:<sup>*</sup></label>
        <input id="fileToUpload" name="fileToUpload" type="file" />
        <input type="submit" value="Start Upload" id="submit" />
    </p>

</form>
<form id="export"  method="get" action="">
	<p>
		<input type="hidden" name="export" value="export" />
		<input type="submit" value="Export" id="submit" />
	</p>

</form>
	<?php if(true === isset($users)) {
		include 'users_table.html.php';
	}
	?>

</div>
</body>
</html>



