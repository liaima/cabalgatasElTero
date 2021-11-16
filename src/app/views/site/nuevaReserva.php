<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<h1>Nueva Reserva</h1>


<div class="container">
<a href="<?= Url::toRoute('site/reservas') ?>" class="btn btn-primary"><i class="bi bi-card-list"></i> Lista de reservas...</a>
</div>
<br>

<?php if($mensaje!=null){
  echo "<div class='alert alert-success' role='alert'>$mensaje</div>";
} ?>
<?php 
  $form = ActiveForm::begin([
    'method'=>'post',
    'id' => 'nuevaReserva',
    'enableClientValidation'=> true,
    'enableAjaxValidation' => false
  ]);
  $itemsRecorrido = [
    "45'" => "45' ",
    "Río" => "Río",
    "Lago" => "Lago",
    "Cascada" => "Cascada",
    "Quemado" => "Quemado",
    "Ladera" => "Ladera"
  ];
  $itemsPrecio = [
    "Completo" => "Completo ",
    "Descuento" => "Descuento",
    "Residente" => "Residente",
    "Exlusivo" => "Exlusivo",
    "Oferta" => "Oferta"
  ];
  $itemsCaballos = [
    "1" => "1 ",
    "2" => "2",
    "3" => "3",
    "4" => "4",
    "5" => "5",
    "6" => "6"
  ];
?>

<div class="container-md">
  <div class="row">
    <div class="col">
      <div class="form-group">
        <?= $form->field($model, 'nombre')->input(type: 'text', options: [
          'placeholder'=>'Nombre:'
        ]) ?>  
      </div>
   </div> 
  </div>
  <div class="row">
   <div class="col-sm-6">
    <div class="form-group">
      <?= $form->field($model, 'telefono')->input(type: 'number', options: [
        'placeholder'=>'Teléfono:'
      ]) ?>  
    </div>
   </div>  
    <div class="col-sm">
      <div class="form-group">
        <?= $form->field($model, 'precio')->dropdownList(items: $itemsPrecio) ?>
      </div>
    </div> 
    <div id="valorDeOferta" class="col-sm" hidden>
     <div class="form-group">
        <?= $form->field($model, 'valorOferta')->input(type: 'number', options: [
          'placeholder'=>'Precio:'
        ]) ?>  
      </div>
   </div>  
  </div>  
  <div class="row">
    <div class="col">
      <div class="form-group">
        <?= $form->field($model, 'fecha')->input(type: 'date') ?>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <?= $form->field($model, 'hora')->input(type: 'time') ?>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <?= $form->field($model, 'recorrido')->dropdownList(items: $itemsRecorrido) ?>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <?= $form->field($model, 'caballos')->dropdownList(items: $itemsCaballos) ?>
      </div>
   </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="form-group">
        <?= $form->field($model, 'comentario')->textarea(options: [
          'placeholder'=>'Comentario:'
        ]) ?>  
      </div>
   </div> 
  </div>
  
  <?= Html::submitInput('Cargar', ['class'=>'btn btn-primary']) ?>
</div>
<?php 

  $form->end();

?>

<script>
  let precio = document.getElementById('validarreserva-precio');
  //let valor = precio.value;
  //console.log(valor);
  precio.addEventListener('change', ()=>{
    let valor = precio.value;
    if (valor == 'Oferta') {
      console.log('oferta!');
      document.getElementById('valorDeOferta').hidden = false;
    }else{
      document.getElementById('valorDeOferta').hidden = true;
    }
    console.log(valor);
  });
</script>
