$(function ($)
{
    var month = {
        "number": ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
        "short": ["Jän", "Feb", "März", "Apr", "Mai", "Juni", "Juli", "Aug", "Sept", "Okt", "Nov", "Dez"],
        "long": ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"]
    },
    today = new Date(), 
    todayYear = today.getFullYear(),
    todayMonth = today.getMonth() + 1,
    todayDay = today.getDate();
    updateTheBirthDayValue = function(options, $selector, selectedYear, selectedMonth, selectedDay) {
      if ((selectedYear * selectedMonth * selectedDay) != 0) {
        if (selectedMonth<10) selectedMonth="0"+selectedMonth;
        if (selectedDay<10) selectedDay="0"+selectedDay;
        hiddenDate = selectedYear + "-" + selectedMonth + "-" + selectedDay;
        $selector.val(hiddenDate);

        if (options.callback) {
          options.callback(hiddenDate);
        }
      }
    }
    generateBirthdayPicker = function ($parent, options) 
    {
        var parentId = $parent.attr('id').replace(/-/g, '');
        var label = $parent.attr('data-label'); 
        
        // append birth day label
        $('#'+parentId).append("<div class='col-md-12'><label for='birthday' class='position-relative control-label required input-label'>"+label+"</label></div>");
        // append input-group div 
        var $day_input =  $('#'+parentId).append("<div class='col-4'><div class='md-form input-group "+parentId+"_day_input' id='"+parentId+"_birth_day'></div></div>");
        var $month_input = $('#'+parentId).append("<div class='col-4'><div class='md-form input-group "+parentId+"_month_input' id='"+parentId+"_birth_month'></div></div>");
        var $year_input = $('#'+parentId).append("<div class='col-4'><div class='md-form input-group "+parentId+"_year_input' id='"+parentId+"_birth_year'></div></div>");
        var $error_msg_div = "<div class='form-input-error-msg'><span class='fa fa-exclamation-circle'></span>Dieses Feld wird benötigt!</div>";
        $('#'+parentId).append($day_input).append($month_input).append($year_input);
          
          // Create the html picker skeleton
          var $fieldset = $("<fieldset class='birthdayPicker'></fieldset>"),
          $year = $("<select class='validate birthYear "+options.sizeClass+"' name='"+parentId+"_birth[year]'></select>"),
          $month = $("<select class='validate birthMonth "+options.sizeClass+"' name='"+parentId+"_birth[month]'></select>"),
          $day = $("<select class='validate birthDate "+options.sizeClass+"' name='"+parentId+"_birth[day]'></select>")
          $birthday = $("<input class='birthDay' name='"+parentId+"_birthDay' type='hidden'/>");

         // Add the option placeholders if specified
          if (options.placeholder) {
            $("<option class='not-option' value=''>Jahr</option>").appendTo($year);
            $("<option class='not-option' value=''>Monat</option>").appendTo($month);
            $("<option class='not-option' value=''>Tag</option>").appendTo($day);
          }
         // Deal with the various Date Formats
          if (options.dateFormat == "bigEndian") {
              $('.'+parentId+'_day_input').append($day).append($error_msg_div);
              $('.'+parentId+'_month_input').append($month).append($error_msg_div);
              $('.'+parentId+'_year_input').append($year).append($error_msg_div); 
            // $fieldset.append($year).append($month).append($day);
          } else if (options.dateFormat == "littleEndian") {
              $('.'+parentId+'_day_input').append($day).append($error_msg_div);
              $('.'+parentId+'_month_input').append($month).append($error_msg_div);
              $('.'+parentId+'_year_input').append($year).append($error_msg_div); 
            // $fieldset.append($day).append($month).append($year);
          } else {
            $('.'+parentId+'_day_input').append($day).append($error_msg_div);
            $('.'+parentId+'_month_input').append($month).append($error_msg_div);
            $('.'+parentId+'_year_input').append($year).append($error_msg_div);
            // $fieldset.append($month).append($day).append($year);
         }
         //calculate the year to add to the select options. 
         var yearBegin = todayYear - options.minAge; 
         var yearEnd = todayYear - options.maxAge;
         if (options.maxYear != todayYear && options.maxYear > todayYear) {
             yearBegin = options.maxYear; 
             yearEnd = yearEnd + (options.maxYear - todayYear)
         }
         for (var i = yearBegin; i >= yearEnd; i--) { 
             $("<option></option>").attr("value", i).text(i).appendTo($year); 
         }
         for (var i = 0; i <= 11; i++) {
             $("<option></option>").attr('value', i + 1).text(month[options.monthFormat][i]).appendTo($month);
         }
         for (var i = 1; i <= 31; i++) {
             var number = (i < 10) ? "0"+i: i;
             $("<option></option>").attr('value', i).text(number).appendTo($day);
         }

        // $($year).prepend("<div class='input-group'>");
        // $($year).append("</div>");
        $fieldset.append($birthday);
        $parent.append($fieldset); 
        
        // Set the default date if given
        if (options.defaultDate) {
            if($.type(options.defaultDate) !== "date"){
                /*
                 * There is no concept of a pure date in js, only absolute timestamps.
                 * A call to `new Date(value)` with a `value` of a string will attempt
                 * to parse a datetime from that string into an absolute and localised
                 * timestamp. Depending on the client locale this can result in the
                 * defaultDate being misrepresented. To counter for this we add the
                 * locale timezone offset.
                 */
                var date = new Date(options.defaultDate);
                date.setSeconds(date.getSeconds() + (date.getTimezoneOffset() * 60));
            }else{
                var date = options.defaultDate;
            }
            $year.val(date.getFullYear());
            $month.val(date.getMonth() + 1);
            $day.val(date.getDate());
            updateTheBirthDayValue(options, $birthday, date.getFullYear(), date.getMonth() + 1, date.getDate());
        }
        // $fieldset.on('change', function ()
        $parent.on('change', function () 
        {   
            $birthday = $(this).find('.birthDay');
            // currently selected values
            selectedYear = parseInt($year.val(), 10),
            selectedMonth = parseInt($month.val(), 10),
            selectedDay = parseInt($day.val(), 10);

            //rebuild the index for the month. 
            var currentMaxMonth = $month.children(":last").val();
            if (selectedYear > todayYear) {
                if (currentMaxMonth > todayMonth) {
                    while (currentMaxMonth > todayMonth) {
                        $month.children(":last").remove();
                        currentMaxMonth--;
                    }
                } 
            } else {
                while (currentMaxMonth < 12) {
                    $("<option></option>").attr('value', parseInt(currentMaxMonth)+1).text(month[options.monthFormat][currentMaxMonth]).appendTo($month);
                    currentMaxMonth++;
                }
            }

            var currentMaxDate = $day.children(":last").val(); 
            // number of days in currently selected year/month
            var actMaxDay = (new Date(selectedYear, selectedMonth, 0)).getDate();
            if (currentMaxDate > actMaxDay) {
                while (currentMaxDate > actMaxDay) {
                    $day.children(":last").remove(); 
                    currentMaxDate--;
                }
            } else if (currentMaxDate < actMaxDay ) {
                while (currentMaxDate < actMaxDay) 
                {
                    var dateIndex = parseInt(currentMaxDate) + 1; 
                    var number = (dateIndex < 10) ? "0"+dateIndex: dateIndex;
                     $("<option></option>").attr('value', dateIndex).text(number).appendTo($day);
                    currentMaxDate++;
                }
            }
            // update the hidden date
            updateTheBirthDayValue(options, $birthday, selectedYear, selectedMonth, selectedDay);
        });
    }

    $.fn.birthdayPicker = function(options) 
    {
        return this.each(function () {
            var settings = $.extend($.fn.birthdayPicker.defaults, options );
            generateBirthdayPicker($(this), settings);
        });
    };

    $.fn.birthdayPicker.defaults = {
        "maxAge"        : 100,
          "minAge"        : 0,
          "maxYear"       : todayYear,
          "dateFormat"    : "middleEndian",
          "monthFormat"   : "number",
          "placeholder"   : true,
          "defaultDate"   : false,
          "sizeClass"        : "span2",
        'callback': false
    }
}( jQuery ))

