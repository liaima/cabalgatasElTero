<?php
namespace app\models;

use Yii;
use yii\base\Model;

class ValidarReserva extends Model
{
  public $nombre;
  public $fecha;
  public $hora;
  public $caballos;

  public function rules()
  {
    return [
      ['nombre', 'required', 'message'=>'El nombre es requerido'],
      //['nombre', 'match', 'pattern'=>'/^.{3,50}$/', 'message'=>'Debe ser de 3 a 50 caracteres'],
      //['nombre', 'match', 'pattern'=>'/^[0-9a-z]+$/i', 'message'=>'Solo letras y números'],
      ['fecha', 'required', 'message'=>'La fecha es requerido'],
      ['hora', 'required', 'message'=>'La hora es requerido'],
      ['caballos', 'required', 'message'=>'La hora es requerido'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'nombre' => 'Nombre:',
      'fecha' => 'Fecha:',
      'hora' => 'Hora:',
      'caballos' => 'Cantidad de Caballos:'
    ];
  }
}
