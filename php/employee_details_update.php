<?php
include_once("./db_connect.php");
// upload file and get name
function upload_file_get_name($name)
{
    if ($_FILES["$name"]) {
        $path = "./uploads/" . $_FILES["$name"]["name"];
        $file_name = $_FILES["$name"]["name"];
        move_uploaded_file($_FILES["$name"]["tmp_name"], $path);
        return $file_name;
    } else {
        die("Something went wrong during file upload!");
    };
};
if (isset($_POST["updateId"]) && $_POST["updateId"] != "") {
    $updateId = $_POST["updateId"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $fathersName = $_POST["fathersName"];
    $phoneCode = $_POST["phoneCode"];
    $phoneNumber = $_POST["phoneNumber"];
    $dob = $_POST["dob"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $company = $_POST["company"];
    $department = $_POST["department"];
    $position = $_POST["position"];
    $joiningDate = $_POST["joiningDate"];
    $bloodGroup = $_POST["bloodGroup"];
    if ($_FILES["employeePhoto"]["name"] != "") {
        $employeePhoto = upload_file_get_name("employeePhoto");
    } else {
        $employeePhoto = NULL;
    }

    // update employee_personal_details
    if ($employeePhoto) {
        $sql = "UPDATE employee_personal_details SET profile_image=?, first_name=?, last_name=?, fathers_name=?, number_type=?, contact_number=?, dob=?, address=?, company=?, department=?, position=?, joining_date=?, blood_group=?,email=? WHERE employee_id=?";
    } else {
        $sql = "UPDATE employee_personal_details SET first_name=?, last_name=?, fathers_name=?, number_type=?, contact_number=?, dob=?, address=?, company=?, department=?, position=?, joining_date=?, blood_group=?,email=? WHERE employee_id=?";
    }
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    if ($employeePhoto) {
        $stmt->bind_param("sssssssssssssss", $employeePhoto, $firstName, $lastName, $fathersName, $phoneCode, $phoneNumber, $dob, $address, $company, $department, $position, $joiningDate, $bloodGroup, $email, $updateId);
    } else {
        $stmt->bind_param("ssssssssssssss", $firstName, $lastName, $fathersName, $phoneCode, $phoneNumber, $dob, $address, $company, $department, $position, $joiningDate, $bloodGroup, $email, $updateId);
    }
    if (!$stmt->execute()) {
        die("execution error: " . $stmt->error);
    }
    echo "
        <script>
            alert('Successfully updated');
            window.location.href = '../index.php';
        </script>
    ";
}
