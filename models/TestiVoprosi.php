<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "testi_voprosi".
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
 * @property string $value_otveta
 * @property string $value_otveta_yes
 * @property string $vopros_test
 * @property string $variant_1
 * @property string $variant_2
 * @property string $variant_3
 * @property string $variant_4
 * @property string $variant_5
 * @property string $variant_6
 * @property string $variant_7
 * @property string $variant_8
 * @property string $variant_9
 * @property string $variant_10
 * @property string $value1
 * @property string|null $value2
 * @property string $value3
 * @property string $value4
 * @property string $value5
 * @property string $value6
 * @property string $value7
 * @property string $value8
 * @property string $value9
 * @property string $value10
 * @property string $date
 * @property string $time
 * @property string|null $dateandtime
 * @property string|null $timeendtest
 * @property int $status_test
 * @property string $active
 * @property string $summ_variant_pole
 * @property string $code_test
 */
class TestiVoprosi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testi_voprosi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'username', 'ticher_id', 'country_id', 'school_id', 'classnumber_id', 'value_otveta', 'value_otveta_yes', 'vopros_test', 'date', 'time', 'status_test', 'active', 'summ_variant_pole', 'code_test'], 'required'],
            [['id', 'ticher_id', 'school_id', 'status_test'], 'integer'],
            [['date', 'time', 'dateandtime', 'timeendtest'], 'safe'],
            [['username', 'country_id', 'classnumber_id', 'value_otveta', 'vopros_test', 'variant_1', 'variant_2', 'variant_3', 'variant_4', 'variant_5', 'variant_6', 'variant_7', 'variant_8', 'variant_9', 'variant_10', 'value1', 'value2', 'value3', 'value4', 'value5', 'value6', 'value7', 'value8', 'value9', 'value10', 'active', 'summ_variant_pole', 'code_test'], 'string', 'max' => 255],
            [['user_id', 'city_id', 'classlater_id'], 'string', 'max' => 20],
            [['value_otveta_yes'], 'string', 'max' => 22],
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
            'value_otveta' => 'Value Otveta',
            'value_otveta_yes' => 'Value Otveta Yes',
            'vopros_test' => 'Vopros Test',
            'variant_1' => 'Variant 1',
            'variant_2' => 'Variant 2',
            'variant_3' => 'Variant 3',
            'variant_4' => 'Variant 4',
            'variant_5' => 'Variant 5',
            'variant_6' => 'Variant 6',
            'variant_7' => 'Variant 7',
            'variant_8' => 'Variant 8',
            'variant_9' => 'Variant 9',
            'variant_10' => 'Variant 10',
            'value1' => 'Value1',
            'value2' => 'Value2',
            'value3' => 'Value3',
            'value4' => 'Value4',
            'value5' => 'Value5',
            'value6' => 'Value6',
            'value7' => 'Value7',
            'value8' => 'Value8',
            'value9' => 'Value9',
            'value10' => 'Value10',
            'date' => 'Date',
            'time' => 'Time',
            'dateandtime' => 'Dateandtime',
            'timeendtest' => 'Timeendtest',
            'status_test' => 'Status Test',
            'active' => 'Active',
            'summ_variant_pole' => 'Summ Variant Pole',
            'code_test' => 'Code Test',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TestiVoprosiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestiVoprosiQuery(get_called_class());
    }
}
