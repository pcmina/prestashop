# PrestaShop Mail Class Override

This folder contains custom override for the PrestaShop `Mail` class. This override modifies the default behavior of email attachments handling in PrestaShop. 
## Overview

The `Mail` class in PrestaShop is responsible for sending emails from the store. This override provides enhancements or custom functionality to the default email handling process. It allows you to add multiple attachments for mail templates based on their names. 

## Installation

To use this override in your PrestaShop installation:

1. **Copy the Override File**: Place the `Mail.php` file from this folder into your PrestaShop installation's `override/classes/` directory. If the `classes` directory does not exist, create it.

    ```bash
    cp Mail.php /path/to/your/prestashop/override/classes/
    ```

2. **Clear Cache**: After copying the file, clear PrestaShop's cache to ensure the override is applied.

    - In the PrestaShop back office, navigate to `Advanced Parameters` > `Performance`.
    - Click on `Clear Cache`.

3. **Test**: Verify that the overridden functionality is working as expected by sending test emails.

## Usage

- **Custom Email Templates**: If your override includes custom email templates, ensure they are placed in the appropriate email template directory of your PrestaShop installation.
- **Attachment location**: You need to specify in override mail.php attachment location. 
- **Configuration**: Any additional configuration needed for the override should be documented here.



