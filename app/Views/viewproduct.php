<div class="container mx-auto">
    <h1 class="text-center col-md-12">Product</h1>
            <?php
                echo '<h2>'.$selected_product->description.'</h2>
                <img src="'.base_url().'/assets/images/products/full/'.$selected_product->photo.'">'
                .'<br><h3>Product Info</h3>';
                    echo '<p>Category: '.$selected_product->category.'</p>';
                    echo '<p>Supplier: '.$selected_product->supplier.'</p>';
                    if(session()->get('userType') == 'Administrator')
                    {

                    }
                    else
                    {
                      
                    }
                        
            ?>
</div> 