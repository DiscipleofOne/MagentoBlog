<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Cms page edit form main tab
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class TSA_Blog_Block_Adminhtml_Post_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        /* @var $model Mage_Cms_Model_Page */
        $model = Mage::registry('tsa_blog_post');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }


        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('tsa_blog_post_id_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('tsa_blog')->__('Blog Post Information')));

        if ($model->getBlogID()) {
            $fieldset->addField('blog_id', 'hidden', array(
                'name' => 'blog_id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('tsa_blog')->__('Blog Post Title'),
            'title'     => Mage::helper('tsa_blog')->__('Blog Post Title'),
            'required'  => true,
            'disabled'  => $isElementDisabled
        ));

        $fieldset->addField('author', 'text', array(
            'name'      => 'author',
            'label'     => Mage::helper('tsa_blog')->__('Blog Post Author'),
            'title'     => Mage::helper('tsa_blog')->__('Blog Post Author'),
            'required'  => true,
            'disabled'  => $isElementDisabled
        ));

        $fieldset->addField('published', 'select', array(
            'name'      => 'published',
            'label'     => Mage::helper('tsa_blog')->__('Blog Post is Published'),
            'title'     => Mage::helper('tsa_blog')->__('Blog Post is Published'),
            'required'  => true,
            'options'   => $model->getAvailableStatuses(),
            'disabled'  => $isElementDisabled
        ));


        $fieldset->addField('image', 'image', array(
            'name'          => 'image',
            'label'         => Mage::helper('tsa_blog')->__('Blog Post Image'),
            'required'      => false
        ));

        Mage::dispatchEvent('adminhtml_tsa_blog_post_edit_tab_main_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('tsa_blog')->__('Blog Post Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('tsa_blog')->__('Blog Post Information');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
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
}
