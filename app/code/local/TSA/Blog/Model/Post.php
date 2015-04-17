<?php

class TSA_Blog_Model_Post extends Mage_Core_Model_Abstract{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
    * Prefix of model events names
    *
    * @var string
    **/
    protected $_eventPrefix = 'tsa_blog';
    /**
     * Wishlist item collection
     *
     * @var Mage_Wishlist_Model_Mysql4_Item_Collection
     */
    protected $_itemCollection = null;

    /**
     * Store filter for wishlist
     *
     * @var Mage_Core_Model_Store
     */
    protected $_store = null;

    /**
     * Shared store ids (website stores)
     *
     * @var array
     */
    protected $_storeIds = null;

    /**
     * Entity cache tag
     *
     * @var string
     */
    protected $_cacheTag = 'tsa_blog';


    protected function _construct()
    {

        $this->_init('tsa_blog/post');
    }


    protected function _beforeSave()
    {
        parent::_beforeSave();


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

        if($this->_isPublishing()) {
            $this->setPublishedDate($timestamp);
        }

        if($this->_isUnpublishing()) {
            $this->setPublishedDate(null);
        }

        return $this;
    }


    /**
     * Prepare page's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        $statuses = new Varien_Object(array(
            self::STATUS_ENABLED => Mage::helper('tsa_blog')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('tsa_blog')->__('Disabled'),
        ));

        Mage::dispatchEvent('tsa_blog_get_available_statuses', array('statuses' => $statuses));

        return $statuses->getData();
    }




    protected function _isPublishing()
    {
        if((!$this->getOrigData() && 1 == $this->getData('published')) || (0 == $this->getOrigData('published') && 1 == $this->getData('published')))
            return true;
        return false;
    }

    protected function _isUnpublishing()
    {
        if((!$this->getOrigData() && 0 ==$this->getData('published')) || (1 == $this->getOrigData('published') && 0 == $this->getData('published')))
            return true;
        return false;
    }

}
