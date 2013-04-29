<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 4/28/13
 * Time: 9:57 PM
 * To change this template use File | Settings | File Templates.
 */
namespace x_captcha;
class Controller_Captcha extends \Controller {
    function init() {
        parent::init();
        if (!class_exists('\Imagick',false)) throw $this->exception('Imagick is not installed');
        if (get_class($this->owner)!='Form_Field_Line') throw $this->exception('Captcha can be connected to Form_Field_Line only');

        $this->owner->captcha = $this;

        $this->addCaptcha();
    }
    function memorizeCaptcha($value) {
        $this->api->memorize($this->owner->name.'_captcha_value',$value);
    }
    function recallCaptcha() {
        if ($this->api->recall($this->owner->name.'_captcha_value')===null)
            $this->api->js()->univ()->errorMessage('Error! Reload captcha and try again!')->execute();
        return $this->api->recall($this->owner->name.'_captcha_value');
    }
    private function addCaptcha() {
        if ($_GET['captcha_view']) {
            $this->add('x_captcha\View_Captcha',array(
                'controller' => $this,
            ));
        } else {
            $view = $this->owner->aboveField();
            $view->setHTML('<img src="'.$this->api->url(null,array('captcha_view'=>'true')).'" />');
            $view->js('click')->reload();
        }
    }
}