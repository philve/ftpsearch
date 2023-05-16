# FTP Search Engine

This is a search engine that indexes files across multiple FTP servers.

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

## Credit

Created by Philve
