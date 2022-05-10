<?php 
$raiz=getenv("DOCUMENT_ROOT");
$directorio_general="/proyectoAlcance";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ALCANCE Proyecto José Escobar C.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
	<link rel="stylesheet" type="text/css" href="../vista/css/notify.css">
	<link rel="stylesheet" type="text/css" href="../vista/css/prettify.css">
        <script src="../vista/js/notify.js" type="text/javascript"></script>
        <script src="../vista/js/prettify.js" type="text/javascript"></script>
                <script src="../vista/js/pswmeter.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  
<link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<!--Inicialización del pluggin jquery data table,
que permite mostrar, eliminar y editar usuarios de forma sencilla -->
<script type="application/javascript">
    $(document).ready( function ()  
    {
        $('#datatableUsuarios').DataTable({
            'processing': true,
            'serverSide': false,
             "bServerSide": false,
            'serverMethod': 'post',
            "bPaginate": true,
              "scrollX": true,
            'ajax': {
                    'url':'../vista/datatable.php'
            },
            'columns':  
            [
                    { data: 'nombre' },
                    { data: 'apellidopaterno' },
                    { data: 'apellidomaterno' },
                    { data: 'correoelectronico' },
                    { data: 'tipousuarioDescripcion' },
                    { data: 'estatusDescripcion' },
                    {
                        "data": "nombre",
                        render:function(data, type, row)
                        {
                        return '<a href="?menu=1&editar='+row.id+'"><i class="fa fa-pencil"/></a>';
                        }
                    },
                    {
                        "data": "nombre",
                        render:function(data, type, row)
                        {
                        return '<a href="?menu=2&borrar='+row.id+'"><i class="fa fa-trash"/></a>';
                        }
                    }   
            ]
        });

    } );
    
</script>
  
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
   
</head>
<body>
    <main>
        <header>
           <div class="row">
               <div class="col-md-2">
                            <img src="../vista/assets/alcancelogo.png"  alt=""/>    
               </div>
               <div class="col-md-10" style="text-align: center;" >
             
                   <h3 style=" padding-top: 8%">Proyecto : José Escobar C. </h3>
               </div>
           </div>
         
        </header>
        
        