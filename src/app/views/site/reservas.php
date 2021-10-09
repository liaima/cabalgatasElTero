<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\widgets\LinkPager;
?>

  <a href="<?= Url::toRoute('site/nueva') ?>" class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Nueva Reserva</a>
  <a href="<?= Url::toRoute([
    'site/reservas', 
    'todas'=>($todas) ? false : true]) ?>" class="btn btn-info"><i class="bi bi-view-list"></i> 
    <?= ($todas) ? 'Ver desede hoy' : 'Ver Todas' ?></a>
    <a href="<?= Url::toRoute('site/reservas') ?>" class="btn btn-secondary"><i class="bi bi-arrow-repeat"></i> Actualizar</a>
<br>
<h3>Lista de Reservas</h3>

<?php if($mensaje!=null){
  echo "<div class='alert alert-$color' role='alert'> $mensaje </div>";
}
?>

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
$i = 0;
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
    <p><?= $row->comentario ?></p>
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
        'caballos'=>$row->cantCaballos,
        'comentario'=>($row->comentario!=null)? $row->comentario : "",]) ?>" class="btn btn-success"><i class="bi bi-pencil"></i>Editar
      </a>

     
      

      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$i?>">
      <i class="bi bi-trash"></i>Borrar
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal<?=$i?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Borrar Reserva</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Está seguro que desea borrar la reserva de <?=$row->nombre?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <a href="<?= Url::toRoute([
              'site/delreserva', 
              'id'=>$row->id,
              'nombre'=>$row->nombre, 
            ]) ?>" class="btn btn-danger">Si, borrar</a>
            </div>
          </div>
        </div>
      </div>
   
  </td>
</tr>
<?php 
$color="";
$valor = "";
$i++;
endforeach ;
if($data==null){
  echo "<div class='alert alert-warning' role='alert'> No Hay Reservas... </div>";
} ?>
</table>

</div>

<?= LinkPager::widget([
  'pagination' => $pages,
]); ?>



