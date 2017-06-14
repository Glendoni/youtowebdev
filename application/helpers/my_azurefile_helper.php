<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
require_once 'Azure/vendor/autoload.php';
use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\ServiceException;



function asset_upload(){

// Create blob REST proxy.

//$connectionString = "DefaultEndpointsProtocol=[http|https];AccountName=[yourAccount];AccountKey=[yourKey]";
// Create blob REST proxy.
return  ServicesBuilder::getInstance()->createBlobService(getenv('FILE_UPLOAD_STORAGE_AZURE'));


}

function uploadBlob($blob, $blob_name = "test"){
        $blobRestProxy  = asset_upload();
    $content =  $blob;
 

try    {
    //Upload blob
    $blobRestProxy->createBlockBlob("baselist", $blob_name, $content);
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}
    
    
}

function getfile($fileToGet){
    $blobRestProxy  = asset_upload();
    try    {
    // Get blob.
    $blob = $blobRestProxy->getBlob("baselist", $fileToGet);
    return $blob->getContentStream();
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}
    
}


function list_files(){
$blobRestProxy  = asset_upload();
    try    {
        // List blobs.
        $blob_list = $blobRestProxy->listBlobs("baselist");
        $blobs = $blob_list->getBlobs();

        foreach($blobs as $blob)
        {
           $a[$blob->getName()] = $blob->getUrl();
        }
        
       

$json = json_encode($a);
 echo $json_beautified = str_replace(array("{", "}", '","'), array("{<br />&nbsp;&nbsp;&nbsp;&nbsp;", "<br />}", '",<br />&nbsp;&nbsp;&nbsp;&nbsp;"'), $json);

    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
    }
    
 