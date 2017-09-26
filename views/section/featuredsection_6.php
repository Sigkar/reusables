<?php

namespace Reusables;

	/*
		$viewdict = [
			"featured_imagepath"=>"",
			"logo_imagepath"=>"",
			"title"=>"",
			"adposition"=>0,
			"desc"=>""
		]
	*/

	$viewdict = Data::convertKeys( $viewdict );

	if( isset( $viewdict['value'] ) ){ 
		$data_id = Data::getDefaultDataID( $viewdict );
		// exit( json_encode( $viewdict ) );
		$viewdict = Data::formatForDefaultData( $data_id );
		// SHOULD CONTROL DATA WITH ID NOT VAR
	}
	if( isset($viewdict['editing']) ){ $isediting=1; }else{ $isediting=0; }
	
	// exit( json_encode( Data::getValue( $viewdict, 'logo_imagepath' ) ) ) ;

?>

<style>
<?php if($isediting){ ?>
	.featuredsection_6 { cursor: pointer; }
		.featuredsection_6:hover { opacity: 0.8; }
<?php } ?>
</style>

<div class="featuredsection_6 <?php echo $identifier ?>">
	<div class="backgroundimage" style="background-image: url('<?php echo Data::getValue( $viewdict, 'featured_imagepath' ) ?>');">
		<div class="gradient"></div>
	</div>
	<div class="header">
		<img id="logo" src="<?php echo Data::getValue( $viewdict, 'logo_imagepath' ) ?>">
		<h3 id="title"><?php echo Data::getValue( $viewdict, 'title' ) ?></h3>
	</div>
</div>

<script>

var viewdict = <?php echo json_encode($viewdict) ?>;
var isediting = <?php echo $isediting ?>;

$('.featuredsection_6').click(function(e){
	if(isediting){
		e.preventDefault();
		var editingdict = viewdict['editing'];
		var type = editingdict['type'];

		if( type == "link" ){
			window.open(editingdict[type]);
		}else if( type == "modal" ){
			// var theclasses = $.extend( { editingdict[type]['modalclass']+Classes; } );
			<?php if( isset( $viewdict['editing'] ) ) { ?>

				let modalclasses = new <?php echo $viewdict['editing']['modal']['modalclass'] ?>Classes();
				// modalclass.populateview( $(this).id );
				modalclasses.populateview();
				$('.modal_background').css({'display': 'inline-block'});
				$('.' + editingdict[type]['parentclass']).css({'display': 'inline-block'});
				
			<?php } ?>
		}else if( type == "popview" ){

		}
	}
});

</script>