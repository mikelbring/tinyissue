
module.exports = function(grunt){

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-banner');
    grunt.loadNpmTasks('grunt-notify');

    grunt.registerTask('default', ['less', 'jshint', 'uglify', 'usebanner', 'notify:success']);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        banner: '/*!\n' +
                ' * Bootstrap Markdown Editor v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
                ' * Copyright <%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
                ' * Licensed under <%= pkg.license.type %> (<%= pkg.license.url %>)\n' +
                ' */\n',

        less: {
            development: {
                options: {
                    cleancss: true,
                    compress: true
                },
                files: {
                    "dist/css/bootstrap-markdown-editor.css": "src/bootstrap-markdown-editor.less"
                }
            }
        },

        usebanner: {
            taskName: {
                options: {
                    position: 'top',
                    banner: '<%= banner %>',
                    linebreak: true
                },
                files: {
                    src: [
                        'dist/css/bootstrap-markdown-editor.css',
                        'dist/js/bootstrap-markdown-editor.js'
                    ]
                }
            }
        },

        jshint: {
            development: {
                options: {
                    curly: true,
                    eqeqeq: true,
                    freeze: true,
                    latedef: true,
                    newcap: true,
                    noarg: true,
                    nonew: true,
                    trailing: true,
                    undef: true,
                    unused: true,
                    browser: true,
                    globals: {
                        console: true,
                        ace: true,
                        jQuery: true
                    }
                },
                files: {
                    src: [
                        "src/bootstrap-markdown-editor.js"
                    ]
                }
            }
        },

        uglify: {
            development: {
                compress: {
                    preserveComments: false,
                    drop_console: true
                },
                files: {
                    "dist/js/bootstrap-markdown-editor.js": ["src/bootstrap-markdown-editor.js"]
                }
            }
        },

        notify: {
            success: {
                options: {
                    title: '✅ Finished Tasks',
                    message: 'All tasks finished successfully'
                }
            }
        },

        watch: {
            css: {
                files: 'src/*.less',
                tasks: ['less', 'usebanner', 'notify:success']
            },
            js: {
                files: 'src/*.js',
                tasks: ['jshint', 'uglify', 'usebanner', 'notify:success']
            }
        }

    });
};
