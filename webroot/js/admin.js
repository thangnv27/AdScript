var browseFileURL = "";
var fileDialogWidth = $(window).width() - 50;
var fileDialogHeight = $(window).height() - 50;
var viewport_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
var viewport_height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
function scrollToElement(el){
    $('body,html').animate({
        scrollTop: $(el).offset().top - $(".menu-header.fixed").outerHeight(true)
    }, 800);
}
function openFileDialog(field) {
    if (tinymce.activeEditor !== null && tinymce.activeEditor.windowManager !== null) {
        var win = window;
        tinymce.activeEditor.windowManager.open({
            file: elfinderUrl, // use an absolute path!
            title: 'Media',
            width: fileDialogWidth,
            height: fileDialogHeight,
            resizable: 'yes',
            maximizable: true
        }, {
            setUrl: function (url) {
                win.document.getElementById(field).value = url;
            }
        });
        return false;
    } else {
        $.colorbox({
            iframe: true,
            fixed: true,
            href: elfinderUrl,
            width: fileDialogWidth,
            height: fileDialogHeight,
            closeButton: false,
            onClosed: function() {
                if(browseFileURL !== ""){
                    document.getElementById(field).value = browseFileURL;
                }
            }
        });
    }
}
function featuredImageFit(){
    $(".featured_image").imagefit({
        onStart: function (index, container, imagecontainer) {},
        onLoad: function (index, container, imagecontainer) {},
        onError: function (index, container, imagecontainer) {}
    });
}
function setFeaturedImage(){
    if (tinymce.activeEditor !== null && tinymce.activeEditor.windowManager !== null) {
        var win = window;
        tinymce.activeEditor.windowManager.open({
            file: elfinderUrl, // use an absolute path!
            title: 'Media',
            width: fileDialogWidth,
            height: fileDialogHeight,
            resizable: 'yes',
            maximizable: true
        }, {
            setUrl: function (url) {
                win.document.querySelector('#featured_image').value = url;
                win.document.querySelector('.featured_image').innerHTML = '<img src="' + url + '" />';
                win.document.querySelector('#addFeaturedImage').style = 'display:none';
                win.document.querySelector('#removeFeaturedImage').style = 'display:block';

                scrollToElement('.featured_image');

                setTimeout(function (){
                    featuredImageFit();
                }, 1000);
            }
        });
        return false;
    } else {
        $.colorbox({
            iframe: true,
            fixed: true,
            href: elfinderUrl,
            width: fileDialogWidth,
            height: fileDialogHeight,
            closeButton: false,
            onClosed: function() {
                if(browseFileURL !== ""){
                    document.querySelector('#featured_image').value = browseFileURL;
                    document.querySelector('.featured_image').innerHTML = '<img src="' + browseFileURL + '" />';
                    document.querySelector('#addFeaturedImage').style = 'display:none';
                    document.querySelector('#removeFeaturedImage').style = 'display:block';

                    scrollToElement('.featured_image');

                    setTimeout(function (){
                        featuredImageFit();
                    }, 1000);
                }
            }
        });
    }
}
function galleryImageFit(){
    $(".gallery li").imagefit({
        onStart: function (index, container, imagecontainer) {},
        onLoad: function (index, container, imagecontainer) {},
        onError: function (index, container, imagecontainer) {}
    });
}
function gallerySortable(){
    $(".gallery ul").sortable({
        connectWith: "gallery ul",
        placeholder: "ui-state-highlight",
        update: function( event, ui ){
            var urls = new Array();
            $(".gallery li img").each(function (){
                urls.push(this.src);
            });
            $('#gallery').val(urls);
        }
    }).disableSelection();
}
function removeGalleryItem(){
    $(".gallery").find(".remove").click(function (){
        $(this).parent().remove();
        var urls = new Array();
        $(".gallery li img").each(function (){
            urls.push(this.src);
        });
        $('#gallery').val(urls);
    });
}
function setGallery(){
    if (tinymce.activeEditor !== null && tinymce.activeEditor.windowManager !== null) {
        var win = window;
        tinymce.activeEditor.windowManager.open({
            file: elfinderUrl, // use an absolute path!
            title: 'Media',
            width: fileDialogWidth,
            height: fileDialogHeight,
            resizable: 'yes',
            maximizable: true
        }, {
            setUrl: function (urls) {
                var lis = "";
                for(i = 0; i < urls.length; i++){
                    lis += '<li><img src="' + urls[i] + '" /><span class="remove">X</span></li>';
                }
                win.document.querySelector('.gallery ul').innerHTML = lis;
                win.document.querySelector('#gallery').value = urls;

                scrollToElement('.gallery');

                setTimeout(function (){
                    galleryImageFit();
                    gallerySortable();
                    removeGalleryItem();
                }, 1000);
            }
        });
        return false;
    } else {
        $.colorbox({
            iframe: true,
            fixed: true,
            href: elfinderUrl,
            width: fileDialogWidth,
            height: fileDialogHeight,
            closeButton: false,
            onClosed: function() {
                if(browseFileURL){
                    var urls = browseFileURL, lis = "";
                    for(i = 0; i < urls.length; i++){
                        lis += '<li><img src="' + urls[i] + '" /><span class="remove">X</span></li>';
                    }
                    document.querySelector('.gallery ul').innerHTML = lis;
                    document.querySelector('#gallery').value = urls;

                    scrollToElement('.gallery');

                    setTimeout(function (){
                        galleryImageFit();
                        gallerySortable();
                        removeGalleryItem();
                    }, 1000);
                }
            }
        });
    }
}
function elFinderBrowser(field_name, url, type, win) {
    tinymce.activeEditor.windowManager.open({
        file: elfinderUrl, // use an absolute path!
        title: 'Media',
        width: fileDialogWidth,
        height: fileDialogHeight,
        resizable: 'yes',
        maximizable: true
    }, {
        setUrl: function (url) {
            win.document.getElementById(field_name).value = url;
        }
    });
    return false;
}
function tinyMCE(el){
    tinymce.init({
        file_browser_callback : elFinderBrowser,
        selector: el,
        height: 400,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save autosave table layer contextmenu directionality emoticons template paste textcolor'
        ],
        toolbar: 'insertfile undo redo | styleselect fontsizeselect | bold italic underline strikethrough | \
            alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code blockquote charmap | \
            link unlink image media | forecolor backcolor emoticons | fullscreen',
        fontsize_formats: "8px 9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 32px 36px 48px 60px 72px",
        content_css: [siteUrl + '/css/bootstrap.min.css', siteUrl + '/css/admin.editor.css']
    });
}
function checkLoggedIn(){
    if ($("#colorbox").is(':hidden')) {
        $.ajax({
            url: adminUrl + "/users/checkuserloggedin", type: "POST", dataType: "json", cache: false,
            data: {check: 1},
            success: function (response, textStatus, XMLHttpRequest) {
                if (response && response.status === 'error') {
                    $.colorbox({
                        iframe: true,
                        href: loginUrl,
                        width: 490,
                        height: 520,
                        closeButton: false,
                        overlayClose: false,
                        escKey: false,
                        onClosed: function () {}
                    });
                }
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
}
function clearPrice(str){
    return str.replace(/[,.\D]/g , "");
}
function parseToDate(str){
    if(str.length > 0){
        var date = str.split("/");
        return new Date(date[2], date[1] - 1, date[0]);
    }
    return null;
}
var PPOFixed = {
    mainMenu:function(){
        var msie6 = jQuery.browser == 'msie' && jQuery.browser.version < 7;
        if (!msie6) {
            var top = jQuery('.menu-header').offset().top - parseFloat(jQuery('.menu-header').css('margin-top').replace(/auto/, 0));
            jQuery(window).scroll(function(event){
                if (jQuery(this).scrollTop() >= top){
                    jQuery('.menu-header').addClass('fixed');
                } else {
                    jQuery('.menu-header').removeClass('fixed');
                }
            });
        }
    }
};
var AdminAjax = {
    addCategory: function (form){
        $(form).submit(function (){
            $(form).find('button[type=submit]').addClass('ajax-small').attr('disabled', 'disabled');
            $.ajax({
                url: $(form).find('input[name=_action]').val(), type: "POST", dataType: "json", cache: false,
                data: $(form).serialize(),
                success: function (response, textStatus, XMLHttpRequest) {
                    if(response){
                        if (response.status.length > 0 && response.message.length > 0) {
                            $(".flash-message").html('<div class="message ' + response.status + '" onclick="this.classList.add(\'hidden\')">' + response.message + '</div>');
                        }
                        if (response.status === 'success') {
                            form.reset();
                            $("#removeFeaturedImage").trigger('click');
                            if(response.body.length > 0){
                                $(".catalog-wrap table tbody").html(response.body);
                            }
                            if(response.options.length > 0){
                                $('select#parent').html(response.options);
                            }
                        }
                        $('body,html').animate({
                            scrollTop: 50
                        }, 800);
                    }
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                complete: function () {
                    $(form).find('button[type=submit]').removeClass('ajax-small').removeAttr('disabled');
                }
            });
            return false;
        });
    }
};
setInterval("checkLoggedIn()", 5 * 1000);
$(function () {
    PPOFixed.mainMenu();

    // Fit image
    if ($(".featured_image img").length > 0) {
        featuredImageFit();
    }
    if ($(".gallery li").length > 0) {
        galleryImageFit();
        gallerySortable();
        removeGalleryItem();
    }

    // Set gallery
    $("#setGallery").click(function () {
        setGallery();
        return false;
    });

    // Set featured image
    $(".featured_image, #addFeaturedImage").click(function () {
        setFeaturedImage();
        return false;
    });

    // Remove featured image
    $("#removeFeaturedImage").click(function (){
        document.querySelector('#featured_image').value = '';
        document.querySelector('.featured_image').innerHTML = '<div class="placeholder">IMAGE</div>';
        document.querySelector('#addFeaturedImage').style = 'display:block';
        document.querySelector('#removeFeaturedImage').style = 'display:none';
        return false;
    });

    // Add category
    if($("#category_form_add").length > 0){
        AdminAjax.addCategory(document.getElementById('category_form_add'));
    }

    // tinyMCE editor
    if($("#post_content").length > 0){
        tinyMCE("#post_content");
    }
    if($("#category_form_edit #description").length > 0){
        tinyMCE("#category_form_edit #description");
    }

    // Datetime picker
    if($("#fromDate").length > 0 && $("#toDate").length > 0){
        $('#fromDate input, #toDate input').focus(function (){
            $(this).prev().click();
        });
        $('#fromDate').datetimepicker({
            format: 'DD/MM/YYYY',
            maxDate: moment(),
            date: parseToDate($('#fromDate input').val()),
            defaultDate: parseToDate($('#fromDate input').val())
        });
        $('#toDate').datetimepicker({
            format: 'DD/MM/YYYY',
            maxDate: moment(),
            date: parseToDate($('#toDate input').val()),
            defaultDate: parseToDate($('#toDate input').val())
        });
    }
    if ($('#dob_datepicker').length > 0) {
        $('#dob_datepicker input').focus(function (){
            $(this).next().click();
        });
        $('#dob_datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            maxDate: moment(),
            date: parseToDate($('#dob_datepicker input').val()),
            defaultDate: parseToDate($('#dob_datepicker input').val())
        });
    }
    if ($('#cmnd_datepicker').length > 0) {
        $('#cmnd_datepicker input').focus(function (){
            $(this).next().click();
        });
        $('#cmnd_datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            maxDate: moment(),
            date: parseToDate($('#cmnd_datepicker input').val()),
            defaultDate: parseToDate($('#cmnd_datepicker input').val())
        });
    }

    // Tags
    if($("#tags_select2").length > 0){
        $("#tags_select2").select2({
            theme: 'bootstrap',
            tags: true,
            tokenSeparators: [',', '.', ';', ':', '/'],
            createSearchChoice: function (term, data) {
                if ($(data).filter(function () {
                    return this.text.localeCompare(term) === 0;
                }).length === 0) {
                    return {
                        id: term,
                        text: term
                    };
                }
            },
            multiple: true,
            minimumInputLength: 1,
            ajax: {
                cache: true,
                dataType: "json",
                data: function (params) {
                    // Query paramters will be ?q=[term]&page=[page]
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, page) {
                    page = page || 1;
                    return {
                        results: $.map(data.items, function (item) {
                            return {
                                text: item.name,
                                id: item.name
                            };
                        }),
                        pagination: {
                            more: (page * 20) < data.total_count
                        }
                    };
                }
            }
        });
    }

    // Dropdown multiple select checkbox
    function getSelectedValue(id) {
        return $("#" + id).find("dt a span.value").html();
    }
    $(".select-dropdown dt a").on('click', function () {
        $(".select-dropdown dd ul").slideToggle('fast');
        return false;
    });

    $(".select-dropdown dd ul li a").on('click', function () {
        $(".select-dropdown dd ul").hide();
    });

    $(document).bind('click', function (e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("select-dropdown"))
            $(".select-dropdown dd ul").hide();
    });

    /*$('.mutliSelect input[type="checkbox"]').on('click', function () {

        var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
            title = $(this).val() + ",";

        if ($(this).is(':checked')) {
            var html = '<span title="' + title + '">' + title + '</span>';
            $('.multiSel').append(html);
            $(".hida").hide();
        } else {
            $('span[title="' + title + '"]').remove();
            var ret = $(".hida");
            $('.select-dropdown dt a').append(ret);

        }
    });*/

    // Bulk Delete
    function checkUncheckAll(){
        var checked = true;
        $("#frmTable .chk").each(function (){
            if(!$(this).is(':checked')){
                checked = false;
            }
        });
        $("#btnCheckAll").prop('checked', checked);
    }
    $("#btnCheckAll").click(function (){
        if($(this).is(':checked')){
            $("#frmTable .chk").prop('checked', true);
        } else {
            $("#frmTable .chk").prop('checked', false);
        }
    });
    $("#frmTable .chk").click(function (){
        checkUncheckAll();
    });
    $("#btnDelete").click(function (){
        $("#frmTable").submit();
    });

    /**
     * Clear price number
     * Not allow: dots, comma and white space
     */
    if($("input#price, input#old_price").length > 0){
//        $("input#price, input#old_price").keyup(function (e){
//            if(e.keyCode === 32 || e.keyCode === 188 || e.keyCode === 190){
//                var val = $(this).val().trim();
//                $(this).val(clearPrice(val));
//            }
//        });
        $("input#price, input#old_price").blur(function (e){
            var val = $(this).val().trim();
            $(this).val(clearPrice(val));
        });
    }
});