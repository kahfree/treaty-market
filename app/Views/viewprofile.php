<div class="container">
        <div class="row">
            <div class="col-md-4 offset-4">
                <h1><?=session()->get('firstname')?>'s profile</h1>
            </div>
        </div>
        <div class="row">
        <?php if(isset($validation)): ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (session()->get('error')): ?>
                    <div class="alert alert-danger col-12" role="alert">
                        <?= session()->get('error') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('cart-remove')): ?>
                    <div class="alert alert-success col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('cart-remove') ?>
                    </div>
                <?php endif; ?>
            
            <div class="col-md-4 offset-1">
                <div class="card">
                    <div class="row">
                        <div class="col">
                                <a href="<?=base_url()?>/wishlist"><h3 class="p-2">Wishlist</h3></a>

                            <div>
                                <?php foreach($products as $product) 
                                {
                                ?>

                                <div class="row" style="margin: 5px;">
                                    <div class="col-xl-4"><img src="<?=base_url()?>/assets/images/products/thumbs/<?= $product->photo ?>"></div>
                                    <div class="col-xl-8">
                                        <div class="row">
                                            <div class="col ml-5"><span><?= $product->description ?></span></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <?php }?>
                                
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-2" style="border-radius: 10px;">
                    <h3 style="text-align: left;"><span class="float-left">Your Details</span><span class="float-right"><a href="<?=base_url()?>/editprofile"><button class="btn btn-primary btn-sm">Update</button></a></span></h3>

                    <form style="text-align: left;" class="" action="<?php echo base_url();?>/createorder/" method="post">
                        <div class="row">
                        <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="firstname">Contact First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" value="<?= $customer->contactFirstName ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="lastname">Contact Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" value="<?= $customer->contactLastName ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="companyName">Company Name</label>
                            <input type="text" class="form-control" name="companyName" id="companyName" value="<?= $customer->customerName ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" class="form-control" name="email" id="email" value="<?= $customer->email ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address1">Address Line 1</label>
                            <input type="text" class="form-control" name="address1" id="address1" value="<?= $customer->addressLine1 ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address2">Address Line 2</label>
                            <input type="text" class="form-control" name="address2" id="address2" value="<?= $customer->addressLine2 ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="<?= $customer->city ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" name="country" id="country" value="<?= $customer->country ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" value="<?= $customer->phone ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="postalCode">Postal Code</label>
                            <input type="text" class="form-control" name="postalCode" id="postalCode" value="<?= $customer->postalCode ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="creditLimit">Credit Limit</label>
                            <input type="text" class="form-control" name="creditLimit" id="creditLimit" value="<?= $customer->creditLimit ?>" readonly>
                        </div>
                    </div>
                    
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>