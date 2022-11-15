<?php

use PHPUnit\Framework\TestCase;

class PigLatinTest extends TestCase
{
    /**
     * This test is to verify, that the problem has been implemented successfully
     * and that it is in compliance with the task
     *
     * @return void
     */
    public function testTranslationIntoPigEnglish(): void
    {
        $translationModel = new App\Model\TranslationModel();

        $this->assertEquals('east-bay', $translationModel->translateIntoPigLatin('beast'));
        $this->assertEquals('ough-day', $translationModel->translateIntoPigLatin('dough'));
        $this->assertEquals('appy-hay', $translationModel->translateIntoPigLatin('happy'));
        $this->assertEquals('estion-quay', $translationModel->translateIntoPigLatin('question'));
        $this->assertEquals('ar-stay', $translationModel->translateIntoPigLatin('star'));
        $this->assertEquals('ee-thray', $translationModel->translateIntoPigLatin('three'));
        $this->assertEquals('xrayay', $translationModel->translateIntoPigLatin('xray'));
        $this->assertEquals('are-squay', $translationModel->translateIntoPigLatin('square'));

    }
}
