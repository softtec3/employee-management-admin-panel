<?php
$pop_up_is_pass = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["firstName"]) {
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
    $ssnornid = $_POST["ssnornid"];
    $employeePhoto = upload_file_get_name("employeePhoto") ?? NULL;
    if ($phoneCode == "+880") {
        $country = "Bangladesh";
    } else {
        $country = "USA";
    }
    // get all users count and make dynamic employee_id and password
    $sql = "SELECT COUNT(*) AS total_rows FROM employee_log";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_user = (int) $row["total_rows"];
    }

    $employee_id = "user" . 100 + $total_user + 1;
    $employee_password = "password" . 100 + $total_user + 1;
    $full_name = $firstName . " " . $lastName;
    // insert tinto employee_log
    $stmt = $conn->prepare("INSERT INTO employee_log(employee_id, password, name) VALUES (?,?,?)");
    if (!$stmt) {
        die("employee_log preparing error: " . $conn->error);
    }
    $stmt->bind_param("sss", $employee_id, $employee_password, $full_name);
    if (!$stmt->execute()) {
        die("employee_log execution error: " . $stmt->error);
    }
    $stmt->close();

    // insert into employee_personal_details
    $stmt = $conn->prepare("INSERT into employee_personal_details (employee_id, profile_image, first_name, last_name, fathers_name, number_type, contact_number, dob, address, country, company, department, position, joining_date, blood_group) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    if (!$stmt) {
        die("employee_personal_details preparing error: " . $conn->error);
    }
    $stmt->bind_param("sssssssssssssss", $employee_id, $employeePhoto, $firstName, $lastName, $fathersName, $phoneCode, $phoneNumber, $dob, $address, $country, $company, $department, $position, $joiningDate, $bloodGroup);

    if (!$stmt->execute()) {
        die("employee_personal_details execution error: " . $stmt->error);
    }
    $stmt->close();

    $ssnornidPhoto = upload_file_get_name("ssnornidPhoto");
    // Insert only ssn or nid doc to employee_documents
    $stmt = $conn->prepare("INSERT into employee_documents (employee_id, ssn_no, ssn_photo) VALUES (?,?,?)");

    if (!$stmt) {
        die("employee_documents preparing error: " . $conn->error);
    }
    $stmt->bind_param("sss", $employee_id, $ssnornid, $ssnornidPhoto);

    if (!$stmt->execute()) {
        die("employee_documents execution error: " . $stmt->error);
    }
    $stmt->close();

    // Multiple document inset
    $uploadDir = "./uploads/";
    // 7️⃣ Handle multiple additional documents
    if (!empty($_POST['docType'])) {
        $docTypes = $_POST['docType'];
        $docPhotos = $_FILES['documentPhoto'];

        for ($i = 0; $i < count($docTypes); $i++) {
            $docType = $docTypes[$i];
            $photoName = "";

            // If a photo was uploaded for this document
            if (!empty($docPhotos['name'][$i])) {
                $fileName = time() . "_" . basename($docPhotos['name'][$i]);
                $target = $uploadDir . $fileName;
                move_uploaded_file($docPhotos['tmp_name'][$i], $target);
                $photoName = $fileName;
            }


            if (!empty($docType)) {
                $stmt2 = $conn->prepare("INSERT INTO extra_documents (employee_id, doc_type, doc_photo) VALUES (?, ?, ?)");
                if (!$stmt2) {
                    die("employee_document dynamic insert error: " . $conn->error);
                }
                $stmt2->bind_param("sss", $employee_id, $docType, $photoName);
                if (!$stmt2->execute()) {
                    die("employee_document dynamic execution error: " . $stmt2->error);
                }
                $stmt2->close();
            }
        }
    }


    $pop_up_is_pass["employee_id"] = $employee_id;
    $pop_up_is_pass["password"] = $employee_password;
}
