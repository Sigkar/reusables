<?php 
	if(!isset($cell4mediatype)){ $cell4mediatype=""; }
	if( !isset($isfeatured) ){ $isfeatured=false; }

	if(!isset($isadmin)){ $isadmin=false; }
	if(!isset($celldict['post_id'])){ $celldict['post_id'] = $celldict['id']; }
?>

<style>
</style>

<div class="cell_4 main <?php echo $identifier ?> <?php if($celldict['isfeatured']){ echo "featured"; } ?> <?php if($celldict['mediatype']=="youtube" || $celldict['mediatype']=="podcast"){ echo $celldict['mediatype']; } ?>" id="<?php echo $celldict['id'] ?>">
	<div class="cell_4 container">
		<div style="display:inline-block; width: 100%">
			<div>
				<a href="<?php if($isadmin){ echo '#'; }else{ echo '/post/'.$celldict['post_id'] . '/' . preg_replace('/\PL/u', '-', preg_replace("/[^ \w]+/", "", $celldict['title']) ); } ?>">
					<div class="cell_4 picture" style="<?php if($celldict['imagepath']){ echo 'background-image: url('.$celldict['imagepath'].');'; } ?>"></div>
				</a>
				<div class="cell_4 words">
					<div class="cell_4 text-container">
						<a href="<?php if($isadmin){ echo '#'; }else{ echo '/post/'.$celldict['post_id'] . '/' . preg_replace('/\PL/u', '', preg_replace("/[^ \w]+/", "", $celldict['title']) ); } ?>">
							<label class="cell_4 title" style="font-size: 0.9em; position: relative; display: inline-block; margin: 0; padding: 0;"><?php if(isset($celldict['title'])){echo $celldict['title'];} ?></label>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var editingon = false;

	
	if(typeof <?php echo $identifier ?> == 'undefined'){
		class <?php echo $identifier ?>Classes {

		setupactions(){
			var editingon=false;
			$('.<?php echo $identifier ?>').off('click');
			$('.<?php echo $identifier ?>').click(function(){

				// if(typeof window.selectedfeatured == 'undefined'){var window.selectedfeatured=null;}
				if($(this).hasClass('featured')){
					window.selectedfeatured = $(this).parent().attr('class');
				}else{
					window.selectedfeatured=null;
				}
				
				var gotothis;
				var whichfeatured;
				var posturl = '/post/';
				// window.selectedfeatured = this.id;
				var thedict;
				
				if(editingon==true){
					// $('.articlesbackground').css('display', 'inline-block');
					// $('.articlespopview').css('display', 'inline-block');
					//updateifvideo(type, path, div);
					if(window.selectedfeatured==null || window.selectedfeatured==""){
						window.location.href = "/editing/post?p="+this.id;
					}else{
						$('.articlesbackground').css('display', 'inline-block');
						$('.articlespopview').css('display', 'inline-block');
					}
				}else{
					// var mediatype = thedict['type'];
					// var prehref = '';
					// var preprehref = '';
					// preprehref = '/';
					// //alert(mediatype);
					// if(mediatype != 'podcast'){
					// 	prehref = preprehref+'post?p=';
					// 	var thehref = prehref.concat(thedict['id']);
					// 	var urltitle = thedict['title'].replace(/\s/g, '');
					// 	window.location.href = thehref+'&'+urltitle;
					// }else{
					// 	preprehref = '/brand-forward';
					// 	prehref = preprehref+'?p=';
					// 	var thehref = prehref.concat(thedict['id']);
					// 	var urltitle = thedict['title'].replace(/\s/g, '');
					// 	window.location.href = thehref+'&'+urltitle;
					// }
					// window.location.href = "http://theanywherecard.com/experiencenash_dev/post?p="+this.id;
					window.location.href = "/post/"+this.id+"/"+$(this).find('.title').text().replace(/\W/g, '-');
				}
			});
		}

	}
		var <?php echo $identifier ?> = new <?php echo $identifier ?>Classes();
	}
	
	<?php echo $identifier ?>.setupactions();
</script>