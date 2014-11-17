<!DOCTYPE HTML>
<html>
<head>
    <title>HTML5 Hello World</title>
    <meta charset="utf-8" http-equiv="encoding">
    <!-- link to css -->
    <link href="style/main.css" rel="stylesheet" type="text/css"/>
    <!-- link to d3.js -->
    <script src="d3/d3.min.js"></script>
    <!-- link to d3 tooltip.js -->
    <script src="d3/tooltip.js"></script>
</head>
<body>
    <?php
        //adding the ims-blti-library
        require_once('./ims-blti/blti.php');

        //storing key and secret
        $CLIENT_ID = 'key';
        $CLIENT_SECRET = 'secret';
        
        //check if it is from canvas
        if($_REQUEST['lti_message_type'] == 'basic-lti-launch-request'){
            echo "coming from Canvas";
        }else{
            echo "not coming from Canvas";
            //exit;
        }

        //try if key is matching
        if($CLIENT_ID === $_POST['oauth_consumer_key']){
            $CONTEXT = new BLTI($CLIENT_SECRET, false, false);
        }else{
            echo "key is wrong";
            //exit;
        }
        
        //try if there is proper oAuth signature
        if(!$CONTEXT->valid){
            echo "YOU DON'T BELONG HERE!";
            //exit;
        }

        //grabbing the datas
        $USER = $_POST['lis_person_name_full'];

        echo '<h1>';
            echo 'hello '.$USER;
        echo '</h1>';
    ?>
    
    <h3>Top 5 Students</h3>
    <svg class="chart"></svg>
    
    <script>
        //this is javascript
        var data = [
            {name: "sanam", value: 2},
            {name: "henry", value: 23},
            {name: "marek", value: 29},
            {name: "alisher", value: 31},
            {name: "robertas", value: 37},
            {name: "jamaal", value: 3},
            {name: "marc", value: 11},
            {name: "jock", value: 7},
            {name: "thomas", value: 13},
            {name: "riaz", value: 17},
            {name: "giorgino", value: 5},
            {name: "leonard", value: 19}
        ];
        
        var width = 800, barHeight = 40;
        
        var x = d3.scale.linear()
                    .domain([0, d3.max(data, function(d) { return d.value; })])
                    .range([0, width]);
        
        var tip = d3.tip()
                    .attr('class', 'd3-tip')
                    .offset([-10, 0])
                    .html(function(d){
                        return "<strong>Post:</strong> <span style='color:red'>" +
                            d.value + "</span>";
                    })
        
        var chart = d3.select(".chart")
                        .attr("width", width)
                        .attr("height", barHeight * data.length)
        
        chart.call(tip);
        
        var bar = chart.selectAll("g")
                        .data(data)
                        .enter().append("g")
                                .attr("transform", function(d, i) { return "translate(0,"  + i * barHeight + ")"; });
        
        chart.append("text")
            .attr("x", 80)             
            .attr("y", -80)
            .attr("text-anchor", "start")  
            .style("font-size", "16px") 
            .style("text-decoration", "underline")  
            .text("Top 5 Students");
        
        bar.append("rect")
            .attr("x", 90)
            .attr("width", function(d) { return x(d.value);})
            .attr("height", barHeight * 0.95)
            .on('mouseover', tip.show)
            .on('mouseout', tip.hide)
        
        bar.append("text")
            .attr("x", 80)
            .attr("y", barHeight /2)
            .attr("dy", "1em")
            .text(function(d) { return d.name; });
    
    </script>
</body>
</html>