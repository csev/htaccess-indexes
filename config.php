<?php
/**
 * Configuration file for the Simple PHP Folder Lister
 */

// File extensions to hide from the listing
$HIDDEN_EXTENSIONS = array(
    '.php',
    '.htaccess',
    '.gitignore',
    '.DS_Store',
    '.config.php'
);

// File names to hide (case-insensitive)
$HIDDEN_FILES = array(
    'index.php',
    'config.php',
    'thumbs.db',
    '.htaccess'
);

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