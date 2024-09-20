'use strict';
jQuery.noConflict();


// media manager holder  variables
var ss_system_uploader;
var _custom_media;

jQuery(function () {

    /* ==========================================================================
     #Post-meta class media manager trigger  http://bit.ly/2g83CQ7
     ========================================================================== */

    jQuery(document).on('click', '.page_upload_trigger_element', function(e) {
    
        var _custom_media = true;
        var _orig_send_attachment = wp.media.editor.send.attachment;
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = jQuery(this);
        // var id = button.attr('data-name').replace('_button', '');  //<a  data-index="1" data-name="speaker_video_button"    console.log(id)
        var id = button.attr('data-name');    
        
        var index = button.attr('data-index');
    
     
        // button.closest('.'+settings.cloneContainer).find("label[for='" + id + "']")
        _custom_media = true;
        wp.media.editor.send.attachment = function (props, attachment) {
            if (_custom_media) {

                jQuery("#" + id + '_input'+ index ).val(attachment.url);
              
                var filename = attachment.url;
                var file_extension = filename.split('.').pop();//find picture extension
                console.log("#" + id + '_list'+ index + ' .background_attachment_metabox_container')
                if (file_extension == "jpg" || file_extension == "jpeg" || file_extension == "png" || file_extension == "gif"  || file_extension == "webp") {
                
                    jQuery("#" + id + '_list'+ index + ' .background_attachment_metabox_container').html('<div class="images-containerBG"><div class="single-imageBG"><span class="delete">X</span>  <img data-targetid="speaker_video_input'+ index +'" class="attachment-100x100 wp-post-image" witdh="100" height="100" src="' + attachment.url + '"></div></div>');
                } else {
                    jQuery("#" + id + '_list'+ index + ' .background_attachment_metabox_container').html('<div class="images-containerBG">' +
                        '<div style="width: 53px; height: 53px;" class="single-imageBG"><span data-targetid="speaker_video_input'+ index +'"  class="delete_media">X</span> ' +
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
        var target_id = jQuery(this).parent().find('img').attr('data-targetid');
        jQuery('#' + target_id).val("");
        jQuery(this).parent().hide(400);
    });

    /* ==========================================================================
     #Delete mp4/mp3 element
     ========================================================================== */
    jQuery(document).on("click touchstart", ".background_attachment_metabox_container .single-imageBG span.delete_media", function () {
        var target_id = jQuery(this).attr('data-targetid');
        jQuery('#' + target_id).val("");
        jQuery(this).parent().hide(400);
    });



////
////
////
////
////
////
////
////
////
////
////
    /* ==========================================================================
     #Upload wp manager (Upload Image) metabox  media gallery click  trigger
     ========================================================================== */
    // when click on the upload button
    jQuery('.ss-stytem-upload-button').on('click', function (e) {
        // json field
        var field = jQuery(this).parent().find('.media_field_content');
        // gallery container
        // var galleryWrapper = jQuery(this).parent().find('.images-container');
        var galleryWrapper = jQuery(this).parent().prev('.images-container');
        e.preventDefault();
        // open the frame
        if (ss_system_uploader) {
            ss_system_uploader.open();
            return;
        }
        // create the media frame
        ss_system_uploader = wp.media.frames.ss_system_uploader = wp.media({
            className: 'media-frame dsf-media-manager',
            multiple: true,
            title: 'Select Images',
            button: {
                text: 'Select'
            }
        });
        ss_system_uploader.on('select', function () {
            var selection = ss_system_uploader.state().get('selection');
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
        ss_system_uploader.open();
    });

    /* ==========================================================================
     #Gallery manager (metabox gallery) metabox  media gallery views trigger
     ========================================================================== */
    jQuery('.images-container').each(function () {
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



});





