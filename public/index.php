<?php

require_once("../src/init.php");

// FORMULAIRE DE PAIEMENT



?>
<h1>Ma boutique</h1>

<div id="card-element">
          <!-- A Stripe Element will be inserted here. -->
</div>
<div id="card-errors" role="alert"></div>

<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe("<?php echo $stripe_pkey;?>");
var elements = stripe.elements();
var cardElement = elements.create('card', {style: {}});
    cardElement.mount('#card-element');

</script>

<style>
  #card-element{
    max-width: 400px; padding: 5px;
    border: 1px solid lightgray;
    box-shadow: 2px 2px 10px;
  }
</style>