	module.exports = function(grunt){
	require('load-grunt-tasks')(grunt);

	function log(err, stdout, stderr, cb) {
		console.log(stdout);
		cb();
	}
	
	grunt.initConfig({
		concat: {
			options: {
				separator: ';',
			},
			jsfusion: {
				src: ['content/themes/reverie-master/js/foundation.min.js', 
				'content/themes/reverie-master/js/pizza/dependencies.js', 
				'content/themes/reverie-master/js/pizza/snap.svg-min.j',
				'content/themes/reverie-master/js/pizza/pizza.js',						
				'content/themes/reverie-master/js/script.js'],
				dest: 'content/themes/reverie-master/js/remote/built.js',
			},
		},
		uglify: {
			options: {
				mangle: false
			},
			jsminify: {
				files: {
					'content/themes/reverie-master/js/remote/built.min.js': ['content/themes/reverie-master/js/remote/built.js']
				}
			}

		},
		jshint: {
			all: ['content/themes/reverie-master/js/script.js']
		},
		cssmin: {
			combine: {
				files: {
					'content/themes/reverie-master/css/style.min.css':['content/themes/reverie-master/css/app.css',
					'content/themes/reverie-master/css/style.css',
					'content/themes/reverie-master/css/font-awesome.css',
					'content/themes/reverie-master/css/pizza.css']
				}
			}
		},
		phpcs : {
			application : {
				src : ['content/themes/reverie-master/functions.php',
				'content/themes/reverie-master/header.php',
				'content/themes/reverie-master/footer.php',
				'content/themes/reverie-master/pafe-full.php',
				'content/themes/reverie-master/page-home.php',
				'content/themes/reverie-master/sidebar.php',
				'content/themes/reverie-master/sidebar-offcanvas.php',
				'content/themes/reverie-master/single-projet.php']
			},
			options: {
				bin: 'phpcs',
				standard: 'Zend',
				callback: log
			}
		},
		imagemin: {                          // Task 
		    dynamic_uploads: {                         // Another target 
		    	files: [{
			        expand: true,                  // Enable dynamic expansion 
			        cwd: 'content/uploads/',                   // Src matches are relative to this path 
			        src: ['**/*.{png,jpg,gif,PNG,jpeg}'],   // Actual patterns to match 
			        dest: 'content/uploads-min/'                  // Destination path prefix 
			    }]
			},
		    dynamic_theme: {                         // Another target 
		    	files: [{
			        expand: true,                  // Enable dynamic expansion 
			        cwd: 'content/themes/reverie-master/img/',                   // Src matches are relative to this path 
			        src: ['**/*.{png,jpg,gif,PNG,jpeg}',],   // Actual patterns to match 
			        dest: 'content/themes/reverie-master/img-min/'                  // Destination path prefix 
			    }]
			},
		},
		watch: {
			js: {
				files: ['content/themes/reverie-master/js/*.js'],
				tasks: ['jshint','concat','uglify'],
				options: {spawn:false}
			},
			css: {
				files: ['content/themes/reverie-master/css/*.css','content/themes/reverie-master/css/!style.min.css'],
				tasks: ['cssmin'],
				options: {
					spawn:false,
					livereload: false,
				}				
			},
			image_themes: {
				files: ['content/themes/reverie-master/img/*','content/themes/reverie-master/img/**/*'],
				tasks: ['newer:imagemin:dynamic_theme'],
			},
			image_uploads: {
				files: ['content/uploads/**/*','content/uploads/**/**/*'],
				tasks: ['newer:imagemin:dynamic_uploads'],				
			}
		}		
});

grunt.registerTask('default', ['jshint','concat','uglify','cssmin','newer:imagemin:dynamic_theme','newer:imagemin:dynamic_uploads']);
}