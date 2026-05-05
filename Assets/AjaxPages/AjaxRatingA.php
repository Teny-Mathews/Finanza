<?php
include("../Connection/Connection.php");
session_start();

// ✅ Load review data
if (isset($_POST["action"]) && $_POST["action"] == "load_data") {
    $average_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;
    $review_content = array();

    $query = "SELECT * FROM tbl_rating r 
              INNER JOIN tbl_user u ON r.user_id=u.user_id 
              ORDER BY r.rating_id DESC";
    $result = $con->query($query);

    while ($row = $result->fetch_assoc()) {
        $review_content[] = array(
            'review_id' => $row["rating_id"],
            'user_id' => $row["user_id"],
            'user_name' => $row["user_name"],
            'user_review' => $row["rating_comment"],
            'rating' => $row["rating_value"],
            'datetime' => $row["rating_date"]
        );

        if ($row["rating_value"] == 5)
            $five_star_review++;
        if ($row["rating_value"] == 4)
            $four_star_review++;
        if ($row["rating_value"] == 3)
            $three_star_review++;
        if ($row["rating_value"] == 2)
            $two_star_review++;
        if ($row["rating_value"] == 1)
            $one_star_review++;

        $total_review++;
        $total_user_rating += $row["rating_value"];
    }

    if ($total_review > 0) {
        $average_rating = $total_user_rating / $total_review;
    }

    $output = array(
        'average_rating' => number_format($average_rating, 1),
        'total_review' => $total_review,
        'five_star_review' => $five_star_review,
        'four_star_review' => $four_star_review,
        'three_star_review' => $three_star_review,
        'two_star_review' => $two_star_review,
        'one_star_review' => $one_star_review,
        'review_data' => $review_content,

    );

    echo json_encode($output);
    exit;
}
?>