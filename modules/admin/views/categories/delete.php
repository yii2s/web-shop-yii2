<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Администрирование', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Удаление категории $model->category_id - '$model->name' и всех ее подкатегорий:";


echo buildTree($tree, $model->category_id, $quantities);

function buildTree($cats, $parent_id, $quant)
{
    if (isset($cats[$parent_id])) {
        $tree = '<ul>';
        foreach ($cats[$parent_id] as $cat_id => $name) {
            $tree .= '<li>' . $cat_id . ' - ' . $name . ' (' . $quant[$cat_id]['quantity_visible'] . ') ' . ' (' . $quant[$cat_id]['quantity_invisible'] . ') ';
            $tree .= buildTree($cats, $cat_id, $quant);
            $tree .= '</li>';
        }
        $tree .= '</ul>';
        return $tree;
    }
}
?>

<div>
    Вы действительно хотите удалить категорию <?= $model->category_id ?> - "<?= $model->name ?>"
    ( <?= $quantities[$model->category_id]['quantity_visible'] ?> )
    ( <?= $quantities[$model->category_id]['quantity_invisible'] ?> )
    и все ее подкатегории?
</div>

<?= Html::a('Да', ['categories/delete', 'id' => $model->category_id, 'confirm' => true], ['class' => 'btn btn-success']); ?>
<?= Html::a('Нет', ['categories/index'], ['class' => 'btn btn-warning']); ?>