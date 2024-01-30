@extends('app')

@section('title','Dashboard-Circle')

@push('css')
@endpush

@section('content')



    <!-- Content Header (Page header) -->

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Home</h1>

          </div>

        </div>

      </div><!-- /.container-fluid -->

    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Target: cr</h3>
               
                <h4>Collection: cr</h4>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>              
              <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Stock: </h3>
                <p>Return: </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>Arrear:cr</h3>
                <p>Collection: cr</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <!-- Graph ---->
        <div class="row">
          <div class="col-md-4">
            <canvas id="normalChart" width="5" height="2"></canvas>
          </div>
          <div class="col-md-4">
            <canvas id="auditChart" width="5" height="2"></canvas>
          </div>
          <div class="col-md-4">
            <canvas id="reopenChart" width="5" height="2"></canvas>
          </div>
        </div>
        <!-- END Graph ---->

        <!-- Graph ---->
        <div class="row">
          <div class="col-md-12">
            <canvas id="targetChart" width="5" height="2"></canvas>
          </div>
        </div>
        <!-- END Graph ---->

      </div>

    </section>
    <!-- /.content -->



  @endsection



  @push('js')

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
  <script>
    //Normal Chart
    var normal = document.getElementById('normalChart');
    var normalChart = new Chart(normal, {
      type: 'pie',
      data: {
        labels: ['Normal Pending Case','Normal Disposal Case'],
        datasets: [{
              data: [300, 50,],
              backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
              ],
              hoverOffset: 4
        }]
      }
    });
    //Audit Chart
    var audit = document.getElementById('auditChart');
    var auditChart = new Chart(audit, {
      type: 'pie',
      data: {
        labels: ['Audit Pending Case','Audit Disposal Case'],
        datasets: [{
              data: [20, 1,],
              backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
              ],
              hoverOffset: 4
        }]
      }
    });
    //Audit Chart
    var reopen = document.getElementById('reopenChart');
    var reopenChart = new Chart(reopen, {
      type: 'pie',
      data: {
        labels: ['Reopen Pending Case','Reopen Disposal Case'],
        datasets: [{
              data: [3, 1,],
              backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
              ],
              hoverOffset: 4
        }]
      }
    });

    //Target and Collection Chart
    var target = document.getElementById('targetChart');
    var targetChart = new Chart(target, {
        type: 'bar',
        data: {
            labels: ['July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [
              {
                  label: 'Target',
                  data: [10, 11, 12, 13, 14, 14, 13, 12, 12, 14, 15, 13],
                  borderWidth: 1,
                  backgroundColor: ['#f60303']
              },
              {
                  label: 'Collection',
                  data: [10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10,],
                  borderWidth: 1,              
                  backgroundColor: ['#03f61f']
              },
              {
                  label: '74',
                  data: [10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10,],
                  borderWidth: 1,              
                  backgroundColor: ['#03f61f']
              },
              {
                  label: 'Arrear',
                  data: [1, 2, 3, 4, 5, 6],
                  borderWidth: 1,              
                  backgroundColor: ['blue']
              },
              {
                  label: 'Advance',
                  data: [1, 2, 3, 4, 5, 6],
                  borderWidth: 1,              
                  backgroundColor: ['yellow']
              },
              {
                  label: 'At Source',
                  data: [1, 2, 3, 4, 5, 6],
                  borderWidth: 1,              
                  backgroundColor: ['perple']
              }

            ]
        },
        options: {}
    });
</script>
  @endpush