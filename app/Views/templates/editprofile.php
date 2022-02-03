<div class="container">
    <div class="row">
        <div class="col-12 col-sm8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white form-wrapper">
            <div class="container">
                <h3>Edit Profile</h3>
                <hr>
                <form class="" action="<?php echo base_url();?>/register" method="post">

                <div class="row">
                <div class="col-sm-2">
                        <div class="form-group">
                            <label for="customerNumber">Customer Number</label>
                            <input type="text" class="form-control" name="customerNumber" id="customerNumber" value="<?= set_value('customerNumber') ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="companyName">Company Name</label>
                            <input type="text" class="form-control" name="companyName" id="companyName" value="<?= set_value('companyName') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="firstname">Contact First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" value="<?= set_value('firstname') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="lastname">Contact Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" value="<?= set_value('lastname') ?>">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email') ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <h4>Update Password</h4>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="pass_word">Password</label>
                            <input type="password" class="form-control" name="password" id="password" value="<?= set_value('password') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="password_confirm">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="<?= set_value('password_confirm') ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address1">Address Line 1</label>
                            <input type="text" class="form-control" name="address1" id="address1" value="<?= set_value('address1') ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address2">Address Line 2</label>
                            <input type="text" class="form-control" name="address2" id="address2" value="<?= set_value('address2') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="<?= set_value('city') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" name="country" id="country" value="<?= set_value('country') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" value="<?= set_value('phoneNumber') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="postalCode">Postal Code</label>
                            <input type="text" class="form-control" name="postalCode" id="postalCode" value="<?= set_value('postalCode') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="creditLimit">Credit Limit</label>
                            <input type="text" class="form-control" name="creditLimit" id="creditLimit" value="<?= set_value('creditLimit') ?>">
                        </div>
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
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>