<div class="mx-auto" style="width:70%">
    <h1 class="text-center"><?php echo session()->get('firstname')?>'s Cart</h1>
    <div class="row justify-content-md-center">
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
            <form class="" action="<?php echo base_url();?>/login" method="post">
            <?php
               echo '<table class="table table-striped col-12">';
               echo '<tr><th>Description</th><th>category</th><th class="col-md-2">quantity</th><th >photo</th><th>Options</th></tr>';
               if($products) {

               
               for($i = 0; $i < count($products); $i++){
                   echo '<tr>';
                   echo '<td>'.$products[$i]->description.'</td>';
                   echo '<td>'.$products[$i]->category.'</td>';
                   echo '<td class="col-md-3"><input class="col-md-3 p-1 ml-1" type="number" name="quantity" id="quantity" min="1" max="'.$products[$i]->quantityInStock.'" value="'.$quantities[$i].'"></td>';
                   echo '<td><img class="card-img-top" src="'.base_url().'/assets/images/products/thumbs/'.$products[$i]->photo.'" alt="Card image cap"></td>';
                   echo '<td><a href="'.base_url().'/removeFromCart/'.$products[$i]->produceCode.'/">Remove</a>';
                   echo '</td></tr>';
               }
            }
            else{
                    
                    echo '<p>You dont have any items in your cart.</p>';
                    //echo '<p>Want to <a href="'.base_url().'/browseproducts'.'">add some?</a></p>';
            }
            echo '</table>';
                
        ?>

            <button type="submit" class="btn btn-primary">Checkout</button>
            </form>
        </div>
</div> 