<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ValidarReserva;
use app\models\TblReservas;
use app\models\TblPrueba;
use yii\bootstrap\Modal;
use app\models\Query;
use app\models\Usuarios;
use yii\helpers\Html;
use yii\data\Pagination;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['login'],
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['logout', 'reservas', 'nueva'],
                        //Esta propiedad establece que tiene permisos
                        'allow' => true,
                        //Usuarios autenticados, el signo ? es para invitados
                        'roles' => ['@'],
                        //Este método nos permite crear un filtro sobre la identidad del usuario
                        //y así establecer si tiene permisos o no
                        'matchCallback' => function ($rule, $action) {
                            //Llamada al método que comprueba si es un administrador
                            return Usuarios::isUserAdmin(Yii::$app->user->identity->id);
                        },
                    ],
                    [
                       //Los usuarios simples tienen permisos sobre las siguientes acciones
                       'actions' => ['logout', 'reservas', 'nueva'],
                       //Esta propiedad establece que tiene permisos
                       'allow' => true,
                       //Usuarios autenticados, el signo ? es para invitados
                       'roles' => ['@'],
                       //Este método nos permite crear un filtro sobre la identidad del usuario
                       //y así establecer si tiene permisos o no
                       'matchCallback' => function ($rule, $action) {
                          //Llamada al método que comprueba si es un usuario simple
                          return Usuarios::isUserSimple(Yii::$app->user->identity->id);
                      },
                   ],
                ],
            ],
     //Controla el modo en que se accede a las acciones, en este ejemplo a la acción logout
     //sólo se puede acceder a través del método post
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

   
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
   
          if (Usuarios::isUserAdmin(Yii::$app->user->identity->id))
          {
            return $this->redirect(["../usuario"]);
          }
          else
          {
            return $this->redirect(["reservas"]);
          }
        }
 
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
   
            if (Usuarios::isUserAdmin(Yii::$app->user->identity->id))
            {
              return $this->redirect(["../usuario"]);
            }
            else
            {
              return $this->redirect(["reservas"]);
            }
   
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

     /**
     * Displays prueba page.
     *
     * @return string
     */
    public function actionPrueba()
    {
        return $this->render('prueba');
    }

  

    public function actionNueva()
    { 
      $model = new ValidarReserva;

      $mensaje = null; 

      if($model->load(Yii::$app->request->post()))
      {
        if ($model->validate())
        {
          //consultas, calulos etc, Guardado
          $tbl = new TblReservas;
          $tbl->nombre = $model->nombre;
          $tbl->telefono = $model->telefono;
          $tbl->fecha = $model->fecha;
          $tbl->hora = $model->hora;
          $tbl->recorrido = $model->recorrido;
          $tbl->cantCaballos = $model->caballos;
          $tbl->precio = $model->precio;
          $tbl->valor = $model->valorOferta;
          $tbl->comentario = $model->comentario;
          if($tbl->insert())
          {
            $mensaje = "La reserva fue cargada correctamente.";
            $model->nombre=null;
            $model->telefono=null;
            $model->fecha=null;
            $model->hora=null;
            $model->recorrido=null;
            $model->caballos=null;
            $model->precio=null;
            $model->valorOferta=null;
            $model->comentario=null;
          }
          else{
            $mensaje = "Ha ocurrido un error al insertar";
          }
        }
        else{
          $model->getErrors();
        }
      }
      return $this->render('nuevaReserva', ['model'=>$model, 'mensaje'=>$mensaje]);
    }

    public function actionReservas($mensaje=null, $color=null, $todas=false)
    {
      $model = new Query;
      $today = date("Y-m-d");
       
      if($model->load(Yii::$app->request->get()))
      {
        if ($model->validate())
        {
          $search = Html::encode($model->query);
          $query = TblReservas::find()
            ->where(['like', 'id', $search])
            ->orWhere(['like', 'nombre', $search]);
        }
        else{
          $model->getErrors();
        }
      }
      else
      {
        if ($todas) {
          $query = TblReservas::find()
            ->orderBy([
              'fecha' => SORT_ASC,
              'hora' => SORT_ASC
            ]);
        }else{
          $query = TblReservas::find()
          ->where(['>=', 'fecha', $today])
          ->orderBy([
            'fecha' => SORT_ASC,
            'hora' => SORT_ASC
          ]);
        }
        
      }

      $countQuery = clone $query;
      $pages = new Pagination([
          'totalCount' => $countQuery->count(),
          'pageSize' => 10
      ]);

      $data = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();


      return $this->render('reservas', [
        'mensaje'=>$mensaje, 
        'color'=>$color,
        'todas'=>$todas,
        'data'=>$data, 
        'model'=>$model,
        'pages'=>$pages
      ]);
    }

    public function actionDelreserva($id, $nombre)
    {
  
      $usr = TblReservas::findOne($id);
      $usr->delete();

      $mensaje = "Se ha eliminado el la reserva de: $nombre";

      return $this->redirect(['site/reservas', 'mensaje'=>$mensaje, 'color'=>'warning']);
    } 

    public function actionEditreserva($id, $nombre, $fecha, $hora, $recorrido, $precio, $valor, $telefono, $caballos, $comentario, $mensaje=null)
    {
      /*
      if ($comentario == null) {
        $comentario="";
      }*/
      $model = new ValidarReserva;
      $model->nombre=$nombre;
      $model->telefono=$telefono;
      $model->fecha=$fecha;
      $model->hora=$hora;
      $model->recorrido=$recorrido;
      $model->caballos=$caballos;
      $model->precio=$precio;
      $model->valorOferta=$valor;
      $model->comentario=$comentario;

      if($model->load(Yii::$app->request->post()))
      {
        if ($model->validate())
        {
          //consultas, calulos etc, Guardado
          $tbl = TblReservas::findOne($id);
          
          $tbl->nombre = $model->nombre;
          $tbl->telefono = $model->telefono;
          $tbl->fecha = $model->fecha;
          $tbl->hora = $model->hora;
          $tbl->recorrido = $model->recorrido;
          $tbl->cantCaballos = $model->caballos;
          $tbl->precio = $model->precio;
          $tbl->valor = $model->valorOferta;
          $tbl->comentario = $model->comentario;
          if($tbl->update())
          {
            $mensaje = "La reserva de $nombre fue actualizada correctamente.";
            $color = 'success';
            return $this->redirect(['site/reservas', 'mensaje'=>$mensaje, 'color'=>$color]);
          }
          else{
            $mensaje = "Ha ocurrido un error al actualizar";
          }
        }
        else{
          $model->getErrors();
        }
      }
      return $this->render('editreserva', [
        'model'=>$model,
        'id'=>$id,
        'nombre'=>$nombre,
        'fecha'=>$fecha,
        'hora'=>$hora,
        'recorrido'=>$recorrido,
        'precio'=>$precio,
        'valor'=>$valor,
        'telefono'=>$telefono,
        'caballos'=>$caballos,
        'comentario'=>$comentario,
        'mensaje'=>$mensaje,
      ]);
    }
  

}
