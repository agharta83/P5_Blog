import Shuffle from 'shufflejs';
import ScrollMagic from 'scrollmagic';

var app = {
  init : function () {
    // On récupére le basePath
    app.basePath = $('body').data('path');

    // Validation du formulaire de connexion
    $('#connexion').on('submit', app.login);

    // Scroll sur la page pour la barre de navigation
    $(window).on('scroll', app.windowScroll);

    // Filter blog list
    $(window).on('load', app.shuffleBlogList);

    // Filter comments list
    $(window).on('load', app.shuffleCommentsList);

    // Filter users list
    $(window).on('load', app.shuffleUsersList);

    // Sticky elements
    $(window).on('scroll', app.stickyElements);

    // Count Animation
    $(window).on('load', app.countAnimation);

    // Trumbowyg
    $(window).on('load', app.showEditor);

    // Modal Reset password
    $('#link_reset_password').on('click', app.modalResetPassword);

    // Modal login
    $(window).on('load', app.showLoginModal);

    // Show Modal Reset Password with errors
    $(window).on('load', app.showModalResetPassword);

    // Image preview
    $(window).on('load', app.previewImg);
  },

  // Sticky Menu
  windowScroll : function() {
    if ($('.navigation').offset().top > 100) {
      $('.navigation').addClass('nav-bg');
    } else {
      $('.navigation').removeClass('nav_bg');
    }
  },

  // Sticky elements (pinning)
  stickyElements : function() {
    if (window.innerWidth > 720) {
      var controller = new ScrollMagic.Controller();

      var pins_elem = $('.pin-elem');

      $.each(pins_elem, function (indexInArray, valueOfElement) {
        new ScrollMagic.Scene({
          offset: 100
        })
          .setPin(this)
          .addTo(controller);
      });
    }

  },

  // Admin dashboard count animations
  count : function($this) {
    var current = parseInt($this.html(), 10);
    current = current + 1;
    $this.html(++current);

    if (current > $this.data('count')) {
      $this.html($this.data('count'));
    } else {
      setTimeout(function () {
        app.count($this)
      }, 50);
    }
  },

  // Count animation
  countAnimation : function() {
    if (window.location.pathname == app.basePath + '/dashboard') {
      $(".stat-count").each(function () {
        $(this).data('count', parseInt($(this).html(), 10));
        $(this).html('0');
        app.count($(this));
      });
    }

  },

  // Editeur Trumbowyng
  showEditor : function() {
    if ((window.location.href.indexOf("posts/new") > -1 || window.location.href.indexOf("update") > -1)) {
      $('#chapo').trumbowyg({
        svgPath: app.basePath + '/public/images/icons.svg',
        autogrow: true,
      });

      $('#content').trumbowyg({
        svgPath: app.basePath + '/public/images/icons.svg',
        autogrow: true,
      });
    }
  },

  // Read url IMG on form and preview img
  previewImg : function () {
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
  modalResetPassword : function() {
    $('#login').modal('toggle');
  },

  // Affiche la modale de login
  showLoginModal : function() {
    if (window.location.pathname == app.basePath + '/login') {
      $("#modalLogin").trigger('click');
    }

  },

  // Affiche la modale de réinitialisation du password avec les erreurs
  showModalResetPassword : function() {
    if (window.location.pathname == app.basePath + '/resetPassword') {
      $("#link_reset_password").trigger('click');
    }
  },

}

$(app.init);

