<?php

class TSA_Blog_Block_Adminhtml_Post extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'tsa_blog_post';
        $this->_headerText = Mage::helper('tsa_blog')->__('Manage Blog Posts');


        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('tsa_blog')->__('Add New Blog Post'));
        } else {
            $this->_removeButton('add');
        }

    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('tsa_blog/post/' . $action);
    }

    protected function _prepareLayout()
    {
        $this->setChild('grid',
            $this->getLayout()->createBlock('tsa_blog/adminhtml_post_grid','tsa.blog.post.grid')
        );
//        parent::_prepareLayout();

        return $this;
    }


}