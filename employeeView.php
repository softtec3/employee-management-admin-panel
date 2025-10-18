<?php
include_once("./php/db_connect.php");
include_once("./php/employees_operations.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Font awesome cdn -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <title>Employee Details</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .printBtnContainer {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 10px;
      box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    }

    #printBtn {
      padding: 8px;
      color: white;
      border: none;
      background-color: #ff7810;
      border-radius: 3px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
    }

    #printAreaContainer {
      width: 220mm;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 20px;
      margin-top: 20px;
      padding: 0 10px;
      padding-bottom: 10px;
    }

    #printAreaContainer img {
      width: 180px;
      max-width: 180px;
      height: 200px;
      max-height: 200px;
      object-fit: contain;
    }

    #printAreaContainer table {
      width: 60%;
      border-collapse: collapse;
    }

    #printAreaContainer table,
    td {
      padding: 5px;
      font-size: 17px;
    }

    #printAreaContainer table td:first-child {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    #printAreaContainer table tr {
      border-bottom: 1px solid gainsboro;
    }
  </style>
</head>

<body>
  <div class="printBtnContainer" id="printBtnContainer">
    <button id="printBtn"><i class="fa-solid fa-print"></i> Print</button>
  </div>
  <!-- Employee Details -->
  <?php
  if ($target_employee && count($target_employee)) {
    $img_url = $target_employee["profile_image"] ? "./uploads/" . $target_employee["profile_image"] : "";
    echo "

    <div id='printAreaContainer'>
  <img src='$img_url' alt='employee Image' />
  <table>
    <tr>
      <td style='font-weight: bold'>ID <span>:</span></td>
      <td>{$target_employee["employee_id"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Full Name <span>:</span></td>
      <td>{$target_employee["first_name"]} {$target_employee["last_name"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Father's Name <span>:</span></td>
      <td>{$target_employee["fathers_name"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Phone Number <span>:</span></td>
      <td>{$target_employee["contact_number"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>DOB <span>:</span></td>
      <td>{$target_employee["dob"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Address <span>:</span></td>
      <td>{$target_employee["address"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Email <span>:</span></td>
      <td>{$target_employee["email"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Company <span>:</span></td>
      <td>{$target_employee["company"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Department <span>:</span></td>
      <td>{$target_employee["department"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Position <span>:</span></td>
      <td>{$target_employee["position"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Joining Date <span>:</span></td>
      <td>{$target_employee["joining_date"]}</td>
    </tr>
    <tr>
      <td style='font-weight: bold'>Blood Group <span>:</span></td>
      <td>{$target_employee["blood_group"]}</td>
    </tr>
  </table>
</div>

    
    ";
  }
  ?>
  <!-- <div id="printAreaContainer">
    <img src="./placeholder.jpg" alt="employee Image" />
    <table>
      <tr>
        <td style="font-weight: bold">ID <span>:</span></td>
        <td>LLC-01</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Full Name <span>:</span></td>
        <td>John Doe</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Father's Name <span>:</span></td>
        <td>John Doe</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Phone Number <span>:</span></td>
        <td>+8801318195591</td>
      </tr>
      <tr>
        <td style="font-weight: bold">DOB <span>:</span></td>
        <td>03/04/2005</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Address <span>:</span></td>
        <td>Jashore, Bangladesh</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Email <span>:</span></td>
        <td>john@gmail.com</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Company <span>:</span></td>
        <td>Soft-Tech Technology LLC</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Department <span>:</span></td>
        <td>Sales</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Position <span>:</span></td>
        <td>Chief Operating Officer</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Joining Date <span>:</span></td>
        <td>12/12/2024</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Blood Group <span>:</span></td>
        <td>A+</td>
      </tr>
    </table>
  </div> -->

  <!-- Print script -->
  <script>
    const prevHtml = document.body.innerHTML;
    const printAreaContainer = document.getElementById("printAreaContainer");
    document.getElementById("printBtn").addEventListener("click", () => {
      document.getElementById("printBtnContainer").remove();
      window.print();
      window.location.reload();
    });
  </script>
</body>

</html>