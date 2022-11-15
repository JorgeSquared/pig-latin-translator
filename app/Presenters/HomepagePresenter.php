<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\TranslationFacade;
use App\Model\TranslationModel;
use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private readonly TranslationFacade $translationFacade,
        private readonly TranslationModel $translationModel,
    )
    {
    }

    protected function createComponentTranslationForm(): Nette\Forms\Form
    {
        $form = new Form;

        $form->addTextArea('content', 'Say something (in English, please):')
            ->setRequired();

        $form->addSubmit('send', 'Translate');

        $form->onSuccess[] = [$this, 'translationFormSucceeded'];

        return $form;
    }

    public function translationFormSucceeded(\stdClass $data): void
    {
        $this->translationFacade->insertContentToTranslate($data);

        $translations = $this->translationFacade->getTranslations(1);

        $translationId = 1;
        foreach ($translations as $translation) {
            $translationId = $translation->id;
            $this->translationFacade->saveTranslationContentByTranslationId(
                $this->translationModel->translateIntoPigLatin($translation->content),
                $translationId,
            );
        }

        $this->flashMessage('Your text in Pig Latin:', 'success');

        $this->redirect('translation:show', [$translationId]);
    }
}
