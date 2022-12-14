<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Utils\Strings;

class TranslationModel
{
    public function translateIntoPigLatin(string $origin): string
    {
        //we are brave (or silly?) and truncate special characters also,
        //so that our future selves can have hard times to restore the text
        //from piggy latin back to english, with the correct punctuation letters
        //(in which case, however, the database is to the rescue)
        $cleanInput = Strings::webalize(Strings::lower(Strings::trim($origin)));
        $wordsToTranslate = explode('-', $cleanInput);

        //First rule of Piggy Latin: when starting with a vowel
        //we append "ay", however the 'y' character is not included since it is
        //phonetically equivalent to a consonant (like 'you') and, on the other hand,
        //words starting with 'xr' or 'yt', although formally starting with a consonant,
        //sound like starting with a vowel, ('x-ray' or 'ytterbium')
        $vowelPattern = '/^([aeiou]|xr|yt)(.*)$/';

        //some words, like 'question' or 'square' contain vowels, although phonetically
        //these vowels are "silent", we want to move the consonants plus 'qu' to the end
        //and then append 'ay'
        $consonantQuPattern = '/^([^aeiou]?)(qu)(.*)$/';

        //if a word begins with a consonant or multiple consonants (i.e. consonant clusters)
        //we move the consonants (or their clusters) to the end of the word and append 'ay'
        $consonantPattern = '/^([^aeiou]+)(.*)$/';

        //If a word contains a "y" after a consonant cluster or as the second letter
        //in a two letter word it makes a vowel sound ('rhythm', 'my')
        $clusterYPattern = '/^([^aeiou]+)(y)(.*)$/';

        foreach ($wordsToTranslate as $key => $wordToTranslate) {
            if (preg_match($vowelPattern, $wordToTranslate, $matches)) {
                $wordsToTranslate[$key] = $matches[1] . $matches[2] . 'ay';
            } elseif (preg_match($consonantQuPattern, $wordToTranslate, $matches)) {
                $wordsToTranslate[$key] = $matches[3] . '-' . $matches[1] . $matches[2] . 'ay';
            } elseif (preg_match($consonantPattern, $wordToTranslate, $matches)) {
                $wordsToTranslate[$key] = $matches[2] . '-' . $matches[1] . 'ay';
            } elseif (preg_match($clusterYPattern, $wordToTranslate, $matches)) {
                $wordsToTranslate[$key] = $matches[2] . $matches[3] . '-' . $matches[1] . 'ay';
            }
        }

        return implode(' ', $wordsToTranslate);
    }
}
