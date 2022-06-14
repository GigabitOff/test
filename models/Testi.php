<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "testi".
 *
 * @property int $id
 * @property string $username
 * @property string|null $user_id
 * @property int $ticher_id
 * @property string $country_id
 * @property string|null $city_id
 * @property int $school_id
 * @property string $classnumber_id
 * @property string|null $classlater_id
 * @property string $name_test
 * @property string $vopros_test
 * @property string $variant_a
 * @property string $variant_b
 * @property string $variant_c
 * @property string $variant_d
 * @property string $variant_i
 * @property string $variant_f
 * @property string $variant_g
 * @property string $value1
 * @property string $value2
 * @property string $value3
 * @property string $value4
 * @property string $value5
 * @property string $value6
 * @property string $value7
 * @property string $date
 * @property string $time
 * @property string|null $dateandtime
 * @property string|null $timeendtest
 * @property int $status_test
 * @property string $active
 * @property string $code_test
 */
class Testi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'username', 'ticher_id', 'country_id', 'school_id', 'classnumber_id', 'name_test', 'vopros_test', 'variant_a', 'variant_b', 'variant_c', 'variant_d', 'variant_i', 'variant_f', 'variant_g', 'value1', 'value2', 'value3', 'value4', 'value5', 'value6', 'value7', 'date', 'time', 'status_test', 'active', 'code_test'], 'required'],
            [['id', 'ticher_id', 'school_id', 'status_test'], 'integer'],
            [['date', 'time', 'dateandtime', 'timeendtest'], 'safe'],
            [['username', 'country_id', 'classnumber_id', 'name_test', 'vopros_test', 'variant_a', 'variant_b', 'variant_c', 'variant_d', 'variant_i', 'variant_f', 'variant_g', 'value1', 'value3', 'active', 'code_test'], 'string', 'max' => 255],
            [['user_id', 'city_id', 'classlater_id'], 'string', 'max' => 20],
            [['value2'], 'string', 'max' => 11],
            [['value4'], 'string', 'max' => 22],
            [['value5', 'value6', 'value7'], 'string', 'max' => 55],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'user_id' => 'User ID',
            'ticher_id' => 'Ticher ID',
            'country_id' => 'Country ID',
            'city_id' => 'City ID',
            'school_id' => 'School ID',
            'classnumber_id' => 'Classnumber ID',
            'classlater_id' => 'Classlater ID',
            'name_test' => 'Name Test',
            'vopros_test' => 'Vopros Test',
            'variant_a' => 'Variant A',
            'variant_b' => 'Variant B',
            'variant_c' => 'Variant C',
            'variant_d' => 'Variant D',
            'variant_i' => 'Variant I',
            'variant_f' => 'Variant F',
            'variant_g' => 'Variant G',
            'value1' => 'Value1',
            'value2' => 'Value2',
            'value3' => 'Value3',
            'value4' => 'Value4',
            'value5' => 'Value5',
            'value6' => 'Value6',
            'value7' => 'Value7',
            'date' => 'Date',
            'time' => 'Time',
            'dateandtime' => 'Dateandtime',
            'timeendtest' => 'Timeendtest',
            'status_test' => 'Status Test',
            'active' => 'Active',
            'code_test' => 'Code Test',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TestiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestiQuery(get_called_class());
    }
}
