<div class="col-sm-12 my-4 py-5" style="background-color: lightgray; width: 100%;">
    <div class="container">
        <h1>Citas - Ayurá Motor</h1>
    </div>
</div>
<div class="container">
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
        {{ $message }}
    </div>
    @endif
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i></h5>
        {{ $message }}
    </div>
    @endif
</div>
<div class="container">
 <p style="text-align: justify; padding-right: 15%;">Su cita en este formulario queda agendada para la hora y día seleccionados, cabe resaltar que queda sujeta a novedades de diagnóstico adicionales que se puedan presentar con su vehículo durante la revisión o lo manifestado previamente a nuestra central de atención.</p>
</div>

<div class="container">

    <form method="post" action="{{url('/reservations')}}">
        @csrf
        
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="name" class="form-control" id="nombre" name="nombre" aria-describedby="emailHelp" placeholder="Ingrese Nombre Completo">
        </div>

        <div class="form-group">
            <label for="email">Correo Eelectronico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese correo electronico">
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="phone">Celular</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Ingrese numero de celular" data-mask="(000) 000-0000"> 
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="cedula">Cédula</label>
                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Ingrese su numero de cedula">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="vehiculo">Vehiculo</label>
                    <select class="form-control" id="vehiculo" name="vehiculo">
                        <option value="">Seleccionar</option>
                        @foreach ($vehiculos as $id => $vehiculo)
                        <option value="{{$id}}">{{$vehiculo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="placa">Placa</label>
                    <input type="text" class="form-control" id="placa" name="placa" placeholder="Ingrese su placa">
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="sede">Sede</label>
                    <select class="form-control" id="sede" name="sede">
                        <option value="">Seleccionar</option>
                        @foreach ($sedes as $id => $sede)
                        <option value="{{$id}}">{{$sede['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="servicio">Servicio</label>
                    <select class="form-control" id="servicio" name="servicio">
                        <option value="">Seleccionar</option>
                        @foreach ($servicios as $id => $servicio)
                        <option value="{{$id}}">{{$servicio}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="form-group" style="width:100%;">
                <label for="servicio">Comentarios</label><br>
                <textarea id="comentarios" name="comentarios" rows="4" style="width: 100%; border-radius: 20px;"></textarea>
            </div>
        </div>



        <div class="container" id="seccion_mensajes" style="text-align: center; margin-top: 1%; margin-bottom: 2%;color: red;
        font-size: 13pt; display: none;">
        <strong>Este tipo de diagnostico solo se realiza en Taller Las Vegas.*</strong> 
    </div>


    <div class="row">
        <div class="col-sm-4">
            <!-- Datepicker -->
            <div id="datepicker" ></div>
            <input type="hidden" id="my_hidden_input">
        </div>
        
        <div class="col-sm-8">
            <div id="horasdisponibles" style="display: flex;"></div>
        </div>
    </div>



    <input id="fecha" name="fecha" type="hidden" value="">

</div>

<script>
    var date = new Date();
    var currentMonth = date.getMonth();
        // quitar en produccion
        currentMonth=currentMonth+1;
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();

        //var date = new Date();
        //date.setDate(date.getDate()+1);

        //alert('esta es la fecha de inicio: '+ date);


        $('#datepicker').datepicker({
            todayHighlight: true,
            startDate: date,
            language: 'es',
        //mes dia anio
        //startDate:"02/16/2021",
        startDate:'"'+currentMonth+'/'+(currentDate+1)+'/'+currentYear+'"',

        
        
    });

        $('#datepicker').datepicker().on('changeDate', function (ev) {
            
            
        //limpiamos el div
        $('#horasdisponibles').html("");

        var mes = ((ev.date.getMonth())+1);
        var dia= ev.date.getDate();
        var anio =ev.date.getFullYear();

        
        //traemos el id de la sede seleccionada
        var idSede = $('#sede').val();
        //alert('esta es la sede'+idSede);

        //obtenemos la fecha en el formato deseado anio-mes-dia
        if(mes<10){
            var fecha = anio+'-0'+mes+'-'+dia;
        }else{
            var fecha = anio+'-'+mes+'-'+dia;
        }
        

        //realizamos una llamada ajax para mostrar los horarios
        //pasamos el id de la sede
        getHorariosDisponibles(idSede,fecha);   //agregar fecha dia/mes/anio

    });


        function getHorariosDisponibles(sedeID,fecha){

            var result = [];

            $.ajax({
            //url: 'api/hours/2/2021-02-22',
            url: 'api/hours/'+sedeID+'/'+fecha,
            beforeSend: function() {
                $.blockUI({ 
                    message: "<h3>Buscando disponibilidad de su cita...<h3>", 
                    css: { color: 'black', borderColor: 'black' } 
                }); 
            },
            success: function(respuesta) {
                console.log(respuesta);
                
                if(Object.keys(respuesta).length === 0){
                    $( "#horasdisponibles" ).append('<p>No existe disponibilidad en el horario seleccionado, Por favor SELECCIONA OTRA FECHA</p>');
                }else{
                    //recorremos el array y poblamos el div de horarios
                    jQuery.each( respuesta, function( i, val ) {
                        $( "#horasdisponibles" ).append( 
                            '<div onClick="setHOur(this);" class="div_hour" data-hour="'+fecha+' '+val+'" >'+val+'-'+(parseInt(i, 10)+1)+':00 </div>' );
                    });
                }
                $.unblockUI();
            },
            error: function() {
                console.log("No se ha podido obtener la información");
                $( "#horasdisponibles" ).append('<p>Ha ocurrido un error intente nuevamente</p>');
                $.unblockUI();
                return[];
            }
        });

        }
        

        $('#datepicker').on('changeDate', function() {
            $('#my_hidden_input').val(
                $('#datepicker').datepicker('getFormattedDate')
                );
        });

        
    //funcion para marcar hora
    function setHOur(obj){
        //deseleccionamos alguno que tenga esa clase
        $("#horasdisponibles div").each(function(){
          if($(this).hasClass("div_hour_select")){
            $(this).removeClass("div_hour_select");    
        }
    });

        //agregamos la clase
        $(obj).addClass('div_hour_select');

        //setemos valor a campo oculto para el envio en el formulario
        setHourInput();
    };

    function setHourInput(){
        //seteamos la fecha escogida por el cliente para enviar al back
        
        var horaSelect = [];

        $("#horasdisponibles div").each(function(){
       		    //alert($(this).attr('id'));
                //console.log($(this).hasClass( "div_hour_select" ));
                if($(this).hasClass( "div_hour_select" )){
                    horaSelect.push($(this).attr("data-hour"));
                }
            });

        $("#fecha").val(horaSelect[0]);
        //console.log(horaSelect[0]);
    }

    //condicion servicio
    $('#servicio').change(function () {
       //revizamos que sede tenemos
       //si es diferente de id = 1 = Taller Avenida las vegas mostramos mensaje
       if($(this).val()==1){
        if($('#sede').val() != 1){
                //mostramos el modal
                $('#btnEnviar').prop('disabled', true);
                $("#seccion_mensajes").show();

            }else{
                $('#btnEnviar').prop('disabled', false);
                $("#seccion_mensajes").hide();
            } 
        }else{
            $('#btnEnviar').prop('disabled', false);
            $("#seccion_mensajes").hide();
        }
        
    });

    //condicion servicio 2
    //condicion servicio
    $('#sede').change(function () {
        if($('#servicio').val()==1){
            if($(this).val() != 1){
                //mostramos el modal
                $('#btnEnviar').prop('disabled', true);
                $("#seccion_mensajes").show();
            }else{
                $('#btnEnviar').prop('disabled', false);
                $("#seccion_mensajes").hide();
            } 
        }else{
            $('#btnEnviar').prop('disabled', false);
            $("#seccion_mensajes").hide();
        }
        
    });

</script>

<div class="container" style="text-align: center;">
    <button id="btnEnviar" type="submit" class="btn btn-primary" style="width: 100%;margin-bottom: 5%; margin-top: 3%;">
        Pedir Cita
    </button>
</div>

</form>


</div>






<style>

    .datepicker-inline{
        width: 100% !important;    
    }

    .table-condensed{
        width: 100% !important;
    }

    .div_hour{
        color: #B8862E;
        border: 1px solid;
        border-color: #B8862E;
        padding: 10px 10px 10px 10px;
        margin-right: 10px;
        font-size: 14px;
        cursor: pointer;
    }

    .div_hour_select{
        color: white !important;
        background-color: #B8862E !important;
    }
</style>