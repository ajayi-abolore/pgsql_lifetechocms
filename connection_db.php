<?php
// Database connection settings
$mysql_host = $_POST['mysql_host'];
$mysql_user = $_POST['mysql_user'];
$mysql_pass = $_POST['mysql_pass'];
$mysql_db = $_POST['mysql_db'];

$pgsql_host = $_POST['pgsql_host'];
$pgsql_user = $_POST['pgsql_user'];
$pgsql_pass = $_POST['pgsql_pass'];
$pgsql_db = $_POST['pgsql_db'];

// MySQL Connection
$mysql_conn = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
if ($mysql_conn->connect_error) {
    die("Connection failed: " . $mysql_conn->connect_error);
}

// PostgreSQL Connection
$pgsql_conn = pg_connect("host=$pgsql_host dbname=$pgsql_db user=$pgsql_user password=$pgsql_pass");
if (!$pgsql_conn) {
    die("Connection failed: " . pg_last_error());
}

// Function to migrate data from MySQL to PostgreSQL
function migrate_data($mysql_conn, $pgsql_conn) {
    $tables = get_mysql_tables($mysql_conn); // Fetch table names from MySQL
    foreach ($tables as $table) {
        $columns = get_mysql_columns($mysql_conn, $table); // Get columns for each table
        create_pgsql_table($pgsql_conn, $table, $columns); // Create table in PostgreSQL
        transfer_data($mysql_conn, $pgsql_conn, $table, $columns); // Transfer data
    }
}

// Get list of tables from MySQL
function get_mysql_tables($mysql_conn) {
    $result = $mysql_conn->query("SHOW TABLES");
    $tables = [];
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
    return $tables;
}

// Get columns for a specific table from MySQL
function get_mysql_columns($mysql_conn, $table) {
    $result = $mysql_conn->query("DESCRIBE $table");
    $columns = [];
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }
    return $columns;
}

// Create the corresponding table in PostgreSQL
function create_pgsql_table($pgsql_conn, $table, $columns) {
    $column_definitions = [];
    foreach ($columns as $column) {
        $column_definitions[] = "$column TEXT"; // Assuming TEXT for simplicity, modify according to your need
    }
    $column_sql = implode(", ", $column_definitions);
    $create_sql = "CREATE TABLE IF NOT EXISTS $table ($column_sql)";
    pg_query($pgsql_conn, $create_sql);
}

// Transfer data from MySQL to PostgreSQL
function transfer_data($mysql_conn, $pgsql_conn, $table, $columns) {
    $mysql_result = $mysql_conn->query("SELECT * FROM $table");
    while ($row = $mysql_result->fetch_assoc()) {
        $values = [];
        foreach ($columns as $column) {
            $values[] = "'" . pg_escape_string($pgsql_conn, $row[$column]) . "'"; // Escape values for PostgreSQL
        }
        $values_sql = implode(", ", $values);
        $insert_sql = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES ($values_sql)";
        pg_query($pgsql_conn, $insert_sql);
    }
}

// Perform the migration
migrate_data($mysql_conn, $pgsql_conn);

// Close the connections
$mysql_conn->close();
pg_close($pgsql_conn);

// Return a response (this part can be done in JSON for the frontend)
echo json_encode(["status" => "success", "message" => "Migration completed successfully."]);

?>
