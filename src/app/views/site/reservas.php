<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\widgets\LinkPager;
?>

  <a href="<?= Url::toRoute('site/nueva') ?>" class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Nueva...</a>
<br>
<h3>Lista de Reservas</h3>

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

<div class="container">
  <?= $form->field($model, "query")->input("search") ?>
  <?= Html::submitInput("Buscar", ["class"=>"btn btn-primary"]) ?>
</div>
<?php 
  $form->end();
?>
<br>
<div class="table-responsive">
<table class="table table-bordered align-middle">
  <tr>
    <th class="col-11">Reserva</th>
    <th class="col-1">Acciones</th>
  </tr>
<?php 
define('DIA', ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']);
$today = date("Y-m-d");
$color = "";
$valor = "";
 foreach($data as $row):
  $date = date_create($row->fecha);
  if ($row->fecha == $today) {
    $color="table-info";
  }
  if ($row->valor!=null) {
    $valor = " - $";   
  }
?>
<tr class=<?= $color ?>>
  <td>
    <p class="fs-5"> <?= DIA[date_format($date, "w")] ?> - <?= date_format($date, "d-m-Y") ?></p>
    <p><?= $row->hora ?> - <?= $row->recorrido ?> x<?= $row->cantCaballos ?> - <?= $row->nombre ?></p>
    <p><?= $row->telefono ?> - <?= $row->precio ?> <?=$valor . $row->valor ?></p>
  </td>
   
  <td>
    
      <a href="<?= Url::toRoute([
        'site/editreserva',
        'id'=>$row->id,
        'nombre'=>$row->nombre,
        'fecha'=> $row->fecha, 
        'hora'=>$row->hora,
        'recorrido'=>$row->recorrido,
        'precio'=>$row->precio,
        'valor'=>($row->valor!=null) ? $row->valor : "",
        'telefono'=>$row->telefono,
        'caballos'=>$row->cantCaballos]) ?>" class="btn btn-success"><i class="bi bi-pencil"></i>Editar
    
   
      <a href="<?= Url::toRoute([
        'site/delreserva', 
        'id'=>$row->id, 
      ]) ?>" class="btn btn-danger"><i class="bi bi-trash"></i>Borrar
   
  </td>
</tr>
<?php 
$color="";
$valor = "";
endforeach ?>
</table>
</div>

<?= LinkPager::widget([
  'pagination' => $pages,
]); ?>



