<?php

class RegisterAction extends CAction
{
	/**
	 * Declares class-based actions.
	 */
	public function run()
	{
        $user = new User;

        if(isset($_POST['User']))
        {
			$user->attributes = $_POST['User'];
            if($user->validate())
            {
				$user->u_password = crypt($user->u_password, $user->u_password);
				$user->confirmPassword = crypt($user->confirmPassword, $user->confirmPassword);
				$user->save();
                Yii::app()->user->setFlash('uCreated','Successfully registered. You may <a href=' . $this->controller->createUrl('site/login') . '>login<a> now.');
				$this->controller->refresh();
            }
        }

        $this->controller->render('register', array('user' => $user));
	}

}