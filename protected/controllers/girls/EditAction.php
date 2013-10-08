<?php

class EditAction extends CAction
{
	/**
	 * Declares class-based actions.
	 */
	public function run()
	{
		$girl = false;

        if(isset($_GET['id']))
        {
			$user = User::model()->with('girls')->findByPk(Yii::app()->user->id);
			$girls = $user->girls;
			foreach($girls as $grl)
			{
				if($grl->g_id === $_GET['id'])
				{
					$girl = $grl;
				}
			}
        }

        if(!$girl)
        {
            Yii::app()->user->setFlash('cantFind','Cant find specified girl.');
        }
		elseif(isset($_POST['Girl']))
        {
            $girl->attributes = $_POST['Girl'];
			$girl->g_photo = CUploadedFile::getInstances($girl,'g_photo');
            if($girl->validate())
            {
                $girl->save();


				if ($girl->g_photo)
				{
					echo '<pre>';
					print_r($_FILES);
					echo '</pre>';
					foreach($girl->g_photo as $key => $file)
					{

						$imagePath = Yii::app()->params['imageFolder'] .
									uniqid(Yii::app()->user->id . rand(Yii::app()->params['randMin'], Yii::app()->params['randMax']) . $key . '_', true) .
									'.' .
									$file->getExtensionName();
//									$girl->g_photo->getExtensionName();
						$file->saveAs($imagePath);
//						$girl->g_photo->saveAs($imagePath);
					}
				}

//                Yii::app()->user->setFlash('updated','Girl successfully updated.');
//				$this->controller->refresh();
            }
        }
        $this->controller->render('edit', array('girl' => $girl));
	}

}