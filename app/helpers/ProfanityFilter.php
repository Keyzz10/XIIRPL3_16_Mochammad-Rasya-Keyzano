<?php

class ProfanityFilter
{
    private static $badWords = [
        // Indonesian profanity
        'anjing', 'babi', 'bangsat', 'bajingan', 'kontol', 'memek', 'ngentot', 'bego', 'goblok', 'tolol',
        'asu', 'anjir', 'anjrit', 'anjay', 'anjg', 'bgsd', 'kntl', 'mmk', 'ngntt', 'ngentod', 'ngntd',
        'tai', 'tae', 'gila', 'idiot', 'kampret', 'keparat', 'setan', 'jinx', 'perek', 'lonte', 'brengsek',
        'budeg', 'ndasmu', 'jancuk', 'janck', 'jancukkk', 'jancok', 'jancukz','ajg',
        
        // English profanity
        'fuck', 'shit', 'damn', 'bitch', 'asshole', 'bastard', 'piss', 'crap', 'hell', 'bloody',
        'fucking', 'shitting', 'damned', 'bitching', 'pissing', 'crapping', 'fucked', 'shitted',
        'fucker', 'shitter', 'damner', 'bitcher', 'pisser', 'crapper', 'fucks', 'shits', 'damns',
        'bitches', 'pisses', 'craps', 'fck', 'sht', 'dmn', 'btch', 'sshle', 'bstrd', 'pss', 'crp',
        'fcking', 'shtting', 'dmned', 'btching', 'pssing', 'crpping', 'fcked', 'shted',
        'fcker', 'shtter', 'dmner', 'btcher', 'psser', 'crpper', 'fcks', 'shts', 'dmns',
        'btches', 'psses', 'crps',
        
        // Common variations and leetspeak
        'f*ck', 'f**k', 'f***', 'sh*t', 'sh**', 'sh***', 'd*mn', 'd**n', 'd***', 'b*tch', 'b**ch', 'b***h',
        'a**hole', 'a***ole', 'a****le', 'b*stard', 'b**tard', 'b***ard', 'p*ss', 'p**s', 'p***',
        'c*ap', 'c**p', 'c***', 'h*ll', 'h**l', 'h***',
        
        // Additional offensive terms
        'idiot', 'moron', 'stupid', 'dumb', 'retard', 'retarded', 'gay', 'lesbian', 'homo', 'fag', 'faggot',
        'nigger', 'nigga', 'n*gga', 'n**ga', 'n***a', 'n****', 'chink', 'kike', 'spic', 'wetback',
        'whore', 'slut', 'prostitute', 'hooker', 'bimbo', 'tramp', 'ho', 'hoe',
        
        // Indonesian additional terms
        'bencong', 'banci', 'waria', 'lesbi', 'homo', 'gay', 'bencong', 'banci', 'waria', 'lesbi',
        'cina', 'cino', 'jawa', 'sunda', 'batak', 'ambon', 'papua', 'dayak', 'bugis', 'makassar',
        'bodoh', 'dungu', 'otak', 'otak udang', 'otak encer', 'otak kering', 'otak kosong',
        'monyet', 'kera', 'sapi', 'kerbau', 'kambing', 'babi', 'anjing', 'kucing', 'tikus',
        
        // Common misspellings and variations
        'fuk', 'fukc', 'fuking', 'fuked', 'fuker', 'fuking', 'fuked', 'fuker',
        'sht', 'shti', 'shting', 'shted', 'shtter', 'shting', 'shted', 'shtter',
        'dmn', 'dmni', 'dmning', 'dmned', 'dmner', 'dmning', 'dmned', 'dmner',
        'btch', 'btchi', 'btching', 'btched', 'btcher', 'btching', 'btched', 'btcher'
    ];

    // Map common leetspeak and symbol substitutions to plain letters
    private static $leetMap = [
        '@' => 'a', '4' => 'a', 'â' => 'a',
        '1' => 'i', '!' => 'i', '|' => 'i',
        '3' => 'e', '€' => 'e',
        '0' => 'o', 'ø' => 'o', 'ô' => 'o',
        '$' => 's', '5' => 's',
        '7' => 't', '+' => 't',
        '8' => 'b'
    ];
    
    private static $replacementWords = [
        'kata-kata kasar', 'kata tidak pantas', 'kata kasar', 'kata tidak sopan', 'kata buruk',
        'profanity', 'inappropriate word', 'bad word', 'offensive word', 'rude word',
        '***', '###', '---', 'xxx', 'ooo', '***', '###', '---', 'xxx', 'ooo'
    ];
    
    /**
     * Check if text contains profanity
     */
    public static function containsProfanity($text)
    {
        if (empty($text)) {
            return false;
        }
        $text = self::normalizeText($text);
        
        foreach (self::$badWords as $badWord) {
            if (strpos($text, strtolower($badWord)) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Filter profanity from text
     */
    public static function filterProfanity($text)
    {
        if (empty($text)) {
            return $text;
        }
        
        $result = $text;
        foreach (self::$badWords as $badWord) {
            $pattern = '/\b' . preg_quote($badWord, '/') . '\b/i';
            $replacement = str_repeat('*', max(3, strlen($badWord)));
            $result = preg_replace($pattern, $replacement, $result);
        }
        return $result;
    }
    
    /**
     * Get list of detected profanity words
     */
    public static function getDetectedProfanity($text)
    {
        if (empty($text)) {
            return [];
        }
        $detected = [];
        $text = self::normalizeText($text);
        
        foreach (self::$badWords as $badWord) {
            if (strpos($text, strtolower($badWord)) !== false) {
                $detected[] = $badWord;
            }
        }
        
        return array_unique($detected);
    }

    /**
     * Normalize text: lowercase, map leetspeak, remove non-letters, collapse repeats
     */
    private static function normalizeText($text)
    {
        $text = strtolower($text);
        // Replace leetspeak characters
        $text = strtr($text, self::$leetMap);
        // Replace common separators with space
        $text = preg_replace('/[_\-\.]/', ' ', $text);
        // Remove accents
        $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        // Remove non-letters
        $text = preg_replace('/[^a-z\s]/', '', $text);
        // Collapse 3+ repeated letters into 2 (fuuuck -> fuuck)
        $text = preg_replace('/([a-z])\1{2,}/', '$1$1', $text);
        // Collapse spaces
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }
    
    /**
     * Check if text is appropriate for comments
     */
    public static function isAppropriate($text)
    {
        return !self::containsProfanity($text);
    }
    
    /**
     * Get a random replacement word
     */
    public static function getRandomReplacement()
    {
        return self::$replacementWords[array_rand(self::$replacementWords)];
    }
}
