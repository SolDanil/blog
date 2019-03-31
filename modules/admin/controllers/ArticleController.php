<?php
namespace app\modules\admin\controllers;
use app\models\Category;
use app\models\ImageUpload;
use app\models\Tag;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $category=ArrayHelper::map(Category::find()->select('id,title')->asArray()->all(), 'id', 'title');
        $model = new Article();
        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'category'=>$category,
                'selected'=>array(),
            ]);
        }
    }
    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $category=ArrayHelper::map(Category::find()->select('id,title')->asArray()->all(), 'id', 'title');
        $selected=array(''.$category_id =>['Selected' => true]);


        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'category'=>$category,
                'selected'=>$selected,
            ]);
        }
    }
    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Если есть данные POST, то сохраняем файл и перенаправляем на страницу статьи.
     * Если данных POST нет, то загружаем форму для загрузки файла.
     * @param integer $id      
     */
    public function actionSetImage($id)
    {
        $model = new ImageUpload;
        if (Yii::$app->request->isPost)
        {
            $article = $this->findModel($id);
            $model->image = UploadedFile::getInstance($model, 'image');
            if($article->saveImage($model->uploadFile($article->image)))
            {
                return $this->redirect(['view', 'id'=>$article->id]);
            }
        }

        return $this->render('image', ['model'=>$model]);
    }
    /**
     * По данным $id получаем, данные статьи 
     * Если есть данные POST, то сохраняем категорию и перенаправляем на страницу статьи.
     * Если данных POST нет, то загружаем форму для настройки категории.
     * @param integer $id      
     */
    public function actionSetCategory($id)
    {
        $article = $this->findModel($id);
        $selectedCategory = $article->category->id;
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');
        if(Yii::$app->request->isPost)
        {
            $category = Yii::$app->request->post('category');
            if($article->saveCategory($category))
            {
                return $this->redirect(['view', 'id'=>$article->id]);
            }
        }
        return $this->render('category', [
            'article'=>$article,
            'selectedCategory'=>$selectedCategory,
            'categories'=>$categories
        ]);
    }
    /**
     * По данным $id получаем, данные статьи 
     * Если есть данные POST, то сохраняем тэги и перенаправляем на страницу статьи.
     * Если данных POST нет, то загружаем форму для настройки тэгов.
     * @param integer $id      
     */
    public function actionSetTags($id)
    {
        $article = $this->findModel($id);
        $selectedTags = $article->getSelectedTags(); // нвыбранные теги для данной статьи
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
        if(Yii::$app->request->isPost)
        {
            $tags = Yii::$app->request->post('tags');
            $article->saveTags($tags);
            return $this->redirect(['view', 'id'=>$article->id]);
        }

        return $this->render('tags', [
            'selectedTags'=>$selectedTags,
            'tags'=>$tags
        ]);
    }
}