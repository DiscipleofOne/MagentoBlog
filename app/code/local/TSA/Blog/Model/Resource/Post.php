<?php

class TSA_Blog_Model_Resource_Post extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tsa_blog/post', 'blog_id');
    }

}
