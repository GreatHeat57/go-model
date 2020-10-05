$(document).ready(function(){
    
    // current time zone by user country
	$('#timezone_name').val($(".timezone_list option:selected").text());
});

// change event timezone list
$('.timezone_list').on('change', function(){
        
    $('#timezone_name').val($(".timezone_list option:selected").text());
});
function getTimeZone(){
        
    if($("#countryid option:selected").val() != ''){
		
		var formData = 'country_code='+$("#countryid option:selected").val();
        var url = siteUrl+"/getTimeZoneAjaxCall";
        var timezoneSelected =  $(".selected_timezone").val();
        
        if($("#countryid option:selected").val() != ''){

            $.ajax({
                method: "get",
                url: url,
                data: formData,
                beforeSend: function(){
		            $(".loading-process").show();
		        },
		        complete: function(){
		            $(".loading-process").hide();
		        },
                success: function (data) {

                	if(data.status == true){
                        
                        $('.timezone_list').html('');
                        var timezoneListSelect =  $(".timezone_list");

                        if(data.timezone != undefined && data.timezone != null){
                            
                            timezoneListSelect.empty();
                            
                            $.each(data.timezone, function (key, val) {

                                // check selected timezone Selected value
                                if(timezoneSelected != '' && timezoneSelected == key){
                                    
                                    timezoneListSelect.append($("<option selected></option>").attr("value", key).text(val));
                                }else{
                                    timezoneListSelect.append($("<option></option>").attr("value", key).text(val));
                                }
                            });

                            $('#timezone_name').val($(".timezone_list option:selected").text());
						}
                    }
                }, error: function (a, b, c) {
                    console.log('error');
                }
            });
        }
    }
}