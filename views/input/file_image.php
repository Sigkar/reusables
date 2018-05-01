<?php

namespace Reusables;
	
	$required = array(
		"background-image"=>"",
		"field_value"=>"",
		"field_index"=>"",
		"field_table"=>"",
		"field_colname"=>"",
		"field_conditions"=>[]
	);
	// exit(json_encode($viewdict));
	// ReusableClasses::checkRequired( $identifier, $viewdict, $required );
if( !isset($viewdict['field_conditions'] ) ){
	$viewdict['field_conditions'] = [];
}else if( $viewdict['field_conditions'] == "" ){
	$viewdict['field_conditions'] = [];
}else if( sizeof($viewdict['field_conditions']) == 1 ) {
	if( sizeof($viewdict['field_conditions'][0]) == 0 ) {
		$viewdict['field_conditions'] = [];
	}
}

$size = Data::getValue( $viewdict, "size" );

if( $size == "" ) {
	$size = "large";
}
$sizeclass = "size_" . $size;

$help_modal = Data::getValue( $viewoptions, "help_modal" );
if( $help_modal != "" ) {
	$help_modal = $help_modal["modalclass"];
}

$labeltext = Data::getValue( $viewdict, "labeltext" );
if( $labeltext == "" ) {
	$labeltext = Data::getValue( $viewoptions, "labeltext" );
}

?>

<style>
</style>

<div class="viewtype_input <?php echo $identifier ?> file_image <?php echo $sizeclass ?>">
	<?php 
		Data::addData( ["title" => $labeltext], $identifier . "_label" );
		Data::addOption( $help_modal, "help_modal", $identifier . "_label" );
		echo Header::make( "basic_label", $identifier . "_label" ); 
	?>
	<label class="file_image" id='imglabel' for='<?php echo $identifier ?>_field_value' style="background-image: url('<?php echo Data::getValue( $viewdict,'background-image') ?>');"></label>
	<input type="file" class="field_value" id="<?php echo $identifier ?>_field_value" value="<?php echo Data::getValue( $viewdict,'field_value') ?>" name="fieldimage[<?php echo Data::getValue( $viewdict,'field_index') ?>][field_value]" style="visibility: hidden; z-index: -1;">
	<input type="hidden" class="field_type" name="fieldimage[<?php echo Data::getValue( $viewdict,'field_index') ?>][field_type]" value="image_<?php echo Data::getValue( $viewdict,'field_index') ?>" style="visibility: hidden; z-index: -1;">
	<input type="hidden" class="tablename" value="<?php echo Data::getValue( $viewdict,'field_table') ?>" name="fieldimage[<?php echo Data::getValue( $viewdict,'field_index') ?>][tablename]">
	<input type="hidden" class="col_name" value="<?php echo Data::getValue( $viewdict,'field_colname') ?>" name="fieldimage[<?php echo Data::getValue( $viewdict,'field_index') ?>][col_name]">
	<?php $i=0; ?>
	<?php foreach ($viewdict['field_conditions'] as $c) { ?>
		<input type="hidden" class="conditionkey_<?php echo $i ?>" value="<?php echo $c['key'] ?>" name="fieldimage[<?php echo Data::getValue( $viewdict,'field_index') ?>][field_conditions][<?php echo $i ?>][key]">
		<input type="hidden" class="conditionvalue_<?php echo $i ?>" value="<?php echo $c['value'] ?>" name="fieldimage[<?php echo Data::getValue( $viewdict,'field_index') ?>][field_conditions][<?php echo $i ?>][value]">
		<?php $i++; ?>
	<?php } ?>
</div>

<script>
	var identifier = "<?php echo $identifier ?>";
		identifier = identifier.replace('.', '\\.')
	$('#'+identifier+'_field_value').change(function(){
		var identifier = "<?php echo $identifier ?>";
		identifier = identifier.replace('.', '\\.')
		Reusable.readthisURL(this, $('.'+identifier+'').find('#imglabel'), null, null);
	});
</script>