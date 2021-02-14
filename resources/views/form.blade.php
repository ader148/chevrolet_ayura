<div class="col-sm-12 my-4 py-5" style="background-color: lightgray; width: 100%;">
    <div class="container">
        <h1>Citas - Ayurá Motor</h1>
    </div>
</div>

<div class="container">
   <p style="text-align: justify; padding-right: 15%;">Su cita en este formulario queda agendada para la hora y día seleccionados, cabe resaltar que queda sujeta a novedades de diagnóstico adicionales que se puedan presentar con su vehículo durante la revisión o lo manifestado previamente a nuestra central de atención.</p>
</div>

<div class="container">

<form>
  
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese Nombre Completo">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Correo Eelectronico</label>
    <input type="email" class="form-control" id="exampleInputPassword1" placeholder="Ingrese correo electronico">
  </div>

  <div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="exampleInputPassword1">Celular</label>
            <input type="phone" class="form-control" id="exampleInputPassword1" placeholder="Ingrese numero de celular">
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="exampleInputPassword1">Cédula</label>
            <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Ingrese su numero de cedula">
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="exampleInputPassword1">Vehiculo</label>
            <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="exampleInputPassword1">Placa</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Ingrese su placa">
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="exampleInputPassword1">Sede</label>
            <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="exampleInputPassword1">Servicio</label>
            <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
    </div>
  </div>


  <!-- Datepicker -->
<h2 class="demoHeaders">Datepicker</h2>
<div id="datepicker"></div>


<script>
    $( "#datepicker" ).datepicker({
	inline: true
});
</script>
  
  <button type="submit" class="btn btn-primary" style="width: 100%;margin-bottom: 5%; margin-top: 3%;">Pedir Cita</button>
</form>

</div>