
'use strict';
jQuery.noConflict();


    jQuery(document).ready(function ($) {
        /* ==========================================================================
         #Post-meta class media manager trigger  http://bit.ly/2g83CQ7
         ========================================================================== */
        jQuery('.page_upload_trigger_element').on('click', function (e) {
            var _custom_media = true;
            var _orig_send_attachment = wp.media.editor.send.attachment;
            // var send_attachment_bkp = wp.media.editor.send.attachment;
  
            var button = jQuery(this);
            var id = button.attr('id').replace('_extra', '');
            _custom_media = true;
            wp.media.editor.send.attachment = function (props, attachment) {
                if (_custom_media) {

                    jQuery("#media_id" ).val(attachment.id);
                    
                    // $('.custom_media_url').val(attachment.url);
                    // $('.custom_media_id').val(attachment.id);
                    var filename = attachment.url;
                    var file_extension = filename.split('.').pop();//find extension
                    if (file_extension == "jpg" || file_extension == "jpeg" || file_extension == "png" || file_extension == "gif"  || file_extension == "webp") {
                        jQuery('.background_attachment_metabox_container').html('<div class="images-containerBG"><div class="single-imageBG"><span class="delete">X</span>  <img data-targetid="wow_pageSetting_backgroundImage" class="img-fluid" src="' + attachment.url + '"></div></div>');
                    } else {
                        jQuery('.background_attachment_metabox_container').html('<div class="images-containerBG">' +
                            '<div  class="single-imageBG"><span data-targetid="wow_pageSetting_backgroundImage"  class="delete_media">X</span> ' +
                            '<span style="font-size: 46px" class="info dashicons dashicons-admin-media"></span> </div></div>');
                    }
                    /* important notes jQuery("#" + id + '_li .background_attachment_metabox_container').html('<div class="images-containerBG">' +
                     '<div class="single-imageBG_"><span class="info">'+attachment.url+'</span></div></div>');*/

                } else {
                    return _orig_send_attachment.apply(this, [props, attachment]);
                }
            };
            wp.media.editor.open(button);
            return false;
        });


     /* ==========================================================================
     #Delete image element
     ========================================================================== */
     jQuery(document).on("click touchstart", ".background_attachment_metabox_container .single-imageBG span.delete", function () {
        //   var imageurl = jQuery(this).parent().find('img').attr('src');
        var target_id = jQuery(this).parent().find('img').attr('data-targetID');
        jQuery('#' + target_id).val("");
        jQuery(this).parent().hide(400);
     });



 
        /* ==========================================================================
         #Upload wp manager (Upload Image) metabox  media gallery click  trigger
         ========================================================================== */
         /*
        // when click on the upload button
        jQuery('.STNCupload_button').on('click', function (e) {
            // json field
            var field = jQuery(this).parent().find('.media_field_content');
            // gallery container
            // var galleryWrapper = jQuery(this).parent().find('.images-container');
            var galleryWrapper = jQuery(this).parent().prev('.images-container');
            e.preventDefault();
            // open the frame
            if (st_studio_uploader) {
                st_studio_uploader.open();
                return;
            }
            // create the media frame
            st_studio_uploader = wp.media.frames.st_studio_uploader = wp.media({
                className: 'media-frame dsf-media-manager',
                multiple: true,
                title: 'Select Images',
                button: {
                    text: 'Select'
                }
            });
            st_studio_uploader.on('select', function () {
                var selection = st_studio_uploader.state().get('selection');
                selection.map(function (attachment) {

                    attachment = attachment.toJSON();

                    // insert the images to the custom gallery interface
                    galleryWrapper.html(galleryWrapper.html() + '<div class="single-image"><span class="delete">X</span><img src="' + attachment.url + '" data-id="' + attachment.id + '" alt="' + attachment.id + '" /></div>');
                    // insert images to the hidden feild
                    if (field.val() != '') {
                        field.val(field.val() + ',' + attachment.id);
                    } else {
                        field.val(attachment.id);
                    }
                });
            });
            // Now that everything has been set, let's open up the frame.
            st_studio_uploader.open();
        });
        */
/**
 
    <input id="image-url" type="text" name="image" />
  <input id="upload-button" type="button" class="button" value="Upload Image" />
 */
/*
  var wkMedia;
  $('#upload-button').click(function(e) {
    e.preventDefault();
    // If the upload object has already been created, reopen the dialog
      if (wkMedia) {
      wkMedia.open();
      return;
    }
    // Extend the wp.media object
    wkMedia = wp.media.frames.file_frame = wp.media({
      title: 'Select media',
      button: {
      text: 'Select media'
    }, multiple: false });

    // When a file is selected, grab the URL and set it as the text field's value
    wkMedia.on('select', function() {
      var attachment = wkMedia.state().get('selection').first().toJSON();
      $('#wk-media-url').val(attachment.url);
    });
    // Open the upload dialog
    wkMedia.open();
  });
*/


    /* ==========================================================================
     #Delete mp4/mp3 element
     ========================================================================== */
    jQuery(document).on("click touchstart", ".background_attachment_metabox_container .single-imageBG span.delete_media", function () {
        var target_id = jQuery(this).attr('data-targetID');
        jQuery('#' + target_id).val("");
        jQuery(this).parent().hide(400);
    });

    /* ==========================================================================
     #Delete Gallery manager (metabox gallery) metabox  media gallery views trigger
     ========================================================================== */
   /* jQuery('.images-container').each(function () {
        var wrapper = jQuery(this);


        // delete image from gallery
        wrapper.find('.single-image span.delete').on('click', function () {
            var confirmed = confirm('Are you sure?');
            if (confirmed) {
                // image url
                var imageurl = jQuery(this).parent().find('img').attr('data-id');
                wrapper.parent().find('.media_field_content').val(function (index, value) {
                    return value.replace(imageurl + ',', '').replace(imageurl, '');
                });
                jQuery(this).parent().hide(400);
            }
        });
    });
*/
 });
