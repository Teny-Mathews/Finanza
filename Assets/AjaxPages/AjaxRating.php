<?php
include("../Connection/Connection.php");
session_start();

// ✅ Save review
if(isset($_POST["rating_data"])) {
    $uid = $_SESSION['uid'];
    $rating_value = $_POST["rating_data"];
    $rating_comment = $_POST["user_review"];

    $stmt = $con->prepare("INSERT INTO tbl_rating(user_id,rating_value,rating_comment,rating_date) VALUES(?,?,?,NOW())");
    $stmt->bind_param("iis", $uid, $rating_value, $rating_comment);

    if($stmt->execute()){
        echo "Your Review & Rating Successfully Submitted";
    } else {
        echo "Your Review & Rating Insertion Failed";
    }
    exit;
}

// ✅ Delete review
if(isset($_POST["action"]) && $_POST["action"] == "delete_review") {
    $rating_id = $_POST["rating_id"];
    $uid = $_SESSION['uid'];

    $stmt = $con->prepare("DELETE FROM tbl_rating WHERE rating_id=? AND user_id=?");
    $stmt->bind_param("ii", $rating_id, $uid);

    if($stmt->execute()) {
        echo "Review deleted successfully.";
    } else {
        echo "Failed to delete review.";
    }
    exit;
}

// ✅ Load review data
if(isset($_POST["action"]) && $_POST["action"] == "load_data") {
    $average_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;
    $review_content = array();

    $query = "SELECT r.*, u.user_name FROM tbl_rating r 
              INNER JOIN tbl_user u ON r.user_id=u.user_id 
              ORDER BY r.rating_id DESC";
    $result = $con->query($query);

    while($row = $result->fetch_assoc()) {
        $review_content[] = array(
            'review_id'     => $row["rating_id"],
            'user_id'       => $row["user_id"],
            'user_name'     => $row["user_name"],
            'user_review'   => $row["rating_comment"],
            'rating'        => $row["rating_value"],
            'datetime'      => $row["rating_date"]
        );

        if($row["rating_value"] == 5) $five_star_review++;
        if($row["rating_value"] == 4) $four_star_review++;
        if($row["rating_value"] == 3) $three_star_review++;
        if($row["rating_value"] == 2) $two_star_review++;
        if($row["rating_value"] == 1) $one_star_review++;

        $total_review++;
        $total_user_rating += $row["rating_value"];
    }

    if($total_review > 0){
        $average_rating = $total_user_rating / $total_review;
    }

    $output = array(
        'average_rating'    => number_format($average_rating, 1),
        'total_review'      => $total_review,
        'five_star_review'  => $five_star_review,
        'four_star_review'  => $four_star_review,
        'three_star_review' => $three_star_review,
        'two_star_review'   => $two_star_review,
        'one_star_review'   => $one_star_review,
        'review_data'       => $review_content,
        'current_user'      => $_SESSION['uid']
    );

    echo json_encode($output);
    exit;
}
?>
