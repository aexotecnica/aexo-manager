<?php echo form_open( "movimiento/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
<?php echo form_close(); ?>


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Partes', 'Cantidad'],
      ['Necesidad',     47],
      ['En Stock',      5],
    ]);

    var options = {
      title: 'My Daily Activities',
      pieHole: 0.4
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }
</script>
