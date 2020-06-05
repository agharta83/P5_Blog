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
    if (window.location.pathname == '/opc/P5_Blog/') {
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
    }
    

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

    // Admin home counter func
    function count($this) {
        var current = parseInt($this.html(), 10);
        current = current +1;
        $this.html(++current);

        if (current > $this.data('count')) {
            $this.html($this.data('count'));
        } else {
            setTimeout(function() {
                count($this)
            }, 50);
        }
    };

    if (window.location.pathname == '/opc/P5_Blog/dashboard') {
        $(".stat-count").each(function() {
            $(this).data('count', parseInt($(this).html(), 10));
            $(this).html('0');
            count($(this));
        });
    };

     // Animate input search length
    if (window.location.pathname == '/opc/P5_Blog/dashboard/posts') {
        var searchInput = $(".search-box input");
	    var inputGroup = $(".search-box .input-group");
        var boxWidth = inputGroup.width();
    
        console.log(searchInput);
	    searchInput.focus(function(){
		    inputGroup.animate({
			    width: "300"
		    });
	    }).blur(function(){
		    inputGroup.animate({
			    width: boxWidth
		    });
	    });
    };

    if (window.location.pathname == '/opc/P5_Blog/dashboard/posts/new') {
        tinymce.init({
            selector: '#new_post_form_chapo',
            height: '300',
            plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });

        tinymce.init({
            selector: '#new_post_form_content',
            height: '500',
            plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });

        // Read url IMG on form input and preview img
        $('input[type="file"]').change(function(e) {
          
            var preview = document.querySelector('.wrapper-preview');
            preview.innerHTML = '';
            var file = document.querySelector('input[type=file]').files[0];

            if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
                var reader = new FileReader();
          
                reader.addEventListener("load", function () {
                  var image = new Image();
                  image.width = 400;
                  image.title = file.name;
                  image.src = this.result;
                  preview.appendChild( image );
                }, false);
          
                reader.readAsDataURL(file);
            }

            var label = document.querySelector('.custom-file-label');
            label.innerText = file.name;

        });

    };

   
	
    

  //someFunction();
});
