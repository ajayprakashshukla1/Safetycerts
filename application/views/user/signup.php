<style type="text/css">
.sign-box{
    max-width: 450px;
}    
</style>
<div class="page-center">
    <div class="page-center-in">
        <div class="container-fluid">
            <form class="sign-box">
                <div class="sign-avatar no-photo">&plus;</div>
                <header class="sign-title">Sign Up</header>

                <div class="form-group">
                    <label style="font-size: 22px; margin-bottom: 15px; margin-left: 17px;">I am </label>
                    <div class="col-md-6">
                       <div class="radio">
                          <input type="radio" value="client" id="radio-1" name="user_role">
                          <label for="radio-1">Client </label>
                       </div>
                    </div>

                    <div class="col-md-6">
                       <div class="radio">
                          <input type="radio" value="contractor" id="radio-2" name="user_role">
                          <label for="radio-2">Contractor </label>
                       </div>
                    </div>
                    
                </div>

                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="E-Mail"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                </div>
                <div class="form-group">
                    <input type="password" name="re_password" class="form-control" placeholder="Repeat password"/>
                </div>

                <div class="form-group">
                    <input type="text" name="first_name" class="form-control" placeholder="First Name"/>
                </div>

                <div class="form-group">
                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"/>
                </div>

                <div class="form-group">
                    <input type="text" name="phone" class="form-control" placeholder="Phone"/>
                </div>

                <button type="submit" class="btn btn-rounded btn-success sign-up">Sign up</button>
                <p class="sign-note">Already have an account? <a href="<?php echo base_url() ?>auth/login">Sign in</a></p>
                <!--<button type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>-->
            </form>
        </div>
    </div>
    </div><!--.page-center-->