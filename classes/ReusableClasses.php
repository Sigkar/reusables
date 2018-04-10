<?php 

namespace Reusables;

if( !defined( 'PROJECT_ROOT' ) ){
	define( 'PROJECT_ROOT', "" );
}

class ReusableClasses {
	
	public $PDO; // PHP Data Object
	protected static $includedfiles = array();
	protected static $forminputlastindexes = [];
	protected static $formonstep = [];
	protected static $editableviews = [];

	protected static $addedjs = "";

	//public static $PDO;
	private $cryptKey = "Rxp45dn142etvQk9e17Oo3nx2xJKfkZs"; // Encryption Key

	public static function addfile( $parent_dir, $file )
	{
		array_push( self::$includedfiles, [ "parent_dir" => $parent_dir, "file" => $file ] );
	}

	public static function addcss()
	{
		// exit( json_encode( self::$includedfiles ) );
		foreach (self::$includedfiles as $f) {
			Style::addcss( $f['parent_dir'], $f['file'] );
		}
	}

	public static function addjs()
	{
		// exit( json_encode( self::$includedfiles ) );
		foreach (self::$includedfiles as $f) {
			Scripts::addjs( $f['parent_dir'], $f['file'] );
		}

		echo self::$addedjs;
	}

	public static function addbeforejs()
	{
		foreach (self::$includedfiles as $f) {
			Scripts::addbeforejs( $f['parent_dir'], $f['file'] );
		}
	}

	public static function startpage( $page )
	{
		ob_start('Reusables\Page::reusables');
	}

	public static function endpage( $parent_dir, $page, $endbody=true, $addjquery=true, $addeditor=true )
	{
		Views::analyze( true );


		$viewoutput = Views::setViews();
		// $formoutput = Views::setForms();

		// Views::makeViews();

		
		// $output = ob_get_contents();
		// ob_end_clean();

		ReusableClasses::addcss();
		ReusableClasses::addReusableJS( $addjquery );
		ReusableClasses::addEditor( $addeditor );
		ReusableClasses::addbeforejs();

		// exit( json_encode( $page ) );
		$page = rtrim($page, ".php");
		
		if( file_exists( BASE_DIR . '/vendor/miltonian/custom/css/pages/header.css' ) ){
			echo "<link rel='stylesheet' type='text/css' href='" . PROJECT_ROOT . "/vendor/miltonian/custom/css/pages/header.css'>";
		}
		if( file_exists( BASE_DIR . '/vendor/miltonian/custom/css/pages/footer.css' ) ){
			echo "<link rel='stylesheet' type='text/css' href='" . PROJECT_ROOT . "/vendor/miltonian/custom/css/pages/footer.css'>";
		}

		if( $parent_dir == ""){
			echo "<link rel='stylesheet' type='text/css' href='" . PROJECT_ROOT . "/vendor/miltonian/custom/css/pages/" . basename($page, '.php') . ".css'>";
			if( file_exists( BASE_DIR . '/vendor/miltonian/custom/js/pages/before/' . basename($page, '.php') . ".js" ) ){
				echo "<script type='text/javascript' src='" . PROJECT_ROOT . "" . '/vendor/miltonian/custom/js/pages/before/' . basename($page, '.php') . ".js" . "'></script>";
			}
		}else{
			echo "<link rel='stylesheet' type='text/css' href='" . PROJECT_ROOT . "/vendor/miltonian/custom/css/pages/" . $parent_dir . "/" . basename($page, '.php') . ".css'>";

			if( file_exists( BASE_DIR . "/vendor/miltonian/custom/js/pages/before/" . $parent_dir . "/" . basename($page, '.php') . ".js" ) ){
				echo "<script type='text/javascript' src='" . PROJECT_ROOT . "" . '/vendor/miltonian/custom/js/pages/before/' . $parent_dir . '/' . basename($page, '.php') . ".js" . "'></script>";
			}
		}
		// echo "<link rel='stylesheet' type='text/css' href='/vendor/miltonian/custom/css/pages/" . basename($page, '.php') . ".css'>";


		echo $viewoutput;
		echo ReusableClasses::makeEditing();
		// echo $formoutput;

		ReusableClasses::addjs();

		echo "
			<script> 
				if( typeof Reusable === 'undefined' ) {
					var Reusable = new ReusableClasses();
				}
			</script>
		";

		Views::cleararrays();

				// ReusableClasses::addEditing($editing);
		echo "
			<script>
				$('.horizontal.main.adminbar.desktopnav.navbar-shadow .horizontal.button.edit_switch.wrapper  a.horizontal.topbar-button').click(function(e){
					e.preventDefault()
					Reusable.toggleEditing()
				})

			</script>
		";

	}

	public static function addEditing( $editing=false )
	{
		if( $editing ) {
			echo "
				Reusable.switchEditing(true)
				$('div.horizontal.main.adminbar.desktopnav.navbar-shadow').css({'background-color': '#FFF8E0'})
				$('.horizontal.button.edit_switch.wrapper.buttonindex_1  .horizontal.topbar-button label').html('Edit: <b style=\"color: green\">On</b>/Off');
			";
		}
	}

	public static function addReusableJS( $addjquery )
	{
		echo "
			<script src='/vendor/miltonian/reusables/assets/js/ReusableClasses.js'></script>
			<script src='/vendor/miltonian/reusables/assets/thirdparty/dropzone.js'></script>
			<script>

			if ( typeof ReusableClasses === 'function' ){
				let Reusables = new ReusableClasses();
				Reusables.addJQuery();
			}
			</script>
		";

		if( $addjquery ){
			echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>";

			echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
			<link rel="stylesheet" href="/resources/demos/style.css">
			<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
			<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
			<link rel="stylesheet" href="/vendor/miltonian/reusables/assets/thirdparty/jquery.timepicker.css">
			<script src="/vendor/miltonian/reusables/assets/thirdparty/jquery.timepicker.min.js"></script>';
		}
	}

	public static function testReusables()
	{
		// ReusableClasses::startpage( "" );
		Data::addData(["title"=>"It works!"], "test_header" );
		Header::set( "underline_edit", "test_header" );
		ReusableClasses::endpage( "", "" );
	}

	public static function addJSToView( $file, $custom_identifier=null, $func )
	{
		self::$addedjs .= "<script>
			" . $file . "." . $func . "( '" . $custom_identifier . "' );
		</script>";
	}

	public static function getOnStepForm( $identifier )
	{
		if( isset( self::$formonstep[ $identifier ] ) ) {
			$laststep = intval( self::$formonstep[$identifier] );
			$onstep = $laststep + 1;
			return $onstep;
		}else{
			return 1;
		}
	}

	public static function setOnStepForm( $identifier, $step )
	{
		if($identifier == null){ return; }
		self::$formonstep[$identifier] = $step;
	}

	public static function getLastInputIndexForForm( $identifier )
	{
		if( !isset( self::$forminputlastindexes[$identifier] ) ) {
			return null;
		}

		$lastindex = self::$forminputlastindexes[$identifier];
		return $lastindex;
	}

	public static function setFormInputIndex( $identifier, $index )
	{
		if( $identifier == null || $identifier==""){
			return;
		}
		self::$forminputlastindexes[$identifier] = $index;

	}

	public static function addEditor( $addit ) {
		if( $addit ) {
			echo '<script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>';
		// exit(json_encode( $addit ) );
		}
	}

	public static function getTypeArray( $input_onlykeys, $multiple_updates=false) {

		$typearray = [];

if($multiple_updates){
}
		$i=0;
		foreach ( $input_onlykeys as $k ) {
			if( $k == "download_script" ){
				array_push( $typearray, 'copybutton_1' );
			}else{
				if( $multiple_updates ) {
					// echo "console.log( 'lets see1: '+JSON.stringify( " . json_encode( Input::getInputTypes() ) . ")); ";
					// $inputtype = Input::getInputType( $k, $multiple_updates, $i );
					// array_push( $typearray, $inputtype );
					$typearray = Input::getInputTypes();
					break;
				}else{
					$inputtype = Input::getInputType( $k );
					array_push( $typearray, $inputtype );
				}
			}
			$i = $i+5;
			// if( $i > 3 ) {
			// 	$i=0;
			// }
		}
		if($multiple_updates){
	// echo "console.log( 'lets see3: '+JSON.stringify( " . json_encode( $typearray ) . ")); ";
}

		return $typearray;
	}

	public static function getEditingFunctionsJS( $dict )
	{

		$action_key = ReusableClasses::getViewActionKey( $dict );
		// if( $action_key == '' ){ return []; }
		$multiple = false;
		if( $action_key == '' ){ $actiondict = $dict; }else{ $actiondict = $dict[$action_key]; $multiple = true; }
		echo "var editingfunctions = [];";
		if( $multiple ) {
			$i=0;
			foreach ( $actiondict as $ca ) {
				$ca_type = Data::getValue( $ca, 'type' );
				if( $ca_type == "modal" ){
					if( isset( $ca_type[ 'modal' ] ) ) {
						echo "var thismodalclass = new " . $ca['modal']['modalclass'] . "Classes();
						editingfunctions.push( thismodalclass );";
					} else{
						echo 'editingfunctions.push( "nothing" );';
					}
				}else{
					echo 'editingfunctions.push( "nothing" );';
				}
				$i++;
			}
		}else{
			$ca_type = Data::getValue( $actiondict, 'type' );
			if( $ca_type == "modal" ){
				if( isset( $actiondict[ 'modal' ] ) ) {
					echo "var thismodalclass = new " . $actiondict['modal']['modalclass'] . "Classes();
					editingfunctions.push( thismodalclass );";
				} else{
					echo 'editingfunctions.push( "nothing" );';
				}
			}else{
				echo 'editingfunctions.push( "nothing" );';
			}
		}
	}

	public static function addEditingToCell( $identifier, $fullviewdict, $celltype )
	{
		$dict = [
			'identifier' => $identifier,
			'fullviewdict' => $fullviewdict,
			'celltype' => $celltype,
			'viewtype' => 'Cell'
		];
		array_push(self::$editableviews, $dict);

	}

	public static function makeEditing() {
		// ob_start();
// echo " <script> ";
		foreach (self::$editableviews as $e) {

			if( strtolower( $e['viewtype'] ) == 'cell' ) {
				echo " <script> ";
				ReusableClasses::makeCellEditing( $e['identifier'], $e['fullviewdict'], $e['celltype'] );
				echo " </script> ";
			} else {
				// echo " <script> ";
				// ReusableClasses::makeViewEditing( $e['viewdict'], $e['viewoptions'], $e['identifier'] );
				// echo " </script> ";
			}
		}

// echo " </script> ";

	}

	public static function makeCellEditing( $identifier, $fullviewdict, $celltype ) {
		$viewdict = Data::retrieveDataWithID( $identifier );
		$viewoptions = Data::retrieveOptionsWithID( $identifier );

		// echo " console.log( JSON.stringify( 'table: " . json_encode( $tableviewoptions ) . "' ) ); ";

		echo 'var thismodalclass = "";';
		echo 'var celltype = ' . json_encode( $celltype ) . ';';

		if( $celltype == "modal" ) {
			// if( $celltype == "modal" ) {
				// exit(json_encode( $identifier ) );
			// echo ' if (typeof ' . $viewoptions['modal']['modalclass'] . 'Classes == "undefined") { ';
			// 	$table_identifier = str_replace("_cell_" . $viewdict['index'], "", $identifier);
			// 	extract( Input::convertInputKeys( $table_identifier . "_form" ));
			// 	echo ' ' . Form::addJSClassToForm( $table_identifier . "_form", $viewdict, $input_onlykeys, $table_identifier . "_form" ) . '; ';
			// echo ' } ';
			// }
			echo 'thismodalclass = new ' . $viewoptions['modal']['modalclass'] . 'Classes();';
			
			echo 'var dataarray = ' . json_encode( $fullviewdict ) . ';';
		}else if( $celltype == "attached" ) {
			echo 'var dataarray = ' . json_encode( $fullviewdict ) . ';';
		}


		echo 'var viewdict = ' . json_encode($viewdict) . ';
		var viewoptions = ' . json_encode( $viewoptions ) . ';
		$(".' . $identifier . '").off().click(function(e){ ';
		echo " if( Reusable.isEditing() ) { ";
		echo 'var viewdict = ' . json_encode($viewdict) . ';
		var viewoptions = ' . json_encode( $viewoptions ) . ';';
		$formid = substr($identifier, 0, strpos($identifier, "_cell_")) . "_form";
		$formviewoptions = Data::retrieveOptionsWithID($formid);
		echo '
		var formviewoptions = ' . json_encode( $formviewoptions ) . ';';
			if( $celltype == "modal" ) {
				echo 'thismodalclass = new ' . $viewoptions['modal']['modalclass'] . 'Classes();';
				echo 'var dataarray = ' . json_encode( $fullviewdict ) . ';';
			}else if( $celltype == "attached" ) {
				echo 'var dataarray = ' . json_encode( $fullviewdict ) . ';';
			}
			echo '
			var celltype = ' . json_encode( $celltype) . ';
			if( celltype == "modal" || celltype == "dropdown" ) { 
				e.preventDefault();
				if( typeof dataarray === "undefined" ) { 
					dataarray = []
				}
				Reusable.addAction( viewdict, [thismodalclass], 0, dataarray, this, e, viewoptions, formviewoptions );
			}else if( celltype == "attached" ){
				e.preventDefault();
				dataarray = ' . json_encode( $fullviewdict ) . ';
				if( typeof dataarray === "undefined" ) { 
					dataarray = []
				}
				var firstkey = ' . json_encode( array_keys($viewdict)[0] ) . ';
				var theindex = parseInt( viewdict[firstkey]["index"] )
				Reusable.addAction( viewdict, [], theindex, dataarray, this, e, viewoptions );
			}';
			
			ReusableClasses::getEditingFunctionsJS( $viewoptions ) ;


			// echo 'if( typeof dataarray === "undefined" ) {
			// 	dataarray = []
			// }
			// var viewdict = ' . json_encode($viewdict) . ';';
			// echo 'var viewoptions = ' . json_encode( $viewoptions ) . ';
			// Reusable.addAction( viewdict, [thismodalclass], 0, dataarray, this, e, viewoptions );';
		echo '}';
		echo '});';
	}

	public static function makeViewEditing( $viewdict, $viewoptions, $identifier, $alwayseditable=false ) {

		echo " let alwayseditable = " . json_encode( $alwayseditable ) . "; ";
		echo " if( Reusable.isEditing() || alwayseditable ) { ";

		$fullarray = Data::getFullArray( $viewdict );
		if( isset( $viewdict[$identifier]['value'] ) ) {
			$fullviewdict = Data::getFullArray( $viewdict )[$identifier]['value'];
		}else{
			$fullviewdict = $viewdict;
		}

		$optiontype = Data::getValue( $viewoptions, 'type' );

		echo "var viewdict = " . json_encode( $viewdict ) . ";
		var viewoptions = " . json_encode( $viewoptions ) . ";

		var thismodalclass = '';

		var type = " . json_encode( $optiontype ) . ";";
		echo "console.log( JSON.stringify( ".json_encode( $optiontype )." ) );";

		if( $optiontype == "modal" ){ 
			// extract( Input::convertInputKeys( $identifier . "_form" ));
			// 	echo ' ' . Form::addJSClassToForm( $identifier . "_form", $viewdict, $input_onlykeys, $identifier . "_form" ) . '; ';
			// 	echo " /*asdf*/ ";
			echo "thismodalclass = new " . $viewoptions['modal']['modalclass'] . "Classes();
			var dataarray = " . json_encode( $fullviewdict ) . ";";
		}
		echo "
		var optiontype = " . json_encode($optiontype) . ";";
		$formid = $identifier . "_form";
		$formviewoptions = Data::retrieveOptionsWithID($formid);
		echo '
		var formviewoptions = ' . json_encode( $formviewoptions ) . ";
		var identifier = " . json_encode( $identifier ) . ";

		if( optiontype == 'modal' || optiontype == 'dropdown' ) { 
			e.preventDefault();
			if( typeof dataarray === 'undefined' ) { 
				dataarray = []
			}

			Reusable.addAction( viewdict, [thismodalclass], 0, dataarray, this, e, viewoptions, formviewoptions, identifier );
		}";

		ReusableClasses::getEditingFunctionsJS( $viewoptions ) ;

		echo " } ";
	}

	public static function getDropdownFunctionsJS( $dict )
	{
		$action_key = ReusableClasses::getViewActionKey( $dict );
		if( $action_key == '' ){ return []; }
		
		echo "var dropdownfunctions = [];";
		$i=0;
		foreach ( $dict[$action_key] as $ca ) {
			$ca_type = Data::getValue( $ca, 'type' );
			if( $ca_type == "modal" ){
				echo "var thismodalclass = new " . $ca['modal']['modalclass'] . "Classes();
				dropdownfunctions.push( thismodalclass );";
			}else{
				echo 'dropdownfunctions.push( "nothing" );';
			}
			$i++;
		}
	}


	public static function convertViewActions( $dict )
	{
		if( $dict == null ) {
			return [];
		}
		$action_key = ReusableClasses::getViewActionKey( $dict );
		$multiple = false;
		if( $action_key == '' ){ $actiondict = $dict; }else{ $actiondict = $dict[$action_key]; $multiple = true; }
		
		if( $multiple ) {
			$i=0;
			foreach ($actiondict as $action) {
				// exit( json_encode( $action ) );
				if( isset( $action['modal'] ) ){
					$actiondict[$i]['type'] = "modal";
					$actionmodal = Data::getValue( $action, 'modal' );
					if( !is_array( $actionmodal ) && $actionmodal != "" ){
						$new_actionmodal = [
							"parentclass" => $actionmodal . "_wrapper", 
							"modalclass" => $actionmodal
						];
						$actiondict[$i]['modal'] = $new_actionmodal;
					}
				}
				$i++;
			}
		}else {
				if( isset( $actiondict['modal'] ) ){
					$actiondict['type'] = "modal";
					$actionmodal = Data::getValue( $actiondict, 'modal' );
					if( !is_array( $actionmodal ) && $actionmodal != "" ){
						$new_actionmodal = [
							"parentclass" => $actionmodal . "_wrapper", 
							"modalclass" => $actionmodal
						];
						$actiondict['modal'] = $new_actionmodal;
					}
				}
		}

		if( $action_key == '' ){ $dict = $actiondict; }else{ $dict[$action_key] = $actiondict; }

		return $dict;
	}

	public static function getViewActionKey( $dict )
	{
		$action_key = '';
		if( isset( $dict['buttons'] ) ){
			$action_key = 'buttons';
		}else if( isset($dict['actions']) ) {
			$action_key = 'actions';
		}

		return $action_key;
	}

	public static function autoMakeView( $viewtype, $viewname, $identifier ) {

		call_user_func_array("Reusables\\".$viewtype . "::set", [ $viewname, $identifier  ] );

	}

	public static function autoMakeStructure( $viewname, $innerviews, $identifier ) {

		$viewtype = "Structure";
		$containerviews = [];
		$i=0;
		foreach ($innerviews as $v) {
			if( !isset( $containerviews[ $v['container_key'] ] ) ) {
				$containerviews[ $v['container_key'] ] = [];
			}
			$view = call_user_func_array("Reusables\\".$v['viewtype'] . "::make", [ $v['viewname'], $identifier . "_" . $i  ] );
			array_push( $containerviews[ $v['container_key'] ], $view );
			$i++;
		}
		call_user_func_array("Reusables\\".$viewtype . "::set", [ $viewname, $containerviews, $identifier  ] );

	}

	public static function setUpEditingForSection( $viewdict, $viewoptions, $identifier, $alwayseditable=false )
	{


		// echo " <script> ";
			ReusableClasses::makeViewEditing( $viewdict, $viewoptions, $identifier, $alwayseditable );
		// echo " </script> ";

		// $dict = [
		// 	'identifier' => $identifier,
		// 	'viewdict' => $viewdict,
		// 	'viewoptions' => $viewoptions,
		// 	'viewtype' => 'View'
		// ];
		// array_push(self::$editableviews, $dict);
		

	}




















	public static function cell( $file, $data )
	{
		$View = View::factory( 'reusables/views/cell/' . $file );
		$View->set( 'celldict', $data );
		echo $View->render();
	}
	public static function section( $file, $data )
	{
		$View = View::factory( 'reusables/views/section/' . $file );
		$View->set( 'sectiondict', $data );
		echo $View->render();
	}
	public static function table( $file, $data )
	{
		$View = View::factory( 'reusables/views/table/' . $file );
		$View->set( 'tabledict', $data );
		echo $View->render();
	}
	public static function header( $file, $data )
	{
		$View = View::factory( 'reusables/views/header/' . $file );
		$View->set( 'headerdict', $data );
		echo $View->render();
	}
	public static function wrapper( $file, $data )
	{
		$View = View::factory( 'reusables/views/wrapper/' . $file );
		$View->set( 'children', $data['children'] );
		$View->set( 'wrapperdict', $data );
		echo $View->render();
	}
	public static function postinternal( $file, $data )
	{
		$View = View::factory( 'reusables/views/postinternal/' . $file );
		$View->set( 'sharingdict', $data['sharingdict'] );
		$View->set( 'postdict', $data );
		echo $View->render();
	}
	public static function structure( $file, $data )
	{
		$View = View::factory( 'reusables/views/structure/' . $file );
		$View->set( 'structuredict', $data );
		echo $View->render();
	}
	public static function sharing( $file, $data )
	{
		$View = View::factory( 'reusables/views/sharing/' . $file );
		$View->set( 'sharingdict', $data );
		echo $View->render();
	}



	public static function getTestArrays( $whichone ){
		$sendback = [];
		if( $whichone==1 ){
			$sendback=self::getTestForHome();
		}else if( $whichone==2 ){
			$sendback=self::getTestForPost();
		}
		return $sendback;
	}

	public static function getTestForHome(){
		$sectiondict = [
			"post_id"=>"0",
			"title"=>"the title",
			"html_text"=>"lorem ipsum stuff you know you know?",
			"featured_imagepath"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/Blue_Bird_Vision_Montevideo_54.jpg/250px-Blue_Bird_Vision_Montevideo_54.jpg",
			"isfeatured"=>false,
			"mediatype"=>"image",
		];
		$postarray = array(
			$sectiondict,
			$sectiondict,
			$sectiondict,
			$sectiondict,
			$sectiondict,
			$sectiondict
		);
		$testarray = array(
			"adposition"=>0,
			"featured_imagepath"=>"http://rocketjar.com/uploads/network-image/34.network-image.1496928583.IHS-(146).jpg",
			"logo_imagepath"=>"http://rocketjar.com/uploads/network-logo/34.network-logo.1496928761.mocklogo.png",
			"title"=>"Hamilton High School",
			"desc"=>"Hamilton High School, Hamilton is a public four-year high school located at 123 Newton Ave in Bicentennial Park, Tennessee, in the United States. It is part of Consolidated High School District 230, which also includes Victor J. Andrew High School and Amos Alonzo Stagg High School. The school is named for first treasurer of the United States of America, Alexander Hamilton.",
			"html_text"=>"Hamilton High School, Hamilton is a public four-year high school located at 123 Newton Ave in Bicentennial Park, Tennessee, in the United States. It is part of Consolidated High School District 230, which also includes Victor J. Andrew High School and Amos Alonzo Stagg High School. The school is named for first treasurer of the United States of America, Alexander Hamilton.",
			"postarray"=>$postarray,
			"children"=>array(["filename"=>"underline_edit", "viewtype"=>"header", "data"=>[] ], ["filename"=>"table_1", "viewtype"=>"table", "data"=>[] ])
		);
		for ($i=0; $i < sizeof($testarray['children']); $i++) { 
			$testarray['children'][$i]['data'] = $testarray;
		}
		$sectiondict1 = [
			"featured_imagepath"=>"http://rocketjar.com/uploads/network-image/34.network-image.1496928583.IHS-(146).jpg",
			"logo_imagepath"=>"http://rocketjar.com/uploads/network-logo/34.network-logo.1496928761.mocklogo.png",
			"title"=>"Hamilton High School",
			"adposition"=>0,
			"desc"=>"Hamilton High School, Hamilton is a public four-year high school located at 123 Newton Ave in Bicentennial Park, Tennessee, in the United States. It is part of Consolidated High School District 230, which also includes Victor J. Andrew High School and Amos Alonzo Stagg High School. The school is named for first treasurer of the United States of America, Alexander Hamilton."
		];
		$postdict = [
			"isfeatured"=>false,
			"mediatype"=>"image",
			"post_id"=>"0",
			"title"=>"The Title",
			"html_text"=>"lorem ipsum stuff you know you know?",
			"featured_imagepath"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/Blue_Bird_Vision_Montevideo_54.jpg/250px-Blue_Bird_Vision_Montevideo_54.jpg",
			"date"=>"",
		];
		$tabledict = [
			"postarray"=>array($postdict, $postdict, $postdict, $postdict, $postdict, $postdict, $postdict, $postdict)
		];

		$sendback = [
			"postarray"=>$postarray,
			"testarray"=>$testarray,
			"sectiondict1"=>$sectiondict1,
			"tabledict"=>$tabledict
		];

		return $sendback;
	}

	public static function getTestForPost(){
		$sectiondict = [
			"post_id"=>"0",
			"title"=>"the title",
			"html_text"=>"lorem ipsum stuff you know you know?",
			"featured_imagepath"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/Blue_Bird_Vision_Montevideo_54.jpg/250px-Blue_Bird_Vision_Montevideo_54.jpg",
			"isfeatured"=>false,
			"mediatype"=>"image",
		];
		$postarray = array(
			$sectiondict,
			$sectiondict,
			$sectiondict,
			$sectiondict,
			$sectiondict,
			$sectiondict
		);
		// only one featured_imagepath per post
		// only one logo_imagpeath per post
		$testarray = array(
			"adposition"=>0,
			"featured_imagepath"=>"http://rocketjar.com/uploads/network-image/34.network-image.1496928583.IHS-(146).jpg",
			"logo_imagepath"=>"http://rocketjar.com/uploads/network-logo/34.network-logo.1496928761.mocklogo.png",
			"title"=>"Hamilton High School",
			"desc"=>"Hamilton High School, Hamilton is a public four-year high school located at 123 Newton Ave in Bicentennial Park, Tennessee, in the United States. It is part of Consolidated High School District 230, which also includes Victor J. Andrew High School and Amos Alonzo Stagg High School. The school is named for first treasurer of the United States of America, Alexander Hamilton.",
			"html_text"=>"Hamilton High School, Hamilton is a public four-year high school located at 123 Newton Ave in Bicentennial Park, Tennessee, in the United States. It is part of Consolidated High School District 230, which also includes Victor J. Andrew High School and Amos Alonzo Stagg High School. The school is named for first treasurer of the United States of America, Alexander Hamilton.",
			"postarray"=>$postarray,
			"goal"=>"4000000",
			"funded"=>"2319900",
			"funders"=>"6",
			"sharingdict"=>["facebook"=>"", "twitter"=>""]
		);
		$rewardsdict = [
			"price"=>"$150",
			"title"=>"Sponsor a Seat",
			"desc"=>"What a huge help you are! We thank you so much and would like to put your name on one of our seats.",
		];
		$rewardsarray = array(
			$rewardsdict, $rewardsdict, $rewardsdict
		);
		$testarray2 = array(
			"adposition"=>0,
			"featured_imagepath"=>"http://rocketjar.com/uploads/network-image/34.network-image.1496928583.IHS-(146).jpg",
			"logo_imagepath"=>"http://rocketjar.com/uploads/network-logo/34.network-logo.1496928761.mocklogo.png",
			"title"=>"Rewards",
			"desc"=>"Hamilton High School, Hamilton is a public four-year high school located at 123 Newton Ave in Bicentennial Park, Tennessee, in the United States. It is part of Consolidated High School District 230, which also includes Victor J. Andrew High School and Amos Alonzo Stagg High School. The school is named for first treasurer of the United States of America, Alexander Hamilton.",
			"html_text"=>"Hamilton High School, Hamilton is a public four-year high school located at 123 Newton Ave in Bicentennial Park, Tennessee, in the United States. It is part of Consolidated High School District 230, which also includes Victor J. Andrew High School and Amos Alonzo Stagg High School. The school is named for first treasurer of the United States of America, Alexander Hamilton.",
			"postarray"=>$rewardsarray,
			"sharingdict"=>["facebook"=>"", "twitter"=>""]
		);
		$postinternalarray = $testarray;

		$sendback = [
			"postarray"=>$postarray,
			"testarray"=>$testarray,
			"testarray2"=>$testarray2,
			"postinternalarray"=>$postinternalarray
		];

		return $sendback;
	}

	
		public static function getPosts_tablenames($postarray){
			// make dict for tablenames
			$tablenames = [];
			$allkeys = array_keys($postarray[0]);
			foreach ($allkeys as $k) {
				$tablenames[$k] = "posts";
			}
			return $tablenames;
		}
	
		public static function getMainCategories_tablenames( $categories )
		{
			// make dict for tablenames
			$tablenames = [];
			$allkeys = array_keys($categories[0]);
			foreach ($allkeys as $k) {
				$tablenames[$k] = "main_categories";
			}
			return $tablenames;
		}

	

	public static function toValueAndDBInfo( $result, $conditions, $default_table, $customcolname=null )
	{
		if( sizeof( $result ) == 0 ) {
			return $result;
		}
		if( isset( $result[0] ) ) {
			if( $result[0] == 0 ) {
				return $result;
			}
		}
		$i=0;
		foreach ($conditions as $c) {
			if( sizeof( $c ) == 0 ) {
				continue;
			}
			$key_arr = explode(".", $c['key']);
			if( sizeof($key_arr) < 2  ) {
				$conditions[$i]['key'] = $default_table.".".$c['key'];
			}
			$i++;
		}
		// exit( json_encode( $conditions ) );
		$newresult = [];

		foreach ($result as $key => $value) {
			if( !is_numeric($key) ) {
				$newresult[$default_table . "." . $key] = $result[$key];
			} else {
				// exit( json_encode( $value ) );
				$newvalue = [];
				foreach ($value as $k=>$v) {
					$newvalue[$default_table . "." . $k] = $value[$k];
				}
				if( sizeof($newvalue) > 0 ) {
					$value = $newvalue;
					$result[$key] = $value;
				}
			}
		}
		if( sizeof($newresult) > 0 ) {
			$result = $newresult;
		}
// exit( json_encode( $result ) );
		$tablenames = [];
		$colnames = [];
		$thisdict = [];
		if ( Data::isAssoc( $result ) ) {
			// is dict
			if( $result == null ){
				return [];
			}
			$thisdict = $result;
		}else{
			// is array
			if( !isset($result[0]) ){
				return [];
			}

			$thisdict = $result[0];

		}
		$allkeys = array_keys($thisdict);

		foreach ($allkeys as $k) {
			$tablenames[$k] = $default_table;
			if( $customcolname ){
				$colnames[$k] = $customcolname;
			}else{
				$colname_arr = explode(".", $k);
				$addtable = true;
				if( isset($colname_arr) ) {
					if( sizeof($colname_arr) > 1 ) {
						$addtable = false;
					}
				}
				if( $addtable ) {
					$colnames[$k] = $default_table.".".$k;
				} else {
					$colnames[$k] = $k;
				}

			}
		}
		$returningdict = [
			"value" => $result,
			"db_info" => [
				"tablenames" => $tablenames,
				"colnames" => $colnames,
				"conditions" => $conditions
			]
		];

		return $returningdict;
	}

	
		public static function getNetworkInfo_db($networkinfo){
			// make dict for tablenames
			$array_for_db = [];
			$allkeys = array_keys($networkinfo[0]);
			// exit(json_encode())
			foreach ($allkeys as $k) {

				if($k=="name"){
					$array_for_db[$k]['tablename'] = "networks";
				}else{
					$array_for_db[$k]['tablename'] = "network_info";
				}
			}
			return $array_for_db;
		}

	public static function checkRequired( $filename, $viewdict, $required )
	{
		$requiredkeys = array_keys($required);

		$missing = false;
		foreach ($requiredkeys as $r) {
			$keys = explode("|", $r);
			// $condition = str_replace("|", " || ", $r);
			$condition = "";
			$i=0;
			$found=false;
			foreach ($keys as $k) {
				if( isset( $viewdict[$k] ) ){ $found=true; }
			}
			
			if( !$found ){ 
				$missing=true; echo $filename . " is missing " . $r . "<br>"; 
			}
		}

		if ($missing) {
			exit();
		}
	}

	public static function ordinal($number) {
	    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
	    if ((($number % 100) >= 11) && (($number%100) <= 13))
	        return $number. 'th';
	    else
	        return $number. $ends[$number % 10];
	}



	// Function to echo chosen error message:
	private function error( $msg ) { echo "<br />! Error: $msg<br />"; }
	// Function to return encrypted version of $x:
	private function encryptIt( $x ) { return( str_replace( '/', '', base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( self::$cryptKey ), $x, MCRYPT_MODE_CBC, md5( md5( self::$cryptKey ) ) ) ) ) ); }
	// Function to return decrypted version of $x:
	private function decryptIt( $x ) { return( rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( self::$cryptKey ), base64_decode( $x ), MCRYPT_MODE_CBC, md5( md5( self::$cryptKey ) ) ), "\0") ); }
	
	public function __destruct()
	{
		if( isset( $this->PDO ) ) unset( $this->PDO );
		if( isset( $this->cryptKey ) ) unset( $this->cryptKey );
	}

}


// --------------------------
/* END: ugoinout_classes/barhop_classes.php */ ?>