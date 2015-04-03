# MEDIIS : a complete and easy deploy WordPress/ZURB Foundation developper solution
# What's in the pack

- A ZURB Foundation based Wordpress starter theme based on the excellent 'Reverie powered by Zhen Huang http://themefortress.com/reverie' (several modifications added by myself)
	- The theme native features :
		- Foundation 5.2.3 
		- Responsive
		- HTML 5
		- SEO Optimized
		- Sass/Scss
		- ...
	- Additionals features (added by theme modifications)
		- IE8 support improved by rem.js
		- Added sub scss files for media query
		- custom post type easy deploy (custom-post-type.php)
		- admin.php (custom admin area)
		- Font Awesome 4.3.0 embeded
		- header.php modified to improve Window 8 support
		- script.js contains Foundation init and a fix for the iOS orientationchange zoom bug.
		Put in this script your js scripts(js will be check, concat nd minify by Grunt)
	
- Mu-plugins :
	- Mandrill (for transactionnal emails) 
	- CMB (Custom Metaboxes and Fields for WordPress https://github.com/WebDevStudios/CMB2)
- Plugin :
	- WP Migrate DB 
- Wordpress installed as git submodule in wp folder so it's easy to upgrade or revert by checkout branch

```sh
cd wp
git fetch && git fetch --tags
git checkout 4.1.1
cd ./
git add wp
git commit -m “Updated to WP 4.1.1”
git push
``` 
- The solution comes with local and dist (staging, production) WordPress config files
- Themes, plugins, uploads are in content folder (nothing in wp folder else that WordPress files)

- A Grunt file to :
	- Verify js and php files
	- Minify css (Reverie modified theme)
	- Minify js (Reverie modified theme)
	- Minify images (Imagemin)
	- Wuth a watcher to do this all in developpment mode.

# INSTALLATION

1 - Clone repository

```sh
cd my/desired/directory
$ git clone --recursive git@bitbucket.org:sbodrero/master_wordpress.git

2 - Execute command to clean git :
$ bash config/init.sh 
``` 

3 - wp-config : 
	- set salt (https://api.wordpress.org/secret-key/1.1/salt/) in wp-config.php
	- set staging of production infos in wp-config
	- set local infos in local-config-sample.php and rename the file local-config.php

4 - update foundation
```sh
cd content/themes/reverie-master
foundation update 
``` 
5 - Init Grunt (need to install Grunt before)
```sh
npm install 
``` 
This will read package.json and install all dependencies 
Run wordpress

Local to staging :

Same actions as before on staging server (except clone reverie), install staging and run wp-migrate db to get right informations to migrate. The erase database contents (all tables)
then locally(local development) run wp-migratedb with right staging params. Import database in staging and run staging Wordpress.
Carefull : admin acces = yourdomain.tld/wp/