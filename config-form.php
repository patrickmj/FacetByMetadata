<div class="three columns alpha">
    <label for="facet_by_metadata_heading"><?php echo __('Heading for facets');?></label>
</div>

<div class="five columns omega">
<input type='text' name='facet_by_metadata_heading' value='<?php echo get_option("facet_by_metadata_heading"); ?>' />
</div>

<?php $view = get_view(); 

$elementIds = json_decode(get_option('facet_by_metadata_elements'), true);
$current_element_set = null;
foreach ($elements as $element):
    if ($element->set_name != $current_element_set):
        $current_element_set = $element->set_name;
?>

<h2 style='clear:both'><?php echo __($current_element_set); ?></h2>

<?php endif; ?>

<div class="four columns alpha">
<?php echo __($element->name); ?>
</div>

<div class="two columns omega">
<?php echo $view->formCheckbox(
    "elements[]",
    $element->id, array(
        'checked' => in_array($element->id, $elementIds)
    )
); ?>

</div>

<?php endforeach; ?>