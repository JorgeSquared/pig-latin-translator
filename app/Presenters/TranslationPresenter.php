<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class TranslationPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $db,
    )
    {
    }

    public function renderShow(int $translationId): void
    {
        $this->template->translation = $this->db
            ->table('translations')
            ->get($translationId);
    }
}
