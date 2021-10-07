<?php
class Access 
{
    private function DataAccess()
    {     
       /*$cmd='SELECT Provincial_Councils_Name FROM `ma_provincial_councils`';                       			 
	    $array = Yii::app()->db->createCommand($cmd)->queryAll();
        return($array);	 
		print_r($array)   ;*/
		
	 $cmd='SELECT `District_ID`, `DS_Division_ID`, `GN_Division_ID` FROM `tbl_users`';
	 $array = Yii::app()->db->createCommand($cmd)->queryAll();
     return($array);		
		
    }
	
	
	
	 public function DistrictDataAccess()
    {
        $Array= $this->DataAccess();
        
        $DistrictModel = new MaDistrict();
       
        $DataArray = array();
		unset(Yii::app()->session['DS_Division_ID']);
		unset(Yii::app()->session['GN_Division_ID']);
		//unset(Yii::app()->session['Post_office_ID']);
		
        if(isset($Array[0]['District_ID']) && $Array[0]['District_ID']!=0 && !is_null ($Array[0]['District_ID']))
        {
			
			$ID = $Array[0]['District_ID'];            			
			if(isset($Array[0]['DS_Division_ID'])){Yii::app()->session['DS_Division_ID']= $Array[0]['DS_Division_ID']; }
			if(isset($Array[0]['GN_Division_ID'])){	Yii::app()->session['GN_Division_ID']= $Array[0]['GN_Division_ID'];}
			//if(isset($Array[0]['Post_office_ID'])){	Yii::app()->session['Post_office_ID']= $Array[0]['Post_office_ID'];}
		
			/*$cmd='Select District_ID,District_Name
					 from  ma_district
					where 
					District_ID="'.$ID.'"';*/
					
					$cmd='Select District_ID,District_Name from  ma_district';	
			
		           
			 $DataArray= Yii::app()->db->createCommand($cmd)->queryAll();
		    
         }
         else 
         {

           $DataArray=  MaDistricts::model()->findAll();
         }
		 
		 $DataArray=CHtml::listData($DataArray,'District_ID','District_Name');
		 return($DataArray);

    }
	
	
	
	
	
	
    public function ProvincialCouncilsDataAccess()
    { 
        $Array= $this->DataAccess();
        
        $ProvincialCouncilsModel = new MaProvincialCouncils();
       
        $DataArray = array();
		//Sprint_r($Array);exit;
		unset(Yii::app()->session['District_ID']);
		unset(Yii::app()->session['DS_Division_ID']);
		//unset(Yii::app()->session['Post_office_ID']);
		
        if(isset($Array[0]['Provincial_Councils_ID']) && $Array[0]['Provincial_Councils_ID']!=0 && !is_null ($Array[0]['Provincial_Councils_ID']))
        {
			//echo "jj";exit;
			$ID = $Array[0]['Provincial_Councils_ID'];
            if(isset($Array[0]['District_ID'])){Yii::app()->session['District_ID']= $Array[0]['District_ID']; }
			if(isset($Array[0]['DS_Division_ID'])){	Yii::app()->session['DS_Division_ID']= $Array[0]['DS_Division_ID'];}
			//if(isset($Array[0]['Post_office_ID'])){	Yii::app()->session['Post_office_ID']= $Array[0]['Post_office_ID'];}
				
			$cmd='Select Provincial_Councils_ID,Provincial_Councils_Name
					 from  ma_provincial_councils
					where 
					Provincial_Councils_ID="'.$ID.'"';	
					
		           
			 $DataArray= Yii::app()->db->createCommand($cmd)->queryAll();
		    
         }
         else 
         {
			
           $DataArray=  MaProvincialCouncils::model()->findAll();
         }
		 
		 $DataArray=CHtml::listData($DataArray,'Provincial_Councils_ID','Provincial_Councils_Name');
		
		 return($DataArray);
		 

    }
	
    
   
    public function AllDistricts()
    {
         $DataArray= Yii::app()->db->createCommand('Select District_ID,District_Name from  ma_district')->queryAll();
		  $AllDistricts=CHtml::listData($DataArray,'District_ID','District_Name');
		  return($AllDistricts);
    }   
	

	
	
   
   
    
}

?>