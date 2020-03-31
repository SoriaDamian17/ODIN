/**
* Theme: Adminto Admin Template
* Author: Coderthemes
* Module/App: Main Js
*/


!function($) {
    "use strict";

    var Navbar = function() {};
    
    //navbar - topbar
    Navbar.prototype.init = function () {
     
      //toggle
      $('.navbar-toggle').on('click', function (event) {
        //$(this).toggleClass('open');
        //$('#navigation').slideToggle(400);
      });

      $('.navigation-menu>li').slice(-1).addClass('last-elements');

      $('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
        if ($(window).width() < 992) {
          e.preventDefault();
          $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
        }
      });

      $(".right-bar-toggle").click(function(){
        $(".right-bar").toggle();
        $('.wrapper').toggleClass('right-bar-enabled');
      });
    },
    //init
    $.Navbar = new Navbar, $.Navbar.Constructor = Navbar
}(window.jQuery),

//initializing
function($) {
    "use strict";
    $.Navbar.init()
}(window.jQuery);


// === following js will activate the menu in left side bar based on url ====
$(document).ready(function () {

     if ($(window).width() < 992) 
      {
       $('.topbar-left').attr('data-link','false');
      }else{
        $('.topbar-left').attr('data-link','true');
      }
    
    $(".navigation-menu a").each(function () {
        if (this.href == window.location.href) {
            $(this).parent().addClass("active"); // add active to li of the current link
            $(this).parent().parent().parent().addClass("active"); // add active class to an anchor
            $(this).parent().parent().parent().parent().parent().addClass("active"); // add active class to an anchor
        }
    });

       
   /**
   * Slide left instantiation and action.
   */
  var slideLeft = new Menu({
    wrapper: '#wrapper',
    type: 'slide-left',
    menuOpenerClass: '.c-button',
    maskId: '#c-mask'
  });

  var slideLeftBtn = document.querySelector('#c-button--slide-left');
  
  slideLeftBtn.addEventListener('click', function(e) {
    e.preventDefault;
    slideLeft.open();
  });

    $('div[data-link="true"],a[data-link="true"]').click(function(){
        var controller = $(this).data('controller');
        var token = $(this).data('token');
        var url = 'index.php?controller=' + controller + '&token=' + token;
        $(location).attr('href',url);
    });

});
