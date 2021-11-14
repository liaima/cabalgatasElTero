<?php
namespace app\models;

use Yii;
use yii\base\Model;

class ValidarReserva extends Model
{
  public $nombre;
  public $fecha;
  public $hora;
  public $telefono;
  public $recorrido;
  public $caballos;
  public $precio;
  public $valorOferta;
  public $comentario;

  public function rules()
  {
    return [
      ['nombre', 'required', 'message'=>'El nombre es requerido'],
      //['nombre', 'match', 'pattern'=>'/^.{3,50}$/', 'message'=>'Debe ser de 3 a 50 caracteres'],
      //['nombre', 'match', 'pattern'=>'/^[0-9a-z]+$/i', 'message'=>'Solo letras y números'],
      ['telefono', 'required', 'message'=>'El nombre es requerido'],
      ['telefono', 'match', 'pattern'=>'/^[0-9]+$/i', 'message'=>'Solo números'],
      ['fecha', 'required', 'message'=>'La fecha es requerido'],
      ['hora', 'required', 'message'=>'La hora es requerido'],
      ['recorrido', 'required', 'message'=>'La hora es requerido'],
      ['caballos', 'required', 'message'=>'La hora es requerido'],
      ['precio', 'required', 'message'=>'La hora es requerido'],
      ['valorOferta', 'match', 'pattern'=>'/^[0-9]+$/i', 'message'=>'Solo números'],
      ['comentario', 'default'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'nombre' => 'Nombre:',
      'telefono' => 'Teléfono:',
      'fecha' => 'Fecha:',
      'hora' => 'Hora:',
      'recorrido' => 'Recorrido:',
      'caballos' => 'Cantidad de Caballos:',
      'precio' => 'Precio:',
      'valorOferta' => 'Precio Total:',
      'comentario' => 'Comentario:'
    ];
  }
}
