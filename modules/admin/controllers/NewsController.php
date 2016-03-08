<?php

namespace app\modules\admin\controllers;

use Yii;
use app\components\Controller;
use app\models\News;
use yii\data\ActiveDataProvider;

class NewsController extends Controller
{

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find(),
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate() {
        $news = (new News)->loadDefaultValues();

        if ($news->load(Yii::$app->request->post()) && $news->validate()) {
            if ($news->save()) {
                return $this->redirect('/admin/news/edit/' . $news->news_id);
            }
        } else {
            return $this->render('create', ['model' => $news]);
        }
    }

    public function actionEdit($id)
    {
        if (!empty($id)) {
            $news = News::find()
                ->where(['news_id' => $id])
                ->one();

//            if ($news) $user = User::findOne($news->user_id);

            if ($news->load(Yii::$app->request->post()) && $news->validate()) {
                $results = $news->save();
                return $this->render('edit', ['model' => $news, 'type' => 'create', 'result' => $results]);
            } else {
                return $this->render('edit', ['model' => $news, 'type' => 'edit']);
            }
        }
    }

    public function actionDelete($id) {
        if (News::deleteAll(['news_id' => $id]))
            return $this->redirect('/admin/news');
    }

    public function actionMultipleDelete() {
        if (News::deleteAll(['news_id' => Yii::$app->request->post('ids')])) {
            echo json_encode('ok');
        } else {
            echo json_encode('nok');
        }
    }

}