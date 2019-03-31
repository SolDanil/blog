<?php
namespace app\modules\admin\controllers;
use app\models\Comment;
use yii\web\Controller;
class CommentController extends Controller
{
    /**
     * Страница отображения всех коментариев.
     * @return Возвращает страницу со всеми комментариями блога      
     */
    public function actionIndex()
    {
        $comments = Comment::find()->orderBy('id desc')->all();

        return $this->render('index',['comments'=>$comments]);
    }
    /**
     * Удаление комментария.
     * @param integer $id 
     * @return Перенаправление на страницу со всеми комментариями блога      
     */
    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);
        if($comment->delete())
        {
            return $this->redirect(['comment/index']);
        }
    }
    /**
     * Разрешение комментария для отображения в болге.
     * @param integer $id 
     * @return Перенаправление на страницу со всеми комментариями блога      
     */
    public function actionAllow($id)
    {
        $comment = Comment::findOne($id);
        if($comment->allow())
        {
            return $this->redirect(['index']);
        }
    }
    /**
     * Запрещение комментария для отображения в болге.
     * @param integer $id 
     * @return Перенаправление на страницу со всеми комментариями блога      
     */
    public function actionDisallow($id)
    {
        $comment = Comment::findOne($id);
        if($comment->disallow())
        {
            return $this->redirect(['index']);
        }
    }
}