jQuery(function ($) {
    $(document).ready(function () {


        /*drop downs*/
        $('.header').after('<div class="overlay"></div>');
        $('select').after('<ul class="options_list"></ul>').each(function (j) {
            $(this).find('option').each(function (i) {
                $(this).closest('.select_wrap_item').attr('data-selectId', j).find('select').attr('data-selectId', j);
                if (i === 0) {
                    var curVal = $(this).html();
                    $(this).closest('div').find('.select_btn').html(curVal).attr('data-selectId', j);
                }
                var selVal = '<li>' + $(this).val() + '</li>';
                $(this).closest('div').css('position', 'relative').find('.options_list').attr('data-selectId', j).append(selVal);
            });
        });

        $(document).on('click', function (e) {
            var target = $(e.target),
                overlay = $('.overlay'),
                curSelectId = target.closest('.select_wrap_item').attr('data-selectId');
            console.log(target);
            console.log(curSelectId);
            $('.select_wrap_item, ul.options_list').removeClass('open');
            $('ul.options_list').fadeOut();
            if(target.is('.btn.select_btn')){ // click on btn
                console.log('btn');

                if(target.parent().hasClass('open')){
                    overlay.hide();

                }else{


                    overlay.show();
                    $('.options_list[data-selectId="' + curSelectId + '"]').fadeIn().closest('.select_wrap_item').addClass('open');
                }
            }else{
                if(target.is(".options_list li")){ // click on  options item
                    var selectedVal = target.html();
                    console.log(selectedVal);
                    $('.select_btn[data-selectId="' + curSelectId + '"]').html(selectedVal);
                    $('select[data-selectId="' + curSelectId + '"]').val(selectedVal);
                }
                overlay.hide();
            }
        });


        /*checkboxes*/
        $('.checkbox label').on('click',function () {
            $(this).toggleClass('active');
        });

        /*radio buttons*/
        $('.btn_radio .btn').on('click', function () {
            if(!$(this).hasClass('active')){
                $(this).parent().find('.btn').removeClass('active').find('input').removeAttr('checked');
            }
            $(this).addClass('active').find('input').attr('checked', 'checked');
        });

        /*file upload*/
       /* var fileInput = $('#upload'),
            files;
        $(document).on('.upload.btn', 'click', function () {
            $('#upload').click();
        });
        $(fileInput).on('change', function () {
            var filename = fileInput.val().replace(/C:\\fakepath\\/i, '');
            $('#uploaded_file').html(filename);
            files = this.files;
            console.log(files);
        });*/


        /*file upload (electrical test)*/
        var fileElectricalInput = $('#upload1'),files;
        $(document).on('.upload.btn.one', 'click', function () {
            $('#upload1').click();
        });
        $(fileElectricalInput).on('change', function () {
            var filename = fileElectricalInput.val().replace(/C:\\fakepath\\/i, '');
            $('#elect_uploaded_file').html(filename);
           
        });

        /*file upload (Emergency  test)*/
        var fileEmmerInput = $('#upload2'),files;
        $(document).on('.upload.btn.two', 'click', function () {
            $('#upload2').click();
        });
        $(fileEmmerInput).on('change', function () {
            var filename = fileEmmerInput.val().replace(/C:\\fakepath\\/i, '');
            $('#emerg_uploaded_file').html(filename);
           
        });

        /*file upload (Portable Appliance  test)*/
        var filePortInput = $('#upload3'),files;
        $(document).on('.upload.btn.three', 'click', function () {
           $('#upload3').click();
        });
        $(filePortInput).on('change', function () {
            var filename = filePortInput.val().replace(/C:\\fakepath\\/i, '');
            $('#port_upload_file').html(filename);
           
        });

        /*file upload (Fire Alarm test)*/
        var fileFireInput = $('#upload4'),files;
        $(document).on('.upload.btn.four', 'click', function () {
            $('#upload4').click();
        });
        $(fileFireInput).on('change', function () {
            var filename = fileFireInput.val().replace(/C:\\fakepath\\/i, '');
            $('#fire_uploaded_file').html(filename);
           
        });

        /*file upload (Smoke Detector test)*/
        var fileSmokeInput = $('#upload5'),files;
        $(document).on('.upload.btn.five', 'click', function () {
            $('#upload5').click();
        });
        $(fileSmokeInput).on('change', function () {
            var filename = fileSmokeInput.val().replace(/C:\\fakepath\\/i, '');
            $('#smoke_uploaded_file').html(filename);
           
        });

        /*file upload (Carbon monoxide detector test)*/
        var fileCarbonInput = $('#upload6'),files;
        $(document).on('.upload.btn.six', 'click', function () {
            $('#upload6').click();
        });
        $(fileCarbonInput).on('change', function () {
            var filename = fileCarbonInput.val().replace(/C:\\fakepath\\/i, '');
            $('#carbon_uploaded_file').html(filename);
           
        });

        /*file upload (Gas safety - coming soon! test)*/
        var fileGasInput = $('#upload7'),files;
        $(document).on('.upload.btn.six', 'click', function () {
            $('#upload7').click();
        });
        $(fileGasInput).on('change', function () {
            var filename = fileGasInput.val().replace(/C:\\fakepath\\/i, '');
            $('#gas_uploaded_file').html(filename);
           
        });

        
        /*validation*/
        $('form').parsley();
        $('label sup, .label sup').parent().parent().find('input, textarea, select').attr('required','');
        $('.inner_page_wrap').each(function (i) {
            $(this).attr('data-page',i).find('input, textarea, select').attr('data-parsley-group', 'page_' + i);
        });
        $('input[name="confirm_email"]').attr('data-parsley-equalto', '#email');
        $('input[name="confirm_password"]').attr('data-parsley-equalto', '#apply_password');


        /*pagination*/
        $('.inner_page_wrap:first-child').addClass('active');
        $('.btn.previous, .btn.next, .submit').on('click',function (e) {
            e.preventDefault();


            var curPage = $('.inner_page_wrap.active'),
                curPageId = curPage.attr('data-page'),
                prevPage = curPage.prev('.inner_page_wrap'),
                first_page= prevPage.prev('.inner_page_wrap'),
                nextPage = curPage.next('.inner_page_wrap');




            if($(e.target).hasClass('next')){
                if ($('form').parsley().validate({group: 'page_' + curPageId})) {
                // if(1==1){
                    if($(e.target).hasClass('submit')){
                        
                        var data = new FormData($('#applyform')[0]);

                       /* $.each( files, function( key, value ){
                            data.append( key, value );
                        });*/
                        

                        /*var form = $('form').serializeArray();
                        for( var i = 0; i < form.length; i++ ){
                            data.append( form[i]['name'], form[i]['value'] );
                        }*/

                        var path= $('#url_path').val();
                        var redirect_path = $('#redirect_path').val();
                        $('.btn.next').html('Please Wait....');
                        $.ajax({
                            type: "POST",
                            // data: $('form').serialize(),
                            data: data,
                            cache: false,
                            // dataType: 'json',
                            processData: false,
                            contentType: false,
                            url: path,
                            success: function(data){                                
                                var obj = jQuery.parseJSON(data);
                                if(obj.status=='fail'){
                                  $('#notify').empty().append('<div class="alert alert-danger">'+
                                          '<strong>Error ! </strong> '+obj.message+' '+
                                        '</div>');
                                }else{
                                   $('#notify').empty().append('<div class="alert alert-success">'+
                                          '<strong>Success!</strong> '+obj.message+' '+
                                        '</div>'); 
                                   $('#applyform').find("input[type=text],input[type=email],input[type=password], textarea").val("");
                                }   
                                                             
                                window.location.href = redirect_path;
                                /*if(data == 1){
                                    window.location.replace("http://safetycerts.co.uk/apply/confirmation.html");
                                }else{
                                    alert('email NOT sended');
                                }*/
                            }
                        });
                    }else{
                        goToPage(nextPage);
                    }
                }
            }else{
                goToPage(prevPage);
            }

        });
        function goToPage(requestPage) {
            //console.log(requestPage);
            var curPage = $('.inner_page_wrap.active'),
                requestPageId = requestPage.attr('data-page'),
                progressText,
                progressWidth;

                //alert(requestPageId);

            curPage.fadeOut().toggleClass('active');
            requestPage.fadeIn().toggleClass('active');
            switch(requestPageId) {
                case '0':
                    progressText = 'step 1 of 3 - your details';
                    progressWidth = '33.33%';
                    $('.sign-up').css('display','block');
                    break;
                case '1':
                    console.log('test');
                    progressText = 'step 2 of 3 - property details';
                    progressWidth = '66.66%';
                    $('.sign-up').css('display','none');
                    break;
                case '2':
                    progressText = 'step 3 of 3 - certificate details and submit';
                    progressWidth = '100%';
                    break;
                default :

            }

            $('.progress-wrap p').html(progressText);
            $('.progress-bar').width(progressWidth);
            if(requestPageId!='0'){
                $('.btn.previous').fadeIn();
            }else{
                $('.btn.previous').fadeOut();
            }
            if(requestPageId!='2'){
                $('.btn.next').html('next').removeClass('submit');
            }else{
                $('.btn.next').html('submit').addClass('submit');
            }




            $('html, body').animate({
                scrollTop: $('.header').offset().top
            }, 500);
        }

        /*debug*/
       /* $('.gray-header p').append('<div class="btn fill" style="color: #267cea;border-color:#267cea;padding: 10px 40px;margin: 0 0 0 50px;">fill data(debug)</div>');
         $(document).on('click','.fill', function () {
            $('input[type="text"]').val('test');
            $('input[type="number"]').val(12);
            $('input[type="checkbox"]').attr('checked',true).parent().find('label').addClass('active');
            $('textarea').val('test');
            $('input[type="email"]').val('test@test.com');
            $('input[type="tel"]').val('123123123');
            $('select').each(function () {
                if($(this).closest('.multi_select').length == 0) {
                    var lastOption = $(this).find('option').last().val();
                    $(this).val(lastOption);
                    $(this).closest('.select_wrap_item').find('.select_btn').html(lastOption);
                }
            });
            setTimeout(function () {
                $('.next').click();
            },100)
             setTimeout(function () {
                $('.next').click();
                 $('html, body').animate({
                     scrollTop: $('.submit').offset().top
                 }, 500);
            },200)

        })*/


    });
});

