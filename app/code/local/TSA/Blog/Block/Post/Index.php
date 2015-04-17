<?php


class TSA_Blog_Block_Post_Index extends TSA_Blog_Block_Post
{
    const POST_COLLECTION = 'tsa_blog_post_active_collection';

    public function __construct()
    {
        parent::__construct();
        $this->_template = 'tsa/blog/post/index.phtml';
    }

    public function getBlogPostCollection()
    {
        if(Mage::registry(self::POST_COLLECTION))
            return Mage::registry(self::POST_COLLECTION);
        Mage::register(self::POST_COLLECTION,$this->_getPostCollection()->load());
        return Mage::registry(self::POST_COLLECTION);
    }

    public function getPostTitle($blogPost)
    {
        return $this->_getPostTitle($blogPost);
    }

    protected function _getPostTitle($blogPost)
    {
        return $blogPost->getTitle();
    }

    public function getPostID($blogPost)
    {
        return $this->_getPostID($blogPost);
    }

    protected function _getPostID($blogPost)
    {
        return $blogPost->getBlogId();
    }

    public function getPostContent($blogPost)
    {
        return $this->_getPostContent($blogPost);
    }

    protected function _getPostContent($blogPost)
    {
        return substr(strip_tags($blogPost->getContent()),0,500) . "...";
    }

    public function getPostViewUrl($blogPost)
    {
        return $this->_getViewURL($blogPost->getBlogId());
    }

    public function getImageURL($blogPost)
    {
        return $this->_getImageURL($blogPost);

    }

    protected function _getImageURL($blogPost)
    {
        return Mage::helper('tsa_blog/images')->resizeImg($blogPost->getImage(), 150);
    }


    public function getPostPublishDate($blogPost)
    {
        return $this->_getPostPublishDate($blogPost);
    }

    protected function _getPostPublishDate($blogPost)
    {
        return date("M jS, Y", strtotime($blogPost->getPublishedDate()));
    }

}