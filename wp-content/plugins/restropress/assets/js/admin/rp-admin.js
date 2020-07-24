jQuery(function( $ ) {

  //show the toast message
  function rpress_toast(heading, message, type){
    $.toast({
      heading : heading,
      text    : message,
      showHideTransition: 'slide',
      icon    : type,
      position: { top: '36px', right: '0px' },
      stack   : false
    });
  }

  $( document ).on( 'click', '.rp-service-time span', function(e) {
   $(this).parents('.rp-service-time').find('input').trigger('click');
    e.preventDefault();
    $( '.service_available_hrs' ).timepicker({
      dropdown: true,
      scrollbar: true,
    });
  });
  
  $( 'select.addon-items-list' ).chosen();

  $( 'select.addon-items-list' ).on('change', function(event, params) {
    if( event.type == 'change' ) {
      $( '.rpress-order-payment-recalc-totals' ).show();
    }
  });

  $( 'input.rpress_timings' ).timepicker({
    dropdown: true,
    scrollbar: true,
  });

  //Validate License
  $('body').on('click', '.rpress-validate-license', function(e) {
    e.preventDefault();
    var _self = $(this);

    $( '.rpress-license-wrapper' ).find( '.rpress-license-field' ).removeClass( 'empty-license-key' );

    var ButtonText    = _self.text();
    var Selected      = _self.parent('.rpress-license-wrapper').find('.rpress-license-field')
    var ItemId        = Selected.attr('data-item-id');
    var ProductName   = Selected.attr('data-item-name');
    var License       = Selected.val();
    var LicenseString = _self.parent('.rpress-license-wrapper').find('.rpress_license_string').val();
    var action        = _self.attr('data-action');
    
    if( License.length ) {
      _self.addClass('disabled');
      _self.text( rpress_vars.please_wait );

      data = {
        action       : action,
        item_id      : ItemId,
        product_name : ProductName,
        license      : License,
        license_key  : LicenseString,
      };

      $.ajax({
        type      : "POST",
        data      : data,
        dataType  : "json",
        url       : rpress_vars.ajaxurl,
        xhrFields : {
          withCredentials: true
        },
        success: function (response) {
          if( response.status !== 'error' ){
            rpress_toast(rpress_vars.success, rpress_vars.license_success, 'success');
            _self.parent( '.rpress-license-wrapper' ).addClass('rpress-updated');
            _self.parents( '.rpress-purchased-wrap' ).find('.rpress-license-deactivate-wrapper').removeClass('hide').addClass('show');
          }
          else {
            rpress_toast(rpress_vars.error, response.message, 'error');
          }
          _self.text(rpress_vars.license_activate);
          _self.removeClass('disabled');
        }
      })
    }
    else {
      $( this ).parents( '.rpress-license-wrapper' ).find( '.rpress-license-field' ).addClass( 'empty-license-key' );
      rpress_toast(rpress_vars.error, rpress_vars.empty_license, 'error');
    }
  });

  //Deactivate License
  $('body').on('click', '.rpress-deactivate-license', function(e) {
    e.preventDefault();
    var _self         = $(this);
    var action        = $(this).attr('data-action');
    var Licensestring = $(this).parents('.rpress-purchased-wrap').find('.rpress_license_string').val();
    var ProductName   = $(this).parents('.rpress-purchased-wrap').find('.rpress-license-field').attr('data-item-name');

    _self.addClass('disabled');
    _self.text(rpress_vars.please_wait);

    if( Licensestring.length ) {
      data = {
        action       : action,
        product_name : ProductName,
        license_key  : Licensestring,
      };

      $.ajax({
        type      : "POST",
        data      : data,
        dataType  : "json",
        url       : rpress_vars.ajaxurl,
        xhrFields : {
          withCredentials: true
        },
        success: function (response) {
          rpress_toast(rpress_vars.information, rpress_vars.license_deactivated, 'info');
          if( response.status !== 'error' ){
            _self.parents('.rpress-purchased-wrap').find('.rpress-license-wrapper').removeClass('rpress-updated');
            _self.parents('.rpress-purchased-wrap').find('.rpress-license-deactivate-wrapper').removeClass('show').addClass('hide');
          }
          _self.text(rpress_vars.deactivate_license);
          _self.removeClass('disabled');
        }
      })
    }
  });

});