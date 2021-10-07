<div class="login-form">
  <h1>Sign In</h1>
  <h2><a href="#">Create Account</a></h2>
  <form>
    <li>
      <input type="text" class="text" value="User Name" onfocus="this.value = '';" onblur="if (this.value == '') {
            this.value = 'User Name';
          }" ><a href="#" class=" icon user"></a>
    </li>
    <li>
      <input type="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {
            this.value = 'Password';
          }"><a href="#" class=" icon lock"></a>
    </li>

    <div class ="forgot">
      <h3><a href="#">Forgot Password?</a></h3>
      <input type="submit" onclick="myFunction()" value="Sign In" > <a href="#" class=" icon arrow"></a>                                                                                                                                                                                                                                 </h3>
    </div>
  </form>
</div>

<div class="content_w">
  <div class="logindiv">
    <div class="right_col_hed">Login</div>
    <div class="col_body">
      <?php
      $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
          'validateOnSubmit' => true,
        ),
      ));
      ?>

      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
          <?php echo $form->textField($model, 'username', array('placeholder' => 'Email', 'class' => 'form-control')) ?>

        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
          <?php echo $form->passwordField($model, 'password', array('placeholder' => 'Password', 'class' => 'form-control')) ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <div class="checkbox">
            <label>
              <input type="checkbox"> Remember me
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-default')); ?>

        </div>
        <?php $this->endWidget(); ?>
      </div>
    </div>
  </div>











