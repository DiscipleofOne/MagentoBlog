<?php

class TSA_Blog_Block_Adminhtml_Post_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {

        $image = Mage::helper('tsa_blog/images')->resizeImg($row->getData($this->getColumn()->getIndex()), 90);
        $html = '<img ';
        $html .= 'id="' . $this->getColumn()->getId() . '" ';
        $html .= 'src="' . $image . '"';
        $html .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '"/>';
        return $html;
    }
}