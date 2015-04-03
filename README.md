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
		Put in this script your js scripts(js will be check, concat and minify by Grunt)
	
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
	- With a watcher to do this all in developpment mode.

# REQUIRED
	- Sass preprocessor
	- Grunt

# INSTALLATION

- Clone repository

```sh
cd my/desired/directory
$ git clone --recursive git@github.com:sbodrero/Mediis_wordpress_Foundation_deploy_master.git

- Execute command to clean git and installed Wordpress from repository :
$ bash config/init.sh 
``` 

- wp-config : 
	- set salt (https://api.wordpress.org/secret-key/1.1/salt/) in wp-config.php
	- set staging of production infos in wp-config
	- set local infos in local-config-sample.php and rename the file local-config.php

- update foundation
```sh
cd content/themes/reverie-master
foundation update 
``` 
- Init Grunt (need to install Grunt before)
```sh
npm install 
``` 
This will read package.json and install all dependencies 
Run wordpress