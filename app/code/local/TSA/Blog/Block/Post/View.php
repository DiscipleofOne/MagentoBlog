<?php

class TSA_Blog_Block_Post_View extends TSA_Blog_Block_Post
{
    public function __construct()
    {
        $this->_layout = 'tsa/blog/post/sidebar.phtml';
        parent::__construct();

        Mage::register('current_blog_post',  Mage::getModel('tsa_blog/post')->load($this->getRequest()->getParam('blog_ID')));
    }

    protected function _getBlogPostTitle()
    {
        return Mage::registry('current_blog_post')->getTitle();
    }

    protected function _getBlogPostContent()
    {
        return Mage::registry('current_blog_post')->getContent();
    }

    public function getBlogPostTitle()
    {
        return $this->_getBlogPostTitle();
    }

    public function getBlogPostContent()
    {
        return $this->_getBlogPostContent();
    }

    public function getBlogPostAuthor()
    {
        return $this->_getBlogPostAuthor();
    }

    protected function _getBlogPostAuthor()
    {
        return Mage::registry('current_blog_post')->getAuthor();
    }

    public function getDatePublished()
    {
        return date("M jS, Y",$this->_getDatePublished());
    }

    protected function _getDatePublished()
    {
        Mage::registry('current_blog_post')->getPublishedDate();
    }

}
