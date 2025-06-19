@extends('layouts.app')

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">CRM</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">CRM</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                    <div class="col">
                        <div class="py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Tout les Utilisateurs<i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-shield-user-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $userCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Tout les formations<i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-profile-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $formationCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Demandes participations<i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-pulse-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $demandesCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-lg-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Etablissement<i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-trophy-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $etablissementCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-lg-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Grades<i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-service-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $gradeCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

<div class="row">
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Formation par grade</h4>
                
            </div><!-- end card header -->
            <div class="card-body pb-0">
                <div id="sales-forecast-chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]' data-colors-minimal='["--vz-primary-rgb, 0.75", "--vz-primary", "--vz-primary-rgb, 0.55"]' data-colors-creative='["--vz-primary", "--vz-secondary", "--vz-info"]' data-colors-corporate='["--vz-primary", "--vz-success", "--vz-secondary"]' data-colors-galaxy='["--vz-primary", "--vz-secondary", "--vz-info"]' data-colors-classic='["--vz-primary", "--vz-warning", "--vz-secondary"]' class="apex-charts" dir="ltr"></div>
            </div>
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xxl-3 col-md-6">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Utilisateur par etablissement</h4>
            </div><!-- end card header -->
            <div class="card-body pb-0">
                <div id="deal-type-charts" data-colors='["--vz-warning", "--vz-danger", "--vz-success"]' data-colors-minimal='["--vz-primary-rgb, 0.15", "--vz-primary-rgb, 0.35", "--vz-primary-rgb, 0.45"]' data-colors-modern='["--vz-warning", "--vz-secondary", "--vz-success"]' data-colors-interactive='["--vz-warning", "--vz-info", "--vz-primary"]' data-colors-corporate='["--vz-secondary", "--vz-info", "--vz-success"]' data-colors-classic='["--vz-secondary", "--vz-danger", "--vz-success"]' class="apex-charts" dir="ltr"></div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xxl-6">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tout les formations</h4>
                
            </div><!-- end card header -->
            <div class="card-body px-0">
                <ul class="list-inline main-chart text-center mb-0">
                    <li class="list-inline-item chart-border-left me-0 border-0">
                        <h4 class="text-primary">$584k <span class="text-muted d-inline-block fs-13 align-middle ms-2">Revenue</span></h4>
                    </li>
                    <li class="list-inline-item chart-border-left me-0">
                        <h4>$497k<span class="text-muted d-inline-block fs-13 align-middle ms-2">Expenses</span>
                        </h4>
                    </li>
                    <li class="list-inline-item chart-border-left me-0">
                        <h4><span data-plugin="counterup">3.6</span>%<span class="text-muted d-inline-block fs-13 align-middle ms-2">Profit Ratio</span></h4>
                    </li>
                </ul>

                <div id="revenue-expenses-charts" data-colors='["--vz-success", "--vz-danger"]' data-colors-minimal='["--vz-primary", "--vz-info"]' data-colors-interactive='["--vz-info", "--vz-primary"]' data-colors-galaxy='["--vz-primary", "--vz-secondary"]' data-colors-classic='["--vz-primary", "--vz-secondary"]' class="apex-charts" dir="ltr"></div>
            </div>
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

                    
@endsection

@push('scripts')
<!-- apexcharts -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Dashboard init -->
<script>
    function getChartColorsArray(e) {
    if (null !== document.getElementById(e)) {
        var t = "data-colors" + ("-" + document.documentElement.getAttribute("data-theme") ?? ""),
            t = document.getElementById(e).getAttribute(t) ?? document.getElementById(e).getAttribute("data-colors");
        if (t) return (t = JSON.parse(t)).map(function(e) {
            var t = e.replace(" ", "");
            return -1 === t.indexOf(",") ? getComputedStyle(document.documentElement).getPropertyValue(t) || t : 2 == (e = e.split(",")).length ? "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")" : t
        });
        console.warn("data-colors attributes not found on", e)
    }
}
var salesForecastChart = "",
    dealTypeCharts = "",
    revenueExpensesCharts = "";
function loadCharts() {
    console.group("Formations per Grade Data");
    console.log("Grade Names:", @json($formationsPerGrade->pluck('grade_name')));
    console.log("Formation Counts:", @json($formationsPerGrade->pluck('total')));
    console.log("Complete Data:", @json($formationsPerGrade));
    console.groupEnd();

    var e, t;

    // First Chart - Formations per Grade (Bar Chart)
    t = getChartColorsArray("sales-forecast-chart");
    if (t) {
        e = {
            series: [{
                name: "Formations",
                data: @json($formationsPerGrade->pluck('total'))
            }],
            chart: {
                type: "bar",
                height: 341,
                toolbar: {
                    show: !1
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "60%",
                    distributed: true
                }
            },
            stroke: {
                show: !0,
                width: 5,
                colors: ["transparent"]
            },
            xaxis: {
                categories: @json($formationsPerGrade->pluck('grade_name')),
                axisTicks: {
                    show: !0,
                    borderType: "solid",
                    color: "#78909C",
                    height: 6,
                    offsetX: 0,
                    offsetY: 0
                },
                title: {
                    text: "Grades",
                    offsetX: 0,
                    offsetY: -30,
                    style: {
                        color: "#78909C",
                        fontSize: "12px",
                        fontWeight: 400
                    }
                },
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(e) {
                        return e  // Keep currency formatting
                    }
                },
                tickAmount: 1, // Changed to 1 tick
                min: 0
            },
            fill: {
                opacity: 1
            },
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                fontWeight: 500,
                offsetX: 0,
                offsetY: -14,
                itemMargin: {
                    horizontal: 8,
                    vertical: 0
                },
                markers: {
                    width: 10,
                    height: 10
                }
            },
            colors: t
        };

        if (salesForecastChart) salesForecastChart.destroy();
        salesForecastChart = new ApexCharts(document.querySelector("#sales-forecast-chart"), e);
        salesForecastChart.render();
    }

    // Second Chart - Users per Etablissement (Radar Chart)
    t = getChartColorsArray("deal-type-charts");
    if (t) {
        const userTotals = @json($usersPerEtab->pluck('total'));
        const maxUser = Math.max(...userTotals);
        e = {
            series: [{
                name: "Users",
                data: userTotals
            }],
            chart: {
                height: 341,
                type: "radar",
                dropShadow: {
                    enabled: !0,
                    blur: 1,
                    left: 1,
                    top: 1
                },
                toolbar: {
                    show: !1
                }
            },
            stroke: {
                width: 2
            },
            fill: {
                opacity: .2
            },
            legend: {
                show: !0,
                fontWeight: 500,
                offsetX: 0,
                offsetY: -8,
                markers: {
                    width: 8,
                    height: 8,
                    radius: 6
                },
                itemMargin: {
                    horizontal: 10,
                    vertical: 0
                }
            },
            markers: {
                size: 0
            },
            colors: t,
            xaxis: {
                categories: @json($usersPerEtab->pluck('etablissement_name'))
            },
            yaxis: {
                tickAmount: maxUser + 1,
                min: 0,
                max: maxUser + 1,
                labels: {
                    formatter: function (val) {
                        return parseInt(val);
                    }
                }
            }
        };

        if (dealTypeCharts) dealTypeCharts.destroy();
        dealTypeCharts = new ApexCharts(document.querySelector("#deal-type-charts"), e);
        dealTypeCharts.render();
    }

    // Third Chart - Revenue vs Expenses (Area Chart)
    t = getChartColorsArray("revenue-expenses-charts");
    if (t) {
        e = {
            series: [
                { name: "Revenue", data: [20, 25, 30, 35, 40, 55, 70, 110, 150, 180, 210, 250] },
                { name: "Expenses", data: [12, 17, 45, 42, 24, 35, 42, 75, 102, 108, 156, 199] }
            ],
            chart: {
                height: 290,
                type: "area",
                toolbar: false
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                curve: "smooth",
                width: 2
            },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            },
            yaxis: {
                labels: {
                    formatter: function(e) {
                        return "$" + e + "k";
                    }
                },
                tickAmount: 5,
                min: 0,
                max: 260
            },
            colors: t,
            fill: {
                opacity: .06,
                colors: t,
                type: "solid"
            }
        };

        if (revenueExpensesCharts) revenueExpensesCharts.destroy();
        revenueExpensesCharts = new ApexCharts(document.querySelector("#revenue-expenses-charts"), e);
        revenueExpensesCharts.render();
    }
}

window.onresize = function() {
    setTimeout(() => {
        loadCharts()
    }, 0)
}, loadCharts();
</script>

@endpush