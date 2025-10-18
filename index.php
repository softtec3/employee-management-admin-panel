<?php
session_start();
if (!$_SESSION["user_id"] || !$_SESSION["user_role"]) {
  header("Location: ./login.php");
}
$logged_in_user = $_SESSION["user_id"];
include_once("./php/db_connect.php");
include_once("./php/logout.php");
include_once("./php/leave_applications.php");
include_once("./php/all_emp_ids.php");
include_once("./php/tasks.php");
include_once("./php/employee_signup.php");
include_once("./php/employees_operations.php");
include_once("./php/projects.php");

if ($_SESSION["user_role"] == "super-admin" || $_SESSION["user_role"] == "project-manager") {
  $project_access = "true";
} else {
  $project_access = "false";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="./style.css" />
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">Admin Panel</div>
    <div class="loginUserDetails">
      <p><?php echo $_SESSION["user_id"] ?></p>
      <p style="text-transform: uppercase;"><?php echo $_SESSION["user_role"] ?></p>
    </div>
    <?php
    if ($_SESSION["user_role"] && ($_SESSION["user_role"] == "super-admin" || $_SESSION["user_role"] == "manager")) {
      echo "
        <button class='nav-btn active' data-target='employeeSignUp'>
      <i class='fa-solid fa-user-plus'></i> Employee Signup
    </button>
        ";
    }
    ?>


    <button class="nav-btn" data-target="assignTask">
      <i class="fa-solid fa-tasks"></i> Assign Task
    </button>
    <button class="nav-btn" data-target="activity">
      <i class="fas fa-history"></i>
      Activity
    </button>
    <!-- <button class="nav-btn" data-target="approvals">
      <i class="fas fa-check-circle"></i> Approvals
    </button> -->
    <!-- <button class="nav-btn" data-target="reports">
      <i class="fas fa-chart-line"></i> Reports
    </button> -->

    <button class="nav-btn" data-target="employeeList">
      <i class="fa-solid fa-users"></i> Employees
    </button>
    <button class="nav-btn" data-target="leaveApplications">
      <i class="fa-solid fa-plane-departure"></i> Leave Applications
    </button>
    <?php
    if ($_SESSION["user_role"] && $_SESSION["user_role"] == "super-admin") {
      echo "
        <button id='paymentUSBtn' class='nav-btn' data-target='paymentUS'>
      <i class='fa-solid fa-file-invoice-dollar'></i> Payment-US
    </button>
        ";
    }
    ?>
    <?php
    if ($_SESSION["user_role"] == "super-admin" || $_SESSION["user_role"] == "project-manager") {
      echo "
          <button class='nav-btn' data-target='projects'>
      <i class='fa-solid fa-diagram-project'></i>
      Projects
    </button>
      ";
    }
    ?>

    <a href="./index.php?logout"> <i class="fa-solid fa-right-from-bracket"></i> Logout </a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Employee Signup -->
    <div id="employeeSignUp" class="content-section     <?php
                                                        if ($_SESSION["user_role"] && ($_SESSION["user_role"] == "super-admin" || $_SESSION["user_role"] == "manager")) {
                                                          echo "active";
                                                        } else {
                                                          echo "hidden";
                                                        }
                                                        ?> ">
      <h2>Employee Signup</h2>
      <form id="signupForm" method="post" enctype="multipart/form-data">
        <div class="formFlex">
          <img id="emPhoto" src="./placeholder.jpg" alt="employee photo" />
          <div class="form-group" style="justify-content: center">
            <label for="employeePhoto">Employee Photo</label>
            <input
              type="file"
              id="employeePhoto"
              name="employeePhoto"
              required />
          </div>
        </div>
        <div class="formFlex">
          <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" required />
          </div>
          <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" required />
          </div>
        </div>
        <div class="form-group">
          <label for="fathersName">Father's Name</label>
          <input type="text" id="fathersName" name="fathersName" required />
        </div>
        <div class="formFlex">
          <div class="formFlex">
            <div class="form-group" style="width: auto">
              <label for="phoneCode">Phone code</label>
              <select
                name="phoneCode"
                id="phoneCode"
                style="width: 115px; height: 39px">
                <option value="+1">USA (+1)</option>
                <option value="+880">BD (+880)</option>
              </select>
            </div>
            <div class="form-group">
              <label for="phoneNumber">Phone Number</label>
              <input
                type="tel"
                id="phoneNumber"
                name="phoneNumber"
                required
                value="+1" />
            </div>
          </div>
          <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" style="height: 39px" />
          </div>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <textarea id="address" name="address" rows="2"></textarea>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div class="form-group">
          <label for="company">Select Company</label>
          <select id="company" name="company" required>
            <option value="" style="display: none">
              -- Select Company --
            </option>
            <option value="soft-tech technology">Soft-Tech Technology</option>
            <option value="soft-tech technology lls">
              Soft-Tech Technology LLC
            </option>
          </select>
        </div>
        <div class="formFlex">
          <div class="form-group">
            <label for="department">Department</label>
            <select id="department" name="department" required>
              <option value="" style="display: none">
                -- Select Department --
              </option>
              <option value="it">IT</option>
              <option value="sales">Sales</option>
              <option value="marketing">Marketing</option>
            </select>
          </div>
          <div class="form-group">
            <label for="position">Position</label>
            <input type="text" id="position" name="position" required />
          </div>
        </div>
        <div class="formFlex">
          <div class="form-group">
            <label for="joiningDate">Joining Date</label>
            <input
              type="date"
              id="joiningDate"
              name="joiningDate"
              style="height: 39px" />
          </div>
          <div class="form-group">
            <label for="bloodGroup">Blood Group</label>
            <select id="bloodGroup" name="bloodGroup" required>
              <option value="" style="display: none">
                -- Select Blood Group --
              </option>
              <option value="A+">A+</option>
              <option value="A-">A-</option>
              <option value="B+">B+</option>
              <option value="B-">B-</option>
              <option value="AB+">AB+</option>
              <option value="AB-">AB-</option>
              <option value="O+">O+</option>
              <option value="O-">O-</option>
            </select>
          </div>
        </div>
        <fieldset>
          <legend>Essential Documents</legend>
          <div class="formFlex">
            <div class="form-group">
              <label for="ssnornid">SSN/NID </label>
              <input type="text" id="ssnornid" name="ssnornid" />
            </div>
            <div class="form-group">
              <label for="ssnornidPhoto">SSN/NID Photo </label>
              <input type="file" id="ssnornidPhoto" name="ssnornidPhoto" />
            </div>
          </div>
        </fieldset>
        <fieldset id="additionalDocuments">
          <legend>Additional Documents</legend>
          <div class="formFlex">
            <div class="form-group">
              <label for="docType">Document Type </label>
              <input type="text" id="docType" name="docType[]" />
            </div>
            <div class="form-group">
              <label for="documentPhoto">Document Photo </label>
              <input type="file" id="documentPhoto" name="documentPhoto[]" />
            </div>
            <div
              id="addBtn"
              style="display: flex; align-items: center; cursor: pointer">
              <i class="fa-solid fa-plus" style="margin-top: 20px"></i>
            </div>
          </div>
        </fieldset>

        <button type="submit" class="submit-btn">Sign Up</button>
      </form>
    </div>

    <!-- Assign Task -->
    <div id="assignTask" class="content-section <?php
                                                if ($_SESSION["user_role"] == "super-admin" || $_SESSION["user_role"] == "manager") {
                                                  echo "";
                                                } else {
                                                  echo "active";
                                                }
                                                ?>">
      <h2>Assign Task</h2>
      <form id="taskForm" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="employeeId">Employee Id</label>
          <select id="employeeId" name="employeeId" required>
            <option value="" style="display: none">
              -- Select employee Id --
            </option>
            <?php
            if (isset($all_emp_ids) && count($all_emp_ids) > 0) {
              foreach ($all_emp_ids as $emp_id) {
                echo "
                  <option value='$emp_id'>$emp_id</option>
                  ";
              }
            }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="taskTitle">Task Title</label>
          <input type="text" id="taskTitle" name="taskTitle" required />
        </div>

        <div class="form-group">
          <label for="taskDescription">Task Description</label>
          <textarea
            id="taskDescription"
            name="taskDescription"
            rows="3"></textarea>
        </div>
        <div class="form-group">
          <label for="taskDocument">Task Document</label>
          <input type="file" id="taskDocument" name="taskDocument" />
        </div>
        <div class="form-group">
          <label for="deadline">Deadline</label>
          <input type="date" id="deadline" name="deadline" required />
        </div>

        <button type="submit" class="submit-btn">Assign Task</button>
      </form>
    </div>
  </div>
  <!-- Employee list -->
  <div id="employeeList" class="content-section">
    <div class="flexJustify">
      <h2>Employees</h2>
      <form action="" class="inputFrom" method="get">
        <input
          type="search"
          name="searchEmployeeId"
          id="searchEmployee"
          placeholder="Search by ID"
          required />
        <button type="submit" class="searchBtn">Search</button>
        <a href="./index.php" type="submit" class="searchBtn" style="background-color: red;">Reset</a>
      </form>
    </div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Position</th>
            <th>Joining Date</th>
            <th>Operation</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($all_employees) && count($all_employees) > 0) {
            foreach ($all_employees as $s_employee) {
              $em_img_url = "./placeholder.jpg";
              $em_emp_id =  $s_employee["employee_id"];
              if ($s_employee["profile_image"]) $em_img_url = "./uploads/" . $s_employee["profile_image"];
              echo "
                <tr>
            <td>{$s_employee["employee_id"]}</td>
            <td>
              <img
                class='tablePhotoEmployee'
                src='$em_img_url'
                alt='' />
            </td>
            <td>{$s_employee["first_name"]} {$s_employee["last_name"]}</td>
            <td>{$s_employee["email"]}</td>
            <td>{$s_employee["contact_number"]}</td>
            <td>{$s_employee["department"]}</td>
            <td>{$s_employee["position"]}</td>
            <td>{$s_employee["joining_date"]}</td>
            <td>
              <a
                href='./index.php?view_id={$s_employee["id"]}'
                class='opBtn view-em-btn'
                style='background-color: #17a2b8'
                title='View'>
                <i class='fa-solid fa-eye'></i>
              </a>
              <a
                href='./index.php?edit_id={$s_employee["id"]}&view_id={$s_employee["id"]}'
                class='opBtn'
                title='Edit'
                style='background-color: #28a745'>
                <i class='fa-solid fa-pen-to-square'></i>
              </a>
              <button
                onclick=\"handleDelete('$em_emp_id')\"
                class='opBtn'
                title='Delete'
                style='background-color: red'>
                <i class='fa-solid fa-trash'></i>
              </button>
            </td>
          </tr> 
                ";
            }
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>
  <!-- Activity -->
  <section id="activity" class="content-section hidden">
    <div class="flexJustify">
      <h2>Employee Task Activity</h2>
      <select name="filter" id="filter" class="filter">
        <option value="" style="display: none">Filter by</option>
        <option value="assigned">Assigned</option>
        <option value="pending">Pending</option>
        <option value="in-progress">In Progress</option>
        <option value="completed">Completed</option>
      </select>
    </div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Employee ID</th>
            <th>Task</th>
            <th>Description</th>
            <th>Document</th>
            <th>Assigned Date</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Completed Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($all_tasks) && count($all_tasks) > 0) {
            foreach ($all_tasks as $s_task) {
              $doc_link = "./uploads/" . $s_task["task_document"];
              $short_desc = substr($s_task["task_description"], 0, 50);
              if ($s_task["status"] == "completed") {
                $is_completed = "<td>{$s_task["completed_date"]}</td>";
              } else {
                $is_completed = "<td>---</td>";
              }
              echo "
            <tr>
            <td>{$s_task["employee_id"]}</td>
            <td>{$s_task["task_title"]}</td>
            <td title='{$s_task["task_description"]}'>$short_desc </td>
            <td><a href='$doc_link' target='_blank' class='docViewLink'>View</a></td>
            <td>{$s_task["created_at"]}</td>
            <td>{$s_task["dead_line"]}</td>
            <td style='text-transform:capitalize'>{$s_task["status"]}</td>
            $is_completed
          </tr>
              ";
            }
          } else {
            echo "<tr><td colspan='12'>No data found</td></tr>";
          }
          ?>

        </tbody>
      </table>
    </div>
  </section>
  <!-- Approval Section -->
  <div id="approvals" class="content-section hidden">
    <h2>Employee Approvals</h2>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Email</th>
            <th>Full Updating</th>
            <th>Submitted Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>LLC-01</td>
            <td>John Doe</td>
            <td>john@example.com</td>
            <td>
              <a
                href="./profile.php?profileId=1"
                target="_blank"
                class="view-doc-btn">
                View
              </a>
            </td>
            <td>2025-09-25</td>
            <td>Pending</td>
            <td>
              <button class="approve-btn">Approve</button>
              <button class="reject-btn">Reject</button>
            </td>
          </tr>
          <tr>
            <td>LLC-02</td>
            <td>Jane Smith</td>
            <td>jane@example.com</td>
            <td>
              <a
                href="./profile.php?profileId=2"
                target="_blank"
                class="view-doc-btn">
                View
              </a>
            </td>
            <td>2025-09-24</td>
            <td>Pending</td>
            <td>
              <button class="approve-btn">Approve</button>
              <button class="reject-btn">Reject</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Report section -->
  <div id="reports" class="content-section hidden">
    <h2>Reports & Analytics</h2>
    <div class="analytics-cards">
      <div class="card">
        <h3>Total Employees</h3>
        <p>120</p>
      </div>
      <div class="card">
        <h3>Tasks Completed</h3>
        <p>85%</p>
      </div>
      <div class="card">
        <h3>Pending Approvals</h3>
        <p>5</p>
      </div>
    </div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Total Tasks</th>
            <th>Tasks Completed</th>
            <th>Tasks In Progress</th>
            <th>Tasks Pending</th>
            <th>Last Active</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>LLC-01</td>
            <td>John Doe</td>
            <td>10</td>
            <td>7</td>
            <td>2</td>
            <td>1</td>
            <td>2025-09-25</td>
          </tr>
          <tr>
            <td>LLC-02</td>
            <td>Jane Smith</td>
            <td>8</td>
            <td>5</td>
            <td>3</td>
            <td>0</td>
            <td>2025-09-24</td>
          </tr>
          <tr>
            <td>LLC-03</td>
            <td>Bob Brown</td>
            <td>6</td>
            <td>4</td>
            <td>1</td>
            <td>1</td>
            <td>2025-09-23</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Leave applications -->
  <div id="leaveApplications" class="content-section hidden">
    <h2>Leave Applications</h2>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>From</th>
            <th>To</th>
            <th>Reason</th>
            <th>Application</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($all_applications) && count($all_applications) > 0) {
            foreach ($all_applications as $s_application) {
              $pdf_url = "./uploads/applications/" . $s_application["application"];
              $action = "<td class='leaveApplicationButtons'>
                              <a href='./index.php?approve_application={$s_application["id"]}' title='Approve' style='background-color: #28a745'>
                                Approve
                              </a>
                              <a href='./index.php?reject_application={$s_application["id"]}' title='Reject' style='background-color: red'>
                                Reject
                              </a>
                            </td>";
              if ($s_application["status"] != "pending") {
                $action = "<td class='leaveApplicationButtons'>
                              Taken
                            </td>";;
              }
              echo "
                            <tr>
                            <td>{$s_application["employee_id"]}</td>
                            <td>{$s_application["full_name"]}</td>
                            <td>{$s_application["from_date"]}</td>
                            <td>{$s_application["to_date"]}</td>
                            <td>{$s_application["reason"]}</td>
                            <td class='leaveApplicationButtons'>
                             <a href='$pdf_url' class='applicationViewBtn' style='background-color: #17a2b8'>View</a>
                           </td>
                           <td style='text-transform: Capitalize'>{$s_application["status"]}</td>
                              $action
                            </tr>
                                
                                ";
            }
          } else {
            echo "<tr><td colspan='12'>0 application</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Projects-->
  <div id="projects" class="content-section hidden">
    <div class="projectsNav">
      <button onclick="handleProjectContent('createProject')">Create Project</button>
      <button onclick="handleProjectContent('assignEmployee')">Assign Employee</button>
      <button onclick="handleProjectContent('projectReport')">Report</button>
    </div>
    <!-- Create project -->
    <div id="createProject" class="project-section">
      <form action="" method="post" enctype="multipart/form-data">
        <h2 style="margin-bottom: 0;">Create Project</h2>
        <div class="form-group">
          <label for="project_title">Project Title</label>
          <input type="text" name="project_title" id="" required>
        </div>
        <div class="form-group">
          <label for="project_description">Project Description</label>
          <textarea name="project_description" style="resize: none; min-height:120px" id="" required></textarea>
        </div>
        <div class="form-group">
          <label for="project_attachment">Project Attachment</label>
          <input type="file" name="project_attachment" id="">
        </div>
        <div class="formFlex">
          <div class="form-group">
            <label for="project_start">Project Start</label>
            <input type="date" name="project_start" id="" value="" required>
          </div>
          <div class="form-group">
            <label for="project_deadline">Project Deadline</label>
            <input type="date" name="project_deadline" id="" required>
          </div>
        </div>
        <div class="form-group">
          <button class="submit-btn">Create Project</button>
        </div>

      </form>
    </div>
    <!-- Assign employee -->
    <div id="assignEmployee" class="project-section" style="display: none;">
      <form action="" method="post" enctype="multipart/form-data">
        <h2 style="margin-bottom: 0;">Assign Employee</h2>
        <div class="form-group">
          <label for="project_id">Select Project</label>
          <select name="project_id" id="project_id" required>
            <option value="" style="display: none;">---Select a project---</option>
            <?php
            if (isset($all_projects) && count($all_projects) > 0) {
              foreach ($all_projects as $project) {

                echo "<option value='{$project["id"]}'>{$project["title"]}</option>";
              }
            }
            ?>
          </select>
        </div>
        <input type="hidden" name="project_title_task" id="project_title_task">
        <div class="form-group">
          <label for="assign_to">Assign To</label>
          <select name="assign_to" id="" required>
            <option value="" style="display: none;">---Select an employee---</option>
            <?php
            if (isset($all_emp_ids) && count($all_emp_ids) > 0) {
              foreach ($all_emp_ids as $emp_id) {
                echo "
                  <option value='$emp_id'>$emp_id</option>
                  ";
              }
            }
            ?>
          </select>
          <input type="hidden" name="assign_by" value="<?php echo htmlspecialchars($logged_in_user) ?>">
        </div>
        <div class="form-group">
          <label for="task_title">Task Title</label>
          <input type="text" name="task_title" id="" required>
        </div>
        <div class="form-group">
          <label for="task_description">Task Description</label>
          <textarea name="task_description" style="resize: none; min-height:120px" id="" required></textarea>
        </div>
        <div class="form-group">
          <label for="task_attachment">Task Attachment</label>
          <input type="file" name="task_attachment" id="">
        </div>
        <div class="formFlex">
          <div class="form-group">
            <label for="assign_date">Assign Date</label>
            <input type="date" name="assign_date" id="" value="" required>
          </div>
          <div class="form-group">
            <label for="task_deadline">Task Deadline</label>
            <input type="date" name="task_deadline" id="" required>
          </div>
        </div>
        <div class="form-group">
          <button class="submit-btn">Assign Task</button>
        </div>

      </form>
    </div>
    <!-- Project report -->
    <div id="projectReport" class="project-section" style="display: none;">
      <div style="display: flex; align-items:center; justify-content: flex-end;width:100%; margin-bottom:20px">
        <!-- <select name="select_project" id="selectProject" style="max-width: 200px;">
          <option value="" style="display: none;">--Select a project--</option>
          <?php
          if (isset($all_projects) && count($all_projects) > 0) {
            foreach ($all_projects as $project) {

              echo "<option value='{$project["id"]}'>{$project["title"]}</option>";
            }
          }
          ?>
        </select> -->
      </div>
      <!-- All projects -->
      <h2>All Projects</h2>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Project ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Attachment</th>
              <th>Start Date</th>
              <th>Deadline</th>
              <th>Status</th>
              <th>Action</th>
              <th>Completed Date</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($all_projects) && count($all_projects) > 0) {

              foreach ($all_projects as $s_project) {
                if ($s_project["status"] != "completed") {
                  $act_btn = "<td><a href='./index.php?complete_project={$s_project["id"]}' class='projectActionBtn' style='background-color: green;'>Complete</a></td>";
                } else {
                  $act_btn = "<td>---</td>";
                }
                if ($s_project["completed_date"]) {
                  $completed_pro = "<td>{$s_project["completed_date"]}</td>";
                } else {
                  $completed_pro = "<td>---</td>";
                }
                echo "
                    <tr>
              <td>{$s_project["id"]}</td>
              <td>{$s_project["title"]}</td>
              <td>{$s_project["description"]}</td>
              <td><a href='./uploads/{$s_project["attachment"]}' target='_blank' class='projectActionBtn' style='background-color: orange;'>View</a></td>
              <td>{$s_project["start_date"]}</td>
              <td>{$s_project["deadline"]}</td>
              <td style='text-transform:capitalize'>{$s_project["status"]}</td>
              $act_btn
               $completed_pro
               <td><a href='./index.php?delete_project={$s_project["id"]}' class='projectActionBtn' style='background-color: red;'>Delete</a></td>
            </tr>
                  ";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <!-- Overview -->
      <h2 style="margin-top: 20px;">Tasks Overview</h2>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Project ID</th>
              <th>Project Title</th>
              <th>Task Title</th>
              <th>Assign To</th>
              <th>Assign Date</th>
              <th>Deadline</th>
              <th>Status</th>
              <th>Action</th>
              <th>Correction</th>
              <th>Completed Date</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($all_projects_tasks) && count($all_projects_tasks) > 0) {
              foreach ($all_projects_tasks as $s_p_task) {
                if ($s_p_task["completed_date"]) {
                  $completed_task = "<td>{$s_p_task["completed_date"]}</td>";
                } else {
                  $completed_task = "<td>---</td>";
                }
                if ($s_p_task["correction"]) {
                  $task_correction = "<td>{$s_p_task["correction"]}</td>";
                } else {
                  $task_correction = "<td>---</td>";
                }
                echo "
                  <tr>
              <td>{$s_p_task["project_id"]}</td>
              <td>{$s_p_task["project_title"]}</td>
              <td>{$s_p_task["title"]}</td>
              <td>{$s_p_task["assign_to"]}</td>
              <td>{$s_p_task["created_at"]}</td>
              <td>{$s_p_task["deadline"]}</td>
              <td style='text-transform: capitalize'>{$s_p_task["status"]}</td>
              <td><button onclick='handleCorrection({$s_p_task["id"]})' class='projectActionBtn' style='background-color: orange;'>Correction</button>
              </td>
              $task_correction
              $completed_task
              <td>
              <a href='./index.php?delete_task={$s_p_task["id"]}' class='projectActionBtn' style='background-color: red;'>Delete</a></td>

            </tr>
                ";
              }
            }
            ?>


          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- All Pop up -->
  <!-- Payment-US -->
  <?php
  if ($_SESSION["user_role"] && $_SESSION["user_role"] == "super-admin") {

    echo "
      <div id='paymentUS' style='display: none'>
    <form action='./php/passkey_verification.php' method='post'>
      <a href='./' id='passkeyFormCloseBtn'><i class='fa fa-solid fa-xmark'></i></a>
      <h3>Passkey Login</h3>
      <div class='form-group'>
        <label for='passkey'>Enter Passkey</label>
        <input type='number' name='passkey' required/>
      </div>
      <div class='form-group'>
        <button type='submit'>Submit</button>
      </div>
    </form>
  </div>
      ";
  }

  ?>

  <!--Employee Username and Password Popup -->
  <?php
  if (isset($pop_up_is_pass) && count($pop_up_is_pass) > 0) {
    $pass = $pop_up_is_pass["password"];
    $emp_user_id = $pop_up_is_pass["employee_id"];
    echo "
    <div class='popup' id='popup' style='display:flex'>
    <div class='popup-content'>
      <a href='./index.php' class='close' id='closePopup'>&times;</a>
      <h3>Employee Created</h3>
      <div class='info'>
        <span>Employee ID: {$pop_up_is_pass["employee_id"]}</span>
        <i class='fa-solid fa-copy' onclick='copyToClipboard(\"$emp_user_id\")'></i>
      </div>
      <div class='info'>
        <span>Password: {$pop_up_is_pass["password"]}</span>
        <i class='fa-solid fa-copy' onclick='copyToClipboard(\"$pass\")'></i>
      </div>
    </div>
  </div>
      ";
  }
  ?>

  <!-- Doc popup -->
  <div class="doc-popup" id="docPopup">
    <div class="doc-popup-content">
      <span class="close" id="closeDocPopup"><i class="fa fa-xmark"></i></span>
      <iframe
        src=""
        title="doc"
        id="docFrame"
        width="100%"
        height="500px"></iframe>
    </div>
  </div>
  <!-- View employee details popup -->
  <?php
  if (isset($target_employee) && count($target_employee) > 0) {
    $t_e_img_url = "./placeholder.jpg";
    $nid_link = $target_nid_doc["ssn_photo"] ? "./uploads/" . $target_nid_doc["ssn_photo"] : "";
    if ($target_employee["profile_image"]) $t_e_img_url = "./uploads/" . $target_employee["profile_image"];
    $doc_rows = "";
    foreach ($all_other_documents as $s_doc) {
      $doc_link = $s_doc["doc_photo"] ? "./uploads/" . $s_doc["doc_photo"] : "";
      $doc_rows .= "
        <tr>
          <td style='font-weight: bold'>{$s_doc["doc_type"]} <span>:</span></td>
          <td>
            <a href='$doc_link' target='_blank' class='empDocViewBtn'>View Document</a>
          </td>
        </tr>
      ";
    };

    echo "
          <div id='employeeDetailsPopup'>
    <div class='employeeDetailsContent' id='employeeDetailsContent'>
      <a href='./index.php' id='emdc-close'><i class='fa-solid fa-xmark'></i></a>
      <img src='$t_e_img_url' alt='employee Image' />
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
        <tr>
          <td style='font-weight: bold'>NID <span>:</span></td>
          <td>
            <a href='$nid_link' target='_blank' class='empDocViewBtn'>View Document</a>
          </td>
        </tr>
        $doc_rows
       
      </table>
      <!-- Need to change the link extension .html to .php -->
      <a
        href='./employeeView.php?view_id={$target_employee["id"]}'
        target='_blank'
        class='btn'
        style='color: white'>View & Print</a>
    </div>
  </div>
        ";
  }
  ?>

  <!-- Employee Delete popup -->
  <div class="uniPopup" id="employeeDelete" style="display: none">
    <form action="" class="employeeDeleteContainer">
      <input
        type="hidden"
        name="deleteEmployeeId"
        id="deleteEmpInput"
        value="" />
      <h3 style="color: red">
        Delete Employee: <span id="idOfDeleteEmp">LLC-01</span>
      </h3>
      <h2>Are you sure..?</h2>
      <div>
        <button style="background-color: red">Delete</button>
        <button id="closeDeleteEmployeePopup" type="button">Cancel</button>
      </div>
    </form>
  </div>
  <!-- Employee Update popup -->
  <div class="uniPopup" id="empUpdatePopup" style="display: none">
    <form action="./php/employee_details_update.php" enctype="multipart/form-data" id="" method="post">
      <input type="hidden" name="updateId" id="updateEmpId" value="<?php echo htmlspecialchars($target_employee['employee_id'] ?? ''); ?>" />
      <a href="./index.php" id="empUPclose"><i class="fa fa-solid fa-xmark"></i></a>
      <h2 style="text-align: center">Employee Update</h2>
      <div class="formFlex">
        <img id="emPhoto" src="<?php $img_u =  $target_employee["profile_image"] ? "./uploads/" . $target_employee["profile_image"] : "./placeholder.jpg";
                                echo $img_u; ?>" alt="employee photo" />
        <div class="form-group" style="justify-content: center">
          <label for="employeePhoto">Employee Photo</label>
          <input
            type="file"
            id="employeePhoto"
            name="employeePhoto" />
        </div>
      </div>
      <div class="formFlex">
        <div class="form-group">
          <label for="firstName">First Name</label>
          <input type="text" id="firstName" name="firstName" required value="<?php echo htmlspecialchars($target_employee['first_name'] ?? ''); ?>" />
        </div>
        <div class="form-group">
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" name="lastName" required value="<?php echo htmlspecialchars($target_employee['last_name'] ?? ''); ?>" />
        </div>
      </div>
      <div class="form-group">
        <label for="fathersName">Father's Name</label>
        <input type="text" id="fathersName" name="fathersName" required value="<?php echo htmlspecialchars($target_employee['fathers_name'] ?? ''); ?>" />
      </div>
      <div class="formFlex">
        <div class="formFlex">
          <div class="form-group" style="width: auto">
            <label for="phoneCode">Phone code</label>
            <select
              name="phoneCode"
              id="phoneCode"
              style="width: 115px; height: 39px">
              <option value="+1" <?php if ($target_employee["number_type"] == "+1") echo "selected" ?>>USA (+1)</option>
              <option value="+880" <?php if ($target_employee["number_type"] == "+880") echo "selected" ?>>BD (+880)</option>
            </select>
          </div>
          <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input
              type="tel"
              id="phoneNumber"
              name="phoneNumber"
              required
              value="<?php echo htmlspecialchars($target_employee['contact_number'] ?? ''); ?>" />
          </div>
        </div>
        <div class="form-group">
          <label for="dob">Date of Birth</label>
          <input type="date" id="dob" name="dob" style="height: 39px" value="<?php echo htmlspecialchars($target_employee['dob'] ?? ''); ?>" />
        </div>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="2"><?php echo htmlspecialchars($target_employee['address'] ?? ''); ?></textarea>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($target_employee['email'] ?? ''); ?>" />
      </div>
      <div class="form-group">
        <label for="company">Select Company</label>
        <select id="company" name="company" required>
          <option value="" style="display: none">-- Select Company --</option>
          <option value="soft-tech technology" <?php if ($target_employee["company"] == "soft-tech technology") echo "selected" ?>>Soft-Tech Technology</option>
          <option value="soft-tech technology lls" <?php if ($target_employee["company"] == "soft-tech technology lls") echo "selected" ?>>
            Soft-Tech Technology LLC
          </option>
        </select>
      </div>
      <div class="formFlex">
        <div class="form-group">
          <label for="department">Department</label>
          <select id="department" name="department" required>
            <option value="" style="display: none">
              -- Select Department --
            </option>
            <option value="it" <?php if ($target_employee["department"] == "it") echo "selected" ?>>IT</option>
            <option value="sales" <?php if ($target_employee["department"] == "sales") echo "selected" ?>>Sales</option>
            <option value="marketing" <?php if ($target_employee["department"] == "marketing") echo "selected" ?>>Marketing</option>
          </select>
        </div>
        <div class="form-group">
          <label for="position">Position</label>
          <input type="text" id="position" name="position" required value="<?php echo htmlspecialchars($target_employee['position'] ?? ''); ?>" />
        </div>
      </div>
      <div class="formFlex">
        <div class="form-group">
          <label for="joiningDate">Joining Date</label>
          <input
            type="date"
            id="joiningDate"
            name="joiningDate"
            style="height: 39px" value="<?php echo htmlspecialchars($target_employee['joining_date'] ?? ''); ?>" />
        </div>
        <div class="form-group">
          <label for="bloodGroup">Blood Group</label>
          <select id="bloodGroup" name="bloodGroup" required>
            <option value="" style="display: none">
              -- Select Blood Group --
            </option>
            <option value="A+" <?php if ($target_employee["blood_group"] == "A+") echo "selected" ?>>A+</option>
            <option value="A-" <?php if ($target_employee["blood_group"] == "A-") echo "selected" ?>>A-</option>
            <option value="B+" <?php if ($target_employee["blood_group"] == "B+") echo "selected" ?>>B+</option>
            <option value="B-" <?php if ($target_employee["blood_group"] == "B-") echo "selected" ?>>B-</option>
            <option value="AB+" <?php if ($target_employee["blood_group"] == "AB+") echo "selected" ?>>AB+</option>
            <option value="AB-" <?php if ($target_employee["blood_group"] == "AB-") echo "selected" ?>>AB-</option>
            <option value="O+" <?php if ($target_employee["blood_group"] == "O+") echo "selected" ?>>O+</option>
            <option value="O-" <?php if ($target_employee["blood_group"] == "O-") echo "selected" ?>>O-</option>
          </select>
        </div>
      </div>
      <!-- <fieldset>
        <legend>Essential Documents</legend>
        <div class="formFlex">
          <div class="form-group">
            <label for="ssnornid">SSN/NID </label>
            <input type="text" id="ssnornid" name="ssnornid" value="<?php echo htmlspecialchars($target_nid_doc['ssn_no'] ?? ''); ?>" />
          </div>
          <div class="form-group">
            <label for="ssnornidPhoto">SSN/NID Photo </label>
            <input type="file" id="ssnornidPhoto" name="ssnornidPhoto" />
          </div>
        </div>
      </fieldset>
      <fieldset id="additionalDocuments">
        <legend>Additional Documents</legend>
        <?php
        if ($all_other_documents && count($all_other_documents) > 0) {
          foreach ($all_other_documents as $other_doc) {
            echo "
                    <div class='formFlex' style='margin-bottom:8px'>
          <div class='form-group'>
            <label for='docType'>Document Type </label>
            <input type='text' id='docType' name='{$other_doc["doc_type"]}' value='{$other_doc["doc_type"]}' />
          </div>
          <div class='form-group'>
            <label for='documentPhoto'>Document Photo </label>
            <input type='file' id='documentPhoto' name='{$other_doc["doc_photo"]}' />
          </div>
        </div>
              ";
          }
        }
        ?>
      </fieldset> -->

      <button type="submit" class="submit-btn">Update</button>
    </form>
  </div>
  <!-- Correction popup -->
  <div id="correctionPopup">
    <form action="" method="post">
      <a href="./index.php" id="correctionPopupClose"><i class="fa fa-solid fa-xmark"></i></a>
      <div class="form-group">
        <label for="correction">Correction</label>
        <textarea name="correction" id="" style="resize: none; min-height:120px"></textarea>
        <input type="hidden" id="correction_id" name="correction_id">
      </div>
      <div class="form-group">
        <button type="submit" class="submit-btn">Submit</button>
      </div>
    </form>
  </div>
  <!-- popup close based on param -->
  <script>
    const searchParams = new URLSearchParams(window.location.search);
    if (searchParams.has("view_id")) {
      document.getElementById("employeeDetailsPopup").style.display = "flex";
    }
    if (searchParams.has("edit_id")) {
      document.getElementById("empUpdatePopup").style.display = "flex";

    }
  </script>
  <!-- Scripts -->
  <script>
    // view employee details popup

    // Img url
    const emPhoto = document.getElementById("emPhoto");
    const employeePhoto = document.getElementById("employeePhoto");
    employeePhoto.addEventListener("change", (e) => {
      const url = URL.createObjectURL(e.target.files[0]);
      emPhoto.src = url;
    });

    // Phone code
    const phoneCode = document.getElementById("phoneCode");
    const phoneNumber = document.getElementById("phoneNumber");
    phoneCode.addEventListener("change", (e) => {
      console.log(e.target.value);
      phoneNumber.value = e.target.value;
    });
    //Add document field
    const addBtn = document.getElementById("addBtn");
    const fieldset = document.getElementById("additionalDocuments");

    addBtn.addEventListener("click", () => {
      const newFormFlex = document.createElement("div");
      newFormFlex.classList.add("formFlex");

      newFormFlex.innerHTML = `
          <div class="form-group" style='margin-top:15px'>
            <label>Document Type </label>
            <input type="text" name="docType[]" />
          </div>
          <div class="form-group" style='margin-top:15px'>
            <label>Document Photo </label>
            <input type="file" name="documentPhoto[]" style='height:39px'/>
          </div>
          <div class="removeBtn" style="display:flex; align-items:center; cursor:pointer; color:red; margin-top: 15px">
            <i class="fa-solid fa-times" style="margin-top:20px;"></i>
          </div>
    `;

      // Insert right after addBtn's parent (.formFlex)
      addBtn.parentNode.insertAdjacentElement("afterend", newFormFlex);

      // Add delete functionality
      newFormFlex
        .querySelector(".removeBtn")
        .addEventListener("click", () => {
          newFormFlex.remove();
        });
    });
    // Navigation
    document.querySelectorAll(".nav-btn").forEach((btn) => {
      btn.addEventListener("click", () => {
        document
          .querySelectorAll(".nav-btn")
          .forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");

        document
          .querySelectorAll(".content-section")
          .forEach((sec) => sec.classList.remove("active"));
        document.getElementById(btn.dataset.target).classList.add("active");
      });
    });

    // Popup handling
    const popup = document.getElementById("popup");
    const closePopup = document.getElementById("closePopup");
    const signupForm = document.getElementById("signupForm");

    // signupForm.addEventListener("submit", (e) => {
    //  e.preventDefault();
    //   popup.classList.add("active");
    // });

    // closePopup.addEventListener("click", () => {
    //   popup.classList.remove("active");
    // });

    // Copy to clipboard
    function copyToClipboard(text) {
      console.log("hello")
      console.log(text);
      navigator.clipboard.writeText(text).then(() => {
        alert(text + " copied!");
      });
    }
  </script>
  <!-- Employee delete popup -->
  <script>
    const handleDelete = (id) => {
      document.getElementById("idOfDeleteEmp").innerText = id;
      document.getElementById("deleteEmpInput").value = id;
      document.getElementById("employeeDelete").style.display = "flex";
    };
    document
      .getElementById("closeDeleteEmployeePopup")
      .addEventListener("click", () => {
        document.getElementById("employeeDelete").style.display = "none";
      });
  </script>
  <!-- Employee Update popup -->
  <script>
    const handleUpdatePopup = (id) => {
      document.getElementById("updateEmpId").value = id;
      document.getElementById("empUpdatePopup").style.display = "flex";
    };
    document.getElementById("empUPclose").addEventListener("click", () => {
      document.getElementById("empUpdatePopup").style.display = "none";
    });
  </script>
  <!-- Passkey form -->
  <script>
    document.getElementById("paymentUSBtn").addEventListener("click", () => {
      document.getElementById("paymentUS").style.display = "flex";
    });
  </script>
  <!-- Activity filter -->
  <script>
    document.getElementById("filter").addEventListener("change", (e) => {
      const value = e.target.value;
      window.location.href = `./index.php?filter_activity=${value}`;
    })
    const searchParam = new URLSearchParams(window.location.search);
    if (searchParam.has("filter_activity")) {
      document.querySelectorAll(".content-section").forEach(single => {
        single.classList.replace("active", "hidden");
      })
      document.getElementById("activity").classList.replace("hidden", "active");
    }
  </script>
  <!-- Project content show hide -->
  <script>
    const handleProjectContent = (id) => {
      document.querySelectorAll(".project-section").forEach(section => {
        section.style.display = "none";
      });
      if (id == "createProject") {
        document.getElementById("createProject").style.display = "flex";

      }
      if (id == "assignEmployee") {
        document.getElementById("assignEmployee").style.display = "flex";

      }
      if (id == "projectReport") {
        document.getElementById("projectReport").style.display = "block";

      }
    }
  </script>
  <!-- handle correction popup -->
  <script>
    const handleCorrection = (id => {
      document.getElementById("correction_id").value = id;
      document.getElementById("correctionPopup").style.display = "flex";
    })
  </script>
  <!-- hide projects section based on role -->
  <script>
    if ("<?php echo $project_access ?>" == "false") {
      document.getElementById("projects").remove();
    }
  </script>
  <!-- project title for assign task -->
  <script>
    document.getElementById("project_id").addEventListener("change", (e) => {
      // Get selected title (text)
      const selectedTitle = e.target.options[e.target.selectedIndex].text;
      document.getElementById("project_title_task").value = selectedTitle;
    })
  </script>
</body>

</html>