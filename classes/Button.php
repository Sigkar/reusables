<?php 

namespace Reusables;

class Button {
	
	public static function place( $file, $identifier )
	{
		Views::addToQueue( "Button", $file, $identifier );
	}

	public static function set( $file, $identifier )
	{
		Views::setDefaultViewInfo( $file, $identifier, "button" );
	}

	public static function setincontainer( $file, $identifier )
	{
		Views::addEditableParts( $identifier );
		return Button::make( $file, $identifier );
	}

	public static function make( $file, $identifier )
	{

		return Views::makeView( $file, $identifier, "button" );
	}

	// public static function make( $file, $identifier )
	// {
	// 	ReusableClasses::addfile( "button", $file );
	// 	$View = View::factory( 'reusables/views/button/' . $file );
	// 	$data = Data::retrieveDataWithID( $identifier );
	// 	$View->set( 'buttondict', $data );
	// 	$View->set( 'identifier', $identifier );
	// 	return $View->render();
	// }

}