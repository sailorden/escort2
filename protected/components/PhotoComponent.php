<?php

/**
 * Used to encapsulate CRUD operations with different photo instances.
 */
class PhotoComponent extends CApplicationComponent
{

	/**
	 * The folder for storign images.
	 *
	 * @var string
	 */
	public $imageFolder;

	/**
	 * The folder for storign image icons.
	 *
	 * @var string
	 */
	public $iconsFolder;

	/**
	 * Creates new Photo model according to specified type
	 * and initializes it with specified values.
	 *
	 * Created to encapsulate the creation of Photo model.
	 *
	 * @param int $ownerId Owner ID.
	 * @param string $imageName Image name.
	 * @param string $iconName Icon name.
	 * @param string $modelType The name of required model: PhotoGirl or PhotoAgency.
	 *
	 * @return PhotoGirl | PhotoAgency
	 */
	private function _createPhotoModel($ownerId, $imageName, $iconName, $modelType)
	{
		switch ($modelType) {
			case Yii::app()->params['photoG']:
				$photo = new PhotoGirl();
				break;
			case Yii::app()->params['photoA']:
				$photo = new PhotoAgency();
				break;
		}

		$photo->pg_girl = $ownerId;
		$photo->pg_link = $imageName;
		$photo->pg_icon = $iconName;
		return $photo;
	}

	/**
	 * Gets array of CUploadedFile's and saves all images in
	 * appropriate models.
	 *
	 * @param array $images Array of CUploadedFile.
	 * @param int $ownerId Owner ID.
	 * @param string $modelType The name of required model: PhotoGirl or PhotoAgency.
	 *
	 * @return string | boolean
	 */
	public function saveImage($images, $ownerId, $modelType)
	{
		foreach($images as $key => $file)
		{
			//Generates the file name
			$imageName = uniqid(Yii::app()->user->id . rand(Yii::app()->params['randMin'], Yii::app()->params['randMax']) . $key . '_', true) .
				'.' .
				$file->getExtensionName();
			$imagePath = $this->imageFolder . $imageName;

			//Generates icon name
			$iconName = uniqid(Yii::app()->user->id . rand(Yii::app()->params['randMin'], Yii::app()->params['randMax']) . $key . '_icon', true) .
				'.' .
				$file->getExtensionName();
			$iconPath = $this->iconsFolder . $iconName;


			$photo = $this->_createPhotoModel($ownerId, $imageName, $iconName, $modelType);

			if ($photo->save())
			{
				$file->saveAs($imagePath);

				//Saves image icon with EasyImage extension
				$icon = new EasyImage($imagePath);
				$icon->resize(Yii::app()->params['iconHeight'], Yii::app()->params['iconWidth']);
				$icon->save($iconPath);
			}
			elseif($photo->hasErrors())
			{
				return $photo->getError('pg_girl');
			}
		}
		return true;
	}

	//Getting all images related with specified girl id
	//Returns array of links for all images
	public function getIcons($girlId)
	{
		$images = PhotoGirl::model()->findAllByAttributes(array('pg_girl'=>$girlId));
		if(count($images))
		{
			foreach($images as &$image)
			{
				$image = $image->getAttributes(array('pg_icon'));
				$image = $image['pg_icon'];
			}
			return $images;
		}
		else
		{
			return false;
		}

	}
}