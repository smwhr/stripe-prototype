<?php

require_once("../src/init.php");

// FORMULAIRE DE PAIEMENT



?>
<h1>Ma boutique</h1>

<div id="card-element">
          <!-- A Stripe Element will be inserted here. -->
</div>
<div id="card-errors" role="alert"></div>
<button class="stripe-button">Payer</button>

<script src="https://js.stripe.com/v3/"></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script>
<script>
var stripe = Stripe("<?php echo $stripe_pkey;?>");
var elements = stripe.elements();
var cardElement = elements.create('card', {style: {}});
    // cardElement = elements.create('iban', {supportedCountries: ['SEPA'],placeholderCountry: 'FR'});
    cardElement.mount('#card-element');

$(document).on("click", ".stripe-button", function(){
  var source = stripe.createSource(cardElement);
      source
        .then(function(source){
          if(source.error){
            console.error(source.error)
          }else{
            console.log("OK !")
          }
        })
        .catch(function(error){
          console.error(error)
        })
})

</script>

<style>
  #card-element{
    max-width: 400px; padding: 5px;
    border: 1px solid lightgray;
    box-shadow: 2px 2px 10px;
  }
</style>