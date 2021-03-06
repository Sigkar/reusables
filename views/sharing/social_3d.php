<?php

namespace Reusables;

	if( !isset($identifier) ){ $identifier = ""; }
	// exit( json_encode( $viewdict ) );


	Views::setParams( 
		[ "facebook", "twitter" ], 
		[],
		$identifier
	);

?>

<style>
</style>

<div class="viewtype_sharing social_3d <?php echo $identifier ?>">
	<div style="position: relative; display: inline-block; width: 100%; text-align: left; margin-top: 10px;">
		<a href="#" class="sharingbuttons" id="fb"><img src="/vendor/miltonian/reusables/images/icons/facebook-256-2.png"><p>Share on Facebook</p></a>
		<a href="#" class="sharingbuttons" id="twitter"><img src="/vendor/miltonian/reusables/images/icons/twitter-512.gif" /><p>Share on Twitter</p></a>
	</div>
</div>

<script>

	$('.social_3d .sharingbuttons').click(function(e){
		e.preventDefault();

		var sharelink;
		if( this.id=="fb" ){
			sharelink = '<?php echo $viewdict['facebook'] ?>';
		}else{
			sharelink = '<?php echo $viewdict['twitter'] ?>';
		}
		var left = ($(window).width()/2)-(900/2);
		var top = ($(window).height()/2)-(600/2);
		window.open (sharelink, "popup", "width=900, height=600, top="+top+", left="+left);
	});

</script>