<section class="section">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-1">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="text-white fa-solid fa-money-bill-trend-up"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>KAS</h4>
                    </div>
                    <div class="card-body">
                        Rp. <?= number_format($saldokasbank[0]->kaskecil) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-1">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="text-white fa-solid fa-building-columns"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>BANK</h4>
                    </div>
                    <div class="card-body">
                    Rp. <?= number_format($saldokasbank[0]->bri + $saldokasbank[0]->mandiri) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-1">
                <div class="card-icon shadow-primary bg-primary">
                <i class="text-white fa-solid fa-money-bill-transfer"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>TOTAL SALDO</h4>
                    </div>
                    <div class="card-body">
                    Rp. <?= number_format(($saldokasbank[0]->bri + $saldokasbank[0]->mandiri) + $saldokasbank[0]->kaskecil) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Statistics</h4>
                    <div class="card-header-action">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary">Month</a>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart2" height="182"></canvas>
                    <div class="statistic-details mt-sm-4">
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
                        <div class="detail-value"><?= number_format($pemasukan_bulanan); ?></div>
                        <div class="detail-name">Today's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
                        <div class="detail-value"><?= number_format($pengeluaran_bulanan); ?></div>
                        <div class="detail-name">This Week's Sales</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-statistic-2 pb-4">
                <div class="card-stats">
                    <div class="card-stats-title">
                        <div>Total Mitra Binaan</div>
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count"><?= $countMitraNormal ?></div>
                            <div class="card-stats-item-label">Normal</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count"><?= $countMitraBermasalah ?></div>
                            <div class="card-stats-item-label">Masalah</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count"><?= $countMitraWo ?></div>
                            <div class="card-stats-item-label">Wipe Out</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap mb-3">
                    <div class="card-header">
                        <h4>Total Mitra</h4>
                    </div>
                    <div class="card-body">
                        <?= $countMitra ?>
                    </div>
                </div>
            </div>
            <div class="card card-statistic-2 pb-4">
                <div class="card-stats">
                    <div class="card-stats-title">
                        <div>Statistik Mitra Binaan</div>
                    </div>
                </div> 
                <div class="card-wrap">
                    <div id="piechart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Sebaran Mitra</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div id="myMap" style="position:relative;width:100%;min-width:290px;height:600px;"></div>
                            <div id="legend">Population Density<br/>(people/mi<sup>2</sup>)<br/></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Invoices</h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tr>
                                <th>Invoice ID</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><a href="#">INV-87239</a></td>
                                <td class="font-weight-600">Kusnadi</td>
                                <td>
                                    <div class="badge badge-warning">Unpaid</div>
                                </td>
                                <td>July 19, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">INV-48574</a></td>
                                <td class="font-weight-600">Hasan Basri</td>
                                <td>
                                    <div class="badge badge-success">Paid</div>
                                </td>
                                <td>July 21, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">INV-76824</a></td>
                                <td class="font-weight-600">Muhamad Nuruzzaki</td>
                                <td>
                                    <div class="badge badge-warning">Unpaid</div>
                                </td>
                                <td>July 22, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">INV-84990</a></td>
                                <td class="font-weight-600">Agung Ardiansyah</td>
                                <td>
                                    <div class="badge badge-warning">Unpaid</div>
                                </td>
                                <td>July 22, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">INV-87320</a></td>
                                <td class="font-weight-600">Ardian Rahardiansyah</td>
                                <td>
                                    <div class="badge badge-success">Paid</div>
                                </td>
                                <td>July 28, 2018</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-hero">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="far fa-question-circle"></i>
                    </div>
                    <h4>14</h4>
                    <div class="card-description">Customers need help</div>
                </div>
                <div class="card-body p-0">
                    <div class="tickets-list">
                        <a href="#" class="ticket-item">
                            <div class="ticket-title">
                                <h4>My order hasn't arrived yet</h4>
                            </div>
                            <div class="ticket-info">
                                <div>Laila Tazkiah</div>
                                <div class="bullet"></div>
                                <div class="text-primary">1 min ago</div>
                            </div>
                        </a>
                        <a href="#" class="ticket-item">
                            <div class="ticket-title">
                                <h4>Please cancel my order</h4>
                            </div>
                            <div class="ticket-info">
                                <div>Rizal Fakhri</div>
                                <div class="bullet"></div>
                                <div>2 hours ago</div>
                            </div>
                        </a>
                        <a href="#" class="ticket-item">
                            <div class="ticket-title">
                                <h4>Do you see my mother?</h4>
                            </div>
                            <div class="ticket-info">
                                <div>Syahdan Ubaidillah</div>
                                <div class="bullet"></div>
                                <div>6 hours ago</div>
                            </div>
                        </a>
                        <a href="features-tickets.html" class="ticket-item ticket-more">
                            View All <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
        var map, datasource, popup, maxValue = 500;

        var defaultColor = '#FFEDA0';
        var colorScale = [
            10, '#FED976',
            20, '#FEB24C',
            50, '#FD8D3C',
            100, '#FC4E2A',
            200, '#E31A1C',
            500, '#BD0026',
            1000, '#800026'
        ];

        function GetMap() {
            //Initialize a map instance.
            map = new atlas.Map('myMap', {
                center: [113.921327, -0.789275],
                zoom: 4,
                view: 'Auto',

                //Add authentication details for connecting to Azure Maps.
                authOptions: {
                    authType: 'subscriptionKey',
                    subscriptionKey: 'ylzPmj9lHIt7A20IJs9JoUzOSrEwD34Q71HdkD47wJA'
                }
            });

            //Create a legend.
            createLegend();

            //Wait until the map resources are ready.
            map.events.add('ready', function () {
                //Create a popup but leave it closed so we can update it and display it later.
                popup = new atlas.Popup({
                    position: [0, 0]
                });

                //Create a data source and add it to the map.
                datasource = new atlas.source.DataSource();
                map.sources.add(datasource);

                //Create a stepped expression based on the color scale. 
                var steppedExp = [
                    'step',
                    ['get', 'density'],
                    defaultColor
                ];

                steppedExp = steppedExp.concat(colorScale);
                
                //Create a layer to render the polygon data.
                var polygonLayer = new atlas.layer.PolygonLayer(datasource, null, {
                    fillColor: steppedExp
                });
                map.layers.add(polygonLayer, 'labels');

                //Add a mouse move event to the polygon layer to show a popup with information.
                map.events.add('mousemove', polygonLayer, function (e) {
                    if (e.shapes && e.shapes.length > 0) {
                        var properties = e.shapes[0].getProperties();

                        //Update the content of the popup.
                        popup.setOptions({
                            content: '<div style="padding:10px"><b>' + properties.name + '</b><br/>Population Density: ' + properties.density + ' people/mi<sup>2</sup></div>',
                            position: e.position
                        });

                        //Open the popup.
                        popup.open(map);
                    }
                });

                //Add a mouse leave event to the polygon layer to hide the popup.
                map.events.add('mouseleave', polygonLayer, function (e) {
                    popup.close();
                });

                //Download a GeoJSON feed and add the data to the data source.
                datasource.importDataFromUrl('/data/geojson/US_States_Population_Density.json');
            });
        }

        function createLegend() {
            var html = [];

            html.push('<i style="background:', defaultColor, '"></i> 0-', colorScale[0], '<br/>');

            for (var i = 0; i < colorScale.length; i += 2) {
                html.push(
                    '<i style="background:', (colorScale[i + 1]), '"></i> ',
                    colorScale[i], (colorScale[i + 2] ? '&ndash;' + colorScale[i + 2] + '<br/>' : '+')
                );
            }

            document.getElementById('legend').innerHTML += html.join('');
        }
    </script>
    <style>
        #legend {
            position: absolute;
            top: 5px;
            left: 5px;
            font-family: Arial;
            font-size: 12px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            padding: 5px;
            line-height:18px;
        }

        #legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
    </style>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
