<?php  
 function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
	if(is_dir("redcap")){
       	redirect("/redcap/");
                  
	}
?>
<?php  
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
 
function dir_copy($src, $dst) { 
  
    // open the source directory
    $dir = opendir($src); 
  
    // Make the destination directory if not exist
    @mkdir($dst); 
  
    // Loop through the files in source directory
    while( $file = readdir($dir) ) { 
  
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) 
            { 
  
                // Recursively calling custom copy function
                // for sub directory 
                dir_copy($src . '/' . $file, $dst . '/' . $file); 
  
            } 
            else { 
                copy($src . '/' . $file, $dst . '/' . $file); 
            } 
        } 
    } 
  
    closedir($dir);
} 

 if(isset($_POST["btn_zip"]))  
 {  
      $output = '';  
      if($_FILES['zip_file']['name'] != '')  
      {  
           $file_name = $_FILES['zip_file']['name'];  
           $array = explode(".", $file_name);  
           $name = implode(".",explode(".", $file_name,-1));  
           $ext = end($array);  
           if($ext == 'zip')  
           {  
                $path = 'upload/';  
                $location = $path . $file_name;  
                if(move_uploaded_file($_FILES['zip_file']['tmp_name'], $location))  
                {  
                     $zip = new ZipArchive;  
                     if($zip->open($location))  
                     {  
                          $zip->extractTo($path);  
                          $zip->close();  
                     } 
                     $files = scandir($path);   
                     //$files = scandir($path . $name);  
                     //$name is extract folder from zip file  
                     foreach($files as $file)  
                     {  
                     	if ($file == "." or $file == ".." or $file == ".gitkeep" )
                     	{
                     		continue;
                     	}
                     	#echo($path.$name.'/'.$file);
                     	#echo(": ");
                     	#echo(is_dir($path.$name.'/'.$file));
                     	if(is_dir($path.$file))
                     	{
                     	if( $file == "redcap" )
                     	{
	#                     	echo($file);
	#                     	echo("<br>");
		               dir_copy($path.$file, $file);  
		               //Overwrite the database php
		               copy('config/database.php', $file.'/database.php'); 
                     	}
                     	deleteDirectory($path.$file);  
                     	}
                     	else{
                     	   //$file_ext = end(explode(".", $file));  
                          //$allowed_ext = array('jpg', 'png');  
                          //if(in_array($file_ext, $allowed_ext))  
                          //{  
                          //     $new_name = md5(rand()).'.' . $file_ext;  
                          //     $output .= '<div class="col-md-6"><div style="padding:16px; border:1px solid #CCC;"><img src="upload/'.$new_name.'" width="170" height="240" /></div></div>';  
                          //     copy($path.$name.'/'.$file, $path . $new_name);  
                          //     unlink($path.$name.'/'.$file);  
                          //}       
                          unlink($path.'/'.$file);
                       }
                     }  
                    //unlink($location);
                    redirect("/redcap/install.php");
                }  
           }  
      }  
 }  
 ?>  

 <!DOCTYPE html>  

 <html>  
 
      <head>  
           <title>BIBBOX RedCap zip Upload</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br />  
           <div class="container" style="width:500px;">  
                <h3 align="">Upload for RedCap zip file</h3><br />  
                <p>The Zip Files should be structure something like this:<br />  
                <ul>
                <li>RedCap.zip</li>
		        <ul>
		        <li>REDCap License.txt</li>
		        <li>Installation Instructions.txt</li>
		        <li>redcap</li>
				<ul>
				<li>api/</li>
				<li>edocs/</li>
				<li>...</li>
				<li>...</li>
				<li>redcap_v10.8.4/</li>
				<li>...</li>
				<li>index.php</li>
				<li>install.php</li>
				<li>...</li>
				</ul>
		        </ul>
                </ul>
                </p>
                <form method="post" enctype="multipart/form-data">  
                     <label>Please Select your RedCap Zip File</label>  
                     <input type="file" name="zip_file" />  
                     <br />  
                     <input type="submit" name="btn_zip" class="btn btn-info" value="Upload" />  
                </form>  
           </div>  
           <br />  
      </body>  
 </html>  
