// plugin: Timmer: http://plugins.jquery.com/project/jtimer
var currentPosition = 0;
var myTimerID = 0;

var slideWidth = 625;//560;
var slideContainer = 'slidesContainer';
var slideInner = 'slideInner';
var slides = '';
var numberOfSlides = 1;

var captionWidth = 275;
var captionContainer = 'captionContainer';
var captionInner = 'captionInner';
var captions = '';

var numberOfcaptions = 1;

function playMySlides() {
    // alert('This message was sent by a timer.');
    //console.log('Move');
    currentPosition += 1;
    if (currentPosition >= numberOfSlides ){
        currentPosition = 0;
    } else if(currentPosition < 0 ){
        currentPosition = numberOfSlides-1;
    }
    // Move slideInner using margin-left
    $('#'+slideInner).animate({
      'marginLeft' : slideWidth*(-currentPosition)
    });
    // Move captionInner
    $('#'+captionInner).animate({
      'marginLeft' : captionWidth*(-currentPosition)
    });
}
$(document).ready(function() {
    // timmer
    //var myTimerID = $.timer();

    // pics:
    slideContainer = 'slidesContainer';
    slideInner = 'slideInner';
    slides = $('#'+slideContainer+' .slide');
    numberOfSlides = slides.length;
    
    // Remove scrollbar in JS
    $('#'+slideContainer).css('overflow', 'hidden');

    // Wrap all .slides with #slideInner div
    slides
        .wrapAll('<div id="'+slideInner+'"></div>')
        // Float left to display horizontally, readjust .slides width
        .css({
          'float' : 'left',
          'width' : slideWidth
    });
    // Set #slideInner width equal to total width of all slides
    $('#'+slideInner).css('width', slideWidth * numberOfSlides);
    // captions : 
    captionContainer = 'captionContainer';
    captionInner = 'captionInner';
    
    captions = $('#'+captionContainer+' .caption');
    numberOfcaptions = captions.length;
    
    // Remove scrollbar in JS
    $('#'+captionContainer).css('overflow', 'hidden');
    // create some filler space
    //$('#'+captionContainer).prepend('<div id="captionFiller"></div>')
   
    // Wrap all .captions with #captionInner div
    captions
        .wrapAll('<div id="'+captionInner+'"></div>')
        // Float left to display horizontally, readjust .captions width
        .css({
          'float' : 'left',
          'width' : (captionWidth-35)
    });
    // Set #captionInner width equal to total width of all captions
    $('#'+captionInner).css('width', captionWidth * numberOfcaptions);
    
    // create the timer info
    
    /*myTimer.set({
        action : ,
        time : 3500
    }).play();
    */
    
  // BUTTONS/Controls

  // Insert controls in the DOM
  $('#slideShow')
    .prepend('<span class="control" id="leftControl">Clicking moves left</span>')
    .append('<span class="control" id="rightControl">Clicking moves right</span>');

  // Hide left arrow control on first load
  //manageControls(currentPosition);

    myTimerID = setInterval("playMySlides()", 3500 );
    $('#slideShow').hover(
        function(){ 
            //myTimer.pause();
            clearInterval(myTimerID );
            myTimerID = 0;
            //console.log('clear');
        },
        function(){ 
            //myTimer.play();
           // console.log('run');
           if ( myTimerID == 0 ) {
               myTimerID = setInterval( "playMySlides()", 3500 );
           }
        }
    );
    jQuery(window).bind("focus", function(event) {
        if ( myTimerID == 0 ) {
           myTimerID = setInterval( "playMySlides()", 3500 );
        }
    }).bind("blur", function(event) {
        clearInterval(myTimerID );
        myTimerID = 0;
    });

    /* Test * /
    $('body').focus(
        function(){ 
            //myTimer.pause();
            clearInterval(myTimerID );
            myTimerID = 0;
            //console.log('clear');
        },
        function(){ 
            //myTimer.play();
           // console.log('run');
           if ( myTimerID == 0 ) {
               myTimerID = setInterval( "playMySlides()", 3500 );
           }
    });
    /* End test */
  // Create event listeners for .controls clicks
  $('.control')
    .bind('click', function(){
    // Determine new position
    currentPosition = ($(this).attr('id')=='rightControl') ? currentPosition+1 : currentPosition-1;
    
    if (currentPosition >= numberOfSlides ){
        currentPosition = 0;
    } else if(currentPosition < 0 ){
        currentPosition = numberOfSlides-1;
    }
    
    // Move slideInner using margin-left
    $('#'+slideInner).animate({
      'marginLeft' : slideWidth*(-currentPosition)
    });
    // Move captionInner
    $('#'+captionInner).animate({
      'marginLeft' : captionWidth*(-currentPosition)
    });
    //console.log("Caption W: " + (captionWidth*(-currentPosition)) );
  });
});
