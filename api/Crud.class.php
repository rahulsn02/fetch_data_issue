<?php 
//Created By  Rahul Saini 


class Crud {
    //this function is resposible to update record 
    //Dependency:Need 4 argumnet ,Tablename, cobmination field and value array,columnname, id where you want to update record 
    public static function update($tableName,$array,$condition,$conn)
            {
              foreach ($array as $key => $value)
               {
                 $text= sprintf("%s='%s'",$key,$value);
                 $var = $var.$text.','; 
               }
              $midstr =  rtrim($var,',');
              $query = sprintf("update %s set %s %s",$tableName,$midstr,$condition);
            // echo $query;
              mysqli_query($conn,$query);                
            }
            
            
    //this function resposible for select record
    //Dependency:need 3 argument, tablename ,column array,condtion where you want to select record        
    public static function select($tableName,$array,$condition,$conn)
            {
             for($i=0;$i<=count($array);$i++)
             {
                $text= sprintf("%s",$array[$i]);
                 $var = $var.$text.',';   
             } 
              $midstr =  rtrim($var,',');
              $query = sprintf("select %s from %s %s",$midstr,$tableName,$condition);  
             // echo $query;
            
              $result=mysqli_query($conn,$query);  
              $status = array();
              while ($row2 = mysqli_fetch_array($result))
                    {
                       $status[] =  $row2['Qc_status'];
                  }
                  return $status;
            }
    //This function is responsible to count customer order id when status is 1 
    //Dependency:Need 1 argument customer order id       
    public static function Qc_count($customer_order_id,$conn)
    {
        $query = "select count(customer_order_id) as count from sub_order where Qc_status = '1' and customer_order_id = '".$customer_order_id."'";
        $result = mysqli_query($conn,$query);
        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            $data[] = $row['count'];
        }
        //print_r($data);
        return $data;
    }
    
    //this function resposible for select record from given columns 
    //Dependency:need 3 argument, tablename ,column array,condtion where you want to select record     
    public static function selectcolumn($tableName,$array,$condition,$conn)
            {
             for($i=0;$i<=count($array);$i++)
             {
                $text= sprintf("%s",$array[$i]);
                 $var = $var.$text.',';   
             } 
              $midstr =  rtrim($var,',');
              $query = sprintf("select %s from %s %s",$midstr,$tableName,$condition);  
        // echo $query;
             
              $result=mysqli_query($conn,$query);  
             
              while ($row2 = mysqli_fetch_assoc($result))
                    {
                       $status[] =  $row2;
                  }
                  return $status;
            } 
            
    //This function is responsible for insert data into table 
    // Dependency:2 arrgument ,Tablename,array conbination of feild and values 
    //Note: Here key must be field of database table          
    public static function insert($tbaleName,$array,$conn)
    {
       foreach ($array as $key => $value)
               {
                 $text= sprintf("%s",$key);
                 $var = $var.$text.','; 
                 $val= sprintf("'%s'",$value);
                 $varval = $varval.$val.','; 
              
               }
                $midstr =  rtrim($var,',');
                $midstrc =  '('.$midstr.')'; 
                $endstr =  rtrim($varval,',');
                $endstrc =  '('.$endstr.')'; 
                $query = sprintf("insert into %s %s values %s",$tbaleName,$midstrc,$endstrc);  
              //echo $query;
                mysqli_query($conn,$query);
                     
               }
    //           
    public static function uploadImage($file)
            {
      $errors= array();
      $file_name = $file['product_image']['name'];
      $file_size =$file['product_image']['size'];
      $file_tmp =$file['product_image']['tmp_name'];
      $file_type=$file['product_image']['type'];
      //print_r($file_name);
     // die();
      //$file_ext=strtolower(end(explode('.',$file_name)));
        $file_ext= explode('.',$file_name);
        $file_ext = $file_ext[1];
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"product_image/".$file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
      return $file_name;
            }
            
            
            
  public static function uploadImage_new($file,$path)
            {
      $errors= array();
      $file_name = $file['name'];
      ///echo $file_name;
      $file_size =$file['size'];
      $file_tmp =$file['tmp_name'];
      $file_type=$file['type'];
      //print_r($file_name);
     // die();
      //$file_ext=strtolower(end(explode('.',$file_name)));
        $file_ext=explode('.',$file_name);
        $file_ext = $file_ext[1];
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"$path/".$file_name);
         //echo "Success";
      }else{
         //print_r($errors);
      }
      return $file_name;
            }
    //This function is responsible to Execute query and return result as associtive array 
    //Dependency:Need 1 argument         
    public static function queryExe($query,$conn)
    {
     // echo  $query;
       $result=mysqli_query($conn,$query);  
       while ($row = mysqli_fetch_assoc($result))
          {
               $data[] =  $row;
             }  
             return $data;
    }
    
   //This Function is resposible to find out last increamented id of the table 
   // Dependency: Need 1 argument table name where you find out the last incremented id 
    public static function LastId($tablename,$conn)
    {
        $sql ="select max(id) as maxID from $tablename";
        $result=self::queryExe($sql,$conn); 
             return $data;
    }
      public static function get_order_id($customer_id)
    {
        $sql ="select id from customer_order where customer_id = $customer_id";
        $result=mysqli_query($conn,$sql); 
          while ($row = mysqli_fetch_assoc($result))
          {
               $data[] =  $row;
             }  
             return $data[0]['id'];
    }

    // This function is responsible to get total inward of product
    //Dependency It will take 1 argument that is product id
    public static function get_inward($product_id,$conn)
    {
        $query ="select sum(quantity) as inward from inward where product_id = $product_id";
        
            $result=mysqli_query($conn,$query);  
       while ($row = mysqli_fetch_assoc($result))
          {
               $data[] =  $row;
             }  
             return $data[0]['inward']; 

    }
    
    public static function get_outward($item_id,$conn)
            {

            $query ="select sum(quantity) as outward from product_order_detail where item_id = $item_id";
            $result=mysqli_query($conn,$query);  
            while ($row = mysqli_fetch_assoc($result))
             {
               $data[] =  $row;
             }  
             return $data[0]['outward']; 
            }
   // This function is responsible to get worker detail 
    //Dependency It will take 1 argument that is worker id         
    public static function get_worker_detail($worker_id,$conn){
        $query = "select * from worker where worker_id='$worker_id'";
        $result=mysqli_query($conn,$query);  
            while ($row = mysqli_fetch_assoc($result))
             {
               $data[] =  $row;
             }  
             return $data;
    }
    
    //--THis function is to check job is alloted or not
    //Dependency It will take 2 arrgument sub_order_id and job_title
    public static function job_allot_or_not($sub_order,$job_title,$conn)
                {
        
                 $query = "select JOBER_ID from JOB_$job_title where SUB_ORDER_ID='$sub_order'";
                
                 $result=mysqli_query($conn,$query);  
                 $row = mysqli_fetch_row($result);
                 if($row[0]!=null)
                     {
                       $sql = "select full_name from worker where worker_id='".$row[0]."'";
                       
                       $res = mysqli_query($conn,$sql);
                       $jobername = mysqli_fetch_row($res);
                       $jober_name = $jobername[0];
                     }else{
                         $jober_name = 'Not Alloted';
                     }
                     return $jober_name;
        
                }
                
                
    //------function to check in privious status is compelete or not
    //Dependency It will take 1 arragument Previous status id---            
    public static function job_allot_or_not_in_previous_table($previous_status_id,$sub_order_id,$conn){
        
        if($previous_status_id==0){
            $status = 1;
        }else{
            $query = "select job_title from job_configuration where id='$previous_status_id'";
            
            $result = mysqli_query($conn,$query);
            $tablename = mysqli_fetch_row($result);
            $table = $tablename[0];
             $query2 = "select ID,JOBER_ID from JOB_$tablename[0] where SUB_ORDER_ID='$sub_order_id' and JOB_STATUS=0";
             $result2 = mysqli_query($conn,$query2);
             
             $table_id = mysqli_fetch_row($result2);
             $jober_id = $table_id[1];
     
            if($table_id[0]!=null)
                {
                    
                   
                    
                    
                $status =1;
                $datetime = date('Y-m-d');
                $time = date("h:i a");
                
                
                $salary_type = self::check_salary_type($jober_id,$conn);
                
            
                 if($salary_type[0]['salary_type']=='Per Item Basis')
                     {
                        
                    
                          self::per_item_salary($jober_id,$sub_order_id,$table,$conn);
                     
                     } 
                     if($salary_type[0]['salary_type']=='Commission Basis')
                     {
                          self::commision_salary($jober_id,$sub_order_id,$table,$conn);
                     } 
                     if($salary_type[0]['salary_type']=='Hourly Basis')
                     {
                     
                          self::hourly_salary($jober_id,$sub_order_id,$table,$conn); 
                     } 
                     
                      if($salary_type[0]['salary_type']=='Per Day Basis')
                     {
                     
                          self::per_day_salary($jober_id,$sub_order_id,$table,$conn);
                     } 
                      if($salary_type[0]['salary_type']=='Monthly Basis')
                     {
                     
                           self::monthly_salary($jober_id,$sub_order_id,$table,$conn);
                     } 
               
                
                mysqli_query($conn,"update JOB_$tablename[0] SET JOB_STATUS=1,JOB_COMPLETION_DATE='$datetime',JOB_COMPLETION_TIME='$time' where SUB_ORDER_ID='$sub_order_id'");
                //-------------------------------------------------
                //Salary Calculations and salary allotment------
                  
                
                }else{
                    $status = 0;
                }
        }
        return $status;
        
        
    }
    //-------Function to be written to get Order Type Title
    //Dependency It will take 1 Arragument That is Order type Value
    public static function order_type_title($order_type,$conn)
    {
          $query = "select ORDER_TYPE_TITLE from order_type where ORDER_TYPE='$order_type'";
            
            $result = mysqli_query($conn,$query);
            $order_type_title = mysqli_fetch_row($result);
            return $order_type_title[0];
        
    }
    
   //-Funtion Written to be get Order Priority
   //Dependency It ll take 1 Arrgument That order priority Value
   public static function Order_priority_title($order_priority)
    {
        $query = "select order_priority,color from order_priority where id='$order_priority'";
            
            $result = mysqli_query($conn,$query);
            $order_type_title = mysqli_fetch_row($result);
            return $order_type_title;
    }
    
  //Function is written to track Progress for Order Working At Perticular Stage
  //Dependency It Will Take Only 1 Arragument That Order_id----
  public static function Progress($order_id,$Job_table,$conn){
      $data =array();
 
      
       $query = "select count(id) from JOB_$Job_table where ORDER_ID='$order_id' and JOB_STATUS=1";
       $result1 = mysqli_query($conn,$query);
       $total_complete_item = mysqli_fetch_array($result1);
       
       $total_complete_item = $total_complete_item[0];
       
       $query = "select count(id) from JOB_$Job_table where ORDER_ID='$order_id' and JOB_STATUS=0";
       $result1 = mysqli_query($conn,$query);
       $incomplete_item = mysqli_fetch_array($result1);
       
       $incomplete_item = $incomplete_item[0];
       
       
       
            $data['incomplete']=$incomplete_item;
            $data['compelete_item']=$total_complete_item;
           
   
       
       return $data;
      
  }
  
  //---------------------------------------------------------------------------------------------------------------
  //--Salary calculation Function
  //Function is written to be check worker salary type
  //Dependency It Will take 1 Arragument That is Worker id----
  public static function check_salary_type($worker_id,$conn)
  {
      
      $query = "select salary_type from worker_salary where worker_id=$worker_id";  
      $result = self::queryExe($query,$conn);
      return $result;
      
  }

  
  //-----------This Function is responsible for calculatin per item salary------
  public static function per_item_salary($jober_id,$sub_order_id,$table,$conn)
  {
      
      
      
      
    //--------code to get item_id from sub_order
    $item_id = self::selectcolumn('sub_order',array('item_id'),"where sub_order_id='$sub_order_id'",$conn);
    $item_id = $item_id[0]['item_id'];
    //-----------code to get job_id from job table
    $worker_type_id = Crud::selectcolumn('worker_type',  array ('worker_type_id'),"where worker_type='$table'",$conn);
    
    $job_id = $worker_type_id[0]['worker_type_id'];
    
    //-------code to get worker specilist for item get specilist id from jober and item id
    $condition = "where item_id='$item_id' and worker_id='$jober_id' and job_id='$job_id'";
    $working_specialist_id = self::selectcolumn('worker_specialist',array ('worker_specialist_id'),$condition,$conn);
    $worker_specialist_id = $working_specialist_id[0]['worker_specialist_id']; 
    if($worker_specialist_id!=null){
        
      
        
        //--Code to get salary from salary table with the help of jober and worker_specialist_id
        $con = "where worker_id='$jober_id' and worker_specialist_id='$worker_specialist_id'";
        $worker_salary_data = self::selectcolumn('worker_salary',array ('salary'),$con,$conn);
        
           $extra_salary =   Crud::selectcolumn('JOB_'.$table,array('JOBER_EXTRA_PAYOUT'),"where SUB_ORDER_ID='$sub_order_id'",$conn);
        
        
        $worker_salary = $worker_salary_data[0]['salary']+$extra_salary[0]['JOBER_EXTRA_PAYOUT'];
        self::update('JOB_'.$table,  array ('JOBER_PAYOUT'=>$worker_salary),"where SUB_ORDER_ID='$sub_order_id'",$conn);   
       
        
        //--Code to enter salary in ledger entry table-----
        $dr_id = 6; 
        $table_id = 'worker_'.$jober_id;
        
       
        
        $ledger_data = self::selectcolumn('ledger',  array ('ledger_id'),"where table_id='$table_id'",$conn);
        $cr = $ledger_data[0][ledger_id];
        
      
        
        
        
        $vcno = self::voucher_no('SLR',$conn);
        $v = $vcno + 1;
        
        
        $vc_no = "SLR" . $v;
        $particulars = $jober_id.'_salary_'.$sub_order_id.'_'.$table;
         
        $ledger_entry_data_array = array (
            'dr_id'=>$dr_id,
            'cr_id'=>$cr,
            'amount'=>$worker_salary,
            'voucher_no'=>$vc_no,
            'date'=>date('Y-m-d'),
            'particulars'=>$particulars,
            'narration'=>''
        );
        self::insert('ledger_entry',$ledger_entry_data_array,$conn);
        //---------------------------End of salary Entry---------------
        
       
        
    }else{
        
        //------this code to handle defauld salary
        
    
        
       $job_id =  Crud::selectcolumn('job_configuration',array('id'),"where job_title='$table'",$conn);
       $job_id = $job_id[0]['id'];
       $worker_salary_data = Crud::selectcolumn('peritemsalary',array('default_price'),"where item_id=$item_id and job_id=$job_id",$conn);
       
      //-----------Code to get Extra salary if any
      
       $extra_salary =   Crud::selectcolumn('JOB_'.$table,array('JOBER_EXTRA_PAYOUT'),"where SUB_ORDER_ID='$sub_order_id'",$conn);
        
       $worker_salary = $worker_salary_data[0]['default_price']+$extra_salary[0]['JOBER_EXTRA_PAYOUT'];
              
       self::update('JOB_'.$table,  array ('JOBER_PAYOUT'=>$worker_salary),"where SUB_ORDER_ID='$sub_order_id'",$conn);   
       //--Code to enter salary in ledger entry table-----
        $dr_id = 6; 
        $table_id = 'worker_'.$jober_id;
        $ledger_data = self::selectcolumn('ledger',  array ('ledger_id'),"where table_id='$table_id'",$conn);
        $cr = $ledger_data[0][ledger_id];
        
        $vcno = self::voucher_no('SLR',$conn);
        $v = $vcno + 1;
        
        $vc_no = "SLR" . $v;
        $particulars = $jober_id.'_salary_'.$sub_order_id.'_'.$table;
         
        $ledger_entry_data_array = array (
            'dr_id'=>$dr_id,
            'cr_id'=>$cr,
            'amount'=>$worker_salary,
            'voucher_no'=>$vc_no,
            'date'=>date('Y-m-d'),
            'particulars'=>$particulars,
            'narration'=>''
        );
        self::insert('ledger_entry',$ledger_entry_data_array,$conn);
        //---------------------------End of salary Entry---------------
        
    }
  
  }
  
  public static function monthly_salary($jober_id,$sub_order_id,$table)
  {
      
  }
  
  public static function per_day_salary($jober_id,$sub_order_id,$table)
  {
      
  }
  
  public static function hourly_salary($jober_id,$sub_order_id,$table)
  {
      
  }
  
  
  public static function booking_salary_calculator($jober_id,$order_id,$order_value,$conn){
      
   
      
    $salary_type =   self::check_salary_type($jober_id,$conn)[0]['salary_type'];

    $job_id = Crud::selectcolumn('worker_type',array('worker_type_id')," where worker_type='BOOKING'",$conn)[0]['worker_type_id'];
       
   
    if($salary_type=='Per Item Basis'){
        
       $item_ids =  Crud::selectcolumn('customer_order',array('so.item_id'),"as co join sub_order as so on so.customer_order_id=co.customer_order_id where co.customer_order_id='$order_id'",$conn);
          $total_booking = 0;
        foreach($item_ids as $ikey=>$ivalue){
            
            
          
            
          $item_id =   $ivalue['item_id']; 
               
                $condition = "where item_id='$item_id' and worker_id='$jober_id' and job_id='$job_id'";
    $working_specialist_id = self::selectcolumn('worker_specialist',array ('worker_specialist_id'),$condition,$conn);
    $worker_specialist_id = $working_specialist_id[0]['worker_specialist_id']; 
    
   
    
    if($worker_specialist_id!=null){
            $con = "where worker_id='$jober_id' and worker_specialist_id='$worker_specialist_id'";
        $worker_salary_data = self::selectcolumn('worker_salary',array ('salary'),$con,$conn);
        // echo 'IIIIIIIIIIIIIIIIIIIIII'.$worker_salary_data[0]['salary'];
        $total_booking = $total_booking+$worker_salary_data[0]['salary'];
       }
            
            
        }
        
        
    }
     if($salary_type=='Commission Basis'){
                $total_booking = 0;
              $condition = "where JOB_TITLE='BOOKING'";
      $commission_percent_data=self::selectcolumn('commission',  array ('COMMISSION'),$condition,$conn);
      $commission_percent = $commission_percent_data[0]['COMMISSION'];
      
             $total_booking = $order_value*$commission_percent/100;
         
     }
      
      return $total_booking;
      
  }
  
  
  


  public static function commision_salary($jober_id,$sub_order_id,$table,$conn)
  {
      
      //---------code to get item and item price from item table-----
      $item_id = self::selectcolumn('sub_order',array('item_id'),"where sub_order_id='$sub_order_id'",$conn);
      $item_id = $item_id[0]['item_id']; 
      
      $condition = "where item_id='$item_id'";
      $item_data = self::selectcolumn('item',  array ('price'),$condition,$conn);
      $item_price = $item_data[0]['price'];
      //---------code to get job commission from commission table
      $condition = "where JOB_TITLE='$table'";
      $commission_percent_data=self::selectcolumn('commission',  array ('COMMISSION'),$condition,$conn);
      $commission_percent = $commission_percent_data[0]['COMMISSION'];
      
      $commission = $item_price*$commission_percent/100;
      self::update('JOB_'.$table,  array ('JOBER_PAYOUT'=>$commission),"where SUB_ORDER_ID='$sub_order_id'",$conn); 
      
            //--Code to enter salary in ledger entry table-----
        $dr_id = 6; 
        $table_id = 'worker_'.$jober_id;
        $ledger_data = self::selectcolumn('ledger',  array ('ledger_id'),"where table_id='$table_id'",$conn);
        $cr = $ledger_data[0][ledger_id];
        $vcno = self::voucher_no('SLR',$conn);
        $v = $vcno + 1;
        $vc_no = "SLR" . $v;
        $particulars = $jober_id.'_salary';
        
        $ledger_entry_data_array = array (
            'dr_id'=>$dr_id,
            'cr_id'=>$cr,
            'amount'=>$commission,
            'voucher_no'=>$vc_no,
            'date'=>date('Y-m-d'),
            'particulars'=>$particulars,
            'narration'=>''
        );
        self::insert('ledger_entry',$ledger_entry_data_array,$conn);
        //---------------------------End of salary Entry---------------
      
      
  }
  
  public static function voucher_no($vc_no,$conn)
  {
     $sql = "select voucher_no from ledger_entry where voucher_no LIKE '" . $vc_no . "%'  order by ledger_entry_id DESC LIMIT 1";
    $result = mysqli_query($conn,$sql) or die(mysqli_error());
    $last_voucher = mysqli_fetch_array($result);
    $last_voucher1 = explode($vc_no, $last_voucher['voucher_no']);
    return $last_voucher1[1];
  }
  
  public static function configured_currency($conn){
   $sql= "select * from currency_config";
   return self::queryExe($sql,$conn);
       
  }
  
  
      
 public static function job_status($sub_order_id,$conn){
     
     


        $jobs = self::queryExe("select * from job_configuration",$conn);
        foreach ($jobs as $key => $value) {

            $job_table = $value['job_title'];
          
             
            $job_in_progress_at_each_stage = self::queryExe("select id as job_in_progress,JOBER_ID from JOB_$job_table where SUB_ORDER_ID='$sub_order_id' and JOB_STATUS=0",$conn);
            
          
          

            if ($job_in_progress_at_each_stage[0]['job_in_progress']) {

                $status = 'On '.$job_table;
                
                
                
                $jober_name = self::selectcolumn('worker',array('full_name'),"where worker_id = '".$job_in_progress_at_each_stage[0]['JOBER_ID']."'",$conn);
                
                $rows['jober_name'] = $jober_name[0]['full_name'];
                
            } else {


                $ready_from_worker = self::queryExe("select id as ready_from_worker from JOB_SUB_ORDER_RELATION where SUB_ORDER_ID=$sub_order_id and STATUS=1",$conn);
                if ($ready_from_worker[0]['ready_from_worker'] != null) {
                    $status = 'Ready From Worker';
                     $rows['jober_name'] = 'Working Done';
                } else {
                    $ready_to_deliver = self::queryExe("select id as ready_to_deliver from JOB_SUB_ORDER_RELATION where  SUB_ORDER_ID=$sub_order_id and STATUS=2",$conn);

                    if ($ready_to_deliver[0]['ready_to_deliver'] != null) {
                        $status = 'Ready_to_Deliver';
                         $rows['jober_name'] = 'Working Done';
                    } else {

                        $deliver = self::queryExe("select id as deliver from JOB_SUB_ORDER_RELATION where  SUB_ORDER_ID=$sub_order_id and STATUS=3",$conn);

                        if ($deliver[0]['deliver'] != null) {

                            $status = 'Delivered';
                             $rows['jober_name'] = 'Working Done';
                        } else {

                       //  $status = 'Not Assign';
                        // die();
                         //$rows['jober_name'] = 'Not Assign';


                           
                        }
                    }
                    
                    
                    
                }
                
                
                
            }
            
        
            
            
            
        }
        
        if($status!=null){ 
         return $status;
        }else{
            return $status = "Not Assigned";
        }
        
    
       
     
 }   
   
    
    
 
   
    
    
    
    

          
}
?>
