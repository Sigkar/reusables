<?php

namespace Reusables;




	$required = array(
		"placeholder"=>"",
		"field_value"=>"",
		"field_index"=>"",
		"field_table"=>"",
		"field_colname"=>"",
		// "field_rowid"=>""
		"field_conditions"=>[]
	);

	// ReusableClasses::checkRequired( "timepicker", $viewdict, $required );
/*
<input type="hidden" class="row_id" value="<?php echo $viewdict['field_rowid'] ?>" name="fieldarray[<?php echo $viewdict['field_index'] ?>][row_id]">
*/
// exit( json_encode( $viewdict ) );
if( !isset($viewdict['field_conditions'] ) ){
	$viewdict['field_conditions'] = [];
}else if( $viewdict['field_conditions'] == "" ){
	$viewdict['field_conditions'] = [];
}else if( sizeof($viewdict['field_conditions']) == 1 ) {
	if( sizeof($viewdict['field_conditions'][0]) == 0 ) {
		$viewdict['field_conditions'] = [];
	}
}

$is_currency = Data::getValue( $viewdict, "is_currency" );
$is_hidden = Data::getValue( $viewdict, "is_hidden" );

if($identifier == "template_form_value_string_input_0"){
	// exit( json_encode( sizeof( $viewdict['field_conditions']) ) );
}

?>

<style>
	.<?php echo $identifier ?> .input_groupaddon { font-size: 14px; font-weight: 400; line-height: 1; color: #555; text-align: center; background-color: #eee; border: 1px solid #ccc; border-radius: 4px; width: 1%; width: 30px; white-space: nowrap; vertical-align: middle; display: table-cell; float: left; border-top-right-radius: 0; padding: 15.5px 0; border-bottom-right-radius: 0; }
	.<?php echo $identifier ?> .field_value.input_withaddon { border-top-left-radius: 0; border-bottom-left-radius: 0; width: calc( 100% - 32px); }
</style>


<div class="viewtype_input <?php echo $identifier ?> timepicker">
	<?php if( !$is_hidden ){ ?>
		<label style="margin-bottom: -5px; font-weight: 700; font-size: 11px"><?php echo Data::getValue( $viewdict, "labeltext") ?></label>
	<?php } ?>
	<?php if( $is_currency != "" ){ ?>
		<span class="input_groupaddon">$</span>
		<input type="text" class="field_value input_withaddon" placeholder="<?php echo Data::getValue( $viewdict, 'placeholder') ?>" value="<?php echo Data::getValue( $viewdict, 'field_value') ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_value]">
	<?php }else if( $is_hidden ){ ?>
		<input type="hidden" class="field_value" placeholder="<?php echo Data::getValue( $viewdict, 'placeholder') ?>" value="<?php echo Data::getValue( $viewdict, 'field_value') ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_value]">
	<?php }else{ ?>
		<input type="text" class="field_value" id="<?php echo $identifier ?>_timepicker" placeholder="<?php echo Data::getValue( $viewdict, 'placeholder') ?>" value="<?php echo Data::getValue( $viewdict, 'field_value') ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_value]">
	<?php } ?>

	<input type="hidden" class="field_type" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_type]" value="text" style="visibility: hidden; z-index: -1;">
	<input type="hidden" class="tablename" value="<?php echo Data::getValue( $viewdict, 'field_table') ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][tablename]">
	<input type="hidden" class="col_name" value="<?php echo Data::getValue( $viewdict, 'field_colname') ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][col_name]">
	<?php $i=0; ?>
	<?php if( sizeof( $viewdict['field_conditions'] ) > 0 ){
		foreach ($viewdict['field_conditions'] as $c) { ?>
			<input type="hidden" class="conditionkey_<?php echo $i ?>" value="<?php echo $c['key'] ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_conditions][<?php echo $i ?>][key]">
			<input type="hidden" class="conditionvalue_<?php echo $i ?>" value="<?php echo $c['value'] ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_conditions][<?php echo $i ?>][value]">
			<?php $i++; ?>
		<?php } ?>
	<?php } ?>
</div>


<script>


$('.<?php echo $identifier ?>.timepicker #<?php echo $identifier ?>_timepicker').timepicker({ 'scrollDefault': 'now' });


	$('.<?php echo $identifier ?>.timepicker #<?php echo $identifier ?>_timepicker').on('click', function (){
	    $('.<?php echo $identifier ?>.timepicker #<?php echo $identifier ?>_timepicker').timepicker({ 'scrollDefault': 'now' });
	});





</script>