<?php

namespace frontend\controllers;

use app\models\Blog;
use app\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\bootstrap4\Html;
use app\models\Telegram;
use Yii;
/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Blog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'blank';

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'blank';

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
   

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'blank';

        $model = new Blog();
        $model -> user_id = Yii::$app->user->identity->id;
        $model -> date = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');;
       
        
       $chat_id ='@dostonolimov2217'; 
       $bot = new Telegram($chat_id); 

        if ($model->load(Yii ::$app->request->post()) ) {
                
                $model -> file =  UploadedFile::getInstance($model,'file');

                $model->save();
      
               $telegram_title = $model->title . PHP_EOL .$model->body;
               $telegram_text = substr($telegram_title,0,200);
              $telegram_text =$telegram_text . PHP_EOL.'To\'liq o\'rish uchun...http://yii2.me/frontend/web ';
                
                if ($model -> file ){
                if( $model -> upload($model -> id) )
                {
                    $path = Yii::getAlias('@frontend/web/images/' .$model->id .'.' .$model->file->extension);
                   
                    $bot->sendPhoto($path,$telegram_text);
                    
                    return $this->redirect(['view', 'id' => $model->id,]);
                }
            }
            else{
                $bot->sendMessage($telegram_text);
                return $this->redirect(['view', 'id' => $model->id,]); 
            }
            }
         else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'blank';
        
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            $model->file = UploadedFile::getInstance($model,'file');

            if ($model -> file && $model -> img_src )
            {

                $model->deleteImage();

                $model->upload($model -> id) ;

                return $this->redirect(['view', 'id' => $model->id,]);

            }
            elseif($model -> file && ! $model -> img_src)
            {
                $model -> upload($model -> id) ;

                return $this->redirect(['view', 'id' => $model->id,]);
            }
            
            else{
                return $this->redirect(['view', 'id' => $model->id,]); 
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blog model.
        * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model -> img_src){
            $model -> deleteImage();
            $model->delete();
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**Upload image file */
    
}
