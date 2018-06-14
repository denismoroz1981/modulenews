<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 13.06.18
 * Time: 19:17
 */

define('MAXSIZE',30000);

function checkProhibited ($name)
{
    $errMsg="";
    $allowed = ["jpg", "jpeg", "png", "giff"];
    $nameParts=pathinfo($name);
    if (!in_array($nameParts["extension"],$allowed)) {
        $errMsg.="File {$name} has not been uploaded as having prohibited extension - {$nameParts["extension"]}. Allowed extensions are: ".
            print_r(implode(", ",$allowed),1).'. '.PHP_EOL;}
    return $errMsg;
}

$layout = '<br><p><b>Upload file for news '.$_GET["id"].'</b></p>
            <form enctype="multipart/form-data" action="" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="'.MAXSIZE.'">';

//for ($i=1;$i<=$this->numOfFiles;$i++) {
    $layout.='<input type="file" name="userfile">';
//}

$layout.='<input type="submit" value="Upload files"></form>';

echo $layout;


$uploadDIR = __DIR__ ."/../img/". DIRECTORY_SEPARATOR . $_GET["id"];
echo '<br>'.$uploadDIR;

        if (!empty($_FILES)) {
            //foreach ($_FILES["userfile"]["error"] as $key => $error)
            $errMsg="";
            try {
                if ($_FILES["userfile"]["error"] == 2) {
                    throw new Exception("<i>File {$_FILES["userfile"]["name"]} has not been uploaded as exceeds 
                        {$_POST["MAX_FILE_SIZE"]} bytes.</i><br>");

                }

                if ($_FILES["userfile"]["error"] == UPLOAD_ERR_OK) {

                    $tmp_name = $_FILES["userfile"]["tmp_name"];
                    $name = basename($_FILES["userfile"]["name"]);
                    $isProhibited = checkProhibited($name);
                    if (!empty($isProhibited)) {
                        throw new Exception($isProhibited);
                    }

                    //if (!file_exists($uploadDIR)) {
                      //  mkdir($uploadDIR, 0777, true);
                    //}
                    if (!file_exists($uploadDIR)) {
                        move_uploaded_file($tmp_name, $uploadDIR);
                    } else {
                        throw new Exception("<i>File {$_FILES["userfile"]["name"]}
                            has not been uploaded twice.</i><br>");
                    }
                    $errMsg.="<i>File {$_FILES["userfile"]["name"]} has been uploaded successfully.</i><br>";
                } else {
                    throw new Exception("<i>File {$_FILES["userfile"]["name"]} has not been
                        uploaded due to error {$_FILES["userfile"]["error"]}.</i><br>");
                }
            } catch (Exception $e) {echo $e->getMessage();}
            echo $errMsg;
        }
