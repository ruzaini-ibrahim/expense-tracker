@extends('layout.master')

@section('title','Dashboard')

@section('content')
 
@php @endphp
<div class="page">
	<div class="page-header text-center">
      <h1 class="page-title">Dashboard</h1>      
    </div>
    <div class="page-content container-fluid">
      <div class="row" data-plugin="matchHeight" data-by-row="true">
        <div class="col-xxl-8 col-lg-8 offset-lg-2 offset-xxl-2">
          <!-- Widget Linearea Color -->
          <div class="card card-shadow card-responsive" id="widgetLineareaColor">
            <div class="card-block p-0">
              <div class="pt-30 p-30" style="height:calc(100% - 250px);">
                <div class="row">
                  <div class="col-8">                    
                    <div class="counter counter-md text-left">
                      <div class="counter-number-group">
                      	<p class="font-size-20 blue-grey-700">Total Expense</p>
                        <span class="counter-icon red-600"><i class="icon wb-triangle-down" aria-hidden="true"></i></span>
                        <span class="counter-number red-600">RM 
                        @php 
                          $total = 0;
            							foreach($amount as $per){
              								$total += $per;
              						}
            							echo $total;
                        @endphp
                    	</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                		<canvas id="exampleChartjsPie" height="150"></canvas>
                </div>
              </div>              
            </div>
          </div>
          <!-- End Widget Linearea Color -->
        </div>        
        
      </div>
    </div>
</div>
  
@endsection

@push('scripts')
<script>
	
(function() {

	var dSubject = @php echo json_encode($subject) @endphp;
	var dAmount = @php echo json_encode($amount) @endphp;
  var dBgColor = @php echo json_encode($bgColor) @endphp;
  var dHovBgColor = @php echo json_encode($hovBgColor) @endphp;	
	console.log(dAmount);

    var pieData = {
      labels: dSubject,
      datasets: [{
        data: dAmount,
        backgroundColor: dBgColor,
        hoverBackgroundColor: dHovBgColor
      }]
    };

    var myPie = new Chart(document.getElementById("exampleChartjsPie").getContext("2d"), {
      type: 'doughnut',
      data: pieData,
      options: {
        responsive: true
      }
    });
  })();

</script>
@endpush