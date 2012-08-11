<?php

include_once(dirname(__FILE__)."/ResourceService.php");

class FileUploader
{
    const API_RESOURCE_BASE_URL = 'resourceservice.local';
    const API_RESOURCE_ERROR = 'ERROR';

    private static function getFileInfo($fieldName)
    {
        return CUploadedFile::getInstanceByName($fieldName);
    }
    
    public static function hasFile($fieldName)
    {
        return (self::getFileInfo($fieldName) != null);
    }

    public static function uploadFile($fieldName)
    {
        $fileInfo = self::getFileInfo($fieldName);
        if ($fileInfo == null)
            return null;
        
        $service = new ResourceService(self::API_RESOURCE_BASE_URL);
        $result = $service->uploadFile($fileInfo->getTempName(), $fileInfo->getName());
        
        if ($result == self::API_RESOURCE_ERROR)
            return null;
        
        return $result;
    }

    public static function uploadFileLocal($fieldName, $fileName = null)
    {
        $fileInfo = self::getFileInfo($fieldName);
        if ($fileInfo === null)
            return null;

        // Upload all file to storage directory. Its temporary.
        $type = 'files';
        $uploadedFileName = ($fileName == null ? $fileInfo->getName() : $fileName);
        $dstPath = FileUploader::getStorageDirectory($type) . $uploadedFileName;

        if (!$fileInfo->saveAs($dstPath))
            return null;
        
        return $type.'/'.$uploadedFileName;
    }

    // Static functions
    public static function getStorageDirectory($type = 'files', $createIfNotExists = true)
    {
        $type = trim($type);
        if (strlen($type) > 0)
            $type .= '/';

        $path = $_SERVER['DOCUMENT_ROOT'].'/storage/'.$type;
        if (!file_exists($path) && $createIfNotExists)
            mkdir($path);
        
        return $path;
    }
}