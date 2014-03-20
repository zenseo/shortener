<?php

/**
 * Это класс модели для таблицы "link".
 *
 * Ниже описаны доступные поля для таблицы 'link':
 *
 * @property string $id
 * @property string $hash
 * @property string $url
 *
 * relationsCommentPlaceholder
 */
class Link extends CActiveRecord
{
	/**
	 * @return string возвращает сроку привязанной к модели таблицы
	 */
	public function tableName()
	{
		return 'link';
	}

	/**
	 * @return array правила валидации для атрибутов модели
	 */
	public function rules()
	{
		return array(
			array(
				'id, hash',
				'unique'
			),
			array(
				'url',
				'required'
			),
			array(
				'url',
				'url'
			),
			array(
				'id',
				'length',
				'max' => 6
			),
			array(
				'hash',
				'length',
				'max' => 40
			),
			array(
				'url',
				'length',
				'max' => 1000
			),
		);
	}

	/**
	 * @return array подписи атрибутов (атрибут=>подпись)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hash' => 'Hash',
			'url' => Yii::t('site', 'Url'),
		);
	}

	/**
	 * Возвращает статическую модель для указанного AR класса.
	 * Обратите внимание, что вы должны иметь этот метод во всех ваших CActiveRecord потомках!
	 *
	 * @param string $className имя класса активной записи.
	 * @return Link статический класс модели
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Add a new short link.
	 * If in DB already exist the same link returns it's id.
	 * Or make new and try to save it until succeeded.
	 *
	 * @return Link
	 */
	public function addNewLink()
	{
		/**
		 * @var Link $exist
		 */

		$this->hash = sha1($this->url);

		$exist = $this->findByAttributes(array(
			'hash' => $this->hash
		));

		if ($exist) {
			return $exist;
		}

		$this->id = substr($this->hash, 0, 6);

		// Save new short link
		$i = 0;
		while (true) {
			$i++;
			if ($this->save()) {
				return $this;
			}

			// If we have same id in DB - make some new
			$this->id = substr(sha1($this->id), 0, 6);


			// Following code just for safety!

			// If too many tryings - there's something wrong.
			// Maybe somebody make same short url in the same time.
			if ($i > 10) {
				$exist = $this->findByAttributes(array(
					'hash' => $this->hash
				));

				if ($exist) {
					return $exist;
				}
			}

			// Just for any case
			if ($i > 12) {
				break;
			}
		}

		return $this;

	}

}
