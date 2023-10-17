<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\UI\Components\Form;


final class HomePresenter extends Nette\Application\UI\Presenter
{

    public function beforeRender(): void
    {
        //directory for components
        $this->template->cDir= __DIR__.'/../UI/Components/templates/';
    }


    protected function createComponentRegistrationForm(): Form
	{
		$form = new Form;
		$form->addText('name', 'Jméno:');
		$form->addPassword('password', 'Heslo:');
        
        
        $sex = [
            'zs' => 'Základní',
            'ss' => 'Střední',
        ];
        $form->addRadioList('school', 'Škola:', $sex);

		$form->addSubmit('send', 'Registrovat');
		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	public function formSucceeded(Form $form, $data): void
	{
		$this->flashMessage('Byl jste úspěšně registrován.');
		$this->redirect('this');
	}
}
