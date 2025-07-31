
Introduction
------------

A Simple PHP based folder and file lister.  This is designed to replace the fucitonality
of `Options +Indexes` in a `.htaccess` file.  The basic use cases is that you have a hosted PHP environment that you just want to serve a hierarchy of folders and files.

This code is mostly about navigating folders - the files will metely be listed by this appkication and the folders will be served by tghe underlying web server.

    FallbackResource index.php
