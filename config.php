<?php
/**
 * Configuration file for the Simple PHP Folder Lister
 */

// File extensions to hide from the listing
$HIDDEN_EXTENSIONS = array(
    // PHP and web files
    '.php',
    '.php3',
    '.php4',
    '.php5',
    '.php7',
    '.php8',
    '.phtml',
    '.phar',
    '.inc',
    '.htaccess',
    '.gitignore',
    '.config.php',
    
    // Scripting languages
    '.js',
    '.pl',
    '.py',
    '.rb',
    '.sh',
    '.bash',
    
    // Executables and binaries
    '.exe',
    '.com',
    '.bat',
    '.cmd',
    '.vbs',
    '.ps1',
    '.jar',
    '.war',
    '.ear',
    '.class',
    '.so',
    '.dll',
    '.dylib',
    '.bin',
    '.msi',
    '.app',
    '.deb',
    '.rpm',
    '.pkg',
    '.apk',
    '.ipa',
    
    // Temporary and system files
    '.swp',
    '.swo',
    '.tmp',
    '.temp',
    '.bak',
    '.backup',
    '.orig',
    '.rej',
    '.log',
    '.cache',
    '.DS_Store'
);

// File names to hide (case-insensitive)
$HIDDEN_FILES = array(
    'index.php',
    'config.php',
    'thumbs.db',
    '.htaccess',
    '*.swp',
    '*.swo',
    '*.tmp',
    '*.temp',
    '*.bak',
    '*.backup',
    '*.orig',
    '*.rej',
    '*.log',
    '*.cache',
    '.DS_Store',
    'Thumbs.db',
    'desktop.ini'
);

// Hide all files that start with a dot (hidden files)
$HIDE_DOT_FILES = true;

// Folder names to hide (case-insensitive)
$HIDDEN_FOLDERS = array(
    '.git',
    '.svn',
    'node_modules',
    'vendor'
);

// Maximum file size to display (in bytes) - set to 0 for no limit
$MAX_FILE_SIZE = 0;

// Show file sizes (true/false)
$SHOW_FILE_SIZES = true;

// Show file modification dates (true/false)
$SHOW_FILE_DATES = true;

// Date format for file modification dates
$DATE_FORMAT = 'Y-m-d H:i:s';

// Page title
$PAGE_TITLE = 'File Browser';

// Enable breadcrumb navigation (true/false)
$SHOW_BREADCRUMBS = true;

// Show GitHub repository link (true/false)
$SHOW_GITHUB_LINK = true;

// GitHub repository URL (leave empty to hide the link)
$GITHUB_REPO_URL = 'https://github.com/csev/htaccess-indexes';
?> 