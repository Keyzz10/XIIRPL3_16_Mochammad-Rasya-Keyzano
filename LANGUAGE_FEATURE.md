# FlowTask Language Feature Documentation

## 🌍 Overview

FlowTask now supports multilingual interface with English and Indonesian languages. Users can select their preferred language in their profile settings.

## ✅ Features Implemented

### 1. Database Changes
- **New Column**: Added `language` column to `users` table
- **Type**: `ENUM('en', 'id')` with default value `'en'`
- **Migration**: All existing users set to English by default

### 2. Language System
- **Helper Class**: `Language.php` for translation management
- **Translation Files**: 
  - `app/lang/en.php` (English)
  - `app/lang/id.php` (Indonesian)
- **Functions**: `__()` and `_e()` for easy translations

### 3. User Interface
- **Profile Page**: Language selection dropdown
- **Session Management**: Language preference stored in session
- **Real-time Preview**: Current language display with flags

## 🎯 How to Use

### For Users:
1. Login to FlowTask
2. Go to Profile page (`index.php?url=profile`)
3. Find "Language Preference" section
4. Select between:
   - 🇺🇸 English
   - 🇮🇩 Bahasa Indonesia
5. Click "Save Changes"
6. Interface language will update immediately

### For Developers:
```php
// Get translated text
echo __('profile.title'); // Returns "My Profile" or "Profil Saya"

// Echo translated text directly
_e('common.save'); // Outputs "Save" or "Simpan"

// Get translation with parameters
echo __('welcome.message', ['name' => $userName]);
```

## 📁 Files Created

```
FlowTask/
├── app/
│   ├── helpers/
│   │   └── Language.php          # Language helper class
│   └── lang/
│       ├── en.php               # English translations
│       └── id.php               # Indonesian translations
├── database/
│   └── add_language_column.sql  # Database migration
├── migrate_language.php         # Migration script
└── test_language.php           # Feature test page
```

## 📝 Files Modified

```
FlowTask/
├── app/
│   ├── controllers/
│   │   ├── BaseController.php   # Initialize Language system
│   │   ├── UserController.php   # Handle language in profile
│   │   └── AuthController.php   # Set language in session
│   └── views/
│       └── users/
│           └── profile.php      # Language selector UI
```

## 🔧 Translation Structure

### English (`app/lang/en.php`)
```php
return [
    'common' => [
        'save' => 'Save',
        'cancel' => 'Cancel',
        // ...
    ],
    'profile' => [
        'title' => 'My Profile',
        'language_preference' => 'Language Preference',
        // ...
    ]
];
```

### Indonesian (`app/lang/id.php`)
```php
return [
    'common' => [
        'save' => 'Simpan',
        'cancel' => 'Batal',
        // ...
    ],
    'profile' => [
        'title' => 'Profil Saya',
        'language_preference' => 'Preferensi Bahasa',
        // ...
    ]
];
```

## 🧪 Testing

### Test Pages:
1. **Profile Test**: `http://localhost/FlowTask/index.php?url=profile`
2. **Language Demo**: `http://localhost/FlowTask/test_language.php`
3. **Migration Test**: `http://localhost/FlowTask/migrate_language.php`

### Test Cases:
- ✅ Database column creation
- ✅ English/Indonesian translation loading
- ✅ Profile form language selector
- ✅ Session language persistence
- ✅ Translation function helpers

## 🚀 Usage Examples

### Basic Translation
```php
// In view files
<h1><?php _e('profile.title'); ?></h1>
<!-- Outputs: "My Profile" (EN) or "Profil Saya" (ID) -->

<button><?php _e('common.save'); ?></button>
<!-- Outputs: "Save" (EN) or "Simpan" (ID) -->
```

### Dynamic Translation
```php
// Get current language
$currentLang = Language::getCurrentLanguage(); // 'en' or 'id'

// Set language programmatically
Language::setLanguage('id');

// Get available languages
$languages = Language::getAvailableLanguages();
```

## 📊 Database Schema

```sql
ALTER TABLE users ADD COLUMN language ENUM('en', 'id') NOT NULL DEFAULT 'en' AFTER phone;
```

## 🎨 UI Components

### Language Selector
```html
<select class="form-select" name="language">
    <option value="en">🇺🇸 English</option>
    <option value="id">🇮🇩 Bahasa Indonesia</option>
</select>
```

### Current Language Display
```html
<span class="badge bg-primary">
    <?php echo ($user['language'] === 'en') ? '🇺🇸 English' : '🇮🇩 Bahasa Indonesia'; ?>
</span>
```

## 🔮 Future Enhancements

1. **Additional Languages**: Easy to add more languages (es, fr, de, etc.)
2. **Auto-detection**: Browser language detection
3. **RTL Support**: Right-to-left language support
4. **Date/Time Formats**: Localized date and time formatting
5. **Number Formats**: Currency and number localization

## 🐛 Troubleshooting

### Common Issues:

1. **Translations not loading**
   - Check if language files exist in `app/lang/`
   - Verify Language::init() is called in BaseController

2. **Language not saving**
   - Ensure `language` column exists in users table
   - Check UserController profile method includes language in data array

3. **Session not updating**
   - Verify AuthController sets language in session during login
   - Check Language::setLanguage() updates session

### Debug Commands:
```php
// Check current language
echo Language::getCurrentLanguage();

// Check session language
echo $_SESSION['language'] ?? 'not set';

// Test translation
echo __('profile.title');
```

## 📞 Support

If you encounter any issues with the language feature:
1. Check the test page: `test_language.php`
2. Verify database migration completed
3. Ensure all required files are present
4. Check browser console for JavaScript errors

---

**Language Feature Status**: ✅ **COMPLETE**  
**Tested**: ✅ **WORKING**  
**Ready for Production**: ✅ **YES**