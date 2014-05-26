<?php

class FacetByMetadata_IndexController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $elementIds = $this->getParam('elements');
        $itemId = $this->getParam('item_id');
        $db = $this->_helper->db;
        $item = $db->getTable('Item')->find($itemId);
        $advanced = array();
        foreach($elementIds as $elementId) {
            $element = $db->getTable('Element')->find($elementId);
            $term = metadata($item, array($element->getElementSet()->name, $element->name), array('no_filter' => true));
            if(!empty($term)) {
                $advanced[] = array('element_id' => $elementId, 'terms' => $term, 'type' => 'is exactly');
            }
        }
        $paramArray = array('search' => '', 'advanced' => $advanced);
        $params = http_build_query($paramArray);
        $this->_helper->redirector->gotoUrl('items/browse?' . $params );
    }
}