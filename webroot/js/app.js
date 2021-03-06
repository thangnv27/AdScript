var viewport_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
var viewport_height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
wow = new WOW({mobile: false});
wow.init();
function displayBarNotification(n, c, m) {
    var nNote = jQuery("#nNote");
    if (n) {
        nNote.attr('class', '').addClass("nNote " + c).fadeIn().html(m);
        setTimeout(function () {
            nNote.attr('class', '').hide("slow").html("");
        }, 10000);
    } else {
        nNote.attr('class', '').hide("slow").html("");
    }
}
function displayAjaxLoading(n) {
    n ? jQuery(".ajax-loading-block-window").show() : jQuery(".ajax-loading-block-window").hide("slow");
}
function getChromeVersion() {
    var raw = navigator.userAgent.match(/Chrom(e|ium)\/([0-9]+)\./);
    return raw ? parseInt(raw[2], 10) : false;
}
function getFirefoxVersion() {
    var raw = navigator.userAgent.match(/Firefox\/([0-9]+)/);
    return raw ? parseInt(raw[1], 10) : false;
}
function ReplaceAll(Source, stringToFind, stringToReplace) {
    var temp = Source;
    var index = temp.indexOf(stringToFind);
    while (index !== -1) {
        temp = temp.replace(stringToFind, stringToReplace);
        index = temp.indexOf(stringToFind);
    }
    return temp;
}
function openDialogLogin(){
    if(jQuery("#loginModal").is(":hidden")){
        jQuery("#loginModal").modal('toggle');
    }
}
function refeshAuthLogedIn(){
    jQuery.ajax({
        url: siteUrl + "/users/refesh_auth_loged_in", type: "POST", dataType: "json", cache: false, 
        success: function (response, textStatus, XMLHttpRequest) {
            if (response) {
                if(response.status === 'success'){
                    is_auth = true;
                    var usd = response.wallets.usd, vnd = response.wallets.vnd;
                    usd = numeral(usd).format('0,0.00');
                    vnd = numeral(vnd).format('0,0.00');
                    jQuery(".content-header .menu .wallet-usd .blance").text(usd);
                    jQuery(".content-header .menu .wallet-vnd .blance").text(vnd);
//                    console.log(response.msg);
                } else {
                    is_auth = false;
                }
            } else {
                is_auth = false;
            }
        },
        error: function (MLHttpRequest, textStatus, errorThrown) {
            is_auth = false;
            console.log(errorThrown);
        }
    });
}
setInterval("refeshAuthLogedIn()", 5 * 1000); // refresh in 5 seconds
jQuery(document).ready(function ($) {
    jQuery("#nNote").click(function () {
        jQuery(this).attr('class', '').hide("slow").html("");
    });
    
    jQuery(window).bind('load resize', function(){
        if(jQuery(window).height() > jQuery('body').height()){
            jQuery("#footer").css({
                position: 'absolute',
                bottom: 0,
                left: 0,
                width: '100%'
            });
        }
    });

    // Back to top
    jQuery("#back-top").click(function () {
        jQuery("html, body").animate({scrollTop: 0}, "slow");
    });

    jQuery(document).mouseup(function (e) {
        if (viewport_width < 992) {
            var container = jQuery(".st-container");
            if (container.find('.mobile-header').hasClass('mobile-clicked')) {
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    jQuery('button.left-menu').trigger('click');
                }
            }
        }
    });

    // Expand/Collapse mobile menu
    jQuery(".st-menu .nav li.menu-item-has-children > ul.sub-menu").hide();
    jQuery(".st-menu .nav li.menu-item-has-children.current-menu-item > ul.sub-menu").show();
    jQuery(".st-menu .nav li.menu-item-has-children.current-menu-parent > ul.sub-menu").show();
    jQuery(".st-menu .nav > li.menu-item-has-children").addClass('dropdown');
    jQuery(".st-menu .nav > li.menu-item-has-children.current-menu-item").removeClass('dropdown');
    jQuery(".st-menu .nav > li.menu-item-has-children.current-menu-parent").removeClass('dropdown');
    jQuery(".st-menu .nav > li.menu-item-has-children > a").after('<span class="arrow"></span>');
    jQuery(".st-menu .nav > li.menu-item-has-children").find('span.arrow').click(function () {
        if (!jQuery(this).parent().hasClass('dropdown')) {
            jQuery(this).parent().addClass('dropdown');
            jQuery(this).next().slideUp();
        } else {
            jQuery(this).parent().removeClass('dropdown');
            jQuery(this).next().slideDown();
        }
    });
    
    // Menu mobile
    jQuery('button.left-menu').click(function () {
        var effect = jQuery(this).attr('data-effect');
        if (jQuery(this).parent().parent().hasClass('mobile-clicked')) {
            jQuery('.st-menu').animate({
                width: 0
            }).css({
                display: 'none',
                transform: 'translate(0px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery(this).parent().parent().addClass('mobile-unclicked').removeClass('mobile-clicked').css({
                transform: 'translate(0px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery(this).parent().parent().parent().removeClass('st-menu-open ' + effect);
            jQuery("#ppo-overlay").hide();
        } else {
            jQuery(this).parent().parent().parent().addClass('st-menu-open ' + effect);
            jQuery('.st-menu').animate({
                width: 270
            }).css({
                display: 'block',
                transform: 'translate(270px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery(this).parent().parent().addClass('mobile-clicked').removeClass('mobile-unclicked').css({
                transform: 'translate(270px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery("#ppo-overlay").show();
        }
    });
    jQuery("#ppo-overlay").click(function (){
        if (jQuery(".st-container").find('.mobile-header').hasClass('mobile-clicked')) {
            jQuery('button.left-menu').trigger('click');
        }
    });
    if ("ontouchstart" in document.documentElement) {
        var element = document.querySelector('#ppo-overlay');
        var element2 = document.querySelector('.st-menu');
        var hammertime = Hammer(element).on("swipeleft", function (event) {
            jQuery("#ppo-overlay").trigger('click');
        });
        var hammertime2 = Hammer(element2).on("swipeleft", function (event) {
            jQuery("#ppo-overlay").trigger('click');
        });
    }
    jQuery(window).bind('resize', function(){
        jQuery("#ppo-overlay").trigger('click');
    });

    // Set default Alt Text for images
    jQuery("img").each(function(){
        var img_src = this.src;
        if(img_src && img_src.length > 0){
            var img_alt = jQuery(this).attr('alt');
            var img_name = img_src.split('/').pop().replace(/\"|\'|\)/g, '');
            img_name = img_name.substring(0, img_name.lastIndexOf('.'));
            
            // For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
            if (typeof img_alt !== typeof undefined && img_alt !== false) {
                if(img_alt.length === 0){
                    jQuery(this).attr('alt', img_name);
                }
            } else {
                jQuery(this).attr('alt', img_name);
            }
        }
    });
    
    // Dang ky thanh vien
    jQuery("#signup_form").submit(function (){
        var _form = this;
        var _action = jQuery(this).attr('action');
        if(!jQuery("#chkAccept").is(":checked")){
            jQuery("#signup_result").html('<p>Bạn cần phải đọc và đồng ý với điều khoản sử dụng tại AdScript!</p>');
        } else {
            jQuery("#signup_result").html('<p>Đang gửi...</p>');
            jQuery("#btnSignup").attr('disabled', 'disabled');
            jQuery.ajax({
                url: _action, type: "POST", dataType: "json", cache: false,
                data: jQuery(_form).serialize(),
                success: function(response, textStatus, XMLHttpRequest) {
                    if (response && response.status === 'success') {
                        jQuery("#signup_result").css({
                            color: 'green'
                        });
                        _form.reset();
                    } else if (response && response.status === 'error') {
                        jQuery("#signup_result").css({
                            color: 'red'
                        });
                    }
                    if(jQuery("#signupModal").is(":hidden")){
                        jQuery("#signupModal").modal('toggle');
                    }
                    jQuery("#signup_result").html(response.message);
                },
                error: function(MLHttpRequest, textStatus, errorThrown) {
                    jQuery("#signup_result").html(errorThrown);
                },
                complete: function() {
                    jQuery("#btnSignup").removeAttr('disabled');
                }
            });
        }
        return false;
    });
    
    // Dang nhap
    jQuery("#login_form").submit(function (){
        var _form = this;
        var _action = jQuery(this).attr('action');
        jQuery("#login_result").html('<p>Đang gửi...</p>');
        jQuery("#btnLogin").attr('disabled', 'disabled');
        jQuery.ajax({
            url: _action, type: "POST", dataType: "json", cache: false,
            data: jQuery(_form).serialize(),
            success: function(response, textStatus, XMLHttpRequest) {
                if (response && response.status === 'success') {
                    _form.reset();
                    if(jQuery("#loginModal").length > 0) {
                        jQuery("#loginModal").modal('hide');
                    } else if(response.redirect_url.length > 0){
                        window.location = response.redirect_url;
                    } else {
                        window.location = siteUrl;
                    }
                } else if (response && response.status === 'error') {
                    jQuery("#login_result").html(response.message);
                }
            },
            error: function(MLHttpRequest, textStatus, errorThrown) {
                jQuery("#login_result").html(errorThrown);
            },
            complete: function() {
                jQuery("#btnLogin").removeAttr('disabled');
            }
        });
        return false;
    });
    
    // Tao quang cao
    jQuery("#frmAddAds").submit(function(){
        if(is_auth){
            var _form = this;
            var _action = jQuery(this).attr('action');
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-top-center";
            jQuery("#frmAddAds .btn-submit").attr('disabled', 'disabled').button('loading');
            jQuery.ajax({
                url: _action, type: "POST", dataType: "json", cache: false,
                data: jQuery(_form).serialize(),
                success: function(response, textStatus, XMLHttpRequest){
                    if(response && response.status === 'success'){
                        toastr.success(response.message, '', {timeOut: 5000});
                        _form.reset();
                        setTimeout(function(){
                            window.location = response.redirect_url;
                        }, 3000);
                    }else if(response.status === 'error'){
                        toastr.error(response.message, '', {timeOut: 5000});
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    toastr.error(errorThrown, '', {timeOut: 5000});
                },
                complete:function(){
                    jQuery("#frmAddAds .btn-submit").removeAttr('disabled').button('reset');
                }
            });
        } else {
            openDialogLogin();
        }
        return false;
    });
    
    // Chinh sua quang cao
    jQuery("#frmEditAds").submit(function(){
        if(is_auth){
            var _form = this;
            var _action = jQuery(this).attr('action');
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-top-center";
            jQuery("#frmEditAds .btn-submit").attr('disabled', 'disabled').button('loading');
            jQuery.ajax({
                url: _action, type: "POST", dataType: "json", cache: false,
                data: jQuery(_form).serialize(),
                success: function(response, textStatus, XMLHttpRequest){
                    if(response && response.status === 'success'){
                        toastr.success(response.message, '', {timeOut: 5000});
                        _form.reset();
                        setTimeout(function(){
                            window.location = response.redirect_url;
                        }, 3000);
                    }else if(response.status === 'error'){
                        toastr.error(response.message, '', {timeOut: 5000});
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    toastr.error(errorThrown, '', {timeOut: 5000});
                },
                complete:function(){
                    jQuery("#frmEditAds .btn-submit").removeAttr('disabled').button('reset');
                }
            });
        } else {
            openDialogLogin();
        }
        return false;
    });
    
    // Activate Ads
    jQuery(".tbl-ads-list .actions .btn-active").click(function(){
        if(is_auth){
            var ad_id = jQuery(this).parent().data('id');
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-top-right";
            jQuery.ajax({
                url: siteUrl + "/ads/activate/" + ad_id, type: "POST", dataType: "json", cache: false,
                success: function(response, textStatus, XMLHttpRequest){
                    if(response && response.status === 'success'){
                        toastr.success(response.message, '', {timeOut: 5000});
                        jQuery(".tbl-ads-list #ad_" + ad_id).find('.btn-active').addClass('hide');
                        jQuery(".tbl-ads-list #ad_" + ad_id).find('.btn-inactive').removeClass('hide');
                    }else if(response.status === 'error'){
                        toastr.error(response.message, '', {timeOut: 5000});
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    toastr.error(errorThrown, '', {timeOut: 5000});
                }
            });
        } else {
            openDialogLogin();
        }
    });
    
    // Pause Ads
    jQuery(".tbl-ads-list .actions .btn-inactive").click(function(){
        if(is_auth){
            var ad_id = jQuery(this).parent().data('id');
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-top-right";
            jQuery.ajax({
                url: siteUrl + "/ads/deactivate/" + ad_id, type: "POST", dataType: "json", cache: false,
                success: function(response, textStatus, XMLHttpRequest){
                    if(response && response.status === 'success'){
                        toastr.success(response.message, '', {timeOut: 5000});
                        jQuery(".tbl-ads-list #ad_" + ad_id).find('.btn-active').removeClass('hide');
                        jQuery(".tbl-ads-list #ad_" + ad_id).find('.btn-inactive').addClass('hide');
                    }else if(response.status === 'error'){
                        toastr.error(response.message, '', {timeOut: 5000});
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    toastr.error(errorThrown, '', {timeOut: 5000});
                }
            });
        } else {
            openDialogLogin();
        }
    });
    
    // Delete Ads
    jQuery(".tbl-ads-list .actions .btn-del").click(function(){
        if(is_auth){
            if(confirm('Are you sure?')){
                var ad_id = jQuery(this).parent().data('id');
                toastr.options.closeButton = true;
                toastr.options.positionClass = "toast-top-right";
                jQuery.ajax({
                    url: siteUrl + "/ads/delete/" + ad_id, type: "POST", dataType: "json", cache: false,
                    success: function(response, textStatus, XMLHttpRequest){
                        if(response && response.status === 'success'){
                            toastr.success(response.message, '', {timeOut: 5000});
                            jQuery(".tbl-ads-list #ad_" + ad_id).remove();
                        }else if(response.status === 'error'){
                            toastr.error(response.message, '', {timeOut: 5000});
                        }
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown){
                        toastr.error(errorThrown, '', {timeOut: 5000});
                    }
                });
            }
        } else {
            openDialogLogin();
        }
    });
    
    // Chinh sua ho so
    jQuery("#frmEditProfile").submit(function(){
        if(is_auth){
            var _form = this;
            var _action = jQuery(this).attr('action');
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-top-center";
            jQuery("#frmEditProfile .btn-save").attr('disabled', 'disabled').button('loading');
            jQuery.ajax({
                url: _action, type: "POST", dataType: "json", cache: false,
                data: jQuery(_form).serialize(),
                success: function(response, textStatus, XMLHttpRequest){
                    if(response && response.status === 'success'){
                        toastr.success(response.message, '', {timeOut: 5000});
                    }else if(response.status === 'error'){
                        toastr.error(response.message, '', {timeOut: 5000});
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    toastr.error(errorThrown, '', {timeOut: 5000});
                },
                complete:function(){
                    jQuery("#frmEditProfile .btn-save").removeAttr('disabled').button('reset');
                }
            });
        } else {
            openDialogLogin();
        }
        return false;
    });
    
    // Thay doi mat khau
    jQuery("#frmChangePassword").submit(function(){
        if(is_auth){
            var _form = this;
            var _action = jQuery(this).attr('action');
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-top-center";
            jQuery("#frmChangePassword .btn-save").attr('disabled', 'disabled').button('loading');
            jQuery.ajax({
                url: _action, type: "POST", dataType: "json", cache: false,
                data: jQuery(_form).serialize(),
                success: function(response, textStatus, XMLHttpRequest){
                    if(response && response.status === 'success'){
                        toastr.success(response.message, '', {timeOut: 5000});
                    }else if(response.status === 'error'){
                        toastr.error(response.message, '', {timeOut: 5000});
                    }
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    toastr.error(errorThrown, '', {timeOut: 5000});
                },
                complete:function(){
                    jQuery("#frmChangePassword .btn-save").removeAttr('disabled').button('reset');
                }
            });
        } else {
            openDialogLogin();
        }
        return false;
    });

});