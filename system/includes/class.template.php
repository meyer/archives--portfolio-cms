<?php

// Template Class
class Template {
	private static $data = array();
	private static $template_name;

	public function __construct( $name, $render = false ){
		$p = Portfolio::get_instance();

		if( file_exists( TEMPLATE_PATH . $name.".php" ) ){
			self::$template_name = TEMPLATE_PATH . $name.".php";
		} else {
			die( "Problem loading <strong>{$name}.php</strong>" );
		}

		self::set("body_id",$name);

		if( $p->meta("sitename") ){
			self::set("sitename",$p->meta("sitename"));
		} else {
			self::set("sitename","SITE NAME NOT SET");
		}
		self::set("page_title",false);

		self::set( 'items_by_id', $p->items_by_id() );
		self::set( 'items_by_project', $p->items_by_project() );
		self::set( 'projects_by_id', $p->projects_by_id() );
		self::set( 'projects_by_slug', $p->projects_by_slug() );

		if( $render ) self::render();
	}

	public static function set($k, $v){
		self::$data[$k] = $v;
	}

	public static function render(){
		extract( self::$data );
		if( !empty( $status_code ) ){
			switch( $status_code ){
				case 404:
				echo "<!-- 404 error -->";
				break;
			}
		}
		include_once( TEMPLATE_PATH . "snippets/header.php" );
		echo "\n\n";
		include_once( self::$template_name );
		echo "\n\n";
		include_once( TEMPLATE_PATH . "snippets/footer.php" );
		exit();
	}
}


?>