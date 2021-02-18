<div class="col-sm-12 my-4 py-5" style="background-color: lightgray; width: 100%;">
    <div class="container">
        <h1>Citas - Ayurá Motor</h1>
    </div>
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

  <div class="row">
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


  <!-- Datepicker -->
<h2 class="demoHeaders">Datepicker</h2>
<div id="datepicker">
</div>
<script>
    $( "#datepicker" ).datepicker({
       inline: true,
    });
</script>

    <button type="submit" class="btn btn-primary" style="width: 100%;margin-bottom: 5%; margin-top: 3%;">
        Pedir Cita
    </button>
</form>

</div>

