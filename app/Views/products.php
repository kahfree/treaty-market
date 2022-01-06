<div class="container">
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
                            <a href="#" class="btn btn-primary">Add to cart</a>
                            <a href="'.base_url().'/browseproducts/'.$row->produceCode.'" class="btn btn-info">View</a>
                            </div>
                            </div>';
                    

                }
                echo '</div>';
            ?>
            
        </div>
</div> 