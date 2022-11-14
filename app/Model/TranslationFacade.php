<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\SmartObject;

final class TranslationFacade
{
    use SmartObject;
    public function __construct(
        private Explorer $database,
    )
    {}

    public function getAll(): Selection
    {
        return $this->database->table('translations');
    }

    public function getTranslations(?int $limit = null): Selection
    {
        $returnValue = $this->getAll()
            ->order('id DESC');

        if ($limit) {
            $returnValue->limit($limit);
        }

        return $returnValue;
    }

    public function insertContentToTranslate(\stdClass $data): ActiveRow
    {
        return $this->getAll()->insert([
            'content' => $data->content,
        ]);
    }

    public function saveTranslationContentByTranslationId(string $translationContent, int $translationId): int
    {
        return $this->getAll()
            ->where('id', $translationId)
            ->update([
                'translation' => $translationContent,
            ]);
    }
}
