<!-- Widgets -->
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">face</i>
            </div>
            <div class="content">
                <div class="text">TESTED</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $data->state['tested']; ?>" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon">
                <i class="material-icons">bug_report</i>
            </div>
            <div class="content">
                <div class="text">INFECTED</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $data->state['active']; ?>" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red hover-expand-effect">
            <div class="icon">
                <i class="material-icons">indeterminate_check_box</i>
            </div>
            <div class="content">
                <div class="text">DEAD</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $data->state['dead']; ?>" data-speed="15" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">security</i>
            </div>
            <div class="content">
                <div class="text">RECOVERED</div>
                <div class="number count-to" data-from="0" data-to="<?php echo $data->state['recovered']; ?>" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
</div>
<!-- Trend -->
<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>STATUS BY DATE</h2>
                    </div>
                    <div class="col-xs-12 col-sm-6 align-right">
                        <div class="switch panel-switch-btn">
                            <span class="m-r-10 font-12">CUMULATIVE</span>
                            <label>OFF<input type="checkbox" id="realtime" checked><span class="lever switch-col-cyan"></span>ON</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="body">
                <div id="real_time_chart" class="dashboard-flot-chart"><canvas id="real_time_chart_canvas"></canvas></div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <!-- Social -->
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <div class="card">
            <div class="body bg-pink">
                <div class="m-b--35 font-bold">/r/Coronavirus</div>
                <ul class="dashboard-stat-list" id="reddit_list">
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <div class="card">
            <div class="body bg-cyan">
                <div class="m-b--35 font-bold">#ostanidoma</div>
                <ul class="dashboard-stat-list" id="ostanidoma">
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <div class="card">
            <div class="body bg-teal">
                <div class="font-bold m-b--35">#CoronavirusCroatia</div>
                <ul class="dashboard-stat-list" id="CoronavirusCroatia">
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <!-- County Info -->
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <div class="card">
            <div class="header">
                <h2>STATUS BY COUNTY</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>County</th>
                                <th>Infected</th>
                                <th>Dead</th>
                                <th>Recovered</th>
                                <th>Deaths per case</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->county as $k => $v) { ?>
                                <tr>
                                    <td><?php echo $v['attributes']['ZUP_IME']; ?></td>
                                    <td><?php echo $v['attributes']['TRENUTNO_ZARAZENI']; ?></td>
                                    <td><?php echo $v['attributes']['UMRLI']; ?></td>
                                    <td><?php echo $v['attributes']['IZLIJECENI']; ?></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-red" role="progressbar" aria-valuenow="<?php echo (100 / $v['attributes']['SLUCAJEVI']) * ($v['attributes']['UMRLI'] * 5); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo (100 / $v['attributes']['SLUCAJEVI']) * ($v['attributes']['UMRLI'] * 5); ?>%">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAPHS -->
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <div class="card">
            <div class="header">
                <h2>STATUS PER CASE</h2>
            </div>
            <div class="body">
                <div id="donut_chart" class="dashboard-donut-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <div class="card">
            <div class="header">
                <h2>CASES PER COUNTY</h2>
            </div>
            <div class="body">
                <div id="donut_chart_2" class="dashboard-donut-chart"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function hexToRgb(hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    initDonutChart();

    function initDonutChart() {
        <?php $sum_cases = 0;
        foreach ($data->county as $k => $v) {
            $sum_cases += $v['attributes']['SLUCAJEVI'];
        }
        ?>
        <?php $cases = $data->state['active'] + $data->state['dead'] + $data->state['recovered']; ?>

        Morris.Donut({
            element: 'donut_chart',
            data: [{
                label: 'Infected',
                value: <?php echo number_format(100 / $cases * $data->state['active'], 2); ?>
            }, {
                label: 'Deaths',
                value: <?php echo number_format(100 / $cases * $data->state['dead'], 2); ?>
            }, {
                label: 'Recovered',
                value: <?php echo number_format(100 / $cases * $data->state['recovered'], 2); ?>
            }],
            colors: ['rgb(255, 165, 0)', 'rgb(255, 0, 80)', 'rgb(0, 255, 80)'],
            formatter: function(y) {
                return y + '%'
            }
        });
        if ($('#donut_chart_2').length > 0) {
            Morris.Donut({
                element: 'donut_chart_2',
                data: [
                    <?php foreach ($data->county as $k => $v) { ?> {
                            label: '<?php echo $v['attributes']['ZUP_IME']; ?>',
                            value: <?php echo number_format(100 / $sum_cases * $v['attributes']['SLUCAJEVI'], 2); ?>
                        },
                    <?php } ?>
                ],
                colors: [
                    'rgb(217, 33, 32)', 'rgb(225, 66, 38)', 'rgb(230, 100, 44)', 'rgb(231, 130, 50)', 'rgb(227, 154, 54)', 'rgb(219, 171, 59)', 'rgb(206, 182, 65)',
                    'rgb(190, 188, 72)', 'rgb(171, 190, 81)', 'rgb(151, 189, 93)', 'rgb(131, 186, 109)', 'rgb(114, 181, 130)', 'rgb(98, 172, 154)', 'rgb(85, 161, 178)',
                    'rgb(75, 145, 192)', 'rgb(68, 124, 191)', 'rgb(64, 99, 176)', 'rgb(63, 71, 156)', 'rgb(69, 45, 138)', 'rgb(83, 27, 127)', 'rgb(120, 80, 129)',
                ],
                formatter: function(y) {
                    return y + '%'
                }
            });
        }
    }

    var chartx = ""; //Initialize realtime chart

    $(document).ready(function() {
        chartx = new Chart(document.getElementById("real_time_chart_canvas").getContext("2d"), getChartJs("kumulativno"));
    });

    $('#realtime').on('change', function() {
        canvas = document.getElementById("real_time_chart_canvas");
        ctx = canvas.getContext("2d");

        // clear canvas
        if (chartx) {
            chartx.destroy();
        }

        let realtime = this.checked ? 'on' : 'off';

        if (realtime == 'on') {
            chartx = new Chart(ctx, getChartJs("kumulativno"));
        } else {
            chartx = new Chart(ctx, getChartJs("forma"));
        }
    });

    function timeConverter(timestamp) {
        let a = new Date(timestamp * 1000);
        let months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        let month = months[a.getMonth()];
        let date = a.getDate();
        let time = date + '.' + month + '.';
        return time;
    }

    function getChartJs(type) {
        let config = null;
        let labels = [];
        let infected = [];
        let dead = [];
        let recovered = [];

        if (type === "kumulativno") {
            labels = [
                <?php foreach ($data->cumulative['dates'] as $x) {
                    echo "'" . $x . "',";
                } ?>
            ];
            infected = [
                <?php foreach ($data->cumulative['infected'] as $x) {
                    echo $x . ",";
                } ?>
            ];
            dead = [
                <?php foreach ($data->cumulative['dead'] as $x) {
                    echo $x . ",";
                } ?>
            ];
            recovered = [
                <?php foreach ($data->cumulative['recovered'] as $x) {
                    echo $x . ",";
                } ?>
            ];
        } else {
            labels = [
                <?php foreach ($data->form['dates'] as $x) {
                    echo "'" . $x . "',";
                } ?>
            ];
            infected = [
                <?php foreach ($data->form['infected'] as $x) {
                    echo $x . ",";
                } ?>
            ];
            dead = [
                <?php foreach ($data->form['dead'] as $x) {
                    echo $x . ",";
                } ?>
            ];
            recovered = [
                <?php foreach ($data->form['recovered'] as $x) {
                    echo $x . ",";
                } ?>
            ];
        }

        config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Dead",
                    data: dead,
                    borderColor: 'rgba(233, 30, 99, 0.75)',
                    backgroundColor: 'rgba(233, 30, 99, 0.3)',
                    pointBorderColor: 'rgba(233, 30, 99, 0)',
                    pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                    pointBorderWidth: 1
                }, {
                    label: "Recovered",
                    data: recovered,
                    borderColor: 'rgba(255, 193, 7, 0.75)',
                    backgroundColor: 'rgba(255, 193, 7, 0.3)',
                    pointBorderColor: 'rgba(255, 193, 7, 0)',
                    pointBackgroundColor: 'rgba(255, 193, 7, 0.9)',
                    pointBorderWidth: 1
                }, {
                    label: "Infected",
                    data: infected,
                    borderColor: 'rgba(0, 188, 212, 0.75)',
                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                    pointBorderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: false
            }
        }

        return config;
    }
</script>