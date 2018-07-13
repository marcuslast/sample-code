# samurai-sports.com/teamwear

# THIS PROJECT IS NOT YET COMPLETE

https://www.samurai-sports.com/teamwear/?bypass=cutting-edge 
New Samurai Sports Website
You must access using the above link

https://www.samurai-sports.com/teamwear/multisport/ - Mosiac Grid with hover effects

https://www.samurai-sports.com/teamwear/contact-us/ - ** 1 ** Javascript Postcode finder created by myself

https://www.samurai-sports.com/teamwear/technical-hub/ - HTML, CSS3, and Bootstrap 4 custom template page

Javascript/jQuery example:

** 1 **

$("#livepostcodesearch").keydown(function(){
         var val = $("#livepostcodesearch").val();
          if(val.length < 4){
              
              val = val.toUpperCase();
              
                  // LIST OF ALL POSTODES IN THE UNITED KINGDOM 
                  
                  var scotland =     ['AB','DD','DG','EH','FK','G','HS','IV','KA','KW','KY','ML','PA','PH','TD'];
                  var north    =     ['BB','BD','BL','CA','CH','CW','DE','DH','DL','DN','FY','HD','HG','HU','HX','L','LA','LL','LN','LS','M','NE','NG','OL','PR','S','SK','SR','TS','WA','WF','WN','YO'];
                  var east     =     ['AL','CB','CM','CO','EN','IG','IP','LE','LU','MK','NN','NR','PE','SG','SS','WD'];
                  var west     =     ['B','BA','BS','CF','CV','DT','DY','EX','GL','HR','LD','NP','PL','SA','SN','SY','TA','TQ','TR','WR','WS','WV'];
                  var southcentral = ['BH','BN','BR','CR','CT','DA','E','EC','GU','HA','HP','KT','ME','N','NW','OX','PO','RG','RH','RM','SE','SL','SM','SO','SP','SW','TN','TW','UB','W','WC'];
                  
                  var region_scotland = (scotland.indexOf(val) > -1);
                  var region_north    = (north.indexOf(val) > -1);
                  var region_east = (east.indexOf(val) > -1);
                  var region_west = (west.indexOf(val) > -1);
                  var region_southcentral = (southcentral.indexOf(val) > -1);
                  
                  var result;
                  
                             if(region_north){
                                 $('#postcoderesult p').html('<p class="your_local_rep">Contact us today for a quote</p><p class="postcoderesult_title">North</p></br><p class="postcoderesult_txt">Tel: +44 (0)1508 535295 </br> Email: <a href="mailto:north@samurai-sports.com" target="_top">north@samurai-sports.com</a></p>'); 
                            }
                             if(region_east){
                                $('#postcoderesult p').html('<p class="your_local_rep">Contact us today for a quote</p><p class="postcoderesult_title">South East</p></br><p class="postcoderesult_txt">Tel: +44 (0)1508 536462 </br> Email: <a href="mailto:southeast@samurai-sports.com" target="_top">southeast@samurai-sports.com</a></p>'); 
                            }
                            if(region_scotland){
                                $('#postcoderesult p').html('<p class="your_local_rep">Contact us today for a quote</p><p class="postcoderesult_title">Scotland</p></br><p class="postcoderesult_txt">Tel: +44 (0)1508 536295 </br> Email: <a href="mailto:scotland@samurai-sports.com" target="_top">scotland@samurai-sports.com</a></p>');                
                            }
                            if(region_west){
                                $('#postcoderesult p').html('<p class="your_local_rep">Contact us today for a quote</p><p class="postcoderesult_title">South West</p></br><p class="postcoderesult_txt">Tel: +44 (0)1508 535284 </br> Email: <a href="mailto:southwest@samurai-sports.com" target="_top">southwest@samurai-sports.com</a></p>'); 
                            }
                            if(region_southcentral){
                                $('#postcoderesult p').html('<p class="your_local_rep">Contact us today for a quote</p><p class="postcoderesult_title">South Central</p></br><p class="postcoderesult_txt">Tel: +44 (0)1508 535294 </br> Email: <a href="mailto:southcentral@samurai-sports.com" target="_top">southcentral@samurai-sports.com</a></p>'); 
                            }
                            if(val < 4){
                                 $('#postcoderesult p').text('Enter your postcode'); 
                            }   
          }        
       });
