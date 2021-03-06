<?php

namespace Reusables;


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
$is_password = Data::getValue( $viewdict, "is_password" );
$is_number = Data::getValue( $viewdict, "is_number" );
$size = Data::getValue( $viewdict, "size" );
$labeltext = Data::getValue( $viewdict, "labeltext" );
$placeholder = Data::getValue( $viewdict, "placeholder" );
$field_value = Data::getValue( $viewdict, "field_value" );
$is_smart = Data::getValue( $viewoptions, "is_smart" );
if( $is_smart == "" ) {
	$is_smart = true;
} else {
	$is_smart = false;
}

if( $is_currency == "" && $is_hidden == "" && $is_password == "" && $size == "" && $labeltext == "" && $placeholder=="" && $field_value == "" ) {

	$is_currency = Data::getValue( $viewoptions, "is_currency" );
	$is_hidden = Data::getValue( $viewoptions, "is_hidden" );
	$is_password = Data::getValue( $viewoptions, "is_password" );
	$is_number = Data::getValue( $viewoptions, "is_number" );
	$size = Data::getValue( $viewoptions, "size" );
	$labeltext = Data::getValue( $viewoptions, "labeltext" );
	$placeholder = Data::getValue( $viewoptions, "placeholder" );
	$field_value = Data::getValue( $viewoptions, "field_value" );
}

if( $placeholder == "" ) {
	$placeholder = ucfirst(str_replace("_", " ", $identifier));
}
if( $labeltext == "" ) {
	$labeltext = ucfirst(str_replace("_", " ", $identifier));
}

if( $size == "" ) {
	$size = "large";
}
$sizeclass = "size_" . $size;


$field_table = Data::getValue( $viewdict, 'field_table' );

$field_name = "fieldarray[" . Data::getValue( $viewdict, 'field_index') . "][field_value]";
if( !$is_smart ) {
	$field_name = Data::getValue( $viewdict, 'field_name' );
	if( $field_name == "" ) {
		$field_name = Data::getValue( $viewoptions, 'field_name' );
		if( $field_name == "" ) {
			$field_name = $identifier;
		}
	}
}

$input_name = Data::getValue($viewdict, 'input_name');

$keys = array_keys( $viewoptions );
$attributes = "";
foreach ($viewoptions as $key => $value) {
	if( !isset( $keys[$key] ) ){ continue; }
	$key = $keys[$key];
	if( $key != "is_smart" && $key != "is_currency" && $key != "is_hidden" && $key != "size" && $key != "labeltext" && $key != "placeholder" && $key != "field_value" ) {
		if( $key == "" && is_numeric($value) ) {
			continue;
		}
		$attributes .= " ";
		if( $key == "" ) {
			$attributes .= $value . " = " . $value ;
		} else {
			$attributes .= $key . " = " . $value;
		}
		$attributes .= " ";
	}
}

$help_modal = Data::getValue( $viewoptions, "help_modal" );
if( $help_modal != "" ) {
	$help_modal = $help_modal["modalclass"];
}

?>

<style>
	.<?php echo $identifier ?> .input_groupaddon { font-size: 14px; font-weight: 400; line-height: 1; color: #555; text-align: center; background-color: #eee; border: 1px solid #ccc; border-radius: 4px; width: 1%; width: 30px; white-space: nowrap; vertical-align: middle; display: table-cell; float: left; border-top-right-radius: 0; padding: 15.5px 0; border-bottom-right-radius: 0; }
	.<?php echo $identifier ?> .field_value.input_withaddon { border-top-left-radius: 0; border-bottom-left-radius: 0; width: calc( 100% - 32px); }
</style>

<div class="viewtype_input <?php echo $identifier ?> textfield <?php echo $sizeclass ?>">
	<?php if( !$is_hidden ){ ?>
		<?php
			Data::add( ["title" => $labeltext], $identifier . "_label" );
			Options::add( $help_modal, "help_modal", $identifier . "_label" );
			echo Header::make( "basic_label", $identifier . "_label" );
		?>
	<?php } ?>
	<?php if( $is_currency != "" ){ ?>
		<span class="input_groupaddon">$</span>
		<input type="text" class="field_value input_withaddon" placeholder="<?php echo $placeholder ?>" value="<?php echo $field_value ?>" name="<?php echo $field_name ?>" <?php echo $attributes ?> >
	<?php } else if( $is_hidden ){ ?>
		<input type="hidden" class="field_value" placeholder="<?php echo $placeholder ?>" value="<?php echo $field_value ?>" name="<?php echo $field_name ?>" <?php echo $attributes ?> >
	<?php } else if( $is_password ){ ?>
		<input type="password" class="field_value" placeholder="<?php echo $placeholder ?>" value="<?php echo $field_value ?>" name="<?php echo $field_name ?>" <?php echo $attributes ?>>
	<?php } else if( $is_number ){ ?>
		<input type="number" class="field_value" placeholder="<?php echo $placeholder ?>" value="<?php echo $field_value ?>" name="<?php echo $field_name ?>" <?php echo $attributes ?>>
	<?php } else{ ?>
		<input type="text" class="field_value" placeholder="<?php echo $placeholder ?>" value="<?php echo $field_value ?>" name="<?php echo $field_name ?>" <?php echo $attributes ?>>
	<?php } ?>

	<?php if( $is_smart ) { ?>
		<input type="hidden" class="field_type" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_type]" value="text" style="visibility: hidden; z-index: -1;">
		<input type="hidden" class="tablename" value="<?php echo Data::getValue( $viewdict, 'field_table') ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][tablename]">
		<input type="hidden" class="col_name" value="<?php echo Data::getValue( $viewdict, 'field_colname') ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][col_name]">
		<input type="hidden" class="field_name" value="<?php echo $input_name ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_name]">
		<?php $i=0; ?>
		<?php if( sizeof( $viewdict['field_conditions'] ) > 0 ){
			foreach ($viewdict['field_conditions'] as $c) { ?>
				<input type="hidden" class="conditionkey_<?php echo $i ?>" value="<?php echo $c['key'] ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_conditions][<?php echo $i ?>][key]">
				<input type="hidden" class="conditionvalue_<?php echo $i ?>" value="<?php echo $c['value'] ?>" name="fieldarray[<?php echo Data::getValue( $viewdict, 'field_index') ?>][field_conditions][<?php echo $i ?>][value]">
				<?php $i++; ?>
			<?php } ?>
		<?php } ?>
	<?php } ?>

</div>

<script>
<?php if( Data::getValue($viewoptions, "placeholder") == "none" ) { ?>
	$('.<?php echo $identifier ?> :input').removeAttr('placeholder');
<?php } ?>
</script>
