@extends('layouts.dashboard')

@section('title', 'Estatísticas')
@section('title-page', 'Estatísticas')
@section('title-sub-page', 'Home')

@section('content')


<!-- row -->
<div class="row">
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="white-box m-b-0 bg-danger">
                            <h3 class="text-white box-title">Moradores <span class="pull-right"><i class="mdi mdi-plus"></i> {{ $resident['weektotal'] }}</span></h3>
                            <div id="sparkline1dash"></div>
                        </div>
                        <div class="white-box">
                            <div class="row">
                                <div class="p-l-20 p-r-20">
                                    <div class="pull-left">
                                        <div class="text-muted m-t-20">Total</div>
                                        <h2>{{ $resident['total'] }}</h2>
                                    </div>
                                    <div data-label="{{ ceil(($resident['weektotal'] * 100) / $resident['total']) }}%" class="css-bar css-bar-{{ ceil(($resident['weektotal'] * 100) / $resident['total']) }} css-bar-lg m-b-0  css-bar-danger pull-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="white-box m-b-0 bg-info">
                            <h3 class="text-white box-title">Ap. Ocupados <span class="pull-right"><i class="mdi mdi-plus"></i> {{ $apartament['weekon'] }}</span></h3>
                            <div id="sparkline2dash" class="text-center"></div>
                        </div>
                        <div class="white-box">
                            <div class="row">
                                <div class="p-l-20 p-r-20">
                                    <div class="pull-left">
                                        <div class="text-muted m-t-20">Ap. Ocupados</div>
                                        <h2>{{ $apartament['on'] }}</h2> </div>
                                    <div data-label="{{ ceil(($apartament['weekon'] * 100) / $apartament['on']) }}%" class="css-bar css-bar-{{ ceil(($apartament['weekon'] * 100) / $apartament['on']) }} css-bar-lg m-b-0  css-bar-info pull-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="white-box m-b-0 bg-purple">
                            <h3 class="text-white box-title">Ap. Livres <span class="pull-right"><i class="mdi mdi-plus"></i> {{ $apartament['weekfree'] }}</span></h3>
                            <div id="sparkline3dash"></div>
                        </div>
                        <div class="white-box">
                            <div class="row">
                                <div class="p-l-20 p-r-20">
                                    <div class="pull-left">
                                        <div class="text-muted m-t-20">Ap. livres</div>
                                        <h2>{{ $apartament['free'] }}</h2> 
                                        </div><div data-label="{{ ceil(($apartament['weekfree'] * 100) / $apartament['free']) }}%" class="css-bar css-bar-{{ ceil(($apartament['weekfree'] * 100) / $apartament['free']) }} css-bar-lg m-b-0  css-bar-info pull-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="white-box m-b-0 bg-inverse">
                            <h3 class="text-white box-title">Moradores Inativos <span class="pull-right"><i class="mdi mdi-plus"></i> {{ $resident['weekinative'] }}</span></h3>
                            <div id="sparkline4dash" class="text-center"></div>
                        </div>
                        <div class="white-box">
                            <div class="row">
                                <div class="p-l-20 p-r-20">
                                    <div class="pull-left">
                                        <div class="text-muted m-t-20">Total Inativos</div>
                                        <h2>{{ $resident['inative'] }}</h2></div>
                                        <div data-label="{{ ceil(($resident['weekinative'] * 100) / $resident['inative']) }}%" class="css-bar css-bar-{{ ceil(($resident['weekinative'] * 100) / $resident['inative']) }} css-bar-lg m-b-0  css-bar-inverse pull-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /row -->
                <!-- ============================================================== -->
                <!-- SALES analyitics widgets -->
                <!-- ============================================================== -->

                <!-- .row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="white-box">
                                    <h3 class="box-title">Total de Prédios</h3>
                                    <ul class="list-inline two-part">
                                        <li><i class="icon-people text-info"></i></li>
                                        <li class="text-right"><span class="counter">{{ $building }}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="white-box">
                                    <h3 class="box-title">Tipologias</h3>
                                    <ul class="list-inline two-part">
                                        <li><i class="icon-folder text-purple"></i></li>
                                        <li class="text-right"><span class="counter">{{ $typology }}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="white-box">
                                    <h3 class="box-title">Serviços</h3>
                                    <ul class="list-inline two-part">
                                        <li><i class="icon-folder-alt text-danger"></i></li>
                                        <li class="text-right"><span class="counter">{{ $service }}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="white-box">
                                    <h3 class="box-title">Porteiros</h3>
                                    <ul class="list-inline two-part">
                                        <li><i class="ti-wallet text-success"></i></li>
                                        <li class="text-right"><span class="counter">{{ $porter }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="white-box real-time-widgets">
                            <div data-label="" class="css-bar m-t-30 css-bar-25 css-bar-xxl css-bar-success"></div>
                            <div class="data-text">
                                <h1>25</h1>
                                <h5>Visitas</h5><span>PAUSADO</span></div>
                        </div>
                    </div>
                </div>

                
                <!-- <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="bg-danger">
                            <div id="ct-sales" class="p-t-30" style="height: 360px"></div>
                        </div>
                        <div class="white-box">
                            <div class="row">
                                <div class="col-xs-8">
                                    <h2 class="m-b-0 font-medium">$354.50</h2>
                                    <h5 class="text-muted m-t-0">160 Sales</h5></div>
                                <div class="col-xs-4">
                                    <div class="circle circle-md bg-info pull-right m-t-10"><i class="ti-shopping-cart"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="bg-theme white-box m-b-0">
                            <ul class="expense-box">
                                <li><i class="wi wi-day-cloudy text-white"></i><span><h1 class="text-white m-b-0">25<sup>o</sup></h1><h4 class="text-white">Sunny day</h4></span></li>
                            </ul>
                            <div id="ct-weather" style="height: 180px"></div>
                            <ul class="dp-table text-white">
                                <li>05 AM</li>
                                <li>10 AM</li>
                                <li>03 PM</li>
                                <li>08 PM</li>
                            </ul>
                        </div>
                        <div class="white-box">
                            <div class="row">
                                <div class="col-xs-8">
                                    <h2 class="m-b-0 font-medium">Sunday</h2>
                                    <h5 class="text-muted m-t-0">March 2017</h5></div>
                                <div class="col-xs-4">
                                    <div class="circle circle-md bg-success pull-right m-t-10"><i class="wi wi-day-sunny"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="calendar-widget m-b-30">
                            <div class="cal-left">
                                <h1>23</h1>
                                <h4>Thursday</h4> <span></span>
                                <h5>March 2017</h5>
                                <div class="cal-btm-text"> <a href="">3 TASKS</a>
                                    <h5>Prepare project</h5> </div>
                            </div>
                            <div class="cal-right bg-info">
                                <table class="cal-table">
                                    <tbody>
                                        <tr>
                                            <td colspan="5">
                                                <h1>March</h1></td>
                                            <td></td>
                                            <td><a href="" class="cal-add"><i class="ti-plus"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>SUN</td>
                                            <td>MON</td>
                                            <td>TUE</td>
                                            <td>WED</td>
                                            <td>THU</td>
                                            <td>FRI</td>
                                            <td>SAT</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>9</td>
                                            <td>10</td>
                                            <td>11</td>
                                            <td>12</td>
                                            <td>13</td>
                                        </tr>
                                        <tr>
                                            <td>14</td>
                                            <td>15</td>
                                            <td>16</td>
                                            <td>17</td>
                                            <td>18</td>
                                            <td>19</td>
                                            <td>20</td>
                                        </tr>
                                        <tr>
                                            <td>21</td>
                                            <td>22</td>
                                            <td class="cal-active">23</td>
                                            <td>24</td>
                                            <td>25</td>
                                            <td>26</td>
                                            <td>27</td>
                                        </tr>
                                        <tr>
                                            <td>28</td>
                                            <td>29</td>
                                            <td>30</td>
                                            <td>31</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h2 class="m-b-0 font-medium">$354.50</h2>
                                    <h5 class="text-muted m-t-0">160 Sales</h5></div>
                                <div class="col-xs-6">
                                    <div id="ct-bar-chart" class="pull-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h2 class="m-b-0 font-medium">$354.50</h2>
                                    <h5 class="text-muted m-t-0">160 Sales</h5></div>
                                <div class="col-xs-6">
                                    <div id="ct-extra" style="height: 70px" class="pull-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-xs-4">
                                    <h2 class="m-b-0 font-medium">$354.50</h2>
                                    <h5 class="text-muted m-t-0">160 Sales</h5></div>
                                <div class="col-xs-8">
                                    <div id="ct-main-bal" style="height: 70px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 col-lg-3 col-sm-12">
                        <div class="white-box real-time-widgets">
                            <div data-label="" class="css-bar m-t-30 css-bar-25 css-bar-xxl css-bar-success"></div>
                            <div class="data-text">
                                <h1>25</h1>
                                <h5>Visitor</h5><span>REALTIME</span></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-9">
                        <div class="white-box">
                            <h3 class="box-title">Todays visit</h3>
                            <ul class="list-inline">
                                <li>
                                    <h5><i class="fa fa-circle m-r-5" style="color: #2cabe3;"></i>Returning Visitor</h5> </li>
                                <li>
                                    <h5><i class="fa fa-circle m-r-5" style="color: #ff7676;"></i>New visits</h5> </li>
                            </ul>
                            <div id="ct-visits" style="height: 220px;"></div>
                        </div>
                    </div>
                </div> -->
                
<!--                 
                <div class="row">
                    <div class="col-lg-3 col-md-6    col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Daily Sales</h3>
                            <div class="text-right"> <span class="text-muted">Todays Income</span>
                                <h1><sup><i class="ti-arrow-up text-success"></i></sup> $12,000</h1> </div> <span class="text-success">20%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only">20% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Weekly Sales</h3>
                            <div class="text-right"> <span class="text-muted">Weekly Income</span>
                                <h1><sup><i class="ti-arrow-down text-danger"></i></sup> $5,000</h1> </div> <span class="text-danger">30%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:30%;"> <span class="sr-only">230% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Monthly Sales</h3>
                            <div class="text-right"> <span class="text-muted">Monthly Income</span>
                                <h1><sup><i class="ti-arrow-up text-info"></i></sup> $10,000</h1> </div> <span class="text-info">60%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span class="sr-only">20% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Yearly Sales</h3>
                            <div class="text-right"> <span class="text-muted">Yearly Income</span>
                                <h1><sup><i class="ti-arrow-up text-inverse"></i></sup> $9,000</h1> </div> <span class="text-inverse">80%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">230% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">MONTHLY USAGE</h3>
                            <h1 class="m-b-30 m-t-0 font-medium">58.50</h1>
                            <ul class="dp-table">
                                <li>
                                    <div class="progress progress-md progress-vertical-bottom m-0">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:30%;"> <span class="sr-only">88% Complete</span> </div>
                                    </div>
                                    <br/> <b>S</b> </li>
                                <li>
                                    <div class="progress progress-md progress-vertical-bottom m-0">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:60%;"> <span class="sr-only">88% Complete</span> </div>
                                    </div>
                                    <br/> <b>M</b> </li>
                                <li>
                                    <div class="progress progress-md progress-vertical-bottom m-0">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:80%;"> <span class="sr-only">88% Complete</span> </div>
                                    </div>
                                    <br/> <b>T</b> </li>
                                <li>
                                    <div class="progress progress-md progress-vertical-bottom m-0">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:30%;"> <span class="sr-only">88% Complete</span> </div>
                                    </div>
                                    <br/> <b>W</b> </li>
                                <li>
                                    <div class="progress progress-md progress-vertical-bottom m-0">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:40%;"> <span class="sr-only">88% Complete</span> </div>
                                    </div>
                                    <br/> <b>T</b> </li>
                                <li>
                                    <div class="progress progress-md progress-vertical-bottom m-0">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:20%;"> <span class="sr-only">88% Complete</span> </div>
                                    </div>
                                    <br/> <b>F</b> </li>
                                <li>
                                    <div class="progress progress-md progress-vertical-bottom m-0">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="height:50%;"> <span class="sr-only">88% Complete</span> </div>
                                    </div>
                                    <br/> <b>S</b> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="white-box">
                            <h3 class="box-title">Polar chart</h3>
                            <div id="ct-polar-chart" style="height: 342px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="mt-gauge text-center">
                            <div id="gaugeDemo" class="gauge gauge-big gauge-green">
                                <div class="gauge-arrow" data-percentage="40" style="transform: rotate(0deg);"> </div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <h1 class="m-b-0 m-t-0 font-medium">26.30</h1>
                                        <h4 class="m-t-0">AMps Used</h4> </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btn mtbutton btn-info btn-circle btn-xl pull-right"><i class="icon-speedometer"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="white-box">
                            <h3 class="box-title">Visit from the countries</h3>
                            <ul class="country-state">
                                <li>
                                    <h2>6350</h2> <small>From India</small>
                                    <div class="pull-right">48% <i class="fa fa-level-up text-success"></i></div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:48%;"> <span class="sr-only">48% Complete</span></div>
                                    </div>
                                </li>
                                <li>
                                    <h2>3250</h2> <small>From UAE</small>
                                    <div class="pull-right">98% <i class="fa fa-level-up text-success"></i></div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:98%;"> <span class="sr-only">98% Complete</span></div>
                                    </div>
                                </li>
                                <li>
                                    <h2>1250</h2> <small>From Australia</small>
                                    <div class="pull-right">75% <i class="fa fa-level-down text-danger"></i></div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:75%;"> <span class="sr-only">75% Complete</span></div>
                                    </div>
                                </li>
                                <li>
                                    <h2>1350</h2> <small>From USA</small>
                                    <div class="pull-right">48% <i class="fa fa-level-up text-success"></i></div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:48%;"> <span class="sr-only">48% Complete</span></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa fa-sort-asc"></i> 18% High then last month</small> Monthly Site Traffic</h3>
                            <div class="stats-row">
                                <div class="stat-item">
                                    <h6>Overall Growth</h6> <b>80.40%</b></div>
                                <div class="stat-item">
                                    <h6>Montly</h6> <b>15.40%</b></div>
                                <div class="stat-item">
                                    <h6>Day</h6> <b>5.50%</b></div>
                            </div>
                            <div id="sparkline8"></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><small class="pull-right m-t-10 text-danger"><i class="fa fa-sort-desc"></i> 18% High then last month</small>Weekly Site Traffic</h3>
                            <div class="stats-row">
                                <div class="stat-item">
                                    <h6>Overall Growth</h6> <b>80.40%</b></div>
                                <div class="stat-item">
                                    <h6>Montly</h6> <b>15.40%</b></div>
                                <div class="stat-item">
                                    <h6>Day</h6> <b>5.50%</b></div>
                            </div>
                            <div id="sparkline9"></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa fa-sort-asc"></i> 18% High then last month</small>Yearly Site Traffic</h3>
                            <div class="stats-row">
                                <div class="stat-item">
                                    <h6>Overall Growth</h6> <b>80.40%</b></div>
                                <div class="stat-item">
                                    <h6>Montly</h6> <b>15.40%</b></div>
                                <div class="stat-item">
                                    <h6>Day</h6> <b>5.50%</b></div>
                            </div>
                            <div id="sparkline10"></div>
                        </div>
                    </div>
                </div> -->

<!--                 
                <div class="row">
                    <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Total Sites Visit</h3>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6  m-t-30">
                                    <h1 class="text-warning">6778</h1>
                                    <p class="text-muted">APRIL 2016</p> <b>(150-165 Sales)</b> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div id="sales1" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Sales Difference</h3>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6  m-t-30">
                                    <h1 class="text-info">$2478</h1>
                                    <p class="text-muted">APRIL 2016</p> <b>(150-165 Sales)</b> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div id="sales2" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                -->
            

@endsection
