'use strict';
/*wordspress color picker init
 http://code.tutsplus.com/articles/how-to-use-wordpress-color-picker-api--wp-33067
 thx--- https://core.trac.wordpress.org/attachment/ticket/25809/color-picker-widget.php
 */
/** ==========================================================================
 #JQUERY+WP color Picker init
 **========================================================================== **/
(function ($) {

    // Add Color Picker to all inputs that have 'color-field' class
    function ColorPicker_construct(widget) {
        widget.find('.ch-color-picker').wpColorPicker(/*{
         change: _.throttle(function() { // For Customizer
         $(this).trigger('change');
         }, 3000)
         }*/);
    };


}(jQuery));



