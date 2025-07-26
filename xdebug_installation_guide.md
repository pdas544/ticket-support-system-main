# Installing and Configuring Xdebug with PhpStorm

## Step 1: Download and Install Xdebug

1. Go to the Xdebug wizard website: https://xdebug.org/wizard

2. Upload the phpinfo.txt file we created or copy-paste its contents into the wizard.

3. The wizard will analyze your PHP configuration and recommend the appropriate Xdebug version. For PHP 8.4.7 with ZTS on Windows x64, you'll likely need a file like `php_xdebug-3.3.1-8.4-vs16-x86_64.dll`.

4. Download the recommended DLL file.

5. Copy the downloaded DLL file to your PHP extensions directory:
   ```
   C:\php\8_4\ext
   ```

6. Rename the file to `php_xdebug.dll` for simplicity.

## Step 2: Configure PHP to Use Xdebug

1. Open your PHP configuration file in a text editor:
   ```
   C:\php\8_4\php.ini
   ```

2. Add the following lines at the end of the file:
   ```ini
   [Xdebug]
   zend_extension=xdebug
   xdebug.mode=debug
   xdebug.start_with_request=yes
   xdebug.client_port=9003
   xdebug.client_host=127.0.0.1
   xdebug.log=C:\php\8_4\xdebug.log
   xdebug.idekey=PHPSTORM
   ```

3. Save the file.

4. Restart your web server (Apache) to apply the changes.
   
   If you're using XAMPP, restart Apache through the XAMPP Control Panel.

5. Verify that Xdebug is installed correctly:
   ```
   php -v
   ```
   
   You should see Xdebug mentioned in the output.

## Step 3: Configure PhpStorm for Xdebug

1. Open PhpStorm and go to your project.

2. Open Settings/Preferences:
   - Windows/Linux: File > Settings
   - macOS: PhpStorm > Preferences

3. Navigate to PHP > Debug:
   - Ensure the Debug port is set to 9003 (same as in php.ini)
   - Check "Can accept external connections"
   - Check "Force break at first line when no path mapping specified"
   - Check "Force break at first line when a script is outside the project"

4. Navigate to PHP > Servers:
   - Click the + button to add a new server
   - Name: localhost (or your server name)
   - Host: localhost
   - Port: 80 (or your web server port)
   - Check "Use path mappings"
   - Map your local project directory to the server path:
     - Local path: C:\xampp\htdocs\Ticket
     - Server path: /Ticket (or the appropriate server path)

5. Apply the changes and click OK.

6. Enable the Xdebug listener in PhpStorm by clicking the "Listen for PHP Debug Connections" button in the toolbar (it looks like a telephone).

## Step 4: Create a Simple Debugging Test

1. Select a file to debug:
   - For this example, we'll use `C:\xampp\htdocs\Ticket\public\index.php` as it's the entry point for the application.

2. Set breakpoints:
   - Open the file in PhpStorm
   - Click in the gutter (the area to the left of the line numbers) on a line where you want execution to pause
   - A red circle will appear, indicating a breakpoint

3. Configure a debug run configuration:
   - Go to Run > Edit Configurations
   - Click the + button and select "PHP Web Page"
   - Name: Debug Ticket
   - Server: Select the server you created earlier
   - Start URL: / (or the specific path you want to debug)
   - Browser: Choose your preferred browser
   - Click OK to save the configuration

## Step 5: Test the Xdebug Setup

1. Start the debugging session:
   - Make sure the Xdebug listener is enabled (the telephone icon should be green)
   - Select the debug configuration you created from the dropdown in the toolbar
   - Click the Debug button (green bug icon)
   - PhpStorm will launch your browser and open the specified URL

2. Verify breakpoints are hit:
   - When the code execution reaches your breakpoint, PhpStorm will become active
   - The execution will pause at the breakpoint
   - The current line will be highlighted
   - If breakpoints aren't hit, see the troubleshooting section below

3. Test variable inspection and step-through debugging:
   - Hover over variables to see their current values
   - Use the Debug tool window to examine variables, the call stack, and other debugging information
   - Use the step buttons in the Debug tool window to control execution:
     - Step Over (F8): Execute the current line and move to the next line
     - Step Into (F7): Step into a function call
     - Step Out (Shift+F8): Complete the current function and return to the caller
     - Resume Program (F9): Continue execution until the next breakpoint or the end of the script

4. End the debugging session:
   - Click the Stop button in the Debug tool window
   - Or let the script complete its execution

## Step 6: Troubleshooting Common Issues

If you encounter problems with Xdebug, here are some common issues and their solutions:

### Xdebug Not Detected

1. Verify Xdebug is installed correctly:
   ```
   php -v
   ```
   
   If Xdebug is not mentioned in the output:
   - Check that the DLL file is in the correct extensions directory
   - Ensure the php.ini configuration is correct
   - Make sure you're editing the correct php.ini file (there might be multiple)
   - Restart your web server after making changes

2. Check Xdebug logs:
   - Look at the log file specified in your php.ini (e.g., C:\php\8_4\xdebug.log)
   - The log will show connection attempts and errors

### Breakpoints Not Being Hit

1. Verify the Xdebug listener is enabled in PhpStorm (the telephone icon should be green).

2. Check browser extensions:
   - For Chrome: Install the "Xdebug Helper" extension
   - For Firefox: Install the "Xdebug Helper" add-on
   - Configure the extension with your IDE key (PHPSTORM)

3. Verify path mappings:
   - Ensure the local path and server path are correctly mapped in PhpStorm
   - Incorrect mappings can prevent breakpoints from being recognized

4. Check firewall settings:
   - Make sure your firewall allows connections on the debug port (9003)

5. Try the bookmarklet approach:
   - Create a bookmark with this JavaScript:
     ```javascript
     javascript:(function() { document.cookie='XDEBUG_SESSION=PHPSTORM;path=/;'; })()
     ```
   - Click the bookmark before loading the page you want to debug

### Connection Issues

1. Verify the correct port is being used:
   - Check that the port in php.ini matches the port in PhpStorm settings

2. Try a different port if 9003 is in use.

3. Ensure xdebug.client_host is set correctly:
   - Use 127.0.0.1 for local development
   - If using Docker or VMs, you might need a different IP address

### Testing with the Provided Test Script

A test script has been created to help you verify your Xdebug setup with the project's routes.php file:

1. Open the provided test script:
   ```
   C:\xampp\htdocs\Ticket\test_debug.php
   ```

2. Set breakpoints in the following locations:
   - In routes.php, around line 19 where the AltoRouter is instantiated
   - In test_debug.php, around line 26 where the routes are retrieved
   - In test_debug.php, around line 31 in the foreach loop

3. Configure a debug run configuration for test_debug.php:
   - Go to Run > Edit Configurations
   - Click the + button and select "PHP Script"
   - Name: Debug Routes Test
   - File: Select test_debug.php
   - Click OK to save the configuration

4. Run the debug session:
   - Make sure the Xdebug listener is enabled
   - Select the "Debug Routes Test" configuration from the dropdown
   - Click the Debug button (green bug icon)
   - The script will run and pause at your breakpoints

5. Examine the variables:
   - When paused at a breakpoint, examine the $router and $routes variables
   - Use the Variables panel in the Debug tool window
   - Step through the code to see how the routes are processed

This test script provides a practical way to verify your Xdebug setup is working correctly with the project's routing system.

## Conclusion

You have now successfully:

1. Installed Xdebug for PHP 8.4.7
2. Configured PHP to use Xdebug
3. Set up PhpStorm for debugging
4. Created and tested a debugging configuration
5. Learned how to troubleshoot common issues

Debugging with Xdebug will significantly improve your development workflow by allowing you to:

- Inspect variables and their values at runtime
- Step through code execution line by line
- Understand the flow of your application
- Quickly identify and fix bugs
- Explore how different parts of your code interact

Remember that you can set breakpoints in any PHP file in your project, not just the ones we've used in this example. This makes Xdebug a powerful tool for understanding and debugging complex applications.

For more advanced usage, consider exploring:

- Conditional breakpoints (break only when a condition is true)
- Watches (monitor specific variables)
- Evaluating expressions during debugging
- Remote debugging (debugging code running on a different server)

Happy debugging!