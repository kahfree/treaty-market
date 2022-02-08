<div class="container">
    <div class="row">
        <div class="col-12 col-sm8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white form-wrapper">
            <div class="container">
                <h3>Edit Profile</h3>
                <hr>
                <form class="" action="<?php echo base_url();?>/editprofile" method="post">

                <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="firstname">Contact First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" value="<?= $customer->contactFirstName ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="lastname">Contact Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" value="<?= $customer->contactLastName ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="companyName">Company Name</label>
                            <input type="text" class="form-control" name="companyName" id="companyName" value="<?= $customer->customerName ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" class="form-control" name="email" id="email" value="<?= $customer->email ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address1">Address Line 1</label>
                            <input type="text" class="form-control" name="address1" id="address1" value="<?= $customer->addressLine1 ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address2">Address Line 2</label>
                            <input type="text" class="form-control" name="address2" id="address2" value="<?= $customer->addressLine2 ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="<?= $customer->city ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" name="country" id="country" value="<?= $customer->country ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" value="<?= $customer->phone ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="postalCode">Postal Code</label>
                            <input type="text" class="form-control" name="postalCode" id="postalCode" value="<?= $customer->postalCode ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="creditLimit">Credit Limit</label>
                            <input type="text" class="form-control" name="creditLimit" id="creditLimit" value="<?= $customer->creditLimit ?>">
                        </div>
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