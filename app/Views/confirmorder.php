

    <div class="container">

    <div class='col-12 mb-2 '>
    <h1 class='m-2'>Confirming Your Order</h1>
                    <div class="card">
                    
                    <div class="card-header">
                    <h5 class='card-title'><span class=''><a href='<?=base_url()?>/viewcart/'>< Go Back</a></span>

                    <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span class="font-weight-bold">Order Date:</span> <?=date('Y-m-d')?></li>
                    <li class="list-group-item"><span class="font-weight-bold">Required Date:</span> <?=$order->requiredDate?></li>
                    <li class="list-group-item"><span class="font-weight-bold">Shipped Date:</span> <?=$order->shippedDate?></li>
                    </ul>
                    
                    </div>
                    </div>

    echo "<h1 class='m-2'>Products on Order #".$order->orderNumber."</h1>";        
    echo '</div>';

<?php
    echo '<div class="card-deck">';
    for($i = 0; $i < count($products); $i++)
    {?>
        
        <div class='col-md-4'>
                    <div class="card">

                    <img class="card-img-top" src="'.base_url().'/assets/images/products/full/'.$products[$i]->photo.'" alt="Card image cap">
                    <div class="card-header">
                    <h5 class='card-title'><span class='font-weight-bold'>".$products[$i]->description." </span> </h5>
                    <h6 class="card-subtitle mb-2 text-muted">Category: '.$products[$i]->category.'  </h6>
                    </div>
                    <div class="card-body">
                   
                    <h6 class="card-text pb-0 mb-0"><span class="font-weight-bold">Quantity:</span> '.$order_details[$i]->quantityOrdered.' <span class="float-right"><span class="font-weight-bold">Price: </span>'.$order_details[$i]->priceEach.'</span></h6>
                    </div>
                    </div>
                    </div>
        
    <?php } ?>
    </div>
    </div>
    </div>
?>

