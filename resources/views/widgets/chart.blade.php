<!doctype html>
<html>
  <head>
  <title>Bar Chart</title>
  <script src="http://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>
  <script src="http://www.chartjs.org/samples/latest/utils.js"></script>
  <style>
  canvas {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
  </style>
  </head>
  <body>
  <h2>Statistiques</h2>
    <div id="container" style="width: 75%;">
    <canvas id="canvas"></canvas>
    </div>
    
    <script>
    <?php
    use App\Models\Don;
    use App\Models\User;
    use App\Models\demande;
    $month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aout', 'Sep', 'Oct', 'Nov', 'Dec');
    $dons = Don::select(\DB::raw("COUNT(*) as count"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(\DB::raw("Month(created_at)"))
                ->pluck('count');

    $users  = User::select(\DB::raw("COUNT(*) as count"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(\DB::raw("Month(created_at)"))
                ->pluck('count');
    $demandes  = demande::select(\DB::raw("COUNT(*) as count"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(\DB::raw("Month(created_at)"))
                ->pluck('count');
    ?>
    var chartdata = {
    type: 'bar',
    data: {
    labels: <?php echo json_encode($month); ?>,
    datasets: [
    
    {
    label: 'Demandes',
    backgroundColor: '#80ffff',
    borderWidth: 1,
    data: <?php echo json_encode($demandes); ?>
    },
    {
    label: 'Dons',
    backgroundColor: '#ff9999',
    borderWidth: 1,
    data: <?php echo json_encode($dons); ?>
    },
    {
    label: 'Users',
    backgroundColor: '#26B99A',
    borderWidth: 1,
    data: <?php echo json_encode($users); ?>
    }
    ]
    },
    options: {
    scales: {
    yAxes: [{
    ticks: {
    beginAtZero:true
    }
    }]
    }
    }
    }
    var ctx = document.getElementById('canvas').getContext('2d');
    new Chart(ctx, chartdata);
    </script>
  </body>
</html>