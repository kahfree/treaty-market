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
                foreach( $product_data->getResult() as $row)
                {
                    echo '<div class="card col-lg-3 m-1">
                            <img class="card-img-top" src="'.base_url().'/assets/images/products/thumbs/'.$row->photo.'" alt="Card image cap">
                            <div class="card-body">
                            <h5 class="card-title">'.$row->description.'</h5>
                            <p class="card-text">Supplied by '.$row->supplier.'</p>
                            <form class="" action="'.base_url().'/addToCart/'.$row->produceCode.'/" method="get">
                            
                            <div class="row justify-content-md-center">
                                <input type="submit" class="btn btn-primary" name="submit" value="Add to cart">
                                <a href="'.base_url().'/browseproducts/'.$row->produceCode.'" class="btn btn-info ml-1">View</a>
                                <a href="'.base_url().'/addToWishlist/'.$row->produceCode.'/" class="btn btn-warning ">Add to wishlist</a>
                            </div>
                            <div class="row mt-2 justify-content-md-left">
                                <label for="quantity" class="ml-3">Quantity:</label>
                                <input class="col-md-3 p-1 ml-1" type="number" name="quantity" id="quantity" min="1" max="'.$row->quantityInStock.'">
                            </div>

                            </form>
                            </div>
                            </div>';
                    

                }
                echo '</div>';
            ?>
            
        </div>
</div> 