Stripe.setPublishableKey('pk_test_51Nz1wNCmiZOJOWEhUMpbqlBLazZ8ZSJXYGuZIXFzkDx5Y9vzz2J6UH2wMHF1eCKsiAdlem4Q9x2HQ9VCbyCoy6fz00Ws1QSEPt');

function stripePay(event) {
    event.preventDefault(); 
    if(validateForm() == true) {
     $('#payNow').attr('disabled', 'disabled');
     $('#payNow').val('Payment Processing....');
     Stripe.createToken({
      number:$('#cardNumber').val(),
      cvc:$('#cardCVC').val(),
      exp_month : $('#cardExpMonth').val(),
      exp_year : $('#cardExpYear').val()
     }, stripeResponseHandler);
     return false;
    }
}

function stripeResponseHandler(status, response) {
 if(response.error) {
  $('#payNow').attr('disabled', false);
  $('#message').html(response.error.message).show();
 } else {
  var stripeToken = response['id'];
  $('#paymentForm').append("<input type='hidden' name='stripeToken' value='" + stripeToken + "' />");

  $('#paymentForm').submit();
 }
}

function validateForm() {
 var validCard = 0;
 var valid = false;
 var cardCVC = $('#cardCVC').val();
 var cardExpMonth = $('#cardExpMonth').val();
 var cardExpYear = $('#cardExpYear').val();
 var cardNumber = $('#cardNumber').val();
 var emailAddress = $('#emailAddress').val();
 var customerName = $('#customerName').val();
 var customerAddress = $('#customerAddress').val();
 var customerCity = $('#customerCity').val();
 var customerZipcode = $('#customerZipcode').val();
 var customerCountry = $('#customerCountry').val();
 var readingName = $('#readingName').val();
 var gender = $('#gender').val();
 var birthDate = $('#birthDate').val();
 var birthTime = $('#birthTime').val();
 var birthPlace = $('#birthPlace').val();
 var validateName = /^[a-z ,.'-]+$/i;
 var validateEmail = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
 var validateMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
 var validateYear = /^2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
 var cvv_expression = /^[0-9]{3,3}$/;

 $('#cardNumber').validateCreditCard(function(result){
  if(result.valid) {
   $('#cardNumber').removeClass('require');
   $('#errorCardNumber').text('');
   validCard = 1;
  } else {
   $('#cardNumber').addClass('require');
   $('#errorCardNumber').text('Invalid Card Number');
   validCard = 0;
  }
 });

 if(validCard == 1) {
  if(!validateMonth.test(cardExpMonth)){
   $('#cardExpMonth').addClass('require');
   $('#errorCardExpMonth').text('Invalid Data');
   valid = false;
  } else { 
   $('#cardExpMonth').removeClass('require');
   $('#errorCardExpMonth').text('');
   valid = true;
  }

  if(!validateYear.test(cardExpYear)){
   $('#cardExpYear').addClass('require');
   $('#errorCardExpYear').error('Invalid Data');
   valid = false;
  } else {
   $('#cardExpYear').removeClass('require');
   $('#errorCardExpYear').error('');
   valid = true;
  }

  if(!cvv_expression.test(cardCVC)) {
   $('#cardCVC').addClass('require');
   $('#errorCardCvc').text('Invalid Data');
   valid = false;
  } else {
   $('#cardCVC').removeClass('require');
   $('#errorCardCvc').text('');
   valid = true;
  }
  
  if(!validateName.test(customerName)) {
   $('#customerName').addClass('require');
   $('#errorCustomerName').text('Invalid Name');
   valid = false;
  } else {
   $('#customerName').removeClass('require');
   $('#errorCustomerName').text('');
   valid = true;
  }

  if(!validateEmail.test(emailAddress)) {
   $('#emailAddress').addClass('require');
   $('#errorEmailAddress').text('Invalid Email Address');
   valid = false;
  } else {
   $('#emailAddress').removeClass('require');
   $('#errorEmailAddress').text('');
   valid = true;
  }

  if(readingName == '') {
   $('#readingName').addClass('require');
   $('#errorReadinName').text('');
   valid = false;
  } else {
   $('#readingName').removeClass('require');
   $('#errorReadinName').text('');
   valid = true;
  }

  if(gender == '') {
   $('#gender').addClass('require');
   $('#errorGender').text('');
   valid = false;
  } else {
   $('#gender').removeClass('require');
   $('#errorGender').text('');
   valid = true;
  }

  if(birthDate == '') {
   $('#birthDate').addClass('require');
   $('#errorBirthDate').text('');
   valid = false;
  } else {
   $('#birthDate').removeClass('require');
   $('#errorBirthDate').text('');
   valid = true;
  }

  if(birthTime == '') {
   $('#birthTime').addClass('require');
   $('#errorBirthTime').text('');
   valid = false;
  } else {
   $('#birthTime').removeClass('require');
   $('#errorBirthTime').text('');
   valid = true;
  }
  if(birthPlace == '') {
   $('#birthPlace').addClass('require');
   $('#errorBirthPlace').text('');
   valid = false;
  } else {
   $('#birthPlace').removeClass('require');
   $('#errorBirthPlace').text('');
   valid = true;
  }
  
  if(customerAddress == '') {
   $('#customerAddress').addClass('require');
   $('#errorCustomerAddress').text('Enter Address Detail');
   valid = false;
  } else {
   $('#customerAddress').removeClass('require');
   $('#errorCustomerAddress').text('');
   valid = true;
  }

  if(customerCity == ''){
   $('#customerCity').addClass('require');
   $('#errorCustomerCity').text('Enter City');
   valid = false;
  } else {
   $('#customerCity').removeClass('require');
   $('#errorCustomerCity').text('');
   valid = true;
  }

  if(customerZipcode == ''){
   $('#customerZipcode').addClass('require');
   $('#errorCustomerZipcode').text('Enter Zip code');
   valid = false;
  } else {
   $('#customerZipcode').removeClass('require');
   $('#errorCustomerZipcode').text('');
   valid = true;
  }

  if(customerCountry == '') {
   $('#customerCountry').addClass('require');
   $('#errorCustomerCountry').text('Enter Country Detail');
   valid = false;
  } else {
   $('#customerCountry').removeClass('require');
   $('#errorCustomerCountry').text('');
   valid = true;
  }  
 }
 return valid;
}

function validateNumber(event) {
 var charCode = (event.which) ? event.which : event.keyCode;
 if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57)){
  return false;
 }
 return true;
}