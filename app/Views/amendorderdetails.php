<div class="container">
    <div class="row">
        <div class="col-12 col-sm8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white form-wrapper">
            <div class="container">
                <div class="row w-100">
                    <h3><?= $order->orderNumber.'\'s '?>Details</h3>
                    <div class="col-12 col-sm-4">
                        <button type="submit" class="btn btn-outline-danger btn-sm btn-block  ">Close</button>
                    </div>
                    </div>
                <hr>
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>
                <form class="" action="<?php echo base_url();?>/amendorderdetails" method="post">

                <div class="row">
                <?php for($i = 0; $i < count($products); $i++){ ?>
                <div class="col-12 col-sm-6">
                    
                <div class="form-group">
                        <label for="<?='product_'.$products[$i]->produceCode.'_quantity' ?>"><?=$products[$i]->description?></label>
                        <a href=""<?php echo base_url();?>/removeProductFromOrder/<?= $order->orderNumber?>/<?= $products[$i]->produceCode?>"" class="text-danger"><span class="float-right">Remove</span></a>
                        <input type="number" class="form-control" name="<?='product_'.$products[$i]->produceCode.'_quantity' ?>" id="<?='product_'.$products[$i]->produceCode.'_quantity' ?>" value="<?= set_value('product_'.$products[$i]->produceCode.'_quantity', $order_details[$i]->quantityOrdered) ?>" min="1" max="<?=$products[$i]->quantityInStock ?>">
                    </div>
                </div>
                <?php } ?>
                
                    <?php if(isset($validation)): ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (session()->get('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                    <?php endif; ?>
                    <div class="d-flex">
                        <div class="mr-auto p-2">
                            <button type="submit" class="btn btn-success btn-block">Update</button>
                        </div>
                        <div class="p-2">
                            <a class="btn btn-primary btn-block" href="<?php echo base_url();?>/addProductToOrder/<?= $order->orderNumber?>/0" >Add Product to Order</a>
                        </div>
                        
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<div class="container">
    <div class="row">
        <?php 
            
        ?>
    </div>
</div>