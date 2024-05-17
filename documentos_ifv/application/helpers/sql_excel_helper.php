<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
* Author: Derek Allard
*/

function to_excel($sql, $filename='exceloutput')
{
     $headers = ''; // just creating the var for field headers to append to below
     $data = ''; // just creating the var for field data to append to below

     $obj =& get_instance();

     $query = $sql["query"];

     //$fields = $sql["fields"];

     if ($query->num_rows() == 0) {
          echo '<p>NO HAY DATOS.</p>';
     } else {

          echo '<table border="1"><tr>';
          echo '<th>Cus</th>';
         
          echo '<th>Departamento</th>';
          echo '<th>Provincia</th>';
          echo '<th>Distrito</th>';

          echo '<th>Total M2</th>';
          echo '<th>Area M2</th>';
         
          /*foreach ($fields as $field) {
                echo '<th>'.$field->name .'</th>';

          }*/
          echo '</tr>';
          foreach ($query->result() as $row) {
              // $line = '';
           echo '<tr>';

               foreach($row as $value) {                                            
                    if ((!isset($value)) OR ($value == "")) {
                         //$value = "\t";
                          echo '<th></th>';
                    } else {
                          echo '<th  class="xl65">'.$value .'</th>';
                    }
                    
               }
           echo '</tr>';
          }

          echo '</table>';

          $data = str_replace("\r","",$data);

          header("Content-type: application/x-msdownload");
          header("Content-Disposition: attachment; filename=$filename.xls");
          echo mb_convert_encoding("$headers\n$data",'utf-16','utf-8');
     }
}
?>

<style type="text/css">
.xl65
{
    mso-style-parent:style0;
    mso-number-format:"\@";
}

</style>