<?php 
/** 
 * @desc 
 * Sort arrays with multibyte values using a predefined or custom alphabet. 
 * 
 * @author Christian Reinecke <reinecke@bajoodoo.de> 
 * @version 1.1 
 * @since 2009-01-15 
 * 
 * @example 
 * <code> 
 *     // quick 
 *     $array = array("Zebra", "EnglÃ¤nder", "England", "Chinese", "Ã„ffchen", "Ãœberseeboot", 
 *                    "Unterseeboot", "ÃŸ", "Sz", "BÃ¼rger", "Burger", "burger", "bÃ¼rger", "Ã„Ã–Ãœ"); 
 *     AIS_Util_MultibyteSort::staticSort($array); 
 *     print_r($array); 
 *     // Array ( 
 *     // [0] => Ã„ffchen [1] => Ã„Ã–Ãœ [2] => Burger [3] => BÃ¼rger [4] => burger [5] => bÃ¼rger 
 *     // [6] => Chinese [7] => England [8] => EnglÃ¤nder [9] => Sz [10] => ÃŸ [11] => Unterseeboot 
 *     // [12] => Ãœberseeboot [13] => Zebra 
 *     // ) 
 * 
 * 
 *     // with custom setup 
 *     $mbsort = new AIS_Util_MultibyteSort("UTF-8", true); 
 *     $mbsort->sort($array); 
 *     print_r($array) 
 *     // same result as above 
 *     $mbsort->sort($otherArray); 
 * </code> 
 * 
 * @todo 
 * This class can not handle unknown special characters (fallback to default behaviour), 
 * which makes it desirable to find a global, sorted alphabet. Feel free to add more special chars. 
 * 
 * Don't forget to send the correct charset in your header 
 * <code> 
 *     header("Content-type: text/html; charset=utf-8"); 
 * </code> 
 */ 
class AIS_Util_MultibyteSort 
{ 
    const EncodingUtf8    = "UTF-8"; 
    const EncodingDefault = self::EncodingUtf8; 

    const CasePreferenceUpper   = true; 
    const CasePreferenceLower   = false; 
    const CasePreferenceDefault = self::CasePreferenceUpper; 

    protected static $instances = array(); 
    protected static $alphabetLoose = array("A" => "Ã„", "a" => "Ã¤Ã ", "O" => "Ã–", "o" => "Ã¶", "U" => "Ãœ", 
                                            "u" => "Ã¼", "s" => "ÃŸ"); 

    /** 
     * multibyte encoding 
     * @see self::EncodingDefault 
     * @var string 
     */ 
    protected $encoding; 

    /** 
     * array map (single special char => ASCII-128) 
     * @var array 
     */ 
    protected $alphabet; 

    /** 
     * case flag, whether upper case chars are preferred to lower case chars 
     * @see self::CasePreferenceDefault 
     * @var bool 
     */ 
    protected $case; 

    /** 
     * @param array|string [optional] loose alphabet or key for predefined loose alphabet 
     * @param string       [optional] encoding for multibyte functions 
     * @param bool         [optional] prefer uppercase char to lower-case (Aa or aA) 
     */ 
    public function __construct($encoding = self::EncodingDefault, $preferUpperCase = self::CasePreferenceDefault) 
    { 
        $this->setEncoding($encoding); 
        $this->setUpperCasePreference($preferUpperCase); 
        $this->loadAlphabet(); 
    } 

    /** 
     * @desc 
     * The instance for all static calls is stored in a static property, so you can use the 
     * instance once again. But if you prefer to use this class only once, use the __construct 
     * method. There's no overhead then. 
     */ 
    public static function getInstance($encoding = self::EncodingDefault, $preferUpperCase = self::CasePreferenceDefault) 
    { 
        $hash = crc32($encoding . $preferUpperCase); 
        if (!array_key_exists($hash, self::$instances)) { 
            self::$instances[$hash] = new self($encoding, $preferUpperCase); 
        } 
        return self::$instances[$hash]; 
    } 

    /** 
     * @desc shortcut 
     */ 
    public static function sortStatic(&$array, $encoding = self::EncodingDefault, $preferUpperCase = self::CasePreferenceDefault) 
    { 
        $self = self::getInstance($encoding, $preferUpperCase); 
        $self->sort($array); 
    } 

    public static function asortStatic(&$array, $encoding = self::EncodingDefault, $preferUpperCase = self::CasePreferenceDefault)
    { 
        $self = self::getInstance($encoding, $preferUpperCase); 
        $self->asort($array); 
    } 

    /** 
     * @desc sort array with the constructor-given settings 
     */ 
    public function sort(&$array) 
    { 
        /** 
         * Got this message: "Warning: usort() [function.usort]: Invalid comparison function"? 
         * Then do not call this method from a static context and change your error_reporting level 
         * to E_ALL | E_STRICT. 
         */ 
        usort($array, array($this, "sortString")); 
    } 

    public function asort(&$array) 
    { 
        uasort($array, array($this, "sortString")); 
    } 

    /** 
     * @desc multibyte string compare (something like we would expect behind mb_strcmp()) 
     * @return int sort order value (1, 0, -1) 
     */ 
    protected function sortString($a, $b) 
    { 
        $ax = mb_strlen($a, $this->encoding); 
        $bx = mb_strlen($b, $this->encoding); 
        for ($i = 0, $x = min($ax, $bx); $i < $x; ++$i) { 
            $result = $this->charCmp(mb_substr($a, $i, 1, $this->encoding), 
                                     mb_substr($b, $i, 1, $this->encoding)); 
            if ($result != 0) { 
                return $result; 
            } 
        } 
        return $this->intCmp($ax, $bx); 
    } 

    /** 
     * @desc integer compare 
     * @return int sort order value (-1, 0, 1) 
     */ 
    protected function intCmp($a, $b) 
    { 
        return ($a == $b) ? 0 : ($a < $b ? -1 : 1); 
    } 

    /** 
     * @desc multibyte char compare 
     * @return int sort order value (-1, 0, 1) 
     */ 
    protected function charCmp($a, $b) 
    { 
        // check if characters are known as special chars 
        $ai = isset($this->alphabet[$a]); // ai = a isset 
        $bi = isset($this->alphabet[$b]); 

        if ($ai && $bi) { 
            // both are known special chars 
            $ar = $this->alphabet[$a]; // ar = a representation (ASCII-128) 
            $br = $this->alphabet[$b]; 
            $result = $this->charCaseCmp($ar, $br); 
            if ($result == 0 && $a != $b) { 
                // they aren't equal, but their representation is, so check position in original array 
                $ap = mb_strpos(self::$alphabetLoose[$ar], $a, 0, $this->encoding); 
                $bp = mb_strpos(self::$alphabetLoose[$br], $b, 0, $this->encoding); 
                $result = $this->intCmp($ap, $bp); 
            } 
        } else if ($ai) { 
            // $a is a known special char, $b not 
            $result = $this->charCaseCmp($this->alphabet[$a], $b); 
             // so they are not equal, $result = 0 means $b is "smaller" 
            $result = ($result == 0) ? 1 : $result; 
        } else if ($bi) { 
            // $b is a known special char, $a not 
            $result = $this->charCaseCmp($a, $this->alphabet[$b]); 
            // so they are not equal; $result = 0 means $a is "smaller" 
            $result = ($result == 0) ? -1 : $result; 
        } else { 
            // both are unknown characters 
            $result = $this->charCaseCmp($a, $b); 
        } 
        return $result; 
    } 

    /** 
     * @desc multibyte char case compare 
     * @return sort order value (-1, 0, 1) 
     */ 
    protected function charCaseCmp($a, $b) 
    { 
        if ($a == $b) { 
            // they are equal, no check required 
            return 0; 
        } 
        $A = mb_strtoupper($a, $this->encoding); 
        $B = mb_strtoupper($b, $this->encoding); 
        $result = strcmp($A, $B); 
        if ($result == 0) { 
            // their mb_strtoupper() value is equal, select compare value depending on case preference 
            $result = ($A != $a) ? $this->case : ($this->case * -1); 
        } 
        return $result; 
    } 

    protected function loadAlphabet() 
    { 
        if (empty($this->alphabet)) { 
            // load only once per instance 
            // $alphabetLoose is required to differ between special chars with the same ASCII-128 representation 
            foreach (self::$alphabetLoose as $order => $char) { 
                for ($i = 0, $x = mb_strlen($char, $this->encoding); $i < $x; ++$i) { 
                    // use each multibyte char as key with its ASCII-128 representation as key 
                    $this->alphabet[mb_substr($char, $i, 1, $this->encoding)] = $order; 
                } 
            } 
        } 
    } 

    protected function setEncoding($encoding) 
    { 
        $this->encoding = $encoding; 
    } 

    protected function setUpperCasePreference($preferUpperCase) 
    { 
        $this->case = $preferUpperCase ? 1 : -1; 
    } 
} 
