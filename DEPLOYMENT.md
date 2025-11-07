# OneNav Theme Deployment Guide

## Updating Your Local WordPress Installation

If you're getting errors like "Cannot redeclare function" in your WordPress installation, it means your theme files need to be updated from the git repository.

### Steps to Update:

1. **Navigate to your WordPress theme directory:**
   ```bash
   cd C:\laragon\www\wp-content\themes\new-main
   ```

2. **Check if the directory is a git repository:**
   ```bash
   git status
   ```

3. **Pull the latest changes:**
   ```bash
   git pull origin main
   ```

4. **Clear WordPress cache (if using a cache plugin):**
   - Go to WordPress Admin Dashboard
   - Navigate to your cache plugin settings
   - Click "Clear Cache" or "Purge Cache"

5. **Reload your website**

### Common Issues:

#### "Cannot redeclare onenav_set_post_views()" Error

**Problem:** The `onenav_set_post_views()` function is declared twice.

**Solution:** This has been fixed in the latest version. Pull the latest changes from the repository.

**Technical Details:**
- The duplicate function declarations were removed from `functions.php:513`
- These functions are now only defined in `inc/helpers.php:21`
- The helper file is properly included in `functions.php:36`

#### Git Not Initialized in Theme Directory

If your theme directory is not a git repository:

1. **Initialize git:**
   ```bash
   cd C:\laragon\www\wp-content\themes\new-main
   git init
   ```

2. **Add remote repository:**
   ```bash
   git remote add origin https://github.com/saitamar10/new.git
   ```

3. **Fetch and checkout main branch:**
   ```bash
   git fetch origin
   git checkout main
   ```

### Alternative: Manual Update

If you can't use git, you can manually update:

1. Download the latest code from GitHub
2. Extract the ZIP file
3. Copy all files to `C:\laragon\www\wp-content\themes\new-main\`
4. Replace existing files when prompted

### Development Workflow

For developers working on this theme:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/saitamar10/new.git
   ```

2. **Create symlink or copy to WordPress:**
   ```bash
   # Option 1: Symlink (recommended)
   mklink /D "C:\laragon\www\wp-content\themes\new-main" "C:\path\to\cloned\repo"

   # Option 2: Copy files
   xcopy /E /I /Y "C:\path\to\cloned\repo" "C:\laragon\www\wp-content\themes\new-main"
   ```

3. **Make changes in the git repository**

4. **Test in WordPress**

5. **Commit and push changes**

### Preventing Future Issues

To avoid synchronization issues:

1. **Always develop in the git repository directory**
2. **Use a symlink from WordPress to your git repo**
3. **Pull latest changes before starting work**
4. **Test after pulling changes**

### Need Help?

If you encounter any issues:
1. Check the GitHub Issues page
2. Review the error logs in `wp-content/debug.log`
3. Ensure all required plugins are installed and activated
