<?php

class SiteController extends CController
{

	/**
	 * Main page
	 */
	public function actionIndex()
	{
		$this->render('index', array('model' => new Link()));
	}

	/**
	 * Add a new link to db
	 */
	public function actionAdd()
	{
		$model = new Link();

		if (isset($_POST['Link'])) {

			$this->performAjaxValidation($model);

			$model->attributes = $_POST['Link'];

			$link = $model->addNewLink();

			if ($link) {
				echo CJSON::encode(array(
					'status' => 200,
					'link' => $link
				));
			}
		}
	}

	/**
	 * Redirect by short link if it exist.
	 * You can turn on cache in config, but make sure, that
	 * you have Memcached on your machine
	 *
	 * @param string $link
	 */
	public function actionRedirect($link)
	{
		/**
		 * @var Link $exist
		 * @var CMemCache $cache
		 */

		$cache = Yii::app()->cache;
		if ($cache) {
			$exist_in_cache = $cache->get($link);
			if ($exist_in_cache) {
				$this->redirect($exist_in_cache);
			}
		}

		$exist = Link::model()->findByPk($link);
		if ($exist) {
			if ($cache) {
				// Stores in cache 1 hour
				$cache->add($exist->id, $exist->url, 60 * 60);
			}
			$this->redirect($exist->url);
		}

		$this->redirect('/');
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param CModel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'create_link_form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Controller bootstrap
	 */
	public function init()
	{
		$this->includeAssets();
	}


	/**
	 * Include assets into html
	 */
	protected function includeAssets()
	{
		/**
		 * @var CClientScript $cs
		 */
		$cs = Yii::app()->getClientScript();
		$cs->addPackage('site', array(
			'baseUrl' => $this->getAssetsUrl(),
			'css' => array(
				'font-awesome/css/font-awesome.min.css',
				'style.css'
			),
			'js' => array(
				'scripts.js',
			),
		));
		$cs->registerPackage('site');
	}

	/**
	 * Publish assets and return its base url.
	 *
	 * @return string relative url to published assets
	 */
	public function getAssetsUrl()
	{
		/**
		 * @var CAssetManager $am
		 */
		$am = Yii::app()->getAssetManager();

		return $am->publish(Yii::getPathOfAlias('application.assets'));
	}

}