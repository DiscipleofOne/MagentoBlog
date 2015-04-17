<?php

class TSA_Blog_Helper_Images extends Mage_Core_Helper_Abstract
{
    public function resizeImg($fileName, $width, $height = null)
    {
        if ($fileName) {
            $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);

            $imageURL = $folderURL . $fileName;

            $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . $fileName;

            $tempPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . "resized" . DS . $fileName;

            $explodedPath = explode(".",$tempPath);

            $explodedPath[count($explodedPath)-2] .= '_' . $width;


            $newPath = implode(".",$explodedPath);

            $tempPath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)  . "resized" . DS . $fileName;

            $explodedPath = explode(".",$tempPath);

            $explodedPath[count($explodedPath)-2] .= '_' . $width;

            $newUrl = implode (".", $explodedPath);

            //if width empty then return original size image's URL
            if ($width) {

                //if image has already resized then just return URL

                if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {

                    $imageObj = new Varien_Image($basePath);

                    $imageObj->constrainOnly(TRUE);

                    $imageObj->keepAspectRatio(FALSE);

                    $imageObj->keepFrame(FALSE);

                    $imageObj->quality(100);

                    $imageObj->resize($width, $height);

                    $imageObj->save($newPath);

                }
                $resizedURL = $newUrl;
            } else {
                $resizedURL = $imageURL;
            }
            return $resizedURL;
        }
        return $fileName;
    }
}