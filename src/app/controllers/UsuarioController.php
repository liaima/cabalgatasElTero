<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\UsuarioSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for Usuarios model.
 */
class UsuarioController extends Controller
{
    
    /**
     * @inheritDoc
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
                        //'actions' => ['logout', 'index', 'create', 'view', 'delete', 'update'],
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
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->username = $_POST['Usuarios']['username'];
                    $model->nombre = $_POST['Usuarios']['nombre'];
                    $model->perfil = $_POST['Usuarios']['perfil'];
                    $model->password = password_hash($_POST['Usuarios']['password'], PASSWORD_BCRYPT);
                    $model->authKey = md5(random_bytes(5));
                    $model->accessToken = password_hash(random_bytes(5), PASSWORD_DEFAULT);

                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }else{
                        $model->getErrors();
                    }
                }else{
                    $model->getErrors();
                }
                
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->username = $_POST['Usuarios']['username'];
                    $model->nombre = $_POST['Usuarios']['nombre'];
                    $model->perfil = $_POST['Usuarios']['perfil'];
                    $model->password = password_hash($_POST['Usuarios']['password'], PASSWORD_BCRYPT);
                    $model->authKey = md5(random_bytes(5));
                    $model->accessToken = password_hash(random_bytes(5), PASSWORD_DEFAULT);

                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }else{
                        $model->getErrors();
                    }
                }else{
                    $model->getErrors();
                }
                
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
