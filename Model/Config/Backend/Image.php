<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Acme (https://www.acmewebtechnology.com/)
 * @package Acme_Newsletterpopup
 */
namespace Acme\Newsletterpopup\Model\Config\Backend;

use Magento\Config\Model\Config\Backend\Image as BackendImage;

class Image extends BackendImage
{
    /**
     * The path where the image will be saved.
     */
    const UPLOAD_DIR = 'myfolder';

    /**
     * Save the uploaded image.
     *
     * @return $this
     */
    public function afterSave()
    {
        $value = $this->getValue();
        if (is_array($value) && isset($value['value'])) {
            $file = $value['value'];
            if ($file && isset($file[0]['name'])) {
                $uploader = $this->_getUploader();
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $path = $this->_getUploadDir() . '/' . $file[0]['name'];
                $uploader->save($this->_getUploadDir(), $file[0]['name']);
                $this->setValue(self::UPLOAD_DIR . $path);
            }
        }

        return parent::afterSave();
    }

    /**
     * Get the upload directory.
     *
     * @return string
     */
    protected function _getUploadDir()
    {
        return $this->_mediaDirectory->getAbsolutePath(self::UPLOAD_DIR);
    }
}
