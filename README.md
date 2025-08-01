# htaccess-indexes

A lightweight PHP application that replaces Apache's `Options +Indexes` functionality
in `.htaccess` for browsing folders and files through a web interface with a much nicer user interface and some decent

## Quick start

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
- `$HOME_URL`: URL for the home icon (leave empty for current directory)
- `$HOME_OPEN_IN_NEW_TAB`: Whether the home icon opens in a new tab (true/false)
- `$HOME_HIDE`: Whether to hide the home icon completely (true/false)

### Local Configuration Overrides

You can create a `config.local.php` file to override settings without modifying the main `config.php` file. This is useful for:

- Environment-specific settings (development, staging, production)
- Keeping sensitive configuration out of version control
- Multiple deployments with different settings

**Example `config.local.php`:**
```php
<?php
// Local configuration overrides
$PASSWORD_PROTECTION_ENABLED = true;
$SITE_PASSWORD = 'my-secure-password';
$HOME_URL = 'https://example.com';
$PAGE_TITLE = 'My File Browser';
```

**Note:** `config.local.php` is automatically included in `.gitignore` to prevent accidentally committing local settings.

## Password Protection

The application includes optional cookie-based password protection. To enable it:

1. **Enable password protection**: Set `$PASSWORD_PROTECTION_ENABLED = true;` in `config.php`
2. **Set a password**: Change `$SITE_PASSWORD` to your desired password
3. **Customize settings** (optional):
   - `$AUTH_COOKIE_NAME`: Name of the authentication cookie (default: 'htaccess_auth')
   - `$AUTH_COOKIE_EXPIRY`: How long the cookie lasts in seconds (default: 2 weeks)

### How it works

- When password protection is enabled, users will see a login form on their first visit
- After entering the correct password, a secure cookie is set that lasts for 2 weeks
- Users won't be prompted for the password again until the cookie expires
- The cookie is HTTP-only and secure (HTTPS only) for enhanced security

### Security considerations

- The password is stored in plain text in `config.php` - ensure this file is not publicly accessible
- Cookies are set with secure flags (HTTP-only and secure) to prevent XSS and man-in-the-middle attacks
- The authentication uses a simple hash-based verification - for production use, consider implementing more robust security measures
- Remember that this is still basic authentication - for highly sensitive content, consider using proper web server authentication

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
- Optional cookie-based password protection

## Security Note

**Important**: Configuring files as "hidden" in `config.php` only hides them from the folder listings displayed by this application. The underlying files will still be served by Apache if accessed directly via URL. **Do not store sensitive files in this directory** - the hiding feature is for "convenience" only and does not provide security protection.

For example, if you hide `secret.txt` in the configuration, it won't appear in the folder listing, but it can still be accessed directly at `https://yoursite.com/secret.txt`.

This is an example of [security through obscurity](https://en.wikipedia.org/wiki/Security_through_obscurity) - simply hiding hiding information in a user interface while it can
still be accessed through an underlying mechaism.  The lesson is (again): **Do not store sensitive files in this directory**

## Requirements

- PHP 7.0 or higher
- Web server with PHP support
- Apache with mod_rewrite or .htaccess fallback

## Features

- **Clean, modern interface** with responsive design
- **Security-focused** with directory traversal protection
- **Configurable hiding** of files and folders
- **Breadcrumb navigation** for easy folder traversal
- **File information** display (size, modification date)
- **Parent directory links** for quick navigation
- **Mobile-friendly** responsive design
- **Optional password protection** with cookie-based authentication

## License

This project is open source and available under the MIT License.

## Acknowledgments

This application was developed with the assistance of Claude, an AI coding assistant from Anthropic. The development process involved iterative design discussions, code implementation, and feature refinement to create a clean, secure, and user-friendly PHP folder lister that replaces Apache's directory indexing functionality. 