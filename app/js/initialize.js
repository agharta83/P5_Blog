import someFunction from './someFile';
import Shuffle from 'shufflejs';
import ScrollMagic from 'scrollmagic';

document.addEventListener('DOMContentLoaded', () => {
  console.log('initialized');

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

// Shuffle js filter and masonry

var myShuffle = new Shuffle(document.querySelector('.shuffle-wrapper'), {
    itemSelector: '.shuffle-item',
    buffer: 1
});

$('input[name="shuffle-filter"]').on('change', function (evt) {
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
    .addTo(controller);
});


  //someFunction();
});
