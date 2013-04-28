<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 4/28/13
 * Time: 9:53 PM
 * To change this template use File | Settings | File Templates.
 */
namespace x_captcha;
class View_Captcha extends \View {
    public $Imagick;
    public $bg_color = 'white';
    public $alphanum = 'ABXZRMHTL23456789';
    public $image_format = 'png';
    public $text_length = 6;
    function init() {
        parent::init();
        $this->getImage();
    }
    function getImage() {
        $this->createImage();
        header( "Content-Type: image/{$this->Imagick->getImageFormat()}" );
        echo $this->Imagick->getImageBlob( );
        exit();
    }
    private function createImage() {
        /* Create Imagick object */
        $this->Imagick = new \Imagick();

        /* Create the ImagickPixel object (used to set the background color on image) */
        $bg = new \ImagickPixel();

        /* Set the pixel color to white */
        $bg->setColor( $this->bg_color );

        /* Create a drawing object and set the font size */
        $ImagickDraw = new \ImagickDraw();

        /* Set font and font size. You can also specify /path/to/font.ttf */
        //$ImagickDraw->setFont( 'Helvetica Regular' );
        $ImagickDraw->setFontSize( 20 );

        /* Create new empty image */
        $this->Imagick->newImage( 85, 30, $bg );

        /* Write the text on the image */
        $this->Imagick->annotateImage( $ImagickDraw, 4, 20, 0, $this->getCaptchaText() );

        /* Add some swirl */
        $this->Imagick->swirlImage( 20 );

        /* Create a few random lines */
        $ImagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
        $ImagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
        $ImagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
        $ImagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
        $ImagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );

        /* Draw the ImagickDraw object contents to the image. */
        $this->Imagick->drawImage( $ImagickDraw );

        /* Give the image a format */
        $this->Imagick->setImageFormat( $this->image_format );
    }
    private function getCaptchaText(){
        $string = substr( str_shuffle( $this->alphanum ), 2, $this->text_length );
        $this->controller->memorizeCaptcha($string);
        return $string;
    }






    function render(){
        /*
   		$this->js(true)
   			->_load('x_tags')
   			->_css('x_tags');
        */
   		return parent::render();
   	}
    function defaultTemplate() {
		// add add-on locations to pathfinder
		$l = $this->api->locate('addons',__NAMESPACE__,'location');
		$addon_location = $this->api->locate('addons',__NAMESPACE__);
		$this->api->pathfinder->addLocation($addon_location,array(
			//'js'=>'templates/js',
			//'css'=>'templates/css',
            //'template'=>'templates',
		))->setParent($l);

        //return array('view/lister/tags');
        return parent::defaultTemplate();
    }
}