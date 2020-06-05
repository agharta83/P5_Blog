exports.files = {
  javascripts: {
    joinTo: {
      'js/app.js': /^app/,
        'js/vendor.js': /^node_modules/
    },
  },
  stylesheets: { 
    joinTo: {
       'css/app.css': /^app/,
       'css/vendor.css': /^node_modules/
    },
  },
};

exports.paths = {
  watched : ['app']
};

exports.watcher = {
  usePolling : true,
  awaitWriteFinish: true
};

exports.plugins = {
  pleeease: {
    sass: true,
    autoprefixer: {
      browsers: ['> 1%'],
    },
  },
};

exports.modules = {
  autoRequire: {
    'js/app.js': ['js/initialize'],
  },
};

exports.npm = {
  globals: {
    jQuery: 'jquery',
    $: 'jquery',
    bootstrap: 'bootstrap',
  },
  styles: {
    bootstrap: ['dist/css/bootstrap.css'],
  },
};
