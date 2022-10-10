<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Blog;
use Yii;
use yii\debug\UserswitchAsset;
use common\models\User;
/**
 * BlogSearch represents the model behind the search form of `app\models\Blog`.
 */
class BlogSearch extends Blog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['title', 'img_src', 'body', 'date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Blog::find()
        ->where(['user_id' => Yii::$app->user->identity->id] )
        -> orderBy(['id'=> SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'img_src', $this->img_src])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
    public function searchAll($params)
    {
        $sql_query = Blog::find()
            ->orderBy(['id' => SORT_DESC]);
        $provider = new ActiveDataProvider(['query' => $sql_query,
        'pagination'=>[
            'pageSize' => 10,
        ]]);   
        
       return $provider;

    }
}
