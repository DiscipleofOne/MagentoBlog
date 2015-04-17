<?php

class TSA_Blog_Model_Resource_Comment extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tsa_blog/comment', 'comment_id');
    }

}