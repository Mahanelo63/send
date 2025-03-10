<?php 
require_once('database.php');
$db=$conn; // Enter your Connection variable;
$tableName='files'; // Enter your table Name;
$value='files'; // Enter your table Name;

// fetching files from database
$fetchFiles=fetch_files($tableName);
// uploading files on submit
if(isset($_POST['submit'])){ 
    //  uploading files
    echo upload_files($tableName); 
}
  function upload_files($tableName){
   
    $uploadTo = "uploads/"; 
    $allowFileExt = array('jpg','png','jpeg','gif','pdf','doc','csv','zip');
    $fileName = array_filter($_FILES['file_name']['name']);
    $fileTempName=$_FILES["file_name"]["tmp_name"];
    $tableName= trim($tableName);
    if(empty($fileName)){ 
       $error="Please Select files..";
       return $error;
     }else if(empty($tableName)){
       $error="You must declare table name";
       return $error;
     }else{
    
     $error=$storeFilesBasename='';
    foreach($fileName as $index=>$file){
         
    $fileBasename = basename($fileName[$index]);
    $filePath = $uploadTo.$fileBasename; 
    $fileExt = pathinfo($filePath, PATHINFO_EXTENSION); 
    if(in_array($fileExt, $allowFileExt)){ 
        // Upload file to server 
        if(move_uploaded_file($fileTempName[$index],$filePath)){ 
         $uploadTo = "uploads/".$fileBasename;
         // Store Files into database table
         $storeFilesBasename =$filePath ; 
; 
             $uploadTo = "uploads/".$fileBasename;
			 store_files($storeFilesBasename, $tableName);
         }else{ 
         $error = 'File Not uploaded ! try again';
         } 
     }else{
       $error .= $_FILES['file_name']['name'][$index].' - file extensions not allowed<br> ';
     }
    }  header("location: index.php");
    
  }
    return $error;
}
    // File upload configuration 
    function store_files($storeFilesBasename, $tableName){
      global $db;
      if(!empty($storeFilesBasename))
      {$value=$storeFilesBasename;
		      $value2=30;$value3="";
      $value = $storeFilesBasename;
       $store="INSERT INTO files (`file_name`, `propertid`) VALUES ('$value','$value2')";
      
      $exec= $db->query($store);
       if($exec){
        echo "files are uploaded successfully" ;
      
       
       }else{
        echo  "Error: " .  $store . "<br>" . $db->error;
       }
      }
    }
   
      
      // fetching padination data
function fetch_files($tableName){
   global $db;
   $tableName= trim($tableName);

}   
    
?>