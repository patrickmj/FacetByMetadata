<?php

class FacetByMetadataPlugin extends Omeka_Plugin_AbstractPlugin
{
    
    protected $_hooks = array(
            'public_items_show',
            'config_form',
            'config',
            'install'
            );
    
    public function hookInstall()
    {
        set_option('facet_by_metadata_elements', json_encode(array()));
    }
    
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
            set_option('facet_by_metadata_elements', json_encode($post['elements']));
        } else {
            set_option('facet_by_metadata_elements', json_encode(array()));
        }
        set_option('facet_by_metadata_heading', $post['facet_by_metadata_heading']);
    }
    
    public function hookPublicItemsShow($args)
    {
        require_once 'Facet_By_Metadata_Form.php';
        $item = $args['item'];
        $html = '<div class="facet-by-metadata">';
        $html .= '<h2>' . get_option('facet_by_metadata_heading') . '</h2>';
        $html .= new Facet_By_Metadata_Form(array('item' => $item));
        $html .= '</div>';
        echo $html;
    }
}
