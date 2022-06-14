<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TestiOtveti]].
 *
 * @see TestiOtveti
 */
class TestiOtvetiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TestiOtveti[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TestiOtveti|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
