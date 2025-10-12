<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <title>Profile</title>
  </head>
  <body>
    <!-- mobile protection -->
    <section id="container">
      <!-- profile page top bar -->
      <div class="topBar">
        <h2 style="margin-bottom: 0">Welcome Name here</h2>
        <form
          action=""
          method="post"
          style="display: flex; align-items: center; flex-direction: row"
        >
          <h3 style="min-width: 220px">
            Account status: <span style="color: orange">Review</span>
          </h3>
          <select name="statusChange" id="">
            <option value="approve">Approve</option>
            <option value="reject">Reject</option>
          </select>
        </form>
      </div>
      <!-- warning container -->
      <div class="warningContainer">
        <p class="warning">
          <i class="fa-solid fa-triangle-exclamation"></i>
          This page of our system is governed by local state government. Your
          information maybe accessed by the local government at any time for
          verification or necessity.
          <br />
          Please provide all your information accurately. Otherwise, your
          account maybe rejected.
        </p>
      </div>
      <main class="main">
        <!-- Personal Details Form -->
        <div class="detailsForm">
          <div class="headingDiv">
            <h3>Personal details</h3>
            <div class="topStatusStyle">
              Status: <span id="infoStatus">Pending</span>
              <select name="personalDetailsStatus">
                <option value="approve">Approve</option>
                <option value="reject">Reject</option>
              </select>
            </div>
          </div>

          <form action="" method="post" enctype="multipart/form-data">
            <div class="profileImageUpload">
              <div class="profileImageContainer">
                <img id="imgPreview" src="./placeholder.jpg" />
              </div>
              <div class="formField">
                <label for="profileImage"
                  >Upload your photo <span class="required">*</span></label
                >
                <input
                  id="imgPreviewInput"
                  type="file"
                  name="profileImage"
                  accept="image/*"
                />
              </div>
            </div>
            <div class="formFlex">
              <div class="formField">
                <label for="firstName"
                  >First name <span class="required">*</span></label
                >
                <input type="text" name="firstName" required />
              </div>
              <div class="formField">
                <label for="lastName"
                  >Last name <span class="required">*</span></label
                >
                <input type="text" name="lastName" required />
              </div>
            </div>

            <div class="formField">
              <label for="fathersName"
                >Father's name <span class="required">*</span></label
              >
              <input type="text" name="fathersName" required />
            </div>

            <div class="presentAddressContainer">
              <h4>Present address</h4>

              <div class="formField">
                <label for="presentAddressStreetOne"
                  >Street address 1 <span class="required">*</span></label
                >
                <input
                  id="presentAddressStreetOne"
                  type="text"
                  name="presentAddressStreetOne"
                  required
                />
              </div>
              <div class="formField">
                <label for="presentAddressStreetTwo"
                  >Street address 2
                  <span class="optional">(Optional)</span></label
                >
                <input
                  id="presentAddressStreetTwo"
                  type="text"
                  name="presentAddressStreetTwo"
                />
              </div>

              <div class="formFlex">
                <div class="formField">
                  <label for="city">City <span class="required">*</span></label>
                  <input id="city" type="text" name="city" required />
                </div>
                <div class="formField">
                  <label for="state"
                    >State <span class="required">*</span></label
                  >
                  <input id="state" type="text" name="state" required />
                </div>
                <div class="formField">
                  <label for="zipcode"
                    >Zipcode <span class="required">*</span></label
                  >
                  <input id="zipcode" type="text" name="zipcode" required />
                </div>
              </div>
              <div class="formField">
                <label for="country"
                  >Country <span class="required">*</span></label
                >
                <input id="country" type="text" name="country" readonly />
              </div>
            </div>
            <div class="sameAs">
              <input
                id="sameAsPresent"
                type="checkbox"
                name="sameAsPresent"
                onchange="handleCheckbox(this)"
              />
              <label for="sameAsPresent">Same as present address </label>
            </div>
            <!-- permanent address -->
            <div class="permanentAddressContainer">
              <h4>Permanent address</h4>

              <div class="formField">
                <label for="permanentAddressStreetOne"
                  >Street address 1 <span class="required">*</span></label
                >
                <input
                  id="permanentAddressStreetOne"
                  type="text"
                  name="permanentAddressStreetOne"
                  required
                />
              </div>
              <div class="formField">
                <label for="permanentAddressStreetTwo"
                  >Street address 2
                  <span class="optional"
                    ><span class="optional">(Optional)</span></span
                  ></label
                >
                <input
                  id="permanentAddressStreetTwo"
                  type="text"
                  name="permanentAddressStreetTwo"
                />
              </div>
              <div class="formFlex">
                <div class="formField">
                  <label for="permanentCity"
                    >City <span class="required">*</span></label
                  >
                  <input
                    id="permanentCity"
                    type="text"
                    name="permanentCity"
                    required
                  />
                </div>
                <div class="formField">
                  <label for="permanentState"
                    >State <span class="required">*</span></label
                  >
                  <input
                    id="permanentState"
                    type="text"
                    name="permanentState"
                    required
                  />
                </div>
                <div class="formField">
                  <label for="permanentZipcode"
                    >Zipcode <span class="required">*</span></label
                  >
                  <input
                    id="permanentZipcode"
                    type="text"
                    name="permanentZipcode"
                    required
                  />
                </div>
              </div>
              <div class="formField">
                <label for="permanentCountry"
                  >Country <span class="required">*</span></label
                >
                <input
                  id="permanentCountry"
                  type="text"
                  name="permanentCountry"
                  readonly
                />
              </div>
            </div>

            <div class="formFlex2">
              <div class="formField">
                <div id="numberCode">
                  <label for="contactNumber" style="min-width: 90px"
                    >Contact no <span class="required">*</span></label
                  >
                  <select name="numberType" id="numberType">
                    <option value="usa">USA +1</option>
                    <option value="bangladesh">BD+880</option>
                  </select>
                </div>
              </div>
              <div class="formField">
                <input
                  type="text"
                  id="contactNumber"
                  name="contactNumber"
                  required
                />
              </div>
            </div>

            <div class="formField">
              <button
                type="submit"
                name="personal_details"
                class="saveChangesBtn"
              >
                Update
              </button>
            </div>
          </form>
        </div>
        <!-- Essential Documents Form -->
        <div class="detailsForm">
          <div class="headingDiv">
            <h3>Essential documents</h3>
            <div class="topStatusStyle">
              Status: <span id="infoStatus">Pending</span
              ><select name="essentialDocumentsStyle">
                <option value="approve">Approve</option>
                <option value="reject">Reject</option>
              </select>
            </div>
          </div>

          <form action="" method="post" enctype="multipart/form-data">
            <div class="formField">
              <label for="addMore">Document type </label>
              <select name="documentType" id="documentType" required>
                <option style="display: none" value="">Select Type</option>
                <option value="passport">passport</option>
                <option value="drivingLicense">driving License</option>
                <option value="voterCard">Voter Card</option>
              </select>
            </div>

            <div id="passportContainer">
              <div class="formField">
                <label for="passportNo"
                  >Passport no <span class="required">*</span></label
                >
                <input type="text" name="passportNo" required />
              </div>
              <div class="formField">
                <label for="passportPhoto"
                  >Passport information page picture
                  <span class="required">*</span></label
                >
                <input
                  type="file"
                  name="passportPhoto"
                  accept="image/*"
                  required
                />
              </div>
            </div>

            <div id="drivingLicenseContainer">
              <div class="formField">
                <label for="drivingLicenseNo"
                  >Driving license no <span class="required">*</span></label
                >
                <input type="text" name="drivingLicenseNo" required />
              </div>
              <div class="formFlex">
                <div class="formField">
                  <label for="drivingLicenseFrontPhoto"
                    >Driving license front photo
                    <span class="required">*</span></label
                  >
                  <input
                    type="file"
                    name="drivingLicenseFrontPhoto"
                    accept="image/*"
                    required
                  />
                </div>
                <div class="formField">
                  <label for="drivingLicenseBackPhoto"
                    >Driving license back photo
                    <span class="required">*</span></label
                  >
                  <input
                    type="file"
                    name="drivingLicenseBackPhoto"
                    accept="image/*"
                    required
                  />
                </div>
              </div>
            </div>

            <div id="voterIdCardContainer">
              <div class="formField">
                <label for="voterCardNo"
                  >Voter card no <span class="required">*</span></label
                >
                <input type="text" name="voterCardNo" required />
              </div>
              <div class="formFlex">
                <div class="formField">
                  <label for="voterCardFrontPhoto"
                    >Voter card front photo
                    <span class="required">*</span></label
                  >
                  <input
                    type="file"
                    name="voterCardFrontPhoto"
                    accept="image/*"
                    required
                  />
                </div>
                <div class="formField">
                  <label for="voterCardBackPhoto"
                    >Voter card back photo
                    <span class="required">*</span></label
                  >
                  <input
                    type="file"
                    name="voterCardBackPhoto"
                    accept="image/*"
                    required
                  />
                </div>
              </div>
            </div>

            <!-- SSN -->
            <div id="ssnContainer">
              <div class="formField">
                <label for="ssnNo"
                  >SSN no <span class="required">*</span></label
                >
                <input type="text" name="ssnNo" required maxlength="9" />
              </div>
              <div class="formField">
                <label for="ssnPhoto"
                  >Photo of SSN card
                  <span class="optional">(Optional)</span></label
                >
                <input type="file" name="ssnPhoto" accept="image/*" />
              </div>
            </div>

            <!-- ITIN -->
            <div id="itinContainer">
              <div class="formField">
                <label for="itinNo"
                  >ITIN no <span class="optional">(Optional)</span></label
                >
                <input type="text" name="itinNo" maxlength="9" />
              </div>
              <div class="formField">
                <label for="itinPhoto"
                  >Photo of ITIN letter
                  <span class="optional">(Optional)</span></label
                >
                <input type="file" name="itinPhoto" accept="image/*" />
              </div>
            </div>
            <div class="formField">
              <button
                type="submit"
                name="essential"
                value="essential"
                class="saveChangesBtn"
              >
                Update
              </button>
            </div>
          </form>
        </div>
        <!-- Emergency Contact Form -->
        <div class="detailsForm" id="emergency">
          <div class="headingDiv">
            <h3>Emergency contact</h3>
            <div class="topStatusStyle">
              Status: <span id="infoStatus">Pending</span>
              <select name="emergencyContactStatus">
                <option value="approve">Approve</option>
                <option value="reject">Reject</option>
              </select>
            </div>
          </div>

          <form action="" method="post" class="contactForm">
            <!-- Contact 1 -->
            <div class="contactContainer">
              <h4>Contact 1 <span class="required">*</span></h4>
              <div class="formField">
                <label for="emergencyName1"
                  >Full name <span class="required">*</span></label
                >
                <input type="text" name="emergencyName1" required />
              </div>
              <div class="formField">
                <label for="emergencyRelation1"
                  >Relationship <span class="required">*</span></label
                >
                <input type="text" name="emergencyRelation1" required />
              </div>
              <div class="formField">
                <label for="emergencyPhone1"
                  >Contact number <span class="required">*</span></label
                >
                <input type="text" name="emergencyPhone1" required />
              </div>
            </div>

            <div class="contactContainer">
              <!-- Contact 2 -->
              <h4>Contact 2 <span class="optional">(Optional)</span></h4>
              <div class="formField">
                <label for="emergencyName2">Full name </label>
                <input type="text" name="emergencyName2" />
              </div>
              <div class="formField">
                <label for="emergencyRelation2">Relationship</label>
                <input type="text" name="emergencyRelation2" />
              </div>
              <div class="formField">
                <label for="emergencyPhone2">Contact number</label>
                <input type="text" name="emergencyPhone2" />
              </div>
            </div>
            <div class="contactContainer">
              <!-- Contact 3 -->
              <h4>Contact 3 <span class="optional">(Optional)</span></h4>
              <div class="formField">
                <label for="emergencyName3">Full name</label>
                <input type="text" name="emergencyName3" />
              </div>
              <div class="formField">
                <label for="emergencyRelation3">Relationship</label>
                <input type="text" name="emergencyRelation3" />
              </div>
              <div class="formField">
                <label for="emergencyPhone3">Contact number</label>
                <input type="text" name="emergencyPhone3" />
              </div>
              <div class="formField">
                <button
                  type="submit"
                  name="emergency_contacts"
                  class="saveChangesBtn"
                >
                  Update
                </button>
              </div>
            </div>
          </form>
        </div>
      </main>
    </section>
    <script>
      const imgPreview = document.getElementById("imgPreview");
      const imgPreviewInput = document.getElementById("imgPreviewInput");
      imgPreviewInput.addEventListener("change", (e) => {
        const url = URL.createObjectURL(e.target.files[0]);
        imgPreview.src = url;
      });
      // Container
      const documentType = document.getElementById("documentType");
      const passportContainer = document.getElementById("passportContainer");
      const drivingLicenseContainer = document.getElementById(
        "drivingLicenseContainer"
      );
      const voterIdCardContainer = document.getElementById(
        "voterIdCardContainer"
      );

      documentType.addEventListener("change", (e) => {
        // reset all first
        [
          passportContainer,
          drivingLicenseContainer,
          voterIdCardContainer,
        ].forEach((container) => {
          container.style.display = "none";
          container
            .querySelectorAll("input")
            .forEach((input) => (input.required = false));
        });

        const value = e.target.value;

        if (value === "passport") {
          passportContainer.style.display = "block";
          passportContainer
            .querySelectorAll("input")
            .forEach((input) => (input.required = true));
        } else if (value === "drivingLicense") {
          drivingLicenseContainer.style.display = "block";
          drivingLicenseContainer
            .querySelectorAll("input")
            .forEach((input) => (input.required = true));
        } else if (value === "voterCard") {
          voterIdCardContainer.style.display = "block";
          voterIdCardContainer
            .querySelectorAll("input")
            .forEach((input) => (input.required = true));
        }
      });
      // permanent and present address
      const permanentAddress = document.getElementById("permanentAddress");
      const sameAsPresent = document.getElementById("sameAsPresent");
      // const presentAddress = document.getElementById("presentAddress");
      const permanentAddressStreetOne = document.getElementById(
        "permanentAddressStreetOne"
      );
      const permanentAddressStreetTwo = document.getElementById(
        "permanentAddressStreetTwo"
      );
      const permanentCity = document.getElementById("permanentCity");
      const permanentState = document.getElementById("permanentState");
      const permanentZipcode = document.getElementById("permanentZipcode");
      const presentAddressStreetOne = document.getElementById(
        "presentAddressStreetOne"
      );
      const presentAddressStreetTwo = document.getElementById(
        "presentAddressStreetTwo"
      );
      const city = document.getElementById("city");
      const state = document.getElementById("state");
      const zipcode = document.getElementById("zipcode");
      function handleCheckbox(checkbox) {
        if (checkbox.checked) {
          permanentAddressStreetOne.value = presentAddressStreetOne.value;
          permanentAddressStreetTwo.value = presentAddressStreetTwo.value;
          permanentCity.value = city.value;
          permanentState.value = state.value;
          permanentZipcode.value = zipcode.value;
        }
      }

      const contactInput = document.getElementById("contactNumber");
      const numberType = document.getElementById("numberType");

      numberType.addEventListener("change", (e) => {
        const value = e.target.value;
        if (value === "bangladesh") {
          contactInput.value = "+880";
        } else {
          contactInput.value = "+1";
        }
      });
    </script>
  </body>
</html>
