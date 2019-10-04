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
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script>
var stripe = Stripe("<?php echo $stripe_pkey;?>");
var elements = stripe.elements();
var cardElement = elements.create('card', {style: {}});
    // cardElement = elements.create('iban', {supportedCountries: ['SEPA'],placeholderCountry: 'FR'});
    cardElement.mount('#card-element');


var prepare = function(){

}

$(document).on("click", ".stripe-button", function(){
  var payment = stripe.createPaymentMethod('card',cardElement)
      payment
        .then(function(payment){
          if(payment.error){
            displayError(payment.error.message)
            console.error(payment.error)
          }else{
            axios.post("/1_prepare.php", {
                    payment_method: payment.paymentMethod.id
                })
              .then(function(response){
                console.log(response.data.message)
                  var intent = response.data.intent
                  axios.post("/2_pay.php", {
                    payment_intent: intent.id
                  })
              })
              .catch(function(error){
                  if(error.response.data.intent_status == "requires_source_action"){
                    console.log("DEMANDER 3D SECURE")
                    var intent_secret = error.response.data.intent.client_secret;
                      return stripe.handleCardAction(intent_secret)
                            .then(function(response){
                                console.log(response.paymentIntent)
                                axios.post("/2_pay.php", {
                                  payment_intent: response.paymentIntent.id
                                })
                            })
                            .catch(function(error){

                            })
                  }
              })
          }
        })
        .catch(function(error){
          displayError(error.message)
          console.error(error)
        })
})

var displayError = function(message){
  console.log(message)
  $("#card-errors").html(message);
  $("#card-errors").show();
}

</script>

<style>
  #card-element{
    max-width: 400px; padding: 5px;
    border: 1px solid lightgray;
    box-shadow: 2px 2px 10px;
  }
  #card-errors{
    border: 1px solid red; margin-top: 1em;
    margin-bottom: 1em;
    max-width: 400px; padding: 5px;
  }
</style>