<?php 

include_once 'static/functions/function_users.php';
$mysqli = new mysqli(mysql_server, mysql_username, mysql_password, mysql_database);

sec_session_start(); 
if(login_check($mysqli) == true) {
    $loggedIn = true;
} else { 
    $loggedIn = false;
}

?>
<?php if($loggedIn): ?>
	<html>
	    <head>
	    	<script type="text/javascript" src="../static/js/jquery-1.11.0.min.js" name="jQuery"></script>
            <?php 

	    		if($_POST["filetype"] == 'image'){
					$fileType = 'image';
	    		}elseif($_POST["filetype"] == 'scene'){
					$fileType = 'scene';
				}elseif($_POST["filetype"] == 'object'){
					$fileType = 'object';
	    		}else{
					$fileType = 'image';
	    		}

                if(count($_POST) > 0 && $_POST['yesseriouslydelete'] != 1 && isset($_POST['obliterate'])){
                    echo 'Are you seriously effing sure you want to delete <span style="font-weight:bold;">' . $_POST["obliterate"] . '</span>?';
                    echo '<form name="fileKiller" action="" method="POST">';
                    echo '<input type="text" title="yesseriouslydelete" name="yesseriouslydelete" value="1" hidden >';
                    echo '<input type="text" value=' . $_POST["obliterate"] . '" name="obliterate" hidden >';
                    echo '<input type="text" value=' . $_POST["filetype"] . '" name="filetype" hidden >';
                    echo '<input type="submit" value="YES DELETE!">';
                    echo '</form>';
				}elseif(count($_POST) > 0 && $_POST['yesseriouslydelete'] == 1 && isset($_POST['obliterate'])){
					$fileToKill = preg_replace('/[^A-Za-z0-9-.\/\_]/', '', $_POST['obliterate']);
					if(!unlink($fileToKill)){
                		echo 'Nope. There was a problem deleting <span style="font-weight:bold;">' . $fileToKill . '</span>';
					}else{
                		echo 'Ok, I deleted <span style="font-weight:bold;">' . $fileToKill . '</span>';
					}
                }
    		
    		?>
	    </head>
	    <body>
	    	<hr>
            <h1>Resource Manager (<?php echo ucwords($fileType) . 's'; ?>)</h1>
            <hr>
	            <?php
	            	if(count($_FILES) > 0){
						$allowedExts = array("gif", "jpeg", "jpg", "png", "js", "obj");
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);

						if(in_array($extension, $allowedExts)){
							if ($_FILES["file"]["error"] > 0){
							    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
							}else{
						    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
						    echo "Type: " . $_FILES["file"]["type"] . "<br>";
						    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
						    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

						    if (file_exists("resources/" . $fileType . "s/" . $_FILES["file"]["name"])){
						      echo $_FILES["file"]["name"] . " already exists. ";
						    }else{
						      move_uploaded_file($_FILES["file"]["tmp_name"],
						      "resources/" . $fileType . "s/" . $_FILES["file"]["name"]);
						      echo "Stored in: " . "resources/" . $fileType . "s/" . $_FILES["file"]["name"];
						      }
						    }
						}else{
							echo "Invalid file";
						}
					}
				?>
 				<form action="" method="POST" id="filetypeForm">
					<fieldset>
						<legend>File Type</legend>
						<input type = "radio"
						     name = "filetype"
						     id = "imageRadio"
						     value = "image"
						     <?php
						     	if($fileType == 'image'){
						     		echo 'checked = "checked"';
						     	}
						     ?>
						     />
						<label for = "sizeSmall">Image</label>

						<input type = "radio"
						     name = "filetype"
						     id = "sceneRadio"
						     value = "scene"
						     <?php
						     	if($fileType == 'scene'){
						     		echo 'checked = "checked"';
						     	}
						     ?>
						     />
						<label for = "sizeMed">Scene</label>

						<input type = "radio"
						     name = "filetype"
						     id = "objectRadio"
						     value = "object"
						     <?php
						     	if($fileType == 'object'){
						     		echo 'checked = "checked"';
						     	}
						     ?>
						     />
						<label for = "sizeLarge">Object</label>
					</fieldset>
				</form>
			<fieldset>
				<?php
					$dirBuild = 'resources/' . $fileType . 's/';
					echo '<legend>' . 'resources/' . $fileType . 's/' . '</legend>';
					$dir = new DirectoryIterator($dirBuild);
					echo '<ul>';
						foreach ($dir as $fileinfo) {
						    if (!$fileinfo->isDot()){
						    	echo '<li>' .
						    	$fileinfo->getFilename() . 
						    	' (  <a href="../' . 
					    	 	$fileinfo->getPathname() . 
					    	 	'" title="' . 
					    	 	$fileinfo->getFilename() . 
					    	 	'" target="_blank" >' . 
					    	 	$fileinfo->getPathname() . 
					    	 	'</a>  ) ' . 
						    	'<form action="" method="POST" id="deleteForm" style="display:inline;"><input type="text" value="' . 
								$fileinfo->getPathname() . 
								'" name="obliterate" hidden><input type="submit" name="submit" value="x"></form></li>';
						    }
						}
					echo '</ul>';
				?>
			</fieldset>
			<fieldset>
				<legend>Upload <?php echo ucwords($fileType);?></legend>
				<form action="" method="post" enctype="multipart/form-data">
					<label for="file">Filename:</label>
					<input type="file" name="file" id="file"><br>
					<input type="text" value="<?php echo $_POST["filetype"]; ?>" name="filetype" hidden >
					<input type="submit" name="submit" value="Submit">
				</form>
			</fieldset>
	    </body>
	    <footer>
	    	<script type="text/javascript">
		    	jQuery(document).ready(function($) {
		    		$('input[type=radio][name=filetype]').change(function() {
		    			$("form#filetypeForm").submit();
				    });
				});
	    	</script>
	    </footer>
	</html>
<?php else: ?>
    <?php 
        header("Location: ../");
        exit;
    ?>
<?php endif; ?>