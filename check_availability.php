<?php
// Assuming you have a database connection established

// Check if the date parameter is set
if(isset($_POST['date'])) {
    // Sanitize the input date
    $selectedDate = $_POST['date'];
    // Perform any necessary validation on the date format
    
    // Example query to check if the selected date is already booked
    $sql = "SELECT COUNT(*) AS count FROM book_list WHERE booked_date = :selectedDate";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':selectedDate', $selectedDate);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If there are any bookings for the selected date, it is not available
    if($result['count'] > 0) {
        // Date is not available
        echo json_encode(array('available' => false));
    } else {
        // Date is available
        echo json_encode(array('available' => true));
    }
} else {
    // Date parameter is not set
    echo json_encode(array('available' => false, 'message' => 'Date parameter is missing'));
}
?>