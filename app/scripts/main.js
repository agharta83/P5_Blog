(function ($) {
    'use strict';

    // Sticky Menu
    $(window).scroll(function () {
        if ($('.navigation').offset().top > 100) {
            $('.navigation').addClass('nav-bg');
        } else {
            $('.navigation').removeClass('nav-bg');
        }
    });
  
    // Background-images
    $('[data-background]').each(function () {
        $(this).css({
            'background-image': 'url(' + $(this).data('background') + ')'
        });
    });
  
    // background color
    $('[data-color]').each(function () {
        $(this).css({
            'background-color': $(this).data('color')
        });
    });
  
    // testimonial-slider
    $('.testimonial-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        arrows: false,
        adaptiveHeight: true
    });
  
    // Shuffle js filter and masonry
    var Shuffle = window.Shuffle;
    var jQuery = window.jQuery;
  
    var myShuffle = new Shuffle(document.querySelector('.shuffle-wrapper'), {
        itemSelector: '.shuffle-item',
        buffer: 1
    });
  
    jQuery('input[name="shuffle-filter"]').on('change', function (evt) {
        var input = evt.currentTarget;
        if (input.checked) {
            myShuffle.filter(input.value);
        }
    });

    // Sticky elements (pinning)
    var controller = new ScrollMagic.Controller();

    var pins_elem = $('.pin-elem');

    $.each(pins_elem, function (indexInArray, valueOfElement) { 
        new ScrollMagic.Scene({
            offset: 100
        })
        .setPin(this)
        .addIndicators({name: '2 (duration: 0'})
        .addTo(controller);
    });

    

  
  
  
  })(jQuery);