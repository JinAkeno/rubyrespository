<html>
 <head>
  <title>PHP Test</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <script>
  var array_result = new Array();
  var options='';
  var count=0;
   var temp_array;
  $( document ).ready(function(){
<?php
      //Read Data from CSV files and convert it to string_array
        $row = 1;
  
        if (($handle = fopen("laposte_hexasmal.csv", "r")) !== FALSE) {
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                
                $num = count($data);
                $row++;
                for ($c=0; $c < $num; $c++) {
                    
                    if($data[$c]==";;;;")
                        continue;
                    
                    //Data Standardization
                    $temp_arr=explode(";",$data[$c]);
                
                    ?>

                    //Get the List of Matching City

                    var temp = new Object();
                    temp["value"]="<?php echo $temp_arr[1] ?>";
                    temp["key"]="<?php echo $temp_arr[2] ?>";
                    array_result.push(temp);
                    temp_array=array_result;
                    options += '<option value="'+temp["key"]+'">';
                    <?php

                     }
            }
            ?>
          
            
            document.getElementById("languages").innerHTML=options;
            <?php
            fclose($handle);
        }

  ?>

     $("#postcode").on('input', function () {
     // alert(this.value);
     if(this.value.length>3)
     {
    
      var select1 = document.getElementById("city_list");
        select1.parentNode.removeChild(select1);
        var select = document.createElement('select');
        select.id="city_list";
        select.width="96%";
        select.multiple="multiple"
      
      var new_array = array_result.filter(function(el){
          
                return el.key.substring(0,$("#postcode").val().length) === $("#postcode").val();
                });
      for(var i=0; i<new_array.length; i++)
      {
          var option = document.createElement('option');
          option.text= array_result[i].value;
          select.add(option, 0);
      }
      var div=document.getElementById("city_view");
          div.appendChild(select);
    }
    });
    
  });
  function display()
  {
      var select = document.getElementById('city_list');
      var options = select.options;
      var selected = select.options[select.selectedIndex];
      $("#content").val("PostalCode:" +$("#postcode").val()+"\nCity:" +selected.value);
  }
  </script>
 </head>
 <body>
      
      <div class="formholder">
        <div class="randompad">
           <fieldset>
            <input id="postcode" type="text"  list="languages">
            <datalist id="languages" onClick="display()"></datalist>
            <div id="city_view">
                <label name="City">Suggested City:</label>
                <select id="city_list" name="sometext" multiple="multiple">
                </select>
            </div>          
             <input type="submit" onClick="display()" value="Select" />
           </fieldset>
        </div>
        <label name="City">City</label>
        <textarea  id="content" type="text" /></textarea>
      </div>

 </body>
</html>