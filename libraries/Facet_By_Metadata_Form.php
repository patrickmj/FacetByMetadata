<?php

class Facet_By_Metadata_Form extends Omeka_Form
{
    protected $item;

    public function init()
    {
        $this->setAction(url('facet-by-metadata'));
        $elTable = get_db()->getTable('Element');
        $elements = array();
        $elementIds = json_decode(get_option('facet_by_metadata_elements'), true);
        foreach($elementIds as $elementId)
        {
            $element = $elTable->find($elementId);
            $elements[$elementId] = metadata($element, 'name') . ': ' . metadata($this->item, array($element->getElementSet()->name, $element->name), array('no_escape' => true, 'no_filter' => true));
        }
        $checkboxes = new Zend_Form_Element_MultiCheckbox('elements');
        $checkboxes->setMultiOptions($elements);
        $this->addElement($checkboxes);
        $this->addElement('hidden', 'item_id', array('value' => $this->item->id));
        $this->addElement('submit', __('Find'));
    }

    protected function setItem($item)
    {
        $this->item = $item;
    }
}