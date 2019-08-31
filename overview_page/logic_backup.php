        <?php 
            foreach($data as $pow){
                $idn=$pow['projectid'];
        ?>
            <div id="timelineLimiter"> <!-- Hides the overflowing timelineScroll div -->
            <br>
            <div align="center" sytle="margin: 0px 0px auto;"><h1><b><?php echo "project".$pow['projectid']; ?></b></h1></div>
            <div id="horizontal_scroll" style="overflow:auto;width:1690px; height:210px; overflow-x:scroll; overflow-y:hidden;">
            <div id="timelineScroll"  class="faltu"> <!-- Contains the timeline and expands to fit -->
                <?php
                // We first select all the events from the database ordered by date:
                $dates = array();
                $query2="SELECT * FROM timeline WHERE projectid=$idn";
                $res=mysqli_query($conn,$query2);
               // $res = mysql_query("SELECT * FROM timeline ORDER BY Date ASC");

                while($row=mysqli_fetch_assoc($res))
                {
                    // Store the events in an array, grouped by years:
                    $dates[date('M/Y',strtotime($row['Date']))][] = $row;
                }

                $colors = array('green','blue','chreme');
                $scrollPoints = '';

                $i=0;
                foreach($dates as $year=>$array)
                {
                    // Loop through the years:
                    echo '
                    <div class="event">
                        <div class="eventHeading '.$colors[$i++%3].'">'.$year.'</div>
                        <ul class="eventList">
                        ';
                    ?>
                        <div class="vertical_scroll" id="vertical_scroll" style="width:310px; height:138px; overflow: auto;">
                        <?php
                    foreach($array as $event)
                    {
                        // Loop through the events in the current year:
                        $tet= $event['type'];
                        if($tet=="Activity"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/975/975392.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                        }
                        elseif($tet=="Meeting"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/584/584504.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
  
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                            
                        }else{

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/1021/1021081.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';    
                        }   
                    }
                    ?>
                        </div>
                    <?php
                    echo '</ul></div>';   
                }
                ?>
                <br>
        <div class="clear"></div>
            </div>
            <br>
            </div>
    </div>
        <?php
            }
        ?>