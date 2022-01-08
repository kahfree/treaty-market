<div class="mx-auto" style="width: 70%;">
    <h1 class="text-center">Every product in the database</h1>
    <?php if(session()->get('userType') == 'Client'): ?>
    <a href="<?=base_url()?>/generateWorkout"><input type="button" class="btn btn-success mb-3" value="Generate Custom Workout"></a>
    <?php endif; ?>

    <?php if(session()->get('userType') == 'Moderator'): ?>
    <a href="<?=base_url()?>/addWorkout"><input type="button" class="btn btn-success mb-3" value="Add Workout"></a>
    <?php endif; ?>
    <div class="row">
    
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('unsuccessful')): ?>
                    <div class="alert alert-danger col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('unsuccessful') ?>
                    </div>
                <?php endif; ?>
            <?php
                echo '<div class="row justify-content-md-center">';
                
                foreach( $product_data as $row)
                { ?>
                    <div class="card col-lg-3 m-1">
                            <img class="card-img-top" src="<?= base_url() ?> /assets/images/products/thumbs/<?= $row->photo ?>" alt="Card image cap">
                            <div class="card-body">
                            <h5 class="card-title"><?=$row->description?></h5>
                            <p class="card-text">Supplied by <?=$row->supplier?></p>
                            <form class="" action="<?php echo base_url();?>/addProductToOrder/<?= $orderNumber?>/<?= $row->produceCode?>" method="post">
                            <div class="row mt-2 justify-content-md-left">
                                <label for="quantity" class="ml-3">Quantity:</label>
                                <input class="col-md-3 p-1 ml-1" type="number" name="quantity" id="quantity" min="1" max="<?=$row->quantityInStock?>">
                                <input type="submit" class="btn btn-primary ml-1" name="submit" value="Add to cart"> 
                            </div>

                            </form>
                            </div>
                            </div>
                    

               <?php }
                echo '</div>';
            ?>
            
        </div>
</div> 