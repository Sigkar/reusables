<?php

namespace Reusables;

if( !isset( $viewoptions['ifnone_insert'] ) ){
	$ifnone_insert = false;
}else{
	$ifnone_insert = $viewoptions['ifnone_insert'];
}

if( !isset( $viewoptions['multiple_inserts'] ) ){
	$multiple_inserts = false;
}else{
	$multiple_inserts = $viewoptions['multiple_inserts'];
}

if( !isset( $viewoptions['multiple_updates'] ) ){
	$multiple_updates = false;
}else{
	$multiple_updates = $viewoptions['multiple_updates'];
}

if( !isset( $viewoptions['formaction'] ) ){
	$formaction = '/edit_view.php';
}else{
	$formaction = $viewoptions['formaction'];
}

if( isset( $viewdict['formtitle'] ) ) {
	unset( $viewdict['formtitle'] );
}

// if( isset( $viewdict[array_keys($viewdict)[0]][ 'data_id' ] ) ){
// 	$original_data_id = $viewdict[ array_keys( $viewdict )[ 0 ] ][ 'data_id' ];
// }else{
// 	$original_data_id = $viewdict[ 'data_id' ];
// }

$original_data_id = $identifier;


$insert_values = [];
if( isset($viewoptions['insert_values']) ) {
	$insert_values = $viewoptions["insert_values"];
}

$added_inputs = Data::getValue( $viewoptions, 'added_inputs' );
if( $added_inputs == "" ) {
	$added_inputs = [];
}

extract( CustomView::makeFormVars( $viewdict, "viewdict" ) );
extract( Input::convertInputKeys( $identifier ) );
// exit( json_encode( $inputs ) );


?>


<style>
	<?php if( $steps > 1 ) { ?>
		.smartform.main_with_hidden.next { display: inline-block; }
		.smartform.main_with_hidden.save { display: none; }
	<?php }else{ ?>
		.smartform.main_with_hidden.next { display: none; }
		.smartform.main_with_hidden.save { display: inline-block; }
	<?php } ?>

	.added_inputs { display: inline-block; position: relative; margin: 10px 0; padding: 10px; width: calc(100% - 0px); font-size: 18px; font-weight: 300; color: #333333; background-color: white; border: 1px solid #e0e0e0; border-radius: 5px; }
</style>



<?php if( $onstep==1 ){ ?>
	<form class='<?php echo $identifier ?>_theform' method='post' action='<?php echo $formaction ?>' enctype='multipart/form-data'>
<?php } ?>

<?php if( $ifnone_insert ){ ?>
	<input type='hidden' name='ifnone_insert' value='1' >
<?php } ?>
<?php if( $multiple_inserts ){ ?>
	<input type='hidden' name='multiple_inserts' value='1' >
<?php } ?>
<?php if( $multiple_updates ){ ?>
	<input type='hidden' name='multiple_updates' value='1' >
<?php } ?>
<div class="viewtype_section <?php echo $identifier ?> smartform main">
	<div class='thecontainer' style='text-align: left; margin-top: 10px; margin-bottom: 0px; text-align: center;'>
		<label class="smartform titlelabel"><?php echo Data::getValue( $viewoptions, 'title' ) ?></label>
		<input type="hidden" name="goto" value="<?php echo Data::getValue( $viewoptions, 'goto' ) ?>">
		<input type="hidden" name="added_file" value="<?php echo Data::getValue( $viewoptions, 'added_file' ) ?>">
		<?php foreach ($added_inputs as $ai) { ?>
			<input class="added_inputs" type="<?php echo Data::getValue( $ai, 'type' ); ?>" name="<?php echo Data::getValue( $ai, 'name' ); ?>" value="<?php echo Data::getValue( $ai, 'value' ); ?>" >
		<?php } ?>
			<?php 

				echo Structure::make( 
					"one_column",
					[
						"maincolumn" => $inputs[ 'c' . $onstep ]
						
					],
					$identifier . "_onstep_" . $onstep . "_main_structure smartform"
				);
			
			?>
		<!-- <button class="smartform modalinner_1 save custombutton">Save</button> -->
		<?php if( $steps > 1 ){ ?>
			<button class="smartform main_with_hidden next custombutton">Next</button>
			<button class="smartform main_with_hidden save custombutton">Save</button>
		<?php }else { ?>
			<button class="smartform main_with_hidden save custombutton">Save</button>
		<?php } ?>
	</div>
</div>
<?php if( $onstep == $steps ) { ?>
	</form>
<?php } ?>

<script>

	<?php if( $steps == $onstep ) { ?>

		var viewdict = <?php echo json_encode($viewdict) ?>;
		var input_keys = <?php echo json_encode($input_onlykeys) ?>;
		var typearray = <?php echo json_encode( ReusableClasses::getTypeArray( $input_onlykeys ) ) ?>;
		var dataarray = <?php echo json_encode( Data::getFullArray( $viewdict ) ) ?>;
		var formatteddata = <?php echo json_encode( Data::retrieveDataWithID( $original_data_id ) ) ?>;
		var identifier = "<?php echo $identifier ?>";

			/* extract( Input::convertInputKeys( $table_identifier . "_form" )); */
		<?php echo Form::addJSClassToForm( $identifier, $viewdict, $input_onlykeys, $identifier );?>;


		if( typeof <?php echo $identifier ?> == 'undefined'  ) {
			var <?php echo $identifier ?> = new <?php echo $identifier ?>Classes();
			<?php echo $identifier ?>.populateview();
		}

	<?php } ?>

// alert()
</script>
	
