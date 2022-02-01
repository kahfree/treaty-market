<div class="mx-auto" style="width:70%">
    <h1 class="text-center"><?php echo session()->get('firstname')?>'s Wishlist</h1>
    <?php if (session()->get('wishlist-remove')): ?>
                    <div class="alert alert-success col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('wishlist-remove') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('unsuccessful')): ?>
                    <div class="alert alert-danger col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('unsuccessful') ?>
                    </div>
                <?php endif; ?>
    <div class="row justify-content-md-center">
                
            <form class="" action="<?php echo base_url();?>/checkout" method="post">
            <?php
               echo '<table class="table table-striped col-12">';
               echo '<tr><th>Image</th><th>Product Name</th><th>Comment</th><th>Priority</th><th>Quantity</th><th>Options</th></tr>';
               if($wishlist) {

               
               for($i = 0; $i < count($wishlist); $i++){
                   echo '<tr>';
                   echo '<td><img class="card-img-top" src="'.base_url().'/assets/images/products/thumbs/'.$products[$i]->photo.'" alt="Card image cap"></td>';
                   echo '<td>'.$products[$i]->description.'</td>';
                   echo '<td>'.$wishlist[$i]->comment.'</td>';
                   echo '<td>'.$wishlist[$i]->priority.'</td>';
                   echo '<td>'.$wishlist[$i]->quantity.'</td>';
                   echo '<td><a href="'.base_url().'/removeFromWishlist/'.$products[$i]->produceCode.'/">Remove</a>';
                   echo '</td></tr>';
               }
            }
            else{
                    
                    echo '<p>You have not wished for anything yet.</p>';
                    //echo '<p>Want to <a href="'.base_url().'/browseproducts'.'">add some?</a></p>';
            }
            echo '</table>';
                
        ?>

            <button type="submit" class="btn btn-primary">Checkout</button>
            </form>
        </div>
</div> 