<?php

class TSA_Blog_Block_Comment extends Mage_Core_Block_Template
{
    public function __construct()
    {
        $this->_template = 'tsa/blog/comment/view.phtml';
        parent::__construct();
    }
}