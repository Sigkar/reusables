<?php

namespace Reusables;

?>

<style>

</style>

<div class="viewtype_structure <?php echo $identifier ?> modal_background main">
	<div class="modal_background overlay"></div>
	<div class="modal_background maincolumn">
		<?php
			foreach ($structuredict['maincolumn'] as $view) {
				echo $view;
			}
		?>
	</div>
</div>

<script>
</script>
