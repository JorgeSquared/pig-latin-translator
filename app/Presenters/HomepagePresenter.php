<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;


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
                ->where('id', $translationId)
                ->update([
                    'translation' => $this->translateIntoPigLatin($translation->content),
                ]);
        }

        $this->flashMessage('Your text in Pig Latin:', 'success');

        $this->redirect('translation:show', [$translationId]);
    }

    private function translateIntoPigLatin(string $origin): string
    {
        //we are brave (or silly?) and truncate special characters also,
        //so that our future selves can have hard times to restore the text
        //from piggy latin back to english, with the correct punctuation letters
        $cleanInput = Strings::webalize(Strings::lower(Strings::trim($origin)));
        $wordsToTranslate = explode('-', $cleanInput);

        //First rule of Piggy Latin: we don't want to append "ay" to words
        //that formally start with a vowel (like 'you', which phonetically starts
        //with 'u' consonant in fact), and, on the other hand, we definitely
        //want to append "ay" to words that formally look like starting with
        //a consonant but phonetically start with a vowel, like 'x-ray'
        $vowelPattern = '/^([aeiou]|xr|yt).*/';

        foreach ($wordsToTranslate as $key => $wordToTranslate) {
            if (preg_match($vowelPattern, $wordToTranslate)) {
                $wordsToTranslate[$key] .= 'ay';
            }
        }

        return implode(' ', $wordsToTranslate);
    }
}
