x_captcha
=========

captcha plugin for atk4


        $form = $this->add('Form');
        $form->addField('Line','captcha')->add('x_captcha/Controller_Captcha');
        $form->addSubmit('Check');
        $form->onSubmit(function($form){
            if (!$this->getElement('captcha')->captcha->isSame($this->get('captcha'))) {
                $form->js()->univ()->successMessage('Captcha is OK!')->execute();
            } else {
                $form->js()->atk4_form('fieldError','captcha','Wrong captcha!')->execute();
            }
        });


If you need case unsensetive captcha just pass false as a second argument for method isSame

        if (!$this->getElement('captcha')->captcha->isSame($this->get('captcha',false)))