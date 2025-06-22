@extends('layouts.app')

@push('styles')

<style>
    .widget-box {
  border: 1px solid #ddd;       /* Bordure grise claire */
  border-radius: 8px;           /* Bords arrondis (optionnel) */
  transition: box-shadow 0.3s ease, border-color 0.3s ease;
}

.widget-box:hover {
  border-color: #4CAF50;        /* Couleur de bordure au hover (vert) */
  box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3); /* Ombre portée verte */
  cursor: pointer;              /* Curseur pointeur au survol */
}
</style>

@endpush


@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Statistique</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Univeresitaire</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row align-items-center">
    <!-- Left column (statistics) -->
    

    <!-- Right column (Users by Device) -->
    <div class="col-xl-4">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Utilisateur par role</h4>
                
            </div><!-- end card header -->
            <div class="card-body">
                <div id="user_role_pie_chart" data-colors='["--vz-primary", "--vz-warning", "--vz-info", "--vz-success"]' class="apex-charts" dir="ltr"></div>

<div class="table-responsive mt-3">
    <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
        <tbody class="border-0">
            <tr>
                <td>
                    <h4 class="fs-14 fs-medium mb-0"><i class="ri-stop-fill text-primary me-2 fs-18"></i>Utilisateurs</h4>
                </td>
                <td>{{ $userRolesStats['user']->total ?? 0 }}</td>
            </tr>
            <tr>
                <td>
                    <h4 class="fs-14 fs-medium mb-0"><i class="ri-stop-fill text-success me-2 fs-18"></i>Établissements</h4>
                </td>
                <td>{{ $userRolesStats['etab']->total ?? 0 }}</td>
            </tr>
            <tr>
                <td>
                    <h4 class="fs-14 fs-medium mb-0"><i class="ri-stop-fill text-warning me-2 fs-18"></i>Formateurs</h4>
                </td>
                <td>{{ $userRolesStats['forma']->total ?? 0 }}</td>
            </tr>
            <tr>
                <td>
                    <h4 class="fs-14 fs-medium mb-0"><i class="ri-stop-fill text-info me-2 fs-18"></i>Université</h4>
                </td>
                <td>{{ $userRolesStats['univ']->total ?? 0 }}</td>
            </tr>
        </tbody>
    </table>
</div>

            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end right col -->
    <div class="col-xl-8">
        <div class="card crm-widget">
            <div class="card-body p-3">
                <div class="row g-3">
                    <!-- 6 widgets: all using col-md-6 -->
                    <div class="col-md-6">
                        <div class="py-4 px-3 widget-box">
                            <h5 class="text-muted text-uppercase fs-13">Tout les Utilisateurs
                                <i class="ri-check-double-line text-success fs-18 float-end align-middle"></i>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-shield-user-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $userCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="py-4 px-3 widget-box">
                            <h5 class="text-muted text-uppercase fs-13">Tout les formations
                                <i class="ri-check-double-line text-success fs-18 float-end align-middle"></i>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-profile-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $formationCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="py-4 px-3 widget-box">
                            <h5 class="text-muted text-uppercase fs-13">Demandes participations
                                <i class="ri-check-double-line text-success fs-18 float-end align-middle"></i>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-pulse-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $demandesCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="py-4 px-3 widget-box">
                            <h5 class="text-muted text-uppercase fs-13">Etablissement
                                <i class="ri-check-double-line text-success fs-18 float-end align-middle"></i>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-trophy-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $etablissementCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="py-4 px-3 widget-box">
                            <h5 class="text-muted text-uppercase fs-13">Grades
                                <i class="ri-check-double-line text-success fs-18 float-end align-middle"></i>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-service-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $gradeCount }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ New 6th Widget -->
                    <div class="col-md-6">
                        <div class="py-4 px-3 widget-box">
                            <h5 class="text-muted text-uppercase fs-13">Validateur Etablissement
                                <i class="ri-check-double-line text-success fs-18 float-end align-middle"></i>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-user-follow-line display-6 text-muted cfs-22"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{ $userRolesStats['etab']->total?? 0 }}">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end new widget -->

                </div><!-- end row -->
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end left col -->
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
            <h4 class="card-title mb-0 flex-grow-1">Demandes vs Utilisateurs</h4>
        </div>
        <div class="card-body px-0">
            <ul class="list-inline main-chart text-center mb-0">
                <li class="list-inline-item chart-border-left me-0 border-0">
                    <h4 class="text-primary">{{ $demandesCount }} <span class="text-muted d-inline-block fs-13 align-middle ms-2">Demandes</span></h4>
                </li>
                <li class="list-inline-item chart-border-left me-0">
                    <h4>{{ $userCount }}<span class="text-muted d-inline-block fs-13 align-middle ms-2">Utilisateurs</span></h4>
                </li>
                <li class="list-inline-item chart-border-left me-0">
                    <h4><span data-plugin="counterup">{{ $userCount > 0 ? round(($userCount/$demandesCount)*100, 1) : 0 }}</span>%<span class="text-muted d-inline-block fs-13 align-middle ms-2">Ratio</span></h4>
                </li>
            </ul>
            <div id="revenue-expenses-charts" 
                 data-colors='["--vz-success", "--vz-danger"]'
                 data-colors-minimal='["--vz-primary", "--vz-info"]'
                 data-colors-interactive='["--vz-info", "--vz-primary"]'
                 data-colors-galaxy='["--vz-primary", "--vz-secondary"]'
                 data-colors-classic='["--vz-primary", "--vz-secondary"]'
                 class="apex-charts" dir="ltr"></div>
        </div>
    </div>
</div>
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
var salesForecastChart, dealTypeCharts, revenueExpensesCharts, userDevicePieCharts, userRolePieChart;

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
                    height: 6
                },
                title: {
                    text: "Grades",
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
                        return e
                    }
                },
                tickAmount: 1,
                min: 0
            },
            fill: {
                opacity: 1
            },
            legend: {
                show: !0,
                position: "bottom",
                fontWeight: 500,
                offsetY: -14
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
                offsetY: -8
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
                {
                    name: "Demandes",
                    data: @json($monthlyStats->pluck('demandes_count'))
                },
                {
                    name: "Utilisateurs (Role: User)",
                    data: @json($monthlyStats->pluck('users_count'))
                }
            ],
            chart: {
                height: 290,
                type: "area",
                toolbar: false
            },
            dataLabels: {
                enabled: false
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
                    formatter: function (e) {
                        return Math.round(e);
                    }
                },
                tickAmount: 1,
                min: 0,
                forceNiceScale: true
            },
            colors: ["#FF4560", "#00E396"],
            fill: {
                opacity: 0.06,
                colors: ["#FF4560", "#00E396"],
                type: "solid"
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return value;
                    }
                }
            },
            markers: {
                size: 4,
                colors: ["#FF4560", "#00E396"]
            }
        };
        if (revenueExpensesCharts) revenueExpensesCharts.destroy();
        revenueExpensesCharts = new ApexCharts(document.querySelector("#revenue-expenses-charts"), e);
        revenueExpensesCharts.render();
    }

    // Fourth Chart - Users by Device (Donut Chart)
    t = getChartColorsArray("user_role_pie_chart");
if (t) {
    e = {
        series: [
            {{ $userRolesStats['user']->total ?? 0 }},
            {{ $userRolesStats['etab']->total ?? 0 }},
            {{ $userRolesStats['forma']->total ?? 0 }},
            {{ $userRolesStats['univ']->total ?? 0 }}
        ],
        labels: ["Utilisateur", "Etablissement", "Formateur", "Universitaire"],
        chart: {
            type: "donut",
            height: 219
        },
        plotOptions: {
            pie: {
                size: 100,
                donut: {
                    size: "76%"
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false
        },
        stroke: {
            width: 0
        },
        colors: t
    };
    if (userRolePieChart) userRolePieChart.destroy();
    userRolePieChart = new ApexCharts(document.querySelector("#user_role_pie_chart"), e);
    userRolePieChart.render();
}

}


window.onresize = function() {
    setTimeout(() => {
        loadCharts()
    }, 0)
}, loadCharts();
</script>

@endpush