<?php
session_start();
if (!isset($_SESSION["valid_role"]) || $_SESSION["valid_role"] != "super-admin") {
  header("Location: ./index.php");
}
require_once("./php/db_connect.php");
require_once("./php/all_status_invoices.php");
require_once("./php/invoice_panel_logout.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <!-- Font awesome cdn -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <!-- Poppins google fonts cdn -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="./invoice.css">
  <title>Invoice Panel</title>
</head>

<body>
  <div id="container">
    <span id="openSidebarBtn"><i class="fa-solid fa-bars-staggered"></i>
    </span>
    <div id="sideBar">
      <div id="closeSidebarBtn"><i class="fa-solid fa-xmark"></i></div>
      <h2>Invoices Panel</h2>
      <p style="text-transform: capitalize; margin-bottom:10px; font-weight: bold"><?php echo $_SESSION["valid_role"] ?></p>
      <ul id="navLinks">
        <li class="navLink" data-id="request">
          <i class="fa-solid fa-paper-plane"></i> Request
        </li>
        <li class="navLink" data-id="unpaid">
          <i class="fa-solid fa-wallet"></i> Unpaid
        </li>
        <li class="navLink" data-id="pending">
          <i class="fa-solid fa-hourglass-half"></i> Pending
        </li>
        <li class="navLink" data-id="paid">
          <i class="fa-solid fa-circle-check"></i> Paid
        </li>
        <li class="navLink" data-id="rejected">
          <i class="fa-solid fa-circle-xmark"></i> Rejected
        </li>
        <li onclick="handleLogout()"><a href="./invoices.php?invoice_logout" style="color: black; text-decoration: none;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      </ul>
    </div>
    <div id="mainContent">
      <!-- Request section -->
      <section class="section" id="request">
        <div class="sectionHeader">Requests</div>
        <div class="loaderTable">
          <table>
            <thead>
              <th>SL</th>
              <th>Customer Email</th>
              <th>Customer Name</th>
              <th>Amount</th>
              <th>Status</th>

            </thead>
            <tbody>
              <?php
              if ($requested_invoices && count($requested_invoices) > 0) {
                foreach ($requested_invoices as $requested) {
                  echo "
                    <tr>
                <td>{$requested["id"]}</td>
                <td>{$requested["customer_email"]}</td>
                <td>{$requested["customer_name"]}</td>
                <td>{$requested["invoice_amount"]}</td>
                <td style='text-transform: capitalize'>{$requested["status"]}</td>
              </tr>
                    
                    ";
                }
              }
              ?>

            </tbody>
          </table>
        </div>
      </section>
      <!-- Unpaid section -->
      <section class="section" id="unpaid" style="display: none">
        <div class="sectionHeader">Unpaid</div>
        <div class="loaderTable">
          <table>
            <thead>
              <th>SL</th>
              <th>Invoice ID</th>
              <th>Purpose/Product details</th>
              <th>Customer Name</th>
              <th>Amount</th>
              <th>Tax</th>
              <th>Payable</th>
              <th>Status</th>
            </thead>
            <tbody>
              <?php
              if ($unpaid_invoices && count($unpaid_invoices) > 0) {
                foreach ($unpaid_invoices as $unpaid) {
                  echo "
                    <tr>
                <td>{$unpaid["id"]}</td>
                <td>{$unpaid["invoice_number"]}</td>
                <td>{$unpaid["invoice_purpose"]}</td>
                <td>Tahmid Alam</td>
                <td>$ {$unpaid["invoice_amount"]}</td>
                <td>$ {$unpaid["cost"]}</td>
                <td>$ {$unpaid["payable_amount"]}</td>
                <td style='text-transform: capitalize'>{$unpaid["status"]}</td>
              </tr>
                    
                    ";
                }
              }
              ?>

            </tbody>
          </table>
        </div>
      </section>
      <!-- Pending section -->
      <section class="section" id="pending" style="display: none">
        <div class="sectionHeader">Pending</div>
        <div class="loaderTable">
          <table>
            <thead>
              <th>SL</th>
              <th>Invoice ID</th>
              <th>Purpose/Product details</th>
              <th>Customer Name</th>
              <th>Payable Amount</th>
              <th>Status</th>
            </thead>
            <tbody>
              <?php
              if ($pending_invoices  && count($pending_invoices) > 0) {
                foreach ($pending_invoices  as $pending) {
                  echo "<tr>
                <td>{$pending["id"]}</td>
                <td>{$pending["invoice_number"]}</td>
                <td>{$pending["invoice_purpose"]}</td>
                <td>{$pending["customer_name"]}</td>
                <td>$ {$pending["payable_amount"]}</td>
                <td style='color: orangered; font-weight: bold'>Pending</td>
              </tr>";
                }
              }
              ?>

            </tbody>
          </table>
        </div>
      </section>
      <!-- Paid section -->
      <section class="section" id="paid" style="display: none">
        <div class="sectionHeader">Paid</div>
        <div class="loaderTable">
          <table>
            <thead>
              <th>SL</th>
              <th>Invoice ID</th>
              <th>Purpose/Product details</th>
              <th>Customer Name</th>
              <th>Amount</th>
              <th>Status</th>
            </thead>
            <tbody>
              <?php
              if ($paid_invoices  && count($paid_invoices) > 0) {
                foreach ($paid_invoices  as $paid) {
                  echo "<tr>
                <td>{$paid["id"]}</td>
                <td>{$paid["invoice_number"]}</td>
                <td>{$paid["invoice_purpose"]}</td>
                <td>{$paid["customer_name"]}</td>
                <td>$ {$paid["payable_amount"]}</td>
                <td style='color: green; font-weight: bold; text-transform: Capitalize;'>{$paid["status"]}</td>
              </tr>";
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </section>
      <!-- Rejected section -->
      <section class="section" id="rejected" style="display: none">
        <div class="sectionHeader">Rejected</div>
        <div class="loaderTable">
          <table>
            <thead>
              <th>SL</th>
              <th>Invoice ID</th>
              <th>Purpose/Product details</th>
              <th>Customer Name</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Remark</th>
            </thead>
            <tbody>
              <?php
              if ($rejected_invoices  && count($rejected_invoices) > 0) {
                foreach ($rejected_invoices  as $rejected) {
                  echo "<tr>
                <td>{$rejected["id"]}</td>
                <td>{$rejected["invoice_number"]}</td>
                <td>{$rejected["invoice_purpose"]}</td>
                <td>{$rejected["customer_name"]}</td>
                <td>$ {$rejected["payable_amount"]}</td>
                <td style='color: red; font-weight: bold; text-transform: Capitalize;'>{$rejected["status"]}</td>
                <td>{$rejected["remark"]}</td>
              </tr>";
                }
              }
              ?>

            </tbody>
          </table>
        </div>
      </section>
    </div>
  </div>

  <!-- script for sidebar open and close -->
  <script>
    // Open sidebar
    document
      .getElementById("openSidebarBtn")
      .addEventListener("click", () => {
        document.getElementById("sideBar").style.display = "flex";
      });
    // Close sidebar
    document
      .getElementById("closeSidebarBtn")
      .addEventListener("click", () => {
        document.getElementById("sideBar").style.display = "none";
      });
  </script>
  <!-- Content hide and show -->
  <script>
    document.querySelectorAll(".navLink").forEach((nav) => {
      nav.addEventListener("click", () => {
        document.querySelectorAll(".navLink").forEach((nav) => {
          document.getElementById(nav.dataset.id).style.display = "none";
        });
        document.getElementById(nav.dataset.id).style.display = "flex";
      });
    });
  </script>
  <!-- Select product and show price -->
  <script>
    const desiredProduct = document.getElementById("desiredProduct");
    const invoiceAmount = document.getElementById("invoiceAmount");
    desiredProduct.addEventListener("change", (e) => {
      const value = e.target.value;
      if (value === "custom") {
        invoiceAmount.removeAttribute("readonly");
        invoiceAmount.required = true;
      }
      if (value === "product_1") {
        invoiceAmount.value = "150";
      } else if (value === "product_2") {
        invoiceAmount.value = "320";
      } else if (value === "product_3") {
        invoiceAmount.value = "1018";
      } else if (value === "product_4") {
        invoiceAmount.value = "750";
      }
    });
  </script>
  <!-- handle logout -->
  <script>
    const handleLogout = () => {
      window.location.href = "./invoices.php?invoice_logout";
    }
  </script>
</body>

</html>