<div class="container">
    <h1 class="text-center col-md-12 mt-3"><?=$selected_product->description?></h1>
            <?php

                    echo '<div class="card col-md-6 offset-3 p-0">';
                    
                    echo '<div class="card-header">';
                    if(session()->get('userType') == 'Customer'){
                        echo "<h5 class='card-title'><span class=''><a href='".base_url().'/browseproducts/'."'><button type='submit' class='btn btn-outline-danger btn-sm btn-block'>Close</button></a></span></h5>";
                    }
                    else if(session()->get('userType') == 'Administrator'){
                        echo "<h5 class='card-title'><span class=''><a href='".base_url().'/viewproducts/'."'><button type='submit' class='btn btn-outline-danger btn-sm btn-block'>Close</button></a></span></h5>";
                    }
                    echo '<ul class="list-group list-group-flush">';
                    echo ' <li class="list-group-item"><span class="font-weight-bold">Category: </span> '.$selected_product->category.'</li>';
                    echo '<li class="list-group-item"><span class="font-weight-bold">Supplier: </span> '.$selected_product->supplier.'</li>';
                    echo '<li class="list-group-item"><span class="font-weight-bold">Price: </span> '.$selected_product->bulkSalePrice.'</li>';
                    echo '</ul>';
                    
                    echo '</div>';
                    echo '<img class="card-img-bottom img-responsive" src="'.base_url().'/assets/images/products/full/'.$selected_product->photo.'" alt="Card image cap">';
                    echo '</div>';
                    if(session()->get('userType') == 'Administrator')
                    {

                    }
                    else
                    {
                      
                    }
                        
            ?>
</div> 