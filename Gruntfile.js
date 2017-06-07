module.exports = function(grunt){
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),	
		
		/**
		 * Sass tasks
		 */
		 sass: {
			dist: {
				options: {
					style: 'compressed',
					sourcemap: 'auto'
				},
				files: {
					'library/css/print.min.css' : 'library/css/scss/print.scss',
					'library/css/navigation.min.css' : 'library/css/scss/navigation.scss',
					'library/css/responsive.min.css' : 'library/css/responsive.scss',
					'./style.min.css' : './style.scss',
				}	
			}	 
		 },
		
		/**
		 * Watch task
		 */
		 watch: {
			css: {
				files: ['**/*.scss'],
				tasks: ['sass']	
			},
		 }
	});
	
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default',['watch']);
};