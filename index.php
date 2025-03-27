<?php
$host = "localhost";
$dbname = "lifetechocms";
$user = "postgres";
$password = "your_password";

try {
    // Create a PDO instance
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to PostgreSQL successfully!";
 
 // Insert Query
    $sql = 'INSERT INTO product3 (keyid, valueId, "dateId") VALUES (:keyid, :valueId, :dateId)';
    
    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Execute the statement
    $stmt->execute([
        ':keyid'   => '123452',  // Example key
        ':valueId' => 'Some data',
        ':dateId'  => '2025-03-26 12:30:00' // Example date
    ]);

    echo "Record inserted successfully!";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>