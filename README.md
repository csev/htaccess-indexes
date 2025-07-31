# htaccess-indexes

A lightweight PHP application that replaces Apache's `Options +Indexes` functionality for browsing folders and files through a web interface.

## Features

- **Clean, modern interface** with responsive design
- **Security-focused** with directory traversal protection
- **Configurable hiding** of files and folders
- **Breadcrumb navigation** for easy folder traversal
- **File information** display (size, modification date)
- **Parent directory links** for quick navigation
- **Mobile-friendly** responsive design



## A quick test

You can do a very simple test of this by going into your `htdocs` folder and checking
this repository out:

    cd (wherever)
    git clone https://github.com/csev/htaccess-indexes
    cd htaccess-indexes
    chmod 644 .htaccess

Then navigate to the folder on your web site in a browser - You should see a browser listing like

https://www.dr-chuck.com/htaccess-indexes/

## Installation

1. Upload or copy `index.php`, `config.php`, and `.htaccess` to the web directory you want to publish
2. Ensure your web server has PHP enabled
3. The application will automatically start working

Different web servers will have different rules about `.htaccess` you might need to fix permissions
to `644`.

    chmod 644 .htaccess

## Configuration

Edit `config.php` to customize the behavior:

- `$HIDDEN_EXTENSIONS`: File extensions to hide (e.g., .php, .htaccess)
- `$HIDDEN_FILES`: Specific files to hide (e.g., index.php, config.php)
- `$HIDDEN_FOLDERS`: Folders to hide (e.g., .git, node_modules)
- `$SHOW_FILE_SIZES`: Whether to display file sizes
- `$SHOW_FILE_DATES`: Whether to display modification dates
- `$SHOW_BREADCRUMBS`: Whether to show breadcrumb navigation
- `$PAGE_TITLE`: Custom page title

## Usage

- **Browse folders**: Click on folder names to navigate into them
- **View files**: Click on file names to open them in a new tab
- **Navigate up**: Use "Parent Directory" or "Root Directory" links
- **Breadcrumbs**: Click on breadcrumb items to jump to specific levels

## URL Structure

- Root directory: `https://yoursite.com/`
- Subdirectory: `https://yoursite.com/?folder=subdirectory`
- Nested directory: `https://yoursite.com/?folder=subdirectory/nested`

## Security Features

- Directory traversal protection
- Path validation to prevent access outside the web root
- Hidden file/folder filtering
- Input sanitization and output escaping

## Security Note

**Important**: Configuring files as "hidden" in `config.php` only hides them from the folder listings displayed by this application. The underlying files will still be served by Apache if accessed directly via URL. **Do not store sensitive files in this directory** - the hiding feature is for "convenience" only and does not provide security protection.

For example, if you hide `secret.txt` in the configuration, it won't appear in the folder listing, but it can still be accessed directly at `https://yoursite.com/secret.txt`.

This is an example of [security through obscurity](https://en.wikipedia.org/wiki/Security_through_obscurity) - simply hiding hiding information in a user interface while it can
still be accessed through an underlying mechaism.  The lesson is (again): **Do not store sensitive files in this directory**

## Requirements

- PHP 7.0 or higher
- Web server with PHP support
- Apache with mod_rewrite (for .htaccess fallback)

## License

This project is open source and available under the MIT License.

## Acknowledgments

This application was developed with the assistance of Claude, an AI coding assistant from Anthropic. The development process involved iterative design discussions, code implementation, and feature refinement to create a clean, secure, and user-friendly PHP folder lister that replaces Apache's directory indexing functionality. 