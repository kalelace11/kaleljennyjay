<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>
            Long Exam
        </title>
    </head>
    <body>
<?php 



class Clinics{
    protected $clinics = array();
    
    function __construct(){
        if(isset($_SESSION['clinics'])){            
            
            $this->clinics = $_SESSION['clinics'];
        }
    }
    
    protected function addClinic($clinic){       
        array_push($this->clinics,$clinic);
        $_SESSION['clinics'] = $this->clinics;
    }
    
    
    protected function deleteClinic($id){
        unset($this->clinics[$id]);
        $_SESSION['clinics'] = $this->clinics;
    }
    
    protected function show(){
        if(isset($_SESSION['clinics'])){   
            return $_SESSION['clinics'];
        } else {
            return ['error' => 'No Data Inserted'];
        }
        
    }
}


class clinicSystem extends Clinics{
    public function show(){        
        return Parent::show();
    }
    
    public function delete(){
         if(isset($_POST['clinic_id']))

        {
       
      $this->deleteClinic($_POST['clinic_id']);
      $deleteId = $_POST['clinic_id'];         
      $readData = file("filename.txt", FILE_IGNORE_NEW_LINES);            
      $arrOut = array();
        }

    }
    
    public function add(){
        if(empty($_POST)){
            $fileName = "filename.txt";
            $data = fopen($fileName, "a");
            fclose($data);
            return;
        }
        if(!isset($_POST['patient_name']) or !isset($_POST['patient_age']) or !isset($_POST['patient_gender']) or !isset($_POST['patient_address'])){
            echo "Please, do not leave fields empty.";
            return;
        }
 
        if(empty($_POST['patient_name']) or empty($_POST['patient_age']) or empty($_POST['patient_gender']) or empty($_POST['patient_address'])){
            echo "Please, do not leave fields empty.";
            return;
        }
 
        $patient_name = $_POST['patient_name'];
        $patient_age = $_POST['patient_age'];
        $patient_gender = $_POST['patient_gender'];
        $patient_address =  $_POST['patient_address'];
        $fileName = "filename.txt";
        $readData = file("filename.txt", FILE_IGNORE_NEW_LINES);
 
        $data = array('patient_name'=>$patient_name,'patient_age'=>$patient_age,'patient_gender'=>$patient_gender,'patient_address'=>$patient_address);
        $this->addClinic($data);
        $fileName = "filename.txt";
        $data = fopen($fileName, "a");
        fwrite($data, $patient_name."|---|".$patient_age."|---|".$patient_gender."|---|".$patient_address."\r\n");
        fclose($data);
    }
}
    ?>
        
        <form method="POST">
            <div class="container mt-4 mb-4">
                <div class="row">
                    <div>
                        <div class="form-group"> 
                            <input type="text" class="form-control" name="patient_name" placeholder="Enter Patient Name">                
                         </div>
                    </div>
                    <div>
                        <div class="form-group"> 
                            <input type="text" class="form-control" name="patient_age" placeholder="Enter Patient Age">                
                        </div>
                    </div>
                    <div>
                        <div class="form-group"> 
                            <input type="text" class="form-control" name="patient_gender" placeholder="Enter Patient Gender">                
                         </div>
                    </div>
                    <div>
                        <div class="form-group"> 
                            <input type="text" class="form-control" name="patient_address" placeholder="Enter Patient address">                
                         </div>
                    </div>
                    <div>
                        <button class="btn btn-primary">
                            Add
                         </button>
                    </div>
                </div>
            </div>
        </form>
        
        
        <table class="table">
            <thead>
                <tr>
                  <th>No.</th>
                    <th>
                        Patient Name
                    </th>
                    <th>
                        Patient Age
                    </th>
                    <th>
                        Patient Gender
                    </th>
                    <th>
                        Patient Address
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $clinics = new ClinicSystem;
                    $clinics->add();
                    $clinics->delete();
                    $data = $clinics->show();
if(isset($data['error'])){
                        echo "<tr><td colspan='6' class='text-center'>". $data['error'] ."</td></tr>";
} else {
                    $table = '';
                    //var_dump($_SESSION['clinics']);
                    $counter = 1;
                    foreach($data as $key => $value){
                        $table .= '<tr>';
                        $table .= '<td>'.$counter++.'</td>';
                        $table .= '<td>'.$value['patient_name'].'</td>';
                        $table .= '<td>'.$value['patient_age'].'</td>';
                        $table .= '<td>'.$value['patient_gender'].'</td>';
                        $table .= '<td>'.$value['patient_address'].'</td>';                        
                        $table .= '<td><form method="POST"><input type="hidden" name="clinic_id" value="'.$key.'"><button class="btn btn-danger">Delete</button></form></td>';
                        $table .= '</tr>';
                    }

                    echo $table;
}

                ?>
                
                
            </tbody>
        </table>
    </body>
</html>