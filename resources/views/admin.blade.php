@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="row">

              <div class="col-md-3 admin-menu">
                
                <a href="/admin/categories" class="btn btn-primary btn-block">RUBROS</a>

              </div>

              <div class="col-md-3 admin-menu">
            
                <a href="/admin/subcategories" class="btn btn-block btn-primary">SUBRUBROS</a>
              
              </div>

              <div class="col-md-3 admin-menu">
            
                <a href="/admin/brands" class="btn btn-block btn-primary">MARCAS</a>

              </div>

              <div class="col-md-3 admin-menu">

                <a href="/admin/products" class="btn btn-block btn-primary">LISTADO DE PRODUCTOS</a>

              </div>

              <div class="col-md-3 admin-menu">

                <a href="admin/users" class="btn btn-block btn-primary">USUARIOS</a>

              </div>

              <div class="col-md-3 admin-menu">
            
                <a href="/admin/orders" class="btn btn-block btn-primary">LISTADO DE PEDIDOS</a>

              </div>

              <div class="col-md-3 admin-menu">
            
                <a href="/admin/obras" class="btn btn-block btn-primary">OBRAS TOTALES</a>

              </div>

              <div class="col-md-3 admin-menu">
            
                <a href="/admin/discount-group" class="btn btn-block btn-primary">GRUPOS DE DESCUENTO</a>

              </div>

              <div class="col-md-3 admin-menu">
            
                <a href="/admin/push" class="btn btn-block btn-primary">PUSH NOTIFICATION</a>

              </div>

               <div class="col-md-3 admin-menu">
            
                <a href="/admin/images" class="btn btn-block btn-primary">IMÁGENES</a>

              </div>

              <div class="col-md-3 admin-menu">
            
                <a href="/admin/shipping-cost" class="btn btn-block btn-primary">ENVÍOS</a>

              </div>
   
           </div>



           <hr>

           <div class="row">

           <div class="col-md-5">
              
              <div class="chart-container bg-light text-center p-4">
                  
                  <h5>Pedidos recibidos hoy: {{$today_orders->count()}}</h5>

                  <canvas id="orders-chart"></canvas>

              </div>

            </div>

            <div class="col-md-2">
              
            </div>


            <div class="col-md-5">

              <div class="chart-container bg-light text-center p-4">
                  
                  <h5 id="total-revenue">Total del día: $ {{$today_orders->sum('total')}}</h5>

                  <canvas id="revenue-chart"></canvas>

              </div>

            </div>

          </div>

          <hr>

              <div class="col-md-12">

              <div class="chart-container bg-light text-center p-4">
                  
                  <h5 id="total-revenue">Total de pedidos del mes: $ {{$orders->sum('total')}}</h5>

                  <canvas id="month-chart"></canvas>

              </div>

            </div>

          </div>
    </div>
</div>
<script>
  $( document ).ready(function() {

Chart.scaleService.updateScaleDefaults('linear', {
    ticks: {
        min: 0,
    }
});

var today_orders = @json($today_orders);
var ctx = document.getElementById('orders-chart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Pedidos'],
        datasets: [{
            label: '',
            data: [today_orders.length],
            backgroundColor: [
                '#f7811d',
            ],
            borderColor: [
                '#4c4c4c',
            ],
            borderWidth: 1
        }]
    },
    options: {
      legend: {
        display: false
    },
        scales: {
            xAxes: [{
                gridLines: {
                display:false
            }   
            }],
          yAxes: [{
            display: true,
            gridLines: {
                display:false
            },
             ticks: {
        stepSize: 1,
          }  
        }]
        }
    }
});

var total = 0;
for (var i = 0; i < today_orders.length; i++) {
  total += Math.round(today_orders[i].total);
}

var ctz = document.getElementById('revenue-chart');
var myChart = new Chart(ctz, {
    type: 'bar',
    data: {
        labels: ['Total'],
        datasets: [{
            label: '',
            data: [total],
            backgroundColor: [
                '#f7811d',
            ],
            borderColor: [
                '#4c4c4c',
            ],
            borderWidth: 1
        }]
    },
    options: {
      legend: {
        display: false
    },
        scales: {
            xAxes: [{
                gridLines: {
                display:false
            }   
            }],
          yAxes: [{
            display: true,
            gridLines: {
                display:false
            }   
        }]
        }
    }
});


function daysInMonth (month, year) { 
                return new Date(year, month, 0).getDate(); 
            } ;

var d = new Date();
var m = d.getMonth()+1;
var y = d.getFullYear();
var total_days = daysInMonth(m, y);
var dates = [];
var totals = [];
var total = [];
var orders = @json($orders);

for (var i = 0; i < total_days; i++) {
  if (i<10) {

  dates[i] = y+"-"+0+m+"-"+0+(i+1);

  } else{
  dates[i] = y+"-"+0+m+"-"+(i+1);

  }
}

for (var i = 0; i < dates.length; i++) {

  for (var j = 0; j < orders.length; j++) {

  if (orders[j].date == dates[i]) {

    totals[i] += Math.round(orders[j].total);

  } else{

    totals.push(0);

  }
  
}

}

var ctw = document.getElementById('month-chart');
var myChart = new Chart(ctw, {
    type: 'line',
    data: {
        labels: dates,
        datasets: [{
            label: '',
            data: totals,
            backgroundColor: [
                '#fff',
            ],
            borderColor: [
                '#f7811d',
            ],
            borderWidth: 3
        }]
    },
    options: {
      legend: {
        display: false
    },
        scales: {
            xAxes: [{
                gridLines: {
                display:false
            }   
            }],
          yAxes: [{
            display: true,
            gridLines: {
                display:false
            } 
        }]
        }
    }
});

});
</script>

@endsection