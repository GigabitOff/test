<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Testi]].
 *
 * @see Testi
 */
class TestiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Testi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Testi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
