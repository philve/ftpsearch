# FTP Search Engine

This project allows you to search for files across multiple FTP servers and provides useful features like previewing and performing tasks on the results.

## Setup

To set up the search engine:

1. Install MySQL and create a database named `ftpsearch`.

2. Import the `mysql.db` file to create the database tables.

3. Update the database credentials in `config.php`.

4. Update the list of FTP hosts in `hosts.list`.

5. Add a cron job to run `sync.php` regularly to update the database with files from the FTP servers. 

6. Configure your web server to serve the files from the `htdocs` directory.

7. Access the search interface at `http://yourdomain.com`.

8. Run `php sync.php` manually the first time to index all files from the FTP servers.


## Features

- Search across multiple FTP servers 
- View previews of files directly in the browser
- Add files to a list of "tasks"
- Database is kept in sync with FTP servers via a cron job


## File Structure

The main files and folders are:

- `htdocs` - The web interface 
- `sync.php` - The script to sync with FTP servers 
- `hosts.list` - The list of FTP hosts 
- `config.php` - Database and FTP configuration 
- `mysql.db` - The database dump file 
- `FTP` - Folder containing FTP utility classes

## Deployment

These steps will deploy the project on a Debian/Ubuntu server:

1. Create a database and user:

   ````sql
   CREATE DATABASE ftpsearch;
   CREATE USER 'ftpsearch'@'localhost' IDENTIFIED BY 'password';
   GRANT ALL ON ftpsearch.* TO 'ftpsearch'@'localhost';
   

2. Upload all files to `/opt/bitnami/apache2/htdocs/ftpsearch/` 

3. Enable Apache mod_rewrite:

   ````bash
   a2enmod rewrite
   systemctl restart apache2
   

4. Initialize the database:

   ````bash 
   php db.php
   

5. Update `config.php` with your FTP credentials and hosts.

6. Run the synchronization script:

   ````bash
   php sync.php
   

7. Make Apache document root 
 - In my case it is `/opt/bitnami/apache2/htdocs/ftpsearch/`

8. Access the project at your server's IP or domain name.


## Usage

- Search for files by entering a query on the home page and clicking "Search".

- Results will show relevant file details and provide options to:

  - Preview the file 
  - Add the file to tasks 
  - Synchronize the database with the FTP servers (via `sync.php`)

- Tasks are stored in the `tasks.json` file and can be used to perform actions on specific files.

- The `.htaccess` file enables:

  - Clean URLs
  - HTTPS redirection
  - Caching of static files
  - Compression of text files

- `robots.txt` allows blocking paths from search engines.

- `static/` contains stylesheets, images and JavaScript files.

- The `FTP/` directory contains classes for connecting and interacting with FTP servers.

- The database schema consists of a single `files` table storing information about synchronized FTP files.


## Credit

Created by Philve
