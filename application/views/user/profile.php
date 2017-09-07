<style type="text/css">
.profile-header-photo {
    background: #232936 none no-repeat scroll 50% 50% / cover ;
    color: #fff;
    height: 245px;
    margin: -27px 15px 20px;
    position: relative;
}    

.profile-side {
    margin: -213px 0 20px;
    position: relative;
}
.progress {
    display: block;
    height: 5px;
    margin-bottom: 0px;
    width: 100%;
}
</style>


<div class="page-content">
  <!-- <div class="profile-header-photo">
      <div class="profile-header-photo-in">
        <div class="tbl-cell">
          <div class="info-block">
            <div class="container-fluid">
              <div class="row">
                <div class="col-xl-9 col-xl-offset-3 col-lg-8 col-lg-offset-4 col-md-offset-0">
                    <div class="tbl info-tbl">
                        <div class="tbl-row">
                            

                        </div>
                    </div>
                 </div>
              </div>
            </div>
          </div>
        </div>
      </div>

     
  </div> --><!--.profile-header-photo-->

  <div class="container-fluid">
   <!-- <div class="row">
       <div class="col-xl-3 col-lg-4">
        <aside class="profile-side">
            <section class="box-typical profile-side-user">
               <form method="post" id="uploadimage">
                <button type="button" class="avatar-preview avatar-preview-128">
                    <?php $img_src= ($login_user->profile_pic) ? base_url()."uploads/".$login_user->profile_pic : base_url()."assest/img/avatar-1-256.png"; ?>
                    <img src="<?php echo $img_src ?>" alt="" id="preview"/>
                    <span class="update">
                        <i class="font-icon font-icon-picture-double"></i>
                        Update photo
                    </span>
                </button>
                <span style="display: none"><input type="file" name="userfile" id="profile_pic"/></span>
               </form>
               <progress max="100" value="60" class="progress progress-striped progress-success" style="display: none">60%</progress>

                
               
            </section>

        </aside>
      </div> 
    </div> -->
    <div class="row">
      
        <div class="col-md-12">
            <section class="tabs-section">
                <div class="tabs-section-nav tabs-section-nav-left">
                    <ul class="nav" role="tablist">
                       
                        <li class="nav-item" style="width: 183px">
                            <a class="nav-link active" href="#tabs-2-tab-4" role="tab" data-toggle="tab">
                                <span class="nav-link-in">Profile</span>
                            </a>
                        </li>

                        <li class="nav-item" style="width: 183px">
                            <a class="nav-link" href="#tabs-2-tab-2" role="tab" data-toggle="tab">
                                <span class="nav-link-in">Change Password</span>
                            </a>
                        </li>
                        <?php if($login_user->role=='contractor'){ ?>
                        <li class="nav-item" style="width: 183px">
                            <a class="nav-link" href="#tabs-2-tab-3" role="tab" data-toggle="tab">
                                <span class="nav-link-in">Delete Account</span>
                            </a>
                        </li>
                        <?php } ?>
                        
                    </ul>
                </div><!--.tabs-section-nav-->

                <div class="tab-content no-styled profile-tabs">
                     <div role="tabpanel" class="tab-pane active" id="tabs-2-tab-4">
                       <?php echo form_open('user/update_profile'); ?>
                        <section class="box-typical profile-settings">
                            <section class="box-typical-section">
                                <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">First Name</label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="text" name="first_name" class="form-control" value="<?php echo $login_user->first_name ?>"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">Last Name</label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="text" name="last_name" class="form-control" value="<?php echo $login_user->last_name ?>"/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">Email</label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="text" name="email" class="form-control" value="<?php echo $login_user->email ?>"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">Phone</label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="text" name="phone" class="form-control" value="<?php echo $login_user->phone ?>"/>
                                    </div>
                                </div>
                            </section>

                            <section class="box-typical-section">
                                <header class="box-typical-header-sm">Info</header>
                                <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">
                                            <i class="font-icon font-icon-pin-2"></i>
                                            Address
                                        </label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="text" name="address" class="form-control" value="<?php echo $login_user->address ?>"/>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">
                                            <i class="font-icon font-icon-earth"></i>
                                            Country
                                        </label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="text" name="country" class="form-control" value="<?php echo $login_user->country ?>"/>
                                    </div>
                                </div>
                            </section>
                           
                            <section class="box-typical-section profile-settings-btns">
                                <button type="submit" class="btn btn-rounded">Save Changes</button>
                                <button type="button" class="btn btn-rounded btn-grey">Cancel</button>
                            </section>
                        </section>
                      </form>
                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane" id="tabs-2-tab-2">
                        <section class="box-typical box-typical-padding">
                          <?php $error= validation_errors(); ?>
                          <?php if(!empty($error)){ ?>
                          <div role="alert" class="alert alert-danger">
                            <strong><?php echo validation_errors(); ?></strong>
                          </div>
                          <?php } ?>

                          <?php $message= $this->session->flashdata('message'); ?>
                          <?php if(!empty($message)){ ?>
                          <div role="alert" class="alert alert-success">
                            <strong><?php echo $this->session->flashdata('message'); ?></strong>
                          </div>
                          <?php } ?>

                           <?php echo form_open('user/update_password'); ?>
                            <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">New Password</label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="password" name="password" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">Re-New Password</label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="password" name="re_password" class="form-control" required />
                                    </div>
                                </div>

                            <section class="box-typical-section profile-settings-btns">
                                <button type="submit" class="btn btn-rounded">Save Changes</button>
                                <button type="button" class="btn btn-rounded btn-grey">Cancel</button>
                            </section>
                           </form> 
                        </section>

                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane" id="tabs-2-tab-3">
                        <section class="box-typical box-typical-padding">
                            <div id="del_noti"></div>
                            <form id="del_ac">
                            <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">Email</label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="email" name="email" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xl-2">
                                        <label class="form-label">Password</label>
                                    </div>
                                    <div class="col-xl-4">
                                        <input type="password" name="password" class="form-control" required />
                                    </div>
                                </div>

                            <section class="box-typical-section profile-settings-btns">
                                <button type="button" class="btn btn-rounded" onclick="delete_ac()">Delete Account</button>
                                
                            </section>
                           </form> 
                        </section>
                    </div><!--.tab-pane-->
                   
                </div><!--.tab-content-->
            </section><!--.tabs-section-->
        </div>
    </div><!--.row-->
  </div><!--.container-fluid-->
</div><!--.page-content-->


<script src="<?php echo base_url(); ?>assest/js/lib/jquery/jquery.min.js"></script>
<script type="text/javascript">
//=============== Profile Pic ==================
$(document).ready(function(){
  $('.avatar-preview').click(function(){
    $("#profile_pic").trigger("click");
  });

  $('#profile_pic').change(function(){
     readURL(this);
  });
  
})


function readURL(input) {
    if (input.files && input.files[0]) {
        //validate
        file=input.files[0];
        var match= ["image/jpeg","image/png","image/jpg"];  
        if(!((file.type==match[0]) || (file.type==match[1]) || (file.type==match[2]))){
           return false;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);

        uploadprofileimage();
    }
}


function uploadprofileimage(){
    $('.progress').css('display','block');
    var path="<?php echo base_url() ?>user/uploadProfileImage";
    $.ajax({
      type: 'POST', 
      url: path,
      //enctype: 'multipart/form-data',
      data:new FormData($('#uploadimage')[0]),
      contentType: false,
      processData: false,
      cache: false,
      success: function(response){
        if(response=='failed'){
           
        }

        $('.progress').css('display','none');
      }
    });
}


function delete_ac(){
  var formdata= $('#del_ac').serialize();
   var path="<?php echo base_url() ?>user/deleteAcAjax";
    $.ajax({
      type: 'POST', 
      url: path,
      data:formdata,
      success: function(response){
     
           $('#del_noti').html('<div role="alert" class="alert alert-danger">'+
                                 '<strong>'+response+'</strong>'+
                               '</div>');
       
      }
    });
}

</script>