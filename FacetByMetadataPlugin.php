<?php

class FindSimilarPlugin extends Omeka_Plugin_AbstractPlugin
{
    
    protected $_hooks = array(
            'public_items_show',
            'config_form',
            'config'
            );
    
    
    public function hookConfigForm()
    {
        $table = get_db()->getTable('Element');
        $select = $table->getSelect()
            ->order('elements.element_set_id')
            ->order('ISNULL(elements.order)')
            ->order('elements.order');

        $elements = $table->fetchObjects($select);
        include 'config-form.php';
    }

    public function hookConfig($args)
    {
        $post = $args['post'];
        if(isset($post['elements'])) {
            set_option('find_similar_elements', json_encode($post['elements']));
        } else {
            set_option('find_similar_elements', json_encode(array()));
        }
    }
    
    public function hookPublicItemsShow($args)
    {
        require_once 'Find_Similar_Form.php';
        $item = $args['item'];
        $form = new Find_Similar_Form(array('item' => $item));
        echo $form;
    }
}
