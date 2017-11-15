<?php


  if ($_FILES["upfile"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["upfile"]["error"] . "<br />";
    }
  else
    {

    if (file_exists("/admin/umediter/uploads/" . $_FILES["upfile"]["name"]))
      {
	
	$time = $_FILES['upfile']['name'];
	$data['url'] = "/admin/umediter/uploads/".$time;
        $data['state'] = "SUCCESS";
      	echo json_encode($data);

	
      }
    else
      {
	$time = $_FILES['upfile']['name'];
      	move_uploaded_file($_FILES["upfile"]["tmp_name"],dirname(__FILE__)."/../uploads/" . $time);	 
	$data['url'] = "/admin/umediter/uploads/".$time;
        $data['state'] = "SUCCESS";
      	echo json_encode($data);

	
      }
    }
  
