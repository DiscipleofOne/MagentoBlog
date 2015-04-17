<?php

class TSA_Blog_Adminhtml_Tsa_Blog_CommentController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Blog'));

        $this->loadLayout();

        $this->_setActiveMenu('tsa_blog/tsa_blog');

        $this->renderLayout();
    }
}