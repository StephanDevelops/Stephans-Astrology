<?php
session_start();
include('include/header.php');
?>
<title>Stripe Payment Gateway Integration</title>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.0.0/jquery.creditCardValidator.js"></script>
<script type="text/javascript" src="script/payment.js"></script>
<?php include('include/container.php'); ?>
<div class="container">	
	<div class="row">	

		<?php
		if (isset($_SESSION["message"]) && $_SESSION["message"] && $_SESSION["message"] == 'failed') {
			?>			
																																																																											<div class="alert alert-danger">
																																																																										  	<?php
																																																																											  echo "Error : Payment failed!";
																																																																											  $_SESSION["message"] = '';
																																																																											  ?>
																																																																											</div>
																																																																									<?php
		} elseif (isset($_SESSION["message"]) && $_SESSION["message"]) {
			?>
																																																																											<div class="alert alert-success">
																																																																										  	<?php
																																																																											  echo $_SESSION["message"];
																																																																											  $_SESSION["message"] = '';
																																																																											  ?>
																																																																											</div>
		<?php } ?>
		<div class="panel panel-default">			
			<div class="panel-heading">Order Process</div>
			<div class="panel-body">
				<form action="process.php" method="POST" id="paymentForm">	
					<div class="row">
						<div align="center" class="col-md-8" style="border-right:1px solid #ddd;">						
							<h4 align="center">Customer Details</h4>
							<div class="form-group">
								<label><b>Name <span class="text-danger">*</span></b>
									<input type="text" name="readingName" id="readingName" class="form-control" value="">
								</label>
								<span id="errorReadingName" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label><b>Gender <span class="text-danger">*</span></b>
									<input type="text" name="gender" id="gender" class="form-control" value="">
								</label>
								<span id="errorGender" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label><b>Birthdate <span class="text-danger">*</span></b>
									<input type="date" name="birthDate" id="birthDate" class="form-control" value="">
								</label>
								<span id="errorBirthDate" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label><b>Time of birth <span class="text-danger">*</span></b>
									<input type="time" name="birthTime" id="birthTime" class="form-control" value="">
								</label>
								<span id="errorBirthTime" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label><b>Birthplace <span class="text-danger">*</span></b>
									<input type="text" name="birthPlace" id="birthPlace" class="form-control" value="">
								</label>
								<span id="errorBirthPlace" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label><b>Email Address <span class="text-danger">*</span></b>
									<input type="text" name="emailAddress" id="emailAddress" class="form-control" value="">
								</label>
								<span id="errorEmailAddress" class="text-danger"></span>
							</div>
							<hr>
							<h4 align="center">Payment Details</h4>
							<div class="form-group">
								<label><b>Card Holder Name <span class="text-danger">*</span></b>
									<input type="text" name="customerName" id="customerName" class="form-control" value="">
								</label>
								<span id="errorCustomerName" class="text-danger"></span>
							</div>
							
							<div class="form-group">
								<label><b>Billing Address <span class="text-danger">*</span></b>
									<textarea name="customerAddress" id="customerAddress" class="form-control"></textarea>
								</label>								
								<span id="errorCustomerAddress" class="text-danger"></span>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label><b>City <span class="text-danger">*</span></b>
											<input type="text" name="customerCity" id="customerCity" class="form-control" value="">
										</label>									
										<span id="errorCustomerCity" class="text-danger"></span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label><b>Zip <span class="text-danger">*</span></b>
											<input type="text" name="customerZipcode" id="customerZipcode" class="form-control" value="">
										</label>										
										<span id="errorCustomerZipcode" class="text-danger"></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label><b>State </b>
											<input type="text" name="customerState" id="customerState" class="form-control" value="">
										</label>								
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label><b>Country <span class="text-danger">*</span></b>
											<input type="text" name="customerCountry" id="customerCountry" class="form-control">
										</label>							
										<span id="errorCustomerCountry" class="text-danger"></span>
									</div>
								</div>
							</div>				
							<div class="form-group">
								<label>Card Number <span class="text-danger">*</span>
									<input type="text" name="cardNumber" id="cardNumber" class="form-control" placeholder="1234 5678 9012 3456" maxlength="20" onkeypress="">
								</label>								
								<span id="errorCardNumber" class="text-danger"></span>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label>Expiration Month <input type="text" name="cardExpMonth" id="cardExpMonth" class="form-control" placeholder="MM" maxlength="2" onkeypress="return validateNumber(event);">
										</label>
										<span id="errorCardExpMonth" class="text-danger"></span>
									</div>
									<div class="col-md-4">
										<label>Expiration Year <input type="text" name="cardExpYear" id="cardExpYear" class="form-control" placeholder="YYYY" maxlength="4" onkeypress="return validateNumber(event);">
										</label>										
										<span id="errorCardExpYear" class="text-danger"></span>
									</div>
									<div class="col-md-4">
										<label>CVC <input type="text" name="cardCVC" id="cardCVC" class="form-control" placeholder="123" maxlength="4" onkeypress="return validateNumber(event);">
										</label>										
										<span id="errorCardCvc" class="text-danger"></span>
									</div>
								</div>
							</div>
							<br>
							<div align="center">
							<input type="hidden" name="price" value="10000">
							<input type="hidden" name="total_amount" value="10000">
							<input type="hidden" name="currency_code" value="USD">
							<input type="hidden" name="item_details" value="Natal chart reading">
							<!-- <input type="hidden" name="item_number" value="TS1234567"> -->
							<!-- <input type="hidden" name="order_number" value="SKA987654321"> -->
							<input type="button" name="payNow" id="payNow" class="btn btn-success btn-sm" onclick="stripePay(event)" value="Pay Now" />
							</div>
							<br>
						</div>
						<div class="col-md-4">
							<h4 align="center">Order Details</h4>
							<div class="table-responsive" id="order_table">
								<table class="table table-bordered table-striped">
									<tbody>
										<tr>  
											<th>Product Name</th>  
											<th>Quantity</th>  
											<th>Price</th>  
											<th>Total</th>  
										</tr>
										<tr>
											<td><strong>Natal chart reading</strong></td>
											<td>1</td>
											<td align="right">$100.00</td>
											<td align="right">$100.00</td>
										</tr>
										<tr>  
											<td colspan="3" align="right">Total</td>  
											<td align="right"><strong>$100.00</strong></td>
										</tr>
									</tbody>
								</table>									
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>			
	</div>		
</div>
<?php include('include/footer.php'); ?>

