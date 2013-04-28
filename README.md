x_captcha
=========

captcha plugin for atk4


        $form = $this->add('Form');
        $form->addField('line','captcha')->add('x_captcha/Controller_Captcha');
        $form->addSubmit('Check');
        $form->onSubmit(function($form){
            if ($form->get('captcha') == $form->getElement('captcha')->captcha->recallCaptcha()) {
                $form->js()->univ()->successMessage('Captcha is OK!')->execute();
            } else {
                $form->js()->atk4_form('fieldError','captcha','Wrong captcha!')->execute();
            }
        });
