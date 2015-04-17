<?php

class TSA_Blog_Block_Adminhtml_Post_Grid_Renderer_Content extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Text
{
    public function _getValue(Varien_Object $row)
    {
        $format = ( $this->getColumn()->getFormat() ) ? $this->getColumn()->getFormat() : null;
        $defaultValue = $this->getColumn()->getDefault();
        if (is_null($format)) {
            // If no format and it column not filtered specified return data as is.
            $data = parent::_getValue($row);
            $string = is_null($data) ? $defaultValue : $data;
            return $this->escapeHtml(substr($string,0,100) . "...");
        }
        elseif (preg_match_all($this->_variablePattern, $format, $matches)) {
            // Parsing of format string
            $formattedString = $format;
            foreach ($matches[0] as $matchIndex=>$match) {
                $value = $row->getData($matches[1][$matchIndex]);
                $formattedString = str_replace($match, $value, $formattedString);
            }
            return substr($formattedString,0,100) . "...";
        } else {
            return $this->escapeHtml($format);
        }
    }
}