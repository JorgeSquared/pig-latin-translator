<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $db,
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
        $this->db->table('translations')
            ->insert([
                'content' => $data->content,
            ]);

        $translations = $this->db->table('translations')
            ->order('id DESC')
            ->limit(1);

        $translationId = 1;
        foreach ($translations as $translation) {
            $translationId = $translation->id;
            $this->db->table('translations')
                ->update([
                    'translation' => $this->translateIntoPigLatin($translation->content),
                ]);
        }

        $this->flashMessage('Your text in Pig Latin:', 'success');

        $this->redirect('translation:show', [$translationId]);
    }

    private function translateIntoPigLatin(string $origin): string
    {
        return strrev($origin);
    }
}
