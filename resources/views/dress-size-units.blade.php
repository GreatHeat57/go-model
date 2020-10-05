<!DOCTYPE html>
<html>
<head>
	<title>Dress Size Unit Measurment</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<body>

	<div style="padding: 10px;"></div>
<center>
<h1>Dress Size Unit Measurment</h1>

<?php
	$select_cat = (isset($selected_category))? $selected_category : '';
	$select_gender = (isset($selected_gender))? $selected_gender : '';
	if(isset($title)){
		echo "<h2>".$title."</h2>";
	}

?>


<form style="padding: 10px;" action="/dress-size-units" method="post">
	<label for="Gender" class="control-label required input-label position-relative">Model Category*:</label>
	<select name="category" id="category" class="form-control" required="required">
	    <option value="">Select a category</option>
	    <option value="1" <?php if ($select_cat == 1 ) echo 'selected' ; ?> >50plus Model</option>
	    <option value="2" <?php if ($select_cat == 2 ) echo 'selected' ; ?> >Baby Model</option>
	    <option value="3" <?php if ($select_cat == 3 ) echo 'selected' ; ?> >Fitness Model</option>
	    <option value="4" <?php if ($select_cat == 4 ) echo 'selected' ; ?> >Kids Model</option>
	    <option value="5" <?php if ($select_cat == 5 ) echo 'selected' ; ?> >Model</option>
	    <option value="6" <?php if ($select_cat == 6 ) echo 'selected' ; ?> >Plus Size Model</option>
	</select>

	<div style="padding: 10px;"></div>

	<label for="Gender" class="control-label required input-label position-relative">Gender:</label>
	<input class="radio_field" id="Male" name="gender" type="radio" value="1">
	<label for="Male" class="d-inline-block radio-label col-sm-6">Male</label>
    <input class="radio_field" id="Female" name="gender" type="radio" value="2">
	<label for="Female" class="d-inline-block radio-label col-sm-6">Female</label>

	<!-- <div style="padding: 10px;"></div> -->

	<!-- <select id="country" name="country" required="required" >
        <option value=""> Select a country </option>
        <option value="at">Austria</option>
        <option value="uk">United Kingdom</option>
        <option value="us">United States</option>
    </select> -->

    <div style="padding: 10px;"></div>

    <input type="submit" name="submit" value="SUBMIT">
</form>

<div style="padding: 10px;">

	<?php

		if(isset($result)){
			
			if(!empty($result) && $result->count() > 0){

				?>
				<table border="1" cellspacing="3px" cellpadding="10px">
					<tr>
						@foreach($tableKey as $key => $label)
						 	<th style="text-align: center;"> {{ $label }}</th>
						@endforeach
					</tr>
				
					<?php  
						
						$key1 = $valueKey[0];
						$key2 = $valueKey[1];
						$key3 = $valueKey[2];
					?>
				
					@foreach($result as $key => $value)
						<tr>
							<td style="text-align: center;">{{ $value->$key1 }}</td>
							<td style="text-align: center;">{{ $value->$key2 }}</td>
							<td style="text-align: center;">{{ $value->$key3 }}</td>
						</tr>
				 	@endforeach
				</table>
				<?php
			}
		} 
	?>
</div>
<br /><br /><br /><br /><br /><br /><br /><br />
</center>
<script>
	$(document).ready( function(){
		check_gender();

		$('#category').on('change', function(){
			check_gender();
		});
	});

	function check_gender(){
			var select_val = $('#category').val();

			if(select_val != undefined && select_val != null){

				if(select_val != 2 && select_val != 4){
					$('#Male').attr('required','required');
					$('#Female').attr('required','required');	
				}else{
					$('#Male').attr('required',false);
					$('#Female').attr('required',false);	
				}
				
			}
	}
</script>
</body>
</html>

