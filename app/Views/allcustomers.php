<?php
echo '<div class="container justify-content-md-center mx-auto">';
echo '<h1>Every Customer and Their Details</h1>';
    foreach($customers as $customer)
    {
        
        echo "<div class='col-8 mb-2 offset-2 '>";
                    echo '<div class="card">';
                    
                    echo '<div class="card-header">';
                    echo "<h5 class='card-title'><span class='font-weight-bold'>".$customer->contactFirstName." ".$customer->contactLastName." </span> <span class='float-right'><span class='font-weight-bold'>Customer Number: </span> ";
                    echo "".$customer->customerNumber."</span></h5>";

                    echo '<ul class="list-group list-group-flush">';
                    echo ' <li class="list-group-item"><span class="font-weight-bold">Works for: </span> '.$customer->customerName.'</li>';
                    echo '<li class="list-group-item"><span class="font-weight-bold">Email address: </span> '.$customer->email.'</li>';
                    echo '<li class="list-group-item"><span class="font-weight-bold">Phone Number: </span> '.$customer->phone.'</li>';
                    echo '</ul>';
                    
                    echo '</div>';
                    echo '<div class="card-body p-2">';
                   
                    echo '<h5 class="card-text pb-0 mb-0 text-center"><a href="'.base_url().'/editcustomer/'.$customer->customerNumber.'"><button class="btn btn-outline-primary btn-block">Edit Details</button></a></h5>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
        
    }
    echo '</div>';
echo '</div>';
echo '</div>';
?>