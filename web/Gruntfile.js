module.exports = function (grunt) {
    grunt.initConfig({
        autoprefixer: {
            dist: {
                files: {
                    'build/styles.css': 'css/styles.css'
                }
            }
        },
        browserSync: {
			dev: {
				bsFiles: {
					src : 'build/styles.css'
				},
				options: {
					watchTask: true,
					proxy: "localhost:8000"
				}
			}
		},
        watch: {
            styles: {
                files: ['css/styles.css'],
                tasks: ['autoprefixer']
            }
        }
    });
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-browser-sync');
    
    // define default task
    grunt.registerTask('default', ['browserSync', 'watch']);
};