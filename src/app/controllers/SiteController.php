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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
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
          $tbl->fecha = $model->fecha;
          $tbl->hora = $model->hora;
          $tbl->cantCaballos = $model->caballos;
          if($tbl->insert())
          {
            $mensaje = "La reserva fue cargada correctamente.";
            $model->nombre=null;
            $model->fecha=null;
            $model->hora=null;
            $model->caballos=null;
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

    public function actionReservas($mensaje=null)
    {
      $model = new Query;
      
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
        $query = TblReservas::find();
      }

      $countQuery = clone $query;
      $pages = new Pagination([
          'totalCount' => $countQuery->count(),
          'pageSize' => 5
      ]);

      $data = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();


      return $this->render('reservas', [
        'mensaje'=>$mensaje, 
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

      return $this->redirect(['site/reservas', 'mensaje'=>$mensaje]);
    } 
  

}
