<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
      var botmanWidget = {
        title: 'Info Covid Bot',
        introMessage: 'Silakan ketik info untuk mendapatkan informasi covid19 di Indonesia' ,
        aboutText: 'Powered by enterkode.com',
        bubbleBackground: '#f8bbd0'
      };
      </script>
      
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyAJROQSvze7U2nS5huwFffktxCmJbBzII0'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);
      var provinces = {!! json_encode($provincesData) !!};
      var provinceData =[];

      for (let i = 0; i < provinces.length; i++) {
        provinceData.push([{v: provinces[i].code, f: provinces[i].name}, provinces[i].total_cases])
      }

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Province', 'Total Kasus Positif'],

          [{v: provinces[0].code, f: provinces[0].name}, provinces[0].total_cases],
          [{v: provinces[1].code, f: provinces[1].name}, provinces[1].total_cases],
          [{v: provinces[2].code, f: provinces[2].name}, provinces[2].total_cases],
          [{v: provinces[3].code, f: provinces[3].name}, provinces[3].total_cases],
          [{v: provinces[4].code, f: provinces[4].name}, provinces[4].total_cases],
          [{v: provinces[5].code, f: provinces[5].name}, provinces[5].total_cases],
          [{v: provinces[6].code, f: provinces[6].name}, provinces[6].total_cases],
          [{v: provinces[7].code, f: provinces[7].name}, provinces[7].total_cases],
          [{v: provinces[8].code, f: provinces[8].name}, provinces[8].total_cases],
          [{v: provinces[9].code, f: provinces[9].name}, provinces[9].total_cases],
          [{v: provinces[10].code, f: provinces[10].name}, provinces[10].total_cases],
          [{v: provinces[11].code, f: provinces[11].name}, provinces[11].total_cases],
          [{v: provinces[12].code, f: provinces[12].name}, provinces[12].total_cases],
          [{v: provinces[13].code, f: provinces[13].name}, provinces[13].total_cases],
          [{v: provinces[14].code, f: provinces[14].name}, provinces[14].total_cases],
          [{v: provinces[15].code, f: provinces[15].name}, provinces[15].total_cases],
          [{v: provinces[16].code, f: provinces[16].name}, provinces[16].total_cases],
          [{v: provinces[17].code, f: provinces[17].name}, provinces[17].total_cases],
          [{v: provinces[18].code, f: provinces[18].name}, provinces[18].total_cases],
          [{v: provinces[19].code, f: provinces[19].name}, provinces[19].total_cases],
          [{v: provinces[20].code, f: provinces[20].name}, provinces[20].total_cases],
          [{v: provinces[21].code, f: provinces[21].name}, provinces[21].total_cases],
          [{v: provinces[22].code, f: provinces[22].name}, provinces[22].total_cases],
          [{v: provinces[23].code, f: provinces[23].name}, provinces[23].total_cases],
          [{v: provinces[24].code, f: provinces[24].name}, provinces[24].total_cases],
          [{v: provinces[25].code, f: provinces[25].name}, provinces[25].total_cases],
          [{v: provinces[26].code, f: provinces[26].name}, provinces[26].total_cases],
          [{v: provinces[27].code, f: provinces[27].name}, provinces[27].total_cases],
          [{v: provinces[28].code, f: provinces[28].name}, provinces[28].total_cases],
          [{v: provinces[29].code, f: provinces[29].name}, provinces[29].total_cases],
          [{v: provinces[30].code, f: provinces[30].name}, provinces[30].total_cases],
          [{v: provinces[31].code, f: provinces[31].name}, provinces[31].total_cases],
          [{v: provinces[32].code, f: provinces[32].name}, provinces[32].total_cases],
          [{v: provinces[33].code, f: provinces[33].name}, provinces[33].total_cases],
          [{v: provinces[34].code, f: provinces[34].name}, provinces[34].total_cases]
        ]);

        var options = {
          region:'ID',
          resolution:'provinces',
          colorAxis: {
            minValue: 0,
            maxValue: provinces[0].total_cases,
            colors: ['#f8bbd0', 'green', 'black']
          },

          // backgroundColor: '#81d4fa',
          // datalessRegionColor: '#f8bbd0',
          defaultColor: '#f5f5f5',
        };

        var chart = new google.visualization.GeoChart(document.getElementById('graph'));

        chart.draw(data, options);
      }
    </script>
    <title>Indonesia Covid Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        body {
            font-family: "Varela Round", sans-serif;
            margin: 0;
            padding: 0;
            background: radial-gradient(#57bfc7, #45a6b3);
        }

        .container-graph {
            display: flex;
            /* height: 100vh; */
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }

        .content {
            text-align: center;
        }

        .graph {
            margin-right: 40px;
            margin-bottom: 40px;
        }

        .links a {
            /* font-size: 1.25rem; */
            text-decoration: none;
            color: white;
            margin: 10px;
        }

        @media all and (max-width: 500px) {
            .links {
                display: flex;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    {{-- <a class="navbar-brand" href="#">Info Covid</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> --}}
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://t.me/indocovidBot">TelegramBot <i class="fa fa-telegram" aria-hidden="true"></i></a>
          
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://github.com/satriyop/covid-19-telegram-bot/"">Source Code <i class="fa fa-github" aria-hidden="true"></i></a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" href="/reports/national/refresh">Refresh ({{ $nationalData->id }}) - {{ $nationalData->created_at }}</a>
      </li>
      </ul>
    </div>
  </nav>

<div class="container-graph">
    <div class="content">
        <div id="graph" style="width: 900px; height: 500px;"></div>
        <div class="links">
            {{-- <a href="/botman/tinker">Chat Bot</a>
            <a href="/reports/national/refresh" >Refresh Data</a>
            <a href="https://github.com/satriyop/covid-19-telegram-bot/" target="_blank">Source Code</a> --}}
        </div>
    </div>
</div>
</body>
</html>