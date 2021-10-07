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
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
            'imageUpload' => array(
                'class' => 'ext.redactor.actions.ImageUpload',
                'uploadPath' => 'images/uploads',
                'uploadUrl' => 'images/uploads',
                'uploadCreate' => true,
                'permissions' => 0755,
            ),
        );
    }

    public function actionIndex()
    {


    $this->layout = 'landing';
        $this->render('index', array(
        ));


        
    }

    public function actionConfig()
    {



        $this->render('config', array(
        ));
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error)
        {
            if (Yii::app()->request->isAjaxRequest)
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
        $model = new ContactForm;
        if (isset($_POST['ContactForm']))
        {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate())
            {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->redirect(array('/user/registration'));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('/user/registration'));
    }

    public function actionEvaluation($loanId)
    {
        if(Yii::app()->user->isGuest)
        {
            $this->redirect(array('/user/login'));
        }
        $model = new QuestionAnswers();
        if (!isset(Yii::app()->session['loanId']))
        {
            $loan = new Loan;
            $menu = new MainMenus();
            $loan->user = Yii::app()->user->id;
            $loan->createdDate = $menu->getDateTime();
            $loan->loanId = null;
            $loan->setIsNewRecord(true);
            $loan->status = 0;
            $loan->loanType = $loanId;
            $loan->save();
            Yii::app()->session['loanId'] = $loan->loanId;
        }
        $this->render('evaluation', array(
            'loanType' => $loanId,
            'model' => $model,
        ));
    }

    public function actionLoanSelect()
    {
        $this->render('loanType');
    }

    public function actionEmployment()
    {
        $this->render('employment');
    }

    public function actionFinancial()
    {
        $this->render('financial');
    }

    public function actionSelected()
    {
        $this->render('selected');
    }

    public function actionDocuments()
    {
        if (isset($_POST['submits']))
        {
            $files = $_FILES['Docs']['tmp_name'];

            $loanID = (int) Yii::app()->session['loanId'];
            foreach ($files AS $key => $fileX)
            {
                foreach ($fileX AS $fileY)
                {
                    $doc = new Document();
                    $doc->documentId = null;
                    $doc->loanId = $loanID;
                    $doc->documentType = $key;
                    $doc->save();
                    $filePath = Yii::getPathOfAlias("webroot") . '/files/' . $loanID . '/';
                    $fileName = $doc->documentId . '.jpg';

                    if (!file_exists($filePath))
                    {
                        mkdir($filePath);
                    }
                    move_uploaded_file($fileY, $filePath . $fileName);
                }
            }
            
            $this->redirect(array('selected'));
        }
        $this->render('document');
    }

    public function actionAnswerProcessor()
    {
        if (isset($_POST['Answer']))
        {
            foreach ($_POST['Answer'] AS $key => $ans)
            {
                $model = new Answer();
                $model->questionId = $key;
                $model->answerId = null;
                $model->answer = $ans;
                $model->userId = Yii::app()->user->id;
                $model->loanId = (int) Yii::app()->session['loanId'];
                $model->save();
            }

            $nextAction = (int) $_POST['nextAction'];
            switch ($nextAction)
            {
                case 1:
                    $this->redirect(array('Employment'));
                    break;
                case 2:
                    $this->redirect(array('financial'));
                    break;
                case 3:
                    $this->redirect(array('documents'));
                    break;
            }
        }
    }
    
    public function actionConfigPanel()
    {
        $this->render('configPanel');
        
    }

}
