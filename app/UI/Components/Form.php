<?php
namespace App\UI\Components;

use Nette;

class Form extends Nette\Application\UI\Form {

    /** @var \Kdyby\Translation\Translator @inject*/
    private $internalTranslator;
    
    public function __construct() {
        parent::__construct();                
        $renderer = $this->getRenderer();
		$renderer->wrappers['controls']['container'] = NULL;
		$renderer->wrappers['pair']['container'] = 'div class=mb-3';
		$renderer->wrappers['pair']['.error'] = 'has-error';
		$renderer->wrappers['label']['container'] = null;
        $renderer->wrappers['control']['container'] = 'div class=mt-2';
		$renderer->wrappers['control']['description'] = 'span class=help-block';
		$renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';
		$renderer->wrappers['error'] = array(
            'container' => 'div class="alert alert-danger" role="alert"',
            'item' => NULL,
        );

		$this->getElementPrototype()->class('form');

        $self = $this;

		$this->onRender[] = function ($self) {
			foreach ($this->getControls() as $control) {

                $control->getLabelPrototype()->addClass('block font-medium leading-6 text-gray-900');


				$type = $control->getOption('type');
				if ($type === 'button') {
					$control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary btn-sm' : 'btn');
					$usedPrimary = TRUE;
				} elseif (in_array($type, ['text', 'textarea', 'select'], TRUE)) {
					if($control->getHtmlName()=="recaptcha"){
                        $control->getLabelPrototype()->addClass('recaptcha-label');
                    }
                    else{
                        $control->getControlPrototype()->addClass('block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6');
                    }
				} elseif (in_array($type, ['checkbox', 'radio'], TRUE)) {
					$control->getSeparatorPrototype()->setName('div')->addClass('');
                    $control->getControlPrototype()->addClass('h-4 w-4 mr-3 border-gray-200 text-indigo-500 focus:ring-indigo-500');
                    $control->getItemLabelPrototype()->addClass('text-sm font-medium leading-6 text-gray-900 flex items-center');
                }
                else{
                }
			}
		};

        $this->addProtection('Vypršel časový limit formuláře, odešlete jej znovu.');
    }
    
    public function addSubmit(string $name, $caption = null): Nette\Forms\Controls\SubmitButton {
        $input=parent::addSubmit($name, $caption);
        return $input;        
    }
    
    public function setInternalTranslator($translator){
        $this->internalTranslator=$translator;
    }
    
    //vlastní políčkao kvůli textům překladů - aby se nemusely všude generovat
    public function addTextTranslated($name, $title, $parameters=array())
    {
        $this->addText($name,$this->internalTranslator->translate($title));
        $this->setTranslatedParameters($name, $parameters);       
        
        return $this[$name];
    }
    public function addPasswordTranslated($name, $title, $parameters=array())
    {
        $this->addPassword($name,$this->internalTranslator->translate($title));
        $this->setTranslatedParameters($name, $parameters);       
        
        return $this[$name];
    }
    public function addEmailTranslated($name, $title, $parameters=array())
    {
        $this->addText($name,$this->internalTranslator->translate($title))
                ->addRule(Form::EMAIL, $this->internalTranslator->translate('form.input.rule.email'));
        $this->setTranslatedParameters($name, $parameters);     
        return $this[$name];
    }
    public function addTextareaTranslated($name, $title, $parameters=array())
    {
        $this->addTextarea($name,$this->internalTranslator->translate($title));
        $this->setTranslatedParameters($name, $parameters);        
        return $this[$name];
    }
    public function addSubmitTranslated($name, $title)
    {
        $this->addSubmit($name,$this->internalTranslator->translate($title));   
        return $this[$name];
    }
    public function addSelectTranslated($name, $title, $items)
    {
        $this->addSelect($name,$this->internalTranslator->translate($title),$items); 
        return $this[$name];
    }

    private function setTranslatedParameters($name,$parameters){
        if(isset($parameters['required']) and $parameters['required']==true){
            $this[$name]->setRequired($this->internalTranslator->translate('form.input.rule.required').' "%label"');
        }
        else{
            $this[$name]->setRequired(false);
        }
        if(isset($parameters['maxLength'])){
            $this[$name]->addRule(Form::MAX_LENGTH, '%label '.$this->internalTranslator->translate('form.input.rule.max_length',$parameters['maxLength']),  $parameters['maxLength']);
        }
        if(isset($parameters['minLength'])){
            $this[$name]->addRule(Form::MIN_LENGTH, '%label '.$this->internalTranslator->translate('form.input.rule.min_length',$parameters['minLength']),  $parameters['minLength']);
        }
        if(isset($parameters['companyIdValidation'])){
            $this[$name]->addFilter(function ($value) {
                return preg_replace('#\s+#', '', $value);
            });
            $this[$name]->addRule('\App\Components\Validators::companyId',$this->internalTranslator->translate('form.input.rule.company_id'));
        }

        if(isset($parameters['tabindex'])){
            $this[$name]->setHtmlAttribute('tabindex',$parameters['tabindex']);
        }
    }

}
//TODO: errory do javascriptových okének?