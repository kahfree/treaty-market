<div class="container">
    <div class="row">
        <div class="col-12 col-sm8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white form-wrapper">
            <div class="container">
                <h3>Login</h3>
                <hr>
                
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('Moderator')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('Moderator') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('unsuccessful')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->get('unsuccessful') ?>
                    </div>
                <?php endif; ?>
                <form class="" action="<?php echo base_url();?>/login" method="post">

                <div class="col-12">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="johndoe@exampledomain.com">

                    </div>
                    <div class="form-group">
                        <label for="pass_word">Password</label>
                        <input type="password" class="form-control" name="pass_word" id="pass_word" placeholder="password">
                    </div>
                </div>
                <?php if(isset($validation)): ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">

                        <div class="col-12 col-sm-6">
                            <button type="submit" class="btn btn-primary ">Login</button>
                        </div>
                    
                    <div class="col-12 col-sm-6 text-right pt-2">
                        <a href="<?php echo base_url();?>/register">Don't have an account yet?</a>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>