<?php

namespace Reusables;

	Views::setParams( 
		[ "imagepath" ], 
		[],
		$identifier
	);

?>



<div class="viewtype_section ios_screenshot_1 main <?php echo $identifier ?>">
	
	<div class="ios_screenshot_1 iphone">
		<div class="ios_screenshot_1 picture" style="background-image: url(<?php echo $viewdict['imagepath'] ?>);">
			
		</div>
	</div>

</div>