<?php

class Facet_By_Metadata_Form extends Omeka_Form
{
    protected $item;
    
    public function init()
    {
        $elTable = get_db()->getTable('Element');
        $elements = array();
        $elementIds = json_decode(get_option('find_similar_elements'), true);
        foreach($elementIds as $elementId)
        {
            $element = $elTable->find($elementId);
            $elements[$elementId] = metadata($element, 'name');
            $elementIds[$element->id] = metadata($element, 'name');
        }
        $checkboxes = new Zend_Form_Element_MultiCheckbox('elements');
        $checkboxes->setMultiOptions($elements);
        $this->addElement($checkboxes);
        $this->addElement('submit', __('Find'));
    }
    
    protected function setItem($item)
    {
        $this->item = $item;
    }
}