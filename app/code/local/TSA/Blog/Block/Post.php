<?php

class TSA_Blog_Block_Post extends Mage_Core_Block_Template
{
    public function __construct()
    {
        $this->_template = 'tsa/blog/post/sidebar.phtml';
        parent::__construct();
    }

    protected function _getPostCollection()
    {
        return Mage::getModel('tsa_blog/post')->getCollection()->addFieldToFilter('published',1);
    }

    protected function _getMoreURL()
    {
        return Mage::getUrl('tsa_blog/post/index');
    }

    public function getPostDisplayData()
    {
        return $this->_getPostDisplayData();
    }
    protected function _getPostDisplayData()
    {
        $postDataCollection = $this->_getPostCollection()->load();

        if($postDataCollection->getData()) {
            foreach ($postDataCollection as $blogPost) {
                $arrPostData[$blogPost->getBlogId()] = (object)array(
                    'title' => $blogPost->getTitle(),
                    'image' => $blogPost->getImage(),
                    'content' => substr(strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",$blogPost->getContent())), 0, 50) . "...",
                    'id' => $blogPost->getBlogId()
                );
            }
            return $arrPostData;
        }
        return null;
    }

    protected function _getNumPostsDisplay()
    {
        return 5;
    }

    /**
     * @param $blogPostID
     * @return string
     */
    protected function _getViewURL($blogPostID)
    {
        return Mage::getUrl('tsa_blog/post/view', array(
            'blog_ID' => $blogPostID
        ));
    }

    protected function _getIndexURL()
    {
        return Mage::getUrl('tsa_blog/post/index');

    }

    public function getIndexURL()
    {
        return $this->_getIndexURL();
    }

    public function getViewURL($blogPostID)
    {
        return $this->_getViewURL($blogPostID);
    }


}
