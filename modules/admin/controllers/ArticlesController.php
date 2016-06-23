<?php

namespace app\modules\admin\controllers;

use Yii;
use app\components\Controller;
use app\models\Articles;
use app\models\Files;
use yii\web\UploadedFile;

class ArticlesController extends Controller
{
    public function actionIndex() {
        $articles = new Articles(['scenario' => Articles::SCENARIO_FILTER]);
        return $this->render('index', [
            'dataProvider' => $articles->search(Yii::$app->request->get()),
            'filterModel' => $articles,
        ]);
    }

    public function actionCreate() {
        $articles = (new Articles)->loadDefaultValues();

        if ($articles->load(Yii::$app->request->post()) && $articles->validate()) {
            $res = $articles->save();
            return $this->redirect('/admin/articles/edit/' . $articles->article_id);
        } else {
            return $this->render('create', ['model' => $articles, 'type' => 'create']);
        }
    }

    public function actionEdit($id)
    {
        $articles = Articles::find()
            ->where(['article_id' => $id])
            ->one();

        $upload_files = new Files(['scenario' => Files::SCENARIO_IMAGE]);

        if (Yii::$app->request->isPost && UploadedFile::getInstance($upload_files, 'downloadFile')) {
            if ($upload_files->load(Yii::$app->request->post()) && $upload_files->validate()) {
                $upload_files->save();
                $upload_files->upload();
            }
        }

        if ($articles->load(Yii::$app->request->post()) && $articles->validate()) {
            $results = $articles->save();
            return $this->render('edit', ['model' => $articles, 'upload_files' => $upload_files, 'type' => 'create', 'result' => $results]);
        } else {
            return $this->render('edit', ['model' => $articles, 'upload_files' => $upload_files, 'type' => 'edit']);
        }
    }

    public function actionDelete($id) {
        if (Articles::deleteAll(['article_id' => $id])) {
            return $this->redirect('/admin/articles');
        }
    }

    public function actionMultipleDelete() {
        if (Articles::deleteAll(['article_id' => Yii::$app->request->post('ids')])) {
            echo json_encode('ok');
        } else {
            echo json_encode('nok');
        }
    }

}