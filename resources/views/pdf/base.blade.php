{{-- @extends('default')

@section('main') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">    
</head>
<body>
    <style>
   

body {
    font-family: Helvetica, sans-serif;
}
table {
    border-collapse: collapse;
}
.table td ,.table th {
    padding: 0.75rem;
    vertical-align: top;
    border: 1px solid #dee2e6;
}
.fs-12{
    font-size: 12px;
}
.text-center{
    text-align: center;
}
table.fs-12 td ,table.fs-12 th{
    padding: 0.5rem 0.75rem;
    font-size: 12px;
    text-align: center
}
/*

th {
    text-align: inherit;
}

.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}

.table th,

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
    border-top: 2px solid #dee2e6;
}

.table .table {
    background-color: #fff;
}

.table-sm th,
.table-sm td {
    padding: 0.3rem;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-borderless th,
.table-borderless td,
.table-borderless thead th,
.table-borderless tbody + tbody {
  border: 0;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}


.table-primary,
.table-primary > th,
.table-primary > td {
  background-color: #b8daff;
}



.table-secondary,
.table-secondary > th,
.table-secondary > td {
  background-color: #d6d8db;
}


.table-success,
.table-success > th,
.table-success > td {
  background-color: #c3e6cb;
}



.table-info,
.table-info > th,
.table-info > td {
  background-color: #bee5eb;
}

.table-warning,
.table-warning > th,
.table-warning > td {
  background-color: #ffeeba;
}

.table-danger,
.table-danger > th,
.table-danger > td {
  background-color: #f5c6cb;
}


.table-light,
.table-light > th,
.table-light > td {
  background-color: #fdfdfe;
}



.table-dark,
.table-dark > th,
.table-dark > td {
  background-color: #c6c8ca;
}


.table-active,
.table-active > th,
.table-active > td {
  background-color: rgba(0, 0, 0, 0.075);
}


.table .thead-dark th {
  color: #fff;
  background-color: #212529;
  border-color: #32383e;
}

.table .thead-light th {
  color: #495057;
  background-color: #e9ecef;
  border-color: #dee2e6;
}

.table-dark {
  color: #fff;
  background-color: #212529;
}

.table-dark th,
.table-dark td,
.table-dark thead th {
  border-color: #32383e;
}

.table-dark.table-bordered {
  border: 0;
}

.table-dark.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(255, 255, 255, 0.05);
}

.table-dark.table-hover tbody tr:hover {
  background-color: rgba(255, 255, 255, 0.075);
}
 div.breakNow { page-break-inside:avoid; page-break-after:always; }

        //tbody:before, tbody:after, thead:before,thead:after { display: none; } 
       
        //ul, img, table {
        //    page-break-inside: auto;
        //}

    thead:before, thead:after, tr:before, tr:after { display: none; }
    tbody:before, tbody:after { display: none; }
    
    thead tr td {font-weight: bold;}
   
       @page {
                margin: 75px 25px;
            }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

                // Extra personal styles 
                // background-color: #03a9f4;
                // color: white;
                // text-align: center;
                //line-height: 35px;
            }
            
            

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                // Extra personal styles
                // background-color: #03a9f4;
                //color: white;
                //text-align: center;
                //line-height: 35px;
            }

            .logodiv{
              position : absolute;
              top:0;
              left:10px;
            }
            .datediv{
              position: absolute;
              top:0;
              right: 10px;
            }
*/
    
    </style>

    <header >
      <div class="logodiv" >   
        <span >
          @if (isset($logo))
            <img style="width: 70px" src="{{$logo}}" alt="Suspensión Lujan" />
          @endif
        </span>
       
         
      </div>
      <div class="datediv" > 
        @if (isset($order))
           <span>{{ucfirst($order->seller)}} -- </span>
        @endif
              <span style="text-aling: right">{{$today}}</span> 
      </div>
           
       
  </header>
    
    <main>
    
      @yield('content')
    </main>
    
</body>
</html>
    

{{-- @endsection --}}