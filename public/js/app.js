(function() {
  'use strict';

  var globals = typeof global === 'undefined' ? self : global;
  if (typeof globals.require === 'function') return;

  var modules = {};
  var cache = {};
  var aliases = {};
  var has = {}.hasOwnProperty;

  var expRe = /^\.\.?(\/|$)/;
  var expand = function(root, name) {
    var results = [], part;
    var parts = (expRe.test(name) ? root + '/' + name : name).split('/');
    for (var i = 0, length = parts.length; i < length; i++) {
      part = parts[i];
      if (part === '..') {
        results.pop();
      } else if (part !== '.' && part !== '') {
        results.push(part);
      }
    }
    return results.join('/');
  };

  var dirname = function(path) {
    return path.split('/').slice(0, -1).join('/');
  };

  var localRequire = function(path) {
    return function expanded(name) {
      var absolute = expand(dirname(path), name);
      return globals.require(absolute, path);
    };
  };

  var initModule = function(name, definition) {
    var hot = hmr && hmr.createHot(name);
    var module = {id: name, exports: {}, hot: hot};
    cache[name] = module;
    definition(module.exports, localRequire(name), module);
    return module.exports;
  };

  var expandAlias = function(name) {
    var val = aliases[name];
    return (val && name !== val) ? expandAlias(val) : name;
  };

  var _resolve = function(name, dep) {
    return expandAlias(expand(dirname(name), dep));
  };

  var require = function(name, loaderPath) {
    if (loaderPath == null) loaderPath = '/';
    var path = expandAlias(name);

    if (has.call(cache, path)) return cache[path].exports;
    if (has.call(modules, path)) return initModule(path, modules[path]);

    throw new Error("Cannot find module '" + name + "' from '" + loaderPath + "'");
  };

  require.alias = function(from, to) {
    aliases[to] = from;
  };

  var extRe = /\.[^.\/]+$/;
  var indexRe = /\/index(\.[^\/]+)?$/;
  var addExtensions = function(bundle) {
    if (extRe.test(bundle)) {
      var alias = bundle.replace(extRe, '');
      if (!has.call(aliases, alias) || aliases[alias].replace(extRe, '') === alias + '/index') {
        aliases[alias] = bundle;
      }
    }

    if (indexRe.test(bundle)) {
      var iAlias = bundle.replace(indexRe, '');
      if (!has.call(aliases, iAlias)) {
        aliases[iAlias] = bundle;
      }
    }
  };

  require.register = require.define = function(bundle, fn) {
    if (bundle && typeof bundle === 'object') {
      for (var key in bundle) {
        if (has.call(bundle, key)) {
          require.register(key, bundle[key]);
        }
      }
    } else {
      modules[bundle] = fn;
      delete cache[bundle];
      addExtensions(bundle);
    }
  };

  require.list = function() {
    var list = [];
    for (var item in modules) {
      if (has.call(modules, item)) {
        list.push(item);
      }
    }
    return list;
  };

  var hmr = globals._hmr && new globals._hmr(_resolve, require, modules, cache);
  require._cache = cache;
  require.hmr = hmr && hmr.wrap;
  require.brunch = true;
  globals.require = require;
})();

(function() {
var global = typeof window === 'undefined' ? this : window;
var __makeRelativeRequire = function(require, mappings, pref) {
  var none = {};
  var tryReq = function(name, pref) {
    var val;
    try {
      val = require(pref + '/node_modules/' + name);
      return val;
    } catch (e) {
      if (e.toString().indexOf('Cannot find module') === -1) {
        throw e;
      }

      if (pref.indexOf('node_modules') !== -1) {
        var s = pref.split('/');
        var i = s.lastIndexOf('node_modules');
        var newPref = s.slice(0, i).join('/');
        return tryReq(name, newPref);
      }
    }
    return none;
  };
  return function(name) {
    if (name in mappings) name = mappings[name];
    if (!name) return;
    if (name[0] !== '.' && pref) {
      var val = tryReq(name, pref);
      if (val !== none) return val;
    }
    return require(name);
  }
};
require.register("js/initialize.js", function(exports, require, module) {
"use strict";

var _shufflejs = _interopRequireDefault(require("shufflejs"));

var _scrollmagic = _interopRequireDefault(require("scrollmagic"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var app = {
  init: function init() {
    // On récupére le basePath
    app.basePath = $('body').data('path'); // Validation du formulaire de connexion

    $('#connexion').on('submit', app.login); // Scroll sur la page pour la barre de navigation

    $(window).on('scroll', app.windowScroll); // Filter blog list

    $(window).on('load', app.shuffleBlogList); // Filter comments list

    $(window).on('load', app.shuffleCommentsList); // Filter users list

    $(window).on('load', app.shuffleUsersList); // Sticky elements

    $(window).on('scroll', app.stickyElements); // Count Animation

    $(window).on('load', app.countAnimation); // Trumbowyg

    $(window).on('load', app.showEditor); // Modal Reset password

    $('#link_reset_password').on('click', app.modalResetPassword); // Modal login

    $(window).on('load', app.showLoginModal); // Show Modal Reset Password with errors

    $(window).on('load', app.showModalResetPassword); // Image preview

    $(window).on('load', app.previewImg);
  },
  // Sticky Menu
  windowScroll: function windowScroll() {
    if ($('.navigation').offset().top > 100) {
      $('.navigation').addClass('nav-bg');
    } else {
      $('.navigation').removeClass('nav_bg');
    }
  },
  // Shuffle blog list
  shuffleBlogList: function shuffleBlogList() {
    if (window.location.href.indexOf("P5_Blog/blog") > -1) {
      var myShuffle = new _shufflejs["default"](document.querySelector('.shuffle-wrapper'), {
        itemSelector: '.shuffle-item',
        buffer: 1
      });
      $('input[name="shuffle-filter"]').on('change', function (evt) {
        var input = evt.currentTarget;

        if (input.checked) {
          myShuffle.filter(input.value);
        }
      });
    }
  },
  // Shuffle comments list
  shuffleCommentsList: function shuffleCommentsList() {
    if (window.location.href.indexOf("dashboard/comments") > -1) {
      $('input[name="NotValid"]').on('change', function (evt) {
        var input = evt.currentTarget;

        if (input.checked) {
          var rows = $('tr[data-groups]');
          rows.each(function (index, row) {
            if (row.getAttribute("data-groups") == "1") {
              $(this).hide();
            }
          });
        }
      });
      $('input[name="all"]').on('change', function (evt) {
        var input = evt.currentTarget;

        if (input.checked) {
          var rows = $('tr[data-groups]');
          rows.each(function (index, row) {
            $(this).show();
          });
        }
      });
    }
  },
  shuffleUsersList: function shuffleUsersList() {
    if (window.location.href.indexOf("dashboard/users") > -1) {
      $('input[name="isAdmin"]').on('change', function (evt) {
        var input = evt.currentTarget;

        if (input.checked) {
          var rows = $('tr[data-groups]');
          rows.each(function (index, row) {
            if (row.getAttribute("data-groups") == '0') {
              $(this).hide();
            }
          });
        }
      });
      $('input[name="all"]').on('change', function (evt) {
        var input = evt.currentTarget;

        if (input.checked) {
          var rows = $('tr[data-groups]');
          rows.each(function (index, row) {
            $(this).show();
          });
        }
      });
    }
  },
  // Sticky elements (pinning)
  stickyElements: function stickyElements() {
    if (window.innerWidth > 720) {
      var controller = new _scrollmagic["default"].Controller();
      var pins_elem = $('.pin-elem');
      $.each(pins_elem, function (indexInArray, valueOfElement) {
        new _scrollmagic["default"].Scene({
          offset: 100
        }).setPin(this).addTo(controller);
      });
    }
  },
  // Admin dashboard count animations
  count: function count($this) {
    var current = parseInt($this.html(), 10);
    current = current + 1;
    $this.html(++current);

    if (current > $this.data('count')) {
      $this.html($this.data('count'));
    } else {
      setTimeout(function () {
        app.count($this);
      }, 50);
    }
  },
  // Count animation
  countAnimation: function countAnimation() {
    if (window.location.pathname == app.basePath + '/dashboard') {
      $(".stat-count").each(function () {
        $(this).data('count', parseInt($(this).html(), 10));
        $(this).html('0');
        app.count($(this));
      });
    }
  },
  // Editeur Trumbowyng
  showEditor: function showEditor() {
    if (window.location.href.indexOf("posts/new") > -1 || window.location.href.indexOf("update") > -1) {
      $('#chapo').trumbowyg({
        svgPath: app.basePath + '/public/images/icons.svg',
        autogrow: true
      });
      $('#content').trumbowyg({
        svgPath: app.basePath + '/public/images/icons.svg',
        autogrow: true
      });
    }
  },
  // Read url IMG on form and preview img
  previewImg: function previewImg() {
    $('input[type="file"]').change(function (e) {
      var preview = document.querySelector('.wrapper-preview');
      preview.innerHTML = '';
      var file = document.querySelector('input[type=file]').files[0];

      if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
        var reader = new FileReader();
        reader.addEventListener("load", function () {
          var image = new Image();
          image.width = 400;
          image.title = file.name;
          image.src = this.result;
          preview.appendChild(image);
        }, false);
        reader.readAsDataURL(file);
      }

      var label = document.querySelector('.custom-file-label');
      label.innerText = file.name;
    });
  },
  // Modal reset password
  modalResetPassword: function modalResetPassword() {
    $('#login').modal('toggle');
  },
  // Affiche la modale de login
  showLoginModal: function showLoginModal() {
    if (window.location.pathname == app.basePath + '/login') {
      $("#modalLogin").trigger('click');
    }
  },
  // Affiche la modale de réinitialisation du password avec les erreurs
  showModalResetPassword: function showModalResetPassword() {
    if (window.location.pathname == app.basePath + '/resetPassword') {
      $("#link_reset_password").trigger('click');
    }
  }
};
$(app.init);
});

require.register("___globals___", function(exports, require, module) {
  

// Auto-loaded modules from config.npm.globals.
window.jQuery = require("jquery");
window["$"] = require("jquery");
window.bootstrap = require("bootstrap");
window.trumbowyg = require("trumbowyg");


});})();require('___globals___');

require('js/initialize');
//# sourceMappingURL=app.js.map