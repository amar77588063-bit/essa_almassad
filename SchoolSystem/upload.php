<?php 

function upload_product_imge (string $filedname, array &$errors,?string $oldimade=null):?sring {
if (!isset($_FILES[$filedname]||$_FILES[$filedname]['error']==UPOAD_ERR_NO_FILE)){
    
return $oldimade;
}

}
$file=$_FILES[$filedname]
if



?>