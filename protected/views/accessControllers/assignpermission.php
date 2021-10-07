<style>
  #table td, th
  {
    border: 1px solid #ccc;
    padding: 8px;
  }

  input[type="submit"]
  {
    margin-top: 14px;

  }

  .as td
  {
    padding: 4px !important;
  }
</style>
<?php
Yii::app()->clientScript->registerScript('search', "var ajaxUpdateTimeout;
    var ajaxRequest;
    $('input#AccessControllers_Action').keyup(function(){
        ajaxRequest = $(this).serialize();
        clearTimeout(ajaxUpdateTimeout);
        ajaxUpdateTimeout = setTimeout(function () {
            $.fn.yiiListView.update(
// this is the id of the CListView
                'ajaxListView',
                {data: ajaxRequest}
            )
        },
// this is the delay
        300);
    });
	
	 $('.ajax_link').click(function(){
  $.fn.yiiListView.update('companyList')
 });
	
	"
);
?>
<script type="text/javascript">

  $(document).ready(function() {

    $("#AccessControllers_Display_Name").change(function() {
      var materialId = $("#AccessControllers_Display_Name").val();
      var rollId = $("#Roles_rolecode").val();

      if (materialId !== "" && rollId !== "")
      {
        $.ajax({
          type: 'POST',
          url: '<?php echo Yii::app()->createAbsoluteUrl("AccessControllers/getCreatetable"); ?>',
          data: {'materialId': materialId, 'rollId': rollId},
          success: function(data) {
            if (data.length > 0)
            {
              $("#table").show();
              $("#table").html(data);
              $("#checkAllRow").show();
              $("#assignBtn").show();
            }
          },
          error: function(data) { // if error occured
            alert("Error occured.please try again");
            //alert(data);
            //alert(RateId);
          },
          dataType: 'html'
        });
      }
      else
      {
        $("#checkAllRow").hide();
        $("#assignBtn").hide();
        $("#table").hide();
      }
    });


    $("#Roles_rolecode").change(function() {
      var materialId = $("#AccessControllers_Display_Name").val();
      var rollId = $("#Roles_rolecode").val();
      if (materialId !== "" && rollId !== "")
      {
        $.ajax({
          type: 'POST',
          url: '<?php echo Yii::app()->createAbsoluteUrl("AccessControllers/getCreatetable"); ?>',
          data: {materialId: materialId, rollId: rollId},
          success: function(data) {
            if (data.length > 0)
            {
              $("#table").show();
              $("#table").html(data);
              $("#checkAllRow").show();
              $("#assignBtn").show();
            }
          },
          error: function(data) { // if error occured
            alert("Error occured.please try again");
          },
          dataType: 'html'
        });
      }
      else
      {
        $("#checkAllRow").hide();
        $("#assignBtn").hide();
        $("#table").hide();
      }
    });

  });

</script>


<script type="text/javascript">
  $(function() {
    $("#checkall").change(function() {
      if ($(this).prop('checked') == true)
      {
        $('input[name="action_id[]"]').prop('checked', true);
      }
      else
      {
        $('input[name="action_id[]"]').prop('checked', false);
      }

    });
  });



  function checkAll() {
    /*
     var checkallValue = $("#checkall").attr("checked");
     if (checkallValue === "checked")
     {
     $('#table input[type=checkbox]').attr("checked", "checked");
     }
     else
     {
     $('#table input[type=checkbox]').removeAttr("checked");
     }
     */
  }
</script>


<script type="text/javascript">


  $(document).ready(function() {

    $("#Role_Role_ID").change(function() {

      /* var checkallValue = $("#checkall").attr("checked");
       
       if(checkBoxValues == "checked")
       {
       $("#checkall").attr("checked", "checked");
       }
       
       */

    });

  });

</script>
<div class="header">
<div class="wrapper">
<h4><i class="icon-cog"></i> Configurations <i class="icon-double-angle-right"></i> 
Access Control </h4>
</div>
</div>
<section class="section-lite">
  <div class="wrapper">
    <div class="exclusivevectors" style="color:">
    </div>
    <div class="rc-featured" >
      <div class="col-left">
        <table class="toole">
          <tr>
            <td><h5>Access Control</h5></td>
            <td></td>
            <td width="10px">
            </td>
            <td width="10px">
            </td>
          </tr>
        </table>
        <div class="left-content">
          <div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
              'id' => 'ma-user-form',
              'enableAjaxValidation' => false,
            ));
            ?>
            <table style="width: 80%!important; margin-left:4px">
              <tr>
                <td  style="width:45px"><?php echo $form->labelEx($modelrole, 'Role'); ?></td>
                <td><?php
                  echo $form->dropDownList($modelrole, 'rolecode', CHtml::listData(
                          Roles::model()->findAll(), 'rolecode', 'role'), array('prompt' => '--- Please Select ---'));
                  ?>
                  <?php echo $form->error($modelrole, 'rolecode'); ?></td>
                <td style="width:20px"/>

                <td><?php echo $form->labelEx($model, 'Controller_Name'); ?></td>
                <td style="width: 181px"><?php echo $form->dropdownlist($model, 'Display_Name', CHtml::listData(AccessControllers::model()->getControllerName(), 'ID', 'Display_Name'), array('width' => '25', 'empty' => '--- Please Select ---')); ?>
                  <?php echo $form->error($model, 'Controller_Name'); ?></td>
              </tr>
              <tr style="width:50px"/>
              <tr id="checkAllRow" style="display: none">                                    
                <td colspan="2" style="text-align: right; padding-top: 30px;" class="allControls"> <label for="checkall">Select/Unselect All</label> <input type='checkbox' name='checkall' style="width:20px" id='checkall'></td>
                <td></td>                        
                <td><?php echo CHtml::submitButton($model->isNewRecord ? 'Assign Permission' : 'Save', array("style" => 'width:130px !important')); ?></td>
              </tr><!---->
            </table>
            <br/>              
            <div class="as" id="table" style="margin-top:1px; width:auto">
            </div>
            <?php echo CHtml::link('&nbsp&nbsp', array('AccessControllers/create')) ?>
            <br/>
            <br/>        
            <?php $this->endWidget(); ?>
          </div>
        </div>
      </div>
      <div class="col-right">
        <div class="menu">
          <h5>Menu</h5>          <ul>
            <?php
            $menu = new MainMenus;
            echo $menu->sideMenues("Menuuser")
            ?>          
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>