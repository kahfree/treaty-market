<div class="container">
    <div class="row">
        <div class="col-12 col-sm8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white form-wrapper">
            <div class="container">
                <h3>Edit Product</h3>
                <hr>
                <form class="" action="<?php echo base_url();?>/editproduct" method="post" enctype='multipart/form-data'>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="produceCode">Produce Code</label>
                            <input type="text" class="form-control" name="produceCode" id="produceCode" readonly value="<?= $product->produceCode ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" name="category" id="category" value="<?= $product->category ?>">
                        </div>
                    </div>
                    <div class="col-12">
                    <div class="form-group">
                            <label for="description">Description</label>
                            <input type="textarea" class="form-control" name="description" id="description" value="<?= $product->description ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <input type="text" class="form-control" name="supplier" id="supplier" value="<?= $product->supplier ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="quantityInStock">Quantity</label>
                            <input type="text" class="form-control" name="quantityInStock" id="quantityInStock" value="<?= $product->quantityInStock ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="bulkBuyPrice">Buy Price</label>
                            <input type="text" class="form-control" name="bulkBuyPrice" id="bulkBuyPrice" value="<?= $product->bulkBuyPrice ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="bulkSalePrice">Sell Price</label>
                            <input type="text" class="form-control" name="bulkSalePrice" id="bulkSalePrice" value="<?= $product->bulkSalePrice ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control" name="photo" id="photo" value="<?= set_value('photo') ?>">
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
                        </form>
                    <div class="col-12 col-sm-6 text-right pt-2">
                        <a href="<?php echo base_url();?>/viewproducts" class="btn btn-danger">Cancel</a>
                    </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>