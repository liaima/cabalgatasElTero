<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<h1>Nueva Reserva</h1>

<a href="<?= Url::toRoute('site/reservas') ?>" class="btn btn-primary"><i class="bi bi-card-list"></i> Lista de reservas...</a>

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
?>

<div class="container-sm">
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
    <?= $form->field($model, 'caballos')->input(type: 'number') ?>
   </div>

   </div>
  </div>
  
  <?= Html::submitInput('Cargar', ['class'=>'btn btn-primary']) ?>
</div>
<?php 

  $form->end();

?>
