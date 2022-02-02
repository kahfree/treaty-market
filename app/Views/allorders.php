<?php
echo '<div class="container justify-content-md-center mx-auto">';
echo '<h1>Every Customer and Their Orders</h1>';
    foreach($customers as $customer)
    {
        
        echo "<div class='col-12 mb-2 '>";
                    echo '<div class="card">';
                    
                    echo '<div class="card-header">';
                    echo "<h5 class='card-title'><span class='font-weight-bold'>".$customer->contactFirstName." ".$customer->contactLastName." </span> <span class='float-right'><span class='font-weight-bold'>Order Count: </span> ";
                    echo "".$orders[$customer->customerNumber]."</span></h5>";

                    echo '<ul class="list-group list-group-flush">';
                    echo ' <li class="list-group-item"><span class="font-weight-bold">Orders in process: </span> '.$inProcessList[$customer->customerNumber].'</li>';
                    echo '<li class="list-group-item"><span class="font-weight-bold">Orders shipped: </span> '.$shippedList[$customer->customerNumber].'</li>';
                    echo '<li class="list-group-item"><span class="font-weight-bold">Orders disputed: </span> '.$disputedList[$customer->customerNumber].'</li>';
                    echo '</ul>';
                    
                    echo '</div>';
                    echo '<div class="card-body p-2">';
                   
                    echo '<h5 class="card-text pb-0 mb-0 text-center"><a href="'.base_url().'/customerorders/'.$customer->customerNumber.'"><button class="btn btn-outline-primary btn-block">View Orders</button></a></h5>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
        
    }
    echo '</div>';
echo '</div>';
echo '</div>';
?>