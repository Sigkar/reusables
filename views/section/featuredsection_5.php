<?php
	//3 cells inline (cell3)
?>

<style>

.<?php echo $identifier ?>{ position: relative;display: inline-block;margin: 0;padding: 0;width: 100%;text-align: center; }
	.<?php echo $identifier ?> .picture {position: relative;margin: 0;background-size: cover;background-position: center;margin: 2px;}
	.<?php echo $identifier ?> #greybox{position: relative;display: inline-block;margin: 0;padding: 0;width: 250px;height: 40px;background-color: grey;color: white;bottom: 0; }
	.<?php echo $identifier ?> .words{ position: relative; display: block; margin: 0; padding: 0; width: auto; height: 100px; background-color: white;}
	.<?php echo $identifier ?> .text-container{ position: relative; display: inline-block; top: 50%; transform: translateY(-50%); width: 100%; }

	.<?php echo $identifier ?> .grey-label{ font-style: italic; color: grey; font-size: 2em; }
@media (min-width: 0px) {
	.<?php echo $identifier ?> .picture.one, .<?php echo $identifier ?> .picture.three {display: none;}
	.<?php echo $identifier ?> .picture {width: 100%; padding: 0; padding-bottom: 68%;}
	.<?php echo $identifier ?> .graylabel {margin-top: calc(68% - 38px);}
	.<?php echo $identifier ?> .post.one, .<?php echo $identifier ?> .post.three {display: none;}
	.<?php echo $identifier ?> .post.two {display: inline-block; width: 100%;}
}
@media (min-width: 768px) {
	.picture {display: inline-block;}
	.picture.one, .picture.three {display: inline-block;}
	.picture {width: 32%; padding: 0; padding-bottom: 28%;}
	.graylabel {margin-top: calc(28% - 38px);}
	.<?php echo $identifier ?> .post.one, .<?php echo $identifier ?> .post.three {display: inline-block; width: 31%;}
	.<?php echo $identifier ?> .post.two {display: inline-block; width: 34%;}
}
</style>


<div class="<?php echo $identifier ?>">
	<div style="display:inline-block; width: 100%;">
		<div style="display: inline-block; width: 100%;">
			<?php 
				echo '<div class="post one sortorder_1 featuredsectionid_1" style="position: relative; margin: 0; padding: 0;">';
					echo Cell::make( "cell_3", $sectiondict['postarray'][0], $identifier . "-leftpost" );
				echo '</div>';
				echo '<div class="post one sortorder_1 featuredsectionid_1" style="position: relative; margin: 0; padding: 0;">';
					echo Cell::make( "cell_3", $sectiondict['postarray'][1], $identifier . "-midpost" );
				echo '</div>';
				echo '<div class="post one sortorder_1 featuredsectionid_1" style="position: relative; margin: 0; padding: 0;">';
					echo Cell::make( "cell_3", $sectiondict['postarray'][2], $identifier . "-rightpost" );
				echo '</div>';
			?>
			
		</div>
	</div>
</div>

<script>
	
</script>