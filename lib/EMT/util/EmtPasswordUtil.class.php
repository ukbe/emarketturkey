<?php
// ++MODELINES++
// kate: indent-width 4; tab-width 4; indent-mode: normal;
// kate: encoding utf8; remove-trailing-space off; replace-trailing-space-save off;
// vim:enc=utf-8:fileformats=unix:tabstop=4:shiftwidth=4:expandtab:


/**
 * Implementation of a password generator
 *
 * The class is abstract to prevent developers from instantiating it.
 *
 * @package lib
 * @subpackage util
 */
abstract class EmtPasswordUtil
{

    // random suffixes
    private static $suffixes = array('dom', 'ity', 'ment', 'sion', 'ness',
                    'ens', 'er', 'ist', 'tion', 'or', 
                    'keit', 'heit', 'mus', 'ung', 'en'); 

    // numerals
    private static $numerals = array('2', '3', '4', '5', '6', '7', '8', '9');

    // symbols
    private static $symbols = array('#', '@', '!', '&', '%', '$', '+');

    // letters
    private static $letters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm',
                    'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
                    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N',
                    'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); 

    // vowel sounds
    private static $vowels = array('a', 'o', 'e', 'i', 'y', 'u', 'ou', 'oo',
                    'ei', 'ie', 'ae', 'oe', 'ue'); 

    // random consonants
    private static $consonants = array('W', 'R', 'T', 'P', 'S', 'D', 'F', 'G', 'H', 'J',
                        'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', 'Qu',
                        'Pf', 'Ph', 'Ck', 'Ch', 'Sch',
                        'w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j',
                        'k', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'qu',
                        'pf', 'ph', 'ck', 'ch', 'sch');

    /**
     * Password generator
     *
     * @param 
     * @return string $password A random password
     * @throws 
     */
    public static function generate()
    {
        $prefs = sfConfig::get('app_password_prefs');
        $password = '';
        if (sfConfig::get('app_password_readable'))
        {
            $prefs = $prefs['readable'];
            do
            {
                $password = self::generateReadable($prefs['syllables']);
                if ($prefs['minDigits'] <= $prefs['maxDigits'])
                {
                    if (rand(0,1) == 1)
                    {
                        $password .= self::pick(self::$numerals, rand($prefs['minDigits'], $prefs['maxDigits']));
                    }
                    else
                    {
                        $password = self::pick(self::$numerals, rand($prefs['minDigits'], $prefs['maxDigits'])) . $password;
                    }
                }
            }
            while ((strlen($password)<$prefs['minLength']) || (strlen($password)>$prefs['maxLength']));
        }
        else
        {
            $prefs = $prefs['hashed'];
            $password = self::generateHashed($prefs);
        }
        return $password;
    }

    /**
     * Readable password chunk generator
     *
     * @param int $syllables Number of syllables to use (each syllable causes 4-9 number of characters )
     * @return string $chunk A random readable password chunk
     * @throws 
     */
    private static function generateReadable($syllables)
    {
        $chunk = '';
        $chunk_suffix = self::pick(self::$suffixes);
        for($i=0; $i<$syllables; $i++) {
            // selecting random consonant
            $doubles = array('n', 'm', 't', 's');
            $c = self::pick(self::$consonants);
            if (in_array($c, $doubles)&&($i!=0)) { // maybe double it
                if (rand(0, 2) == 1) // 33% probability
                $c .= $c;
            }
            $chunk .= $c;

            // selecting random vowel
            $chunk .= self::pick(self::$vowels);

            if ($i == $syllables - 1)
                if (in_array($chunk_suffix[0], self::$vowels))  // if suffix begin with vowel
                    $chunk .= self::pick(self::$consonants);  // add one more consonant

        }
        // selecting random suffix
        $chunk .= $chunk_suffix;
        return $chunk;
    }

    /**
     * Random password generator
     *
     * @param array $prefs Preferences from app.yml to generate password  
     * @return string $password A random password
     * @throws 
     */
    private static function generateHashed($prefs)
    {
        $maxlenght = rand($prefs['minLength'], $prefs['maxLength']);

        $sourceChars = array();
        if ($prefs['includeNumerals']) $sourceChars = array_merge($sourceChars, self::$numerals);
        if ($prefs['includeLetters']) $sourceChars = array_merge($sourceChars, self::$letters);
        if ($prefs['includeSymbols']) $sourceChars = array_merge($sourceChars, self::$symbols);

        $password    = '';
        $password .= self::pick($sourceChars, $maxlenght);

        return $password;
    }

    /**
     * Picks a value from array given
     *
     * @param array $arr Array of values to be selected from  
     * @param int $cnt Number of characters to be returned  
     * @return string $password A random password
     * @throws 
     */
    private static function pick(&$arr, $cnt=1)
    {
        $c = '';
        for ($i=0; $i<$cnt; $i++)
        {
            $c .= $arr[rand(0, sizeof($arr)-1)];
        }
        return $c;
    }

}
