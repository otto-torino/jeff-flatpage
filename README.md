jeff-flatpage by Otto srl, MIT license
======================================

![Screenshot](http://github.com/otto-torino/jeff-flatpage/raw/master/doc/screenshot_admin_list.jpg)

jeff-flatpage is a jeff module that lets you store simple "flat" HTML content in a database and handles the management for you via jeff’s admin interface.

Use it for one-off, special-case pages, such as "About" or "Privacy Policy" pages, that you want to store in a database but for which you don’t want to develop a custom Jeff module.

The module is provided with english and italian translations, and a mysql statement for the table creation.    
Media (images, videos) may be added to the page content, whose access may also be restricted to some system groups.    
The access to backoffice administration is restricted to users having the flatpage admin permission.

Fields
-------

* date (optional)
* title (mandatory)
* slug (mandatory). Is the relative url remainding to the page (usually the tite without spaces and strange characters)
* subtitle (optional)
* abstract (optional)
* text (optional)
* image1 (optional). An image file, supported formats are jpg,png,gif
* image2 (optional). An image file, supported formats are jpg,png,gif
* video1 (optional). A youtube video code (i.e. http://www.youtube.com/watch?v=fT7rCWZvsD8 => code: fT7rCWZvsD8)
* video2 (optional). A youtube video code (i.e. http://www.youtube.com/watch?v=fT7rCWZvsD8 => code: fT7rCWZvsD8)
* groups (optional). A list of groups which can access the contents, if empty the content is public.

Instructions on how to insert images and videos inside the page text are provided in the insertion form. Such elements may be inserted using custom tags like    
{{image1 width=200 position:left lightbox:true}}

Outputs
--------

* page view
* page 404 (if the required slug is not found)
* page 403 (if the user can't access the content)

Installation
-------------

1. Create the db table and add the admin permission executing the statements provided in the **flatpage.sql** file. This file contains the statements using the mysql  syntax, change it for different DBMS.
2. Insert the table definition provided in the **project_tables.php** file inside your same-name file. If you don't have one copy it inside your ROOT directory.
3. Create a "**flatpage**" directory inside the "**upload**" directory under ROOT (for the images upload).
4. Append the array elements inside **languages/<language>.php** to your theme languages files (the default one is in ROOT/themes/default/languages/<language>.php).
5. Copy all the files inside **view** directory inside your theme view directory (the default one is ROOT/themes/default/view).
6. Copy the whole **flatpage** directory inside your **modules** directory (ROOT/modules).
6. Finished.
7. Add an admin menu link to access the flatpage backoffice, the url is ROOT/admin/flatpage/manage.
8. Enjoy it.

Please report issues, bugs and what you like in the project github issues page.
