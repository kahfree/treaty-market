<div class="container">
    <div class="row">
        <div class="col-12 col-sm8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white form-wrapper">
            <div class="container">
                <h3>Add Product</h3>
                <hr>
                <form class="" action="<?php echo base_url();?>/addproduct" method="post" enctype='multipart/form-data'>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="produceCode">Produce Code</label>
                            <input type="text" class="form-control" name="produceCode" id="produceCode" value="<?= set_value('produceCode') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" name="category" id="category" value="<?= set_value('category') ?>">
                        </div>
                    </div>
                    <div class="col-12">
                    <div class="form-group">
                            <label for="description">Description</label>
                            <input type="textarea" class="form-control" name="description" id="description" value="<?= set_value('description') ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <input type="text" class="form-control" name="supplier" id="supplier" value="<?= set_value('supplier') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="quantityInStock">Quantity</label>
                            <input type="text" class="form-control" name="quantityInStock" id="quantityInStock" value="<?= set_value('quantityInStock') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="bulkBuyPrice">Buy Price</label>
                            <input type="text" class="form-control" name="bulkBuyPrice" id="bulkBuyPrice" value="<?= set_value('bulkBuyPrice') ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="bulkSalePrice">Sell Price</label>
                            <input type="text" class="form-control" name="bulkSalePrice" id="bulkSalePrice" value="<?= set_value('bulkSalePrice') ?>">
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
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    
                    <div class="col-12 col-sm-6 text-right pt-2">
                        <a href="<?php echo base_url();?>/viewproducts"><button class="btn btn-danger">Cancel</button></a>
                    </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>