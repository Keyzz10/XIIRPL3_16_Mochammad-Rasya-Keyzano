<?php
/**
 * Language Helper Class
 * Simple internationalization system for FlowTask
 */

class Language {
    private static $currentLanguage = 'id';
    private static $translations = [];
    
    /**
     * Initialize language system
     */
    public static function init() {
        // Set language from session or default to Indonesian
        self::$currentLanguage = $_SESSION['language'] ?? 'id';
        
        // Force Indonesian language for all users
        if (self::$currentLanguage !== 'id') {
            self::$currentLanguage = 'id';
            $_SESSION['language'] = 'id';
        }
        
        // Load translations
        self::loadTranslations();
    }
    
    /**
     * Load translation files
     */
    private static function loadTranslations() {
        $langFile = ROOT_PATH . '/app/lang/' . self::$currentLanguage . '.php';
        
        if (file_exists($langFile)) {
            self::$translations = require $langFile;
        } else {
            // Fallback to Indonesian, then English
            $fallbackFile = ROOT_PATH . '/app/lang/id.php';
            if (file_exists($fallbackFile)) {
                self::$translations = require $fallbackFile;
            } else {
                $fallbackFileEn = ROOT_PATH . '/app/lang/en.php';
                if (file_exists($fallbackFileEn)) {
                    self::$translations = require $fallbackFileEn;
                }
            }
        }
    }
    
    /**
     * Get translated text
     * @param string $key Translation key
     * @param array $params Parameters to replace in translation
     * @return string Translated text
     */
    public static function get($key, $params = []) {
        // Split nested keys (e.g., 'profile.title')
        $keys = explode('.', $key);
        $translation = self::$translations;
        
        foreach ($keys as $k) {
            if (isset($translation[$k])) {
                $translation = $translation[$k];
            } else {
                // Return key if translation not found
                return $key;
            }
        }
        
        // Replace parameters if provided
        if (!empty($params)) {
            foreach ($params as $param => $value) {
                $translation = str_replace(':' . $param, $value, $translation);
            }
        }
        
        return $translation;
    }
    
    /**
     * Set current language
     * @param string $language Language code (en, id)
     */
    public static function setLanguage($language) {
        if (in_array($language, ['en', 'id'])) {
            self::$currentLanguage = $language;
            $_SESSION['language'] = $language;
            self::loadTranslations();
        }
    }
    
    /**
     * Get current language
     * @return string Current language code
     */
    public static function getCurrentLanguage() {
        return self::$currentLanguage;
    }
    
    /**
     * Check if current language is RTL
     * @return bool
     */
    public static function isRTL() {
        // Currently neither English nor Indonesian are RTL
        return false;
    }
    
    /**
     * Get language direction
     * @return string 'ltr' or 'rtl'
     */
    public static function getDirection() {
        return self::isRTL() ? 'rtl' : 'ltr';
    }
    
    /**
     * Get available languages
     * @return array Available languages
     */
    public static function getAvailableLanguages() {
        return [
            'en' => [
                'name' => 'English',
                'native' => 'English',
                'flag' => '🇺🇸'
            ],
            'id' => [
                'name' => 'Indonesian',
                'native' => 'Bahasa Indonesia', 
                'flag' => '🇮🇩'
            ]
        ];
    }
}

/**
 * Helper function for getting translations
 * @param string $key Translation key
 * @param array $params Parameters to replace
 * @return string Translated text
 */
function __($key, $params = []) {
    return Language::get($key, $params);
}

/**
 * Helper function for getting translated text with echo
 * @param string $key Translation key
 * @param array $params Parameters to replace
 */
function _e($key, $params = []) {
    echo Language::get($key, $params);
}
?>