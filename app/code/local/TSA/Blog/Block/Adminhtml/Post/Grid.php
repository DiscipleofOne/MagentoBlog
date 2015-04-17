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
 * Adminhtml newsletter templates grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class TSA_Blog_Block_Adminhtml_Post_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setEmptyText(Mage::helper('tsa_blog')->__('No Blog Posts'));
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('tsa_blog/post')->getCollection();

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('blog_id',
            array('header'  => Mage::helper('tsa_blog')->__('ID'), 'align'=>'center', 'index'=>'blog_id'));

        $this->addColumn('image',
            array(
                'header'    => Mage::helper('tsa_blog')->__('Blog Post Image'),
                'align'     => 'center',
                'index'     => 'image',
                'renderer'  => 'tsa_blog/adminhtml_post_grid_renderer_image'
            ));

        $this->addColumn('created_date',
            array(
                'header'    => Mage::helper('tsa_blog')->__('Date Added'),
                'index'     => 'created_date',
                'gmtoffset' => true,
                'type'      => 'datetime',
            ));

        $this->addColumn('author',
            array(
                'header'    => Mage::helper('tsa_blog')->__('Author'),
                'index'     => 'author'
        ));

        $this->addColumn('title',
            array(
                'header'    => Mage::helper('tsa_blog')->__('Title'),
                'index'     => 'title',
        ));

        $this->addColumn('content',
            array(
                'header'    => Mage::helper('tsa_blog')->__('Content'),
                'index'     => 'content',
                'renderer' => 'tsa_blog/adminhtml_Post_grid_renderer_content'
        ));


        $this->addColumn('published_date',
            array(
                'header'    =>Mage::helper('tsa_blog')->__('Published Date'),
                'index'     =>'published_date',
                'gmtoffset' => true,
                'type'      =>'datetime',
                'default'   => '-----'

            ));

        $this->addColumn('published',
            array(
                'header'        => Mage::helper('tsa_blog')->__('Published'),
                'index'         => 'published',
                'align'         => 'center',
                'renderer'      => 'tsa_blog/adminhtml_post_grid_renderer_boolean'

            ));




        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('blog_id'=>$row->getId()));
    }



    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('blog_post_publish');
        $this->getMassactionBlock()->setFormFieldName('blog_id');

        $this->getMassactionBlock()->addItem('publish', array(
            'label'=> Mage::helper('tsa_blog')->__('Publish'),
            'url'=>$this->getUrl('*/*/massPublish', array(''=>'')),
            'confirm' => Mage::helper('tsa_blog')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('unpublish', array(
            'label'=> Mage::helper('tsa_blog')->__('Unpublish'),
            'url'=>$this->getUrl('*/*/massUnpublish', array(''=>'')),
            'confirm' => Mage::helper('tsa_blog')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('tsa_blog')->__('Delete'),
            'url'=>$this->getUrl('*/*/massDelete', array(''=>'')),
            'confirm' => Mage::helper('tsa_blog')->__('Are you sure?')
        ));






        return $this;
    }

}

