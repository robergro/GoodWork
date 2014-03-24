<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		// On démarre la session
	    session_start ();  
	    // On détruit les variables de notre session
	    session_unset ();  
	    // On détruit notre session
	   	session_destroy (); 	 	

        // On démarre une nouvelle la session
	    session_start (); 
	}

	public function actionAutocompleteTest() {
		$res =array();

                  
		if (isset($_GET['term'])) {
			// http://www.yiiframework.com/doc/guide/database.dao
			$qtxt ="SELECT  Usr.usr_login, Usr.usr_nom, Usr.usr_prenom FROM gw_usr as Usr WHERE Usr.usr_login LIKE :username";
			$command =Yii::app()->db->createCommand($qtxt);
			$command->bindValue(":username", '%'.$_GET['term'].'%', PDO::PARAM_STR);


			$res =$command->queryColumn();
		}

		$res = array('robergro11', 'robergro21', 'robergro56','robergro11', 'robergro21', 'robergro56','robergro11', 'robergro21', 'robergro56','robergro11', 'robergro21', 'robergro56');

		echo CJSON::encode($res);
		Yii::app()->end();
	}


	public function actionLogUser() {
		session_start();

	    $username = $_POST['name'];


	    //Recuperation du grain de sel
	    $sqlSel="SELECT Usr.usr_id, Usr.usr_sel from gw_usr as Usr WHERE Usr.usr_login='$username' LIMIT 1";

	    $rowsSel=Yii::app()->db->createCommand($sqlSel)->query();

	    $rowsSel->bindColumn(1,$usr_id);
	    $rowsSel->bindColumn(2,$usr_sel);

	    foreach($rowsSel as $rowSel){ 	
	    	
	    	//Concatenation du pwd
	    	$password =  sha1($_POST['pwd'].$usr_sel);     

	    	$sql="SELECT Usr.usr_id from gw_usr as Usr WHERE Usr.usr_id='$usr_id' AND Usr.usr_pwd='$password' LIMIT 1";
		    $rows=Yii::app()->db->createCommand($sql)->query();
		    $rows->bindColumn(1,$usr_id);
		    foreach($rows as $row){ 
		        $_SESSION['Goodwork_id']=$usr_id;	
		        Yii::app()->user->name = $username;
		    	echo 'true';  
		    	return;     
		    }  

	    } 

	    echo 'false';

	}



	public function actionExporterMd() {
		if(!empty($_POST['fichierMarkdown']))
	    {
	        $fichier = $_POST['fichierMarkdown'];
	        header('Content-disposition: attachment; filename="monfichierMarkdown.md"');
	        print $fichier;
	               
	    } 
	}




}