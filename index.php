<?php
/**
 * Simple PHP Folder and File Lister
 * Replaces Apache's Options +Indexes functionality
 */

// Load configuration
require_once 'config.php';

// Get current folder from URL parameter
$current_folder = isset($_GET['folder']) ? $_GET['folder'] : '';
$current_path = $current_folder;

// Security: Prevent directory traversal
$current_path = str_replace('..', '', $current_path);
$current_path = str_replace('//', '/', $current_path);
$current_path = trim($current_path, '/');

// Build full path
$base_path = __DIR__;
$full_path = $base_path;
if (!empty($current_path)) {
    $full_path .= '/' . $current_path;
}

// Validate path exists and is within base directory
if (!is_dir($full_path) || !is_readable($full_path)) {
    http_response_code(404);
    die('Directory not found or not accessible');
}

// Ensure we're not trying to access parent directories
$real_base = realpath($base_path);
$real_current = realpath($full_path);
if (strpos($real_current, $real_base) !== 0) {
    http_response_code(403);
    die('Access denied');
}

// Function to check if file/folder should be hidden
function shouldHide($name, $is_dir = false) {
    global $HIDDEN_EXTENSIONS, $HIDDEN_FILES, $HIDDEN_FOLDERS;
    
    $lower_name = strtolower($name);
    
    if ($is_dir) {
        return in_array($lower_name, array_map('strtolower', $HIDDEN_FOLDERS));
    } else {
        // Check hidden files
        if (in_array($lower_name, array_map('strtolower', $HIDDEN_FILES))) {
            return true;
        }
        
        // Check hidden extensions
        foreach ($HIDDEN_EXTENSIONS as $ext) {
            if (strcasecmp(substr($name, -strlen($ext)), $ext) === 0) {
                return true;
            }
        }
        
        return false;
    }
}

// Function to format file size
function formatFileSize($bytes) {
    if ($bytes == 0) return '0 B';
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $i = floor(log($bytes, 1024));
    return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
}

// Function to build breadcrumb navigation
function buildBreadcrumbs($path) {
    if (empty($path)) return array();
    
    $parts = explode('/', $path);
    $breadcrumbs = array();
    $current_path = '';
    
    foreach ($parts as $part) {
        $current_path .= ($current_path ? '/' : '') . $part;
        $breadcrumbs[] = array(
            'name' => $part,
            'path' => $current_path
        );
    }
    
    return $breadcrumbs;
}

// Get directory contents
$items = array();
$dir_handle = opendir($full_path);

while (($item = readdir($dir_handle)) !== false) {
    if ($item === '.' || $item === '..') continue;
    
    $item_path = $full_path . '/' . $item;
    $is_dir = is_dir($item_path);
    
    if (!shouldHide($item, $is_dir)) {
        $items[] = array(
            'name' => $item,
            'is_dir' => $is_dir,
            'size' => $is_dir ? null : filesize($item_path),
            'modified' => filemtime($item_path)
        );
    }
}

closedir($dir_handle);

// Sort items: directories first, then files, both alphabetically
usort($items, function($a, $b) {
    if ($a['is_dir'] && !$b['is_dir']) return -1;
    if (!$a['is_dir'] && $b['is_dir']) return 1;
    return strcasecmp($a['name'], $b['name']);
});

$breadcrumbs = buildBreadcrumbs($current_path);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($PAGE_TITLE); ?></title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: #2c3e50;
            color: white;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 300;
        }
        .breadcrumbs {
            background: #ecf0f1;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
        }
        .breadcrumb-item {
            display: inline-block;
        }
        .breadcrumb-item:not(:last-child)::after {
            content: ' / ';
            color: #7f8c8d;
        }
        .breadcrumb-item a {
            color: #3498db;
            text-decoration: none;
        }
        .breadcrumb-item a:hover {
            text-decoration: underline;
        }
        .content {
            padding: 20px;
        }
        .file-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .file-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }
        .file-item:hover {
            background-color: #f8f9fa;
        }
        .file-item:last-child {
            border-bottom: none;
        }
        .file-icon {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }
        .file-name {
            flex: 1;
            font-weight: 500;
        }
        .file-name a {
            color: #2c3e50;
            text-decoration: none;
        }
        .file-name a:hover {
            color: #3498db;
        }
        .file-info {
            color: #7f8c8d;
            font-size: 14px;
            text-align: right;
        }
        .folder {
            color: #f39c12;
        }
        .file {
            color: #3498db;
        }
        .parent-links {
            margin-bottom: 20px;
            padding: 15px;
            background: #ecf0f1;
            border-radius: 5px;
        }
        .parent-links a {
            color: #3498db;
            text-decoration: none;
            margin-right: 15px;
        }
        .parent-links a:hover {
            text-decoration: underline;
        }
        .empty-message {
            text-align: center;
            color: #7f8c8d;
            padding: 40px 20px;
            font-style: italic;
        }
        .navigation-links {
            margin-bottom: 20px;
            padding: 15px;
            background: #ecf0f1;
            border-radius: 5px;
        }
        .nav-link {
            color: #3498db;
            text-decoration: none;
            margin-right: 15px;
            font-weight: 500;
        }
        .nav-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo htmlspecialchars($PAGE_TITLE); ?></h1>
        </div>
        
        <?php if ($SHOW_BREADCRUMBS && !empty($breadcrumbs)): ?>
        <div class="breadcrumbs">
            <div class="breadcrumb-item">
                <a href="?"><?php echo htmlspecialchars(basename($base_path)); ?></a>
            </div>
            <?php foreach ($breadcrumbs as $crumb): ?>
            <div class="breadcrumb-item">
                <a href="?folder=<?php echo urlencode($crumb['path']); ?>"><?php echo htmlspecialchars($crumb['name']); ?></a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="content">
            <?php if (empty($items)): ?>
            <div class="empty-message">
                This directory is empty.
            </div>
            <?php else: ?>
            <ul class="file-list">
                <?php foreach ($items as $item): ?>
                <li class="file-item">
                    <div class="file-icon">
                        <?php if ($item['is_dir']): ?>
                            <span class="folder">📁</span>
                        <?php else: ?>
                            <span class="file">📄</span>
                        <?php endif; ?>
                    </div>
                    <div class="file-name">
                        <?php if ($item['is_dir']): ?>
                            <a href="?folder=<?php echo urlencode($current_path . ($current_path ? '/' : '') . $item['name']); ?>">
                                <?php echo htmlspecialchars($item['name']); ?>/
                            </a>
                        <?php else: ?>
                            <a href="<?php echo htmlspecialchars($current_path . ($current_path ? '/' : '') . $item['name']); ?>" target="_blank">
                                <?php echo htmlspecialchars($item['name']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if ($SHOW_FILE_SIZES || $SHOW_FILE_DATES): ?>
                    <div class="file-info">
                        <?php if ($SHOW_FILE_SIZES && !$item['is_dir']): ?>
                            <span><?php echo formatFileSize($item['size']); ?></span>
                        <?php endif; ?>
                        <?php if ($SHOW_FILE_DATES): ?>
                            <?php if ($SHOW_FILE_SIZES && !$item['is_dir']): ?> | <?php endif; ?>
                            <span><?php echo date($DATE_FORMAT, $item['modified']); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 