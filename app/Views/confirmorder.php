<div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Order Confirmation</h1>
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
            <div class="col-md-6 offset-1">
                <div class="card p-2" style="border-radius: 10px;">
                    <h3 style="text-align: left;">Payment Information</h3>
                    <form style="text-align: left;" class="" action="<?php echo base_url();?>/createorder/<?= $total ?>" method="post">
                        <div class="row">
                            <div class="col"><label class="form-label" style="text-align: left;">Cardholder Name</label><input class="form-control" type="text" style="background: var(--bs-gray-200);" name="cardName" id="cardName" value="<?= set_value('cardName') ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col"><label class="form-label">Card Number</label><input class="form-control" type="text" style="background: var(--bs-gray-200);" name="cardNumber" id="cardNumber" value="<?= set_value('cardNumber') ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Expiration Date</label><input class="form-control" type="text" style="background: var(--bs-gray-200);" name="expiryDate" id="expiryDate" value="<?= set_value('expiryDate') ?>"></div>
                            <div class="col-md-2"><label class="form-label">CVV</label><input class="form-control" type="text" style="background: var(--bs-gray-200);" name="CVV" id="CVV" value="<?= set_value('CVV') ?>"></div>
                            <div class="col-md-3"><label class="form-label">Card Type</label>
                                <select class="form-control" style="background: var(--bs-gray-200);" name="cardType" id="cardType">
                                    <option value="Visa">Visa</option>
                                    <option value="Mastercard">Mastercard</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col"><button class="btn btn-primary" type="submit" style="margin-top: 18px;">Pay €<?= $total ?></button></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <h3 class="p-2">Order Summary</h3>
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
                                        <div class="row">
                                            <div class="col ml-5">€<?= $product->bulkSalePrice ?><em> x <?= $_SESSION['cart'][$product->produceCode]?></em></div>
                                        </div>
                                        <div class="row">
                                            <div class="col ml-5"><strong>€<?= ($product->bulkSalePrice * $_SESSION['cart'][$product->produceCode]) ?></strong></div>
                                        </div>
                                    </div>
                                </div>

                                <?php }?>
                                
                               <hr> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" style="margin: 15px;">
                            <p>Subtotal</p>
                            <p>Additional Charges</p>
                            <p>Total</p>
                        </div>
                        <div class="col" style="margin: 15px;">
                            <p><strong>€<?= $subtotal ?></strong></p>
                            <p><strong>€6.99</strong></p>
                            <p><strong>€<?= $total ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

