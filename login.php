<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Admin Login</title>
  </head>
  <body>
    <section id="adminLoginFormContainer">
      <form id="adminLoginForm" action="" method="post">
        <h2>Admin Login</h2>
        <div
          class="error-message"
          style="
            color: red;
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffebee;
            border: 1px solid #f44336;
            border-radius: 4px;
            display: none;
          "
        >
          Invalid employee ID or password!
        </div>
        <div class="form-group">
          <label for="user_id">User ID</label>
          <input type="text" name="user_id" />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" />
        </div>
        <div class="form-group">
          <button>Login</button>
        </div>
      </form>
    </section>
  </body>
</html>
