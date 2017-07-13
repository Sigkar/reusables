<?php

namespace Reusables;

	/*
	$structuredict = [ 
				"maincolumn" => array(["viewtype"=>"","filename"=>"", "data"=>""]),
				"sidecolumn_right" => array(["viewtype"=>"","filename"=>"", "data"=>""])
			]
	*/
?>

<style>

</style>

<div class="<?php echo $identifier ?> structure_1 main">
	<div class="structure_1 maincolumn">
		<?php 
			foreach ($structuredict['maincolumn'] as $view) {
				// $ReusableClasses->$view['viewtype']( $view['filename'], $view['data'] );
				echo $view;
			}
		?>
	</div>
	<div class="structure_1 sidecolumn_right">
		<?php 
			foreach ($structuredict['sidecolumn_right'] as $view) {
				// $ReusableClasses->$view['viewtype']( $view['filename'], $view['data'] );
				echo $view;
			}
		?>
	</div>
</div>

<script>
</script>