<div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Order Confirmation</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-6">
                <div class="card p-2" style="border-radius: 10px;">
                    <h3 style="text-align: left;">Payment Information</h3>
                    <form style="text-align: left;">
                        <div class="row">
                            <div class="col"><label class="form-label" style="text-align: left;">Cardholder Name</label><input class="form-control" type="text" style="background: var(--bs-gray-200);"></div>
                        </div>
                        <div class="row">
                            <div class="col"><label class="form-label">Card Number</label><input class="form-control" type="text" style="background: var(--bs-gray-200);"></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-xxl-4"><label class="form-label">Expiration Date</label><input class="form-control" type="text" style="background: var(--bs-gray-200);"></div>
                            <div class="col-xxl-3"><label class="form-label">CVV</label><input class="form-control" type="text" style="background: #e9ecef;"></div>
                            <div class="col-xxl-5">
                                <div class="form-check" style="margin-top: 2.35em; margin-left:1em; "><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1" style="color: var(--bs-gray);">Save Payment Method</label></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><button class="btn btn-primary" type="button" style="margin-top: 18px;">Pay €<?= $total ?></button></div>
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
                                    <div class="col-xl-4"><img src="assets/images/products/thumbs/<?= $product->photo ?>"></div>
                                    <div class="col-xl-8">
                                        <div class="row">
                                            <div class="col ml-5"><span><?= $product->description ?></span><em> x <?= $_SESSION['cart'][$product->produceCode]?></em></div>
                                        </div>
                                        <div class="row">
                                            <div class="col ml-5"><strong>€<?= $product->bulkSalePrice ?></strong></div>
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

