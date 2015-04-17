<?php

class TSA_Blog_Model_Comment extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {

        $this->_init('tsa_blog/comment');
    }


    protected function _beforeSave()
    {
        parent::_beforeSave();

        /**
         * Perform some actions just before a brand is saved.
         */
        $this->_updateTimestamps();

        return $this;
    }

    protected function _updateTimeStamps()
    {
        $timestamp = now();
        /**
         * If we have a brand new object, set the created timestamp.
         */
        if ($this->isObjectNew()) {
            $this->setCreatedDate($timestamp);
        }

        return $this;
    }



}