<?php

class TSA_Blog_Block_Adminhtml_Post_Grid_Renderer_Boolean extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Text
{
    public function _getValue(Varien_Object $row)
    {

        $data = parent::_getValue($row);

        $checked = $data == 1 ? 'checked="checked" ' : '';

        return $this->_getCheckboxHtml($checked);
    }



    /**
     * @param string $value   Value of the element
     * @param bool   $checked Whether it is checked
     * @return string
     */
    protected function _getCheckboxHtml($checked)
    {
        $html = '<input type="checkbox" ';
        $html .= 'class="checkbox"';
        $html .= $checked . 'disabled/>';
        return $html;
    }


}