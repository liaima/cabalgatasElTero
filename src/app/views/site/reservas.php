<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\widgets\LinkPager;
?>

  <a href="<?= Url::toRoute('site/nueva') ?>" class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Nueva...</a>

<h3>Lista de la tabla Usuarios</h3>

<?php if($mensaje!=null){
  echo "<div class='alert alert-warning' role='alert'> $mensaje </div>";
} ?>

<?php 
  $form = ActiveForm::begin([
    "method"=>"get",
    "action"=>Url::toRoute("site/reservas"),
    "enableClientValidation"=>true
  ]);
?>

<div>
  <?= $form->field($model, "query")->input("search") ?>
</div>

<?= Html::submitInput("Buscar", ["class"=>"btn btn-primary"]) ?>

<?php 
  $form->end();
?>
<table class="table table-bordered">
  <tr>
    <th>Codigo:</th>
    <th>Nombre:</th>
    <th>Fecha:</th>
    <th>Hora:</th>
    <th>Cantidad de Caballos:</th>
    <th>Acciones</th>
  </tr>
<?php 
 foreach($data as $row):
?>
<tr>
  <td>
    <?= $row->id ?>
  </td>
  <td>
    <?= $row->nombre ?>
  </td>
  <td>    
      <?= $row->fecha ?>    
  </td>
  <td>    
      <?= $row->hora ?>    
  </td>
  <td>    
      <?= $row->cantCaballos ?>    
  </td>
  <td>
    <a href="<?= Url::toRoute(['site/delreserva', 'id'=>$row->id, 'nombre'=>$row->nombre]) ?>" class="btn btn-danger"><i class="bi bi-trash"></i>
  </td>
</tr>
<?php endforeach ?>
</table>


