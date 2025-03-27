<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySQL to PostgreSQL Migration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
            position: relative;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            position: relative;
            z-index: 2;  /* Ensure it's on top of the background */
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px; 
        }
        input[type="text"], input[type="password"], input[type="submit"], select {
            width: 60%;
            padding: 10px;
            font-size: 14px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
         input {
            display: inline-block;
            width: auto; /* Optional: to adjust input width */
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 32px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .progress-bar {
            width: 0;
            height: 10px;
            background-color: #4CAF50;
            border-radius: 5px;
            margin-top: 10px;
        }
        .log {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            height: 150px;
            overflow-y: auto;
            border-radius: 5px;
            font-size: 12px;
        }

        /* Background Styling */
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #e0e0e0;
            z-index: 1;  /* Keep it behind the form */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>MySQL to PostgreSQL Migration Tool</h1>
    
    <!-- MySQL & PostgreSQL Connection Form -->
    <div class="form-group">
        <label for="mysql_host">MySQL Host</label>
        <input type="text" id="mysql_host" placeholder="MySQL Host">
    </div>
    <div class="form-group">
        <label for="mysql_user">MySQL User</label>
        <input type="text" id="mysql_user" placeholder="MySQL User">
    </div>
    <div class="form-group">
        <label for="mysql_pass">MySQL Password</label>
        <input type="password" id="mysql_pass" placeholder="MySQL Password">
    </div>
    <div class="form-group">
        <label for="mysql_db">MySQL Database</label>
        <input type="text" id="mysql_db" placeholder="MySQL Database">
    </div>
<div>
    <h1>Postgree Connection</h1>
</div>
    <div class="form-group">
        <label for="pgsql_host">PostgreSQL Host</label>
        <input type="text" id="pgsql_host" placeholder="PostgreSQL Host">
    </div>
    <div class="form-group">
        <label for="pgsql_user">PostgreSQL User</label>
        <input type="text" id="pgsql_user" placeholder="PostgreSQL User">
    </div>
    <div class="form-group">
        <label for="pgsql_pass">PostgreSQL Password</label>
        <input type="password" id="pgsql_pass" placeholder="PostgreSQL Password">
    </div>
    <div class="form-group">
        <label for="pgsql_db">PostgreSQL Database</label>
        <input type="text" id="pgsql_db" placeholder="PostgreSQL Database">
    </div>
    
    <div class="form-group">
        <button class="btn" id="startMigration">Start Migration</button>
    </div>

    <!-- Migration Progress Section -->
    <div class="form-group">
        <h3>Migration Progress</h3>
        <div class="progress-bar" id="progress"></div>
        <div class="log" id="log">Migration logs will appear here...</div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle migration button click
    $('#startMigration').click(function() {
        var mysqlHost = $('#mysql_host').val();
        var mysqlUser = $('#mysql_user').val();
        var mysqlPass = $('#mysql_pass').val();
        var mysqlDb = $('#mysql_db').val();
        
        var pgsqlHost = $('#pgsql_host').val();
        var pgsqlUser = $('#pgsql_user').val();
        var pgsqlPass = $('#pgsql_pass').val();
        var pgsqlDb = $('#pgsql_db').val();
        
        if (!mysqlHost || !mysqlUser || !mysqlPass || !mysqlDb || !pgsqlHost || !pgsqlUser || !pgsqlPass || !pgsqlDb) {
            alert("Please fill in all fields!");
            return;
        }
        
        // Disable start button to avoid multiple clicks
        $('#startMigration').attr("disabled", true);

        // Sample migration process
        var progress = 0;
        var interval = setInterval(function() {
            progress += 10;
            $('#progress').css('width', progress + '%');
            $('#log').append('<p>Step ' + progress + '% completed...</p>');
            
            // Once completed, stop the interval
            if (progress >= 100) {
                clearInterval(interval);
                $('#log').append('<p>Migration completed successfully!</p>');
                $('#startMigration').attr("disabled", false); // Re-enable the button
            }
        }, 1000);
    });
});
</script>

</body>
</html>