<?php
include("../Assets/connection/connection.php");
session_start();
ob_start();
include("Head.php");
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>Review & Rating System in PHP & MySQL using Ajax</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        crossorigin="anonymous">

    <!-- Font Awesome (free) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- jQuery / Popper / Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <style>
        .progress-label-left {
            float: left;
            margin-right: 0.5em;
            line-height: 1em;
        }

        .progress-label-right {
            float: right;
            margin-left: 0.3em;
            line-height: 1em;
        }

        .star-light {
            color: #e9ecef !important;
        }

        .avatar-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            line-height: 48px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Rating Box</h1>

        <div class="card">
            <div class="card-header">
                Rating Box
                <a style="float:right; padding:6px 12px; color:white; background-color:blue; border-radius:5px;" href="Homepage.php">Home</a>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-sm-4 text-center">
                        <h1 class="text-warning mt-4 mb-4">
                            <b><span id="average_rating">0.0</span> / 5</b>
                        </h1>

                        <div class="mb-3">
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                        </div>

                        <h3><span id="total_review">0</span> Review</h3>
                    </div>

                    <div class="col-sm-4">
                        <p>
                        <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" id="five_star_progress"></div>
                        </div>
                        </p>

                        <p>
                        <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" id="four_star_progress"></div>
                        </div>
                        </p>

                        <p>
                        <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" id="three_star_progress"></div>
                        </div>
                        </p>

                        <p>
                        <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" id="two_star_progress"></div>
                        </div>
                        </p>

                        <p>
                        <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" id="one_star_progress"></div>
                        </div>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-5" id="review_content"></div>
    </div>

    <script>
        $(document).ready(function () {

            function load_rating_data() {
                $.ajax({
                    url: "../Assets/AjaxPages/AjaxRatingA.php",
                    method: "POST",
                    data: { action: 'load_data' },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            console.error("Backend error:", data.error);
                            $('#review_content').html('<div class="alert alert-danger">Backend error: '+data.error+'</div>');
                            return;
                        }

                        // Defensive: handle zero total_review
                        var total = parseInt(data.total_review) || 0;
                        var avg = parseFloat(data.average_rating) || 0.0;
                        $('#average_rating').text(avg.toFixed(1));
                        $('#total_review').text(total);

                        // main stars
                        var count_star = 0;
                        $('.main_star').each(function () {
                            count_star++;
                            if (Math.ceil(avg) >= count_star) {
                                $(this).removeClass('star-light').addClass('text-warning');
                            } else {
                                $(this).removeClass('text-warning').addClass('star-light');
                            }
                        });

                        $('#total_five_star_review').text(data.five_star_review);
                        $('#total_four_star_review').text(data.four_star_review);
                        $('#total_three_star_review').text(data.three_star_review);
                        $('#total_two_star_review').text(data.two_star_review);
                        $('#total_one_star_review').text(data.one_star_review);

                        function pct(count) {
                            if (total === 0) return '0%';
                            return Math.round((count / total) * 100) + '%';
                        }

                        $('#five_star_progress').css('width', pct(parseInt(data.five_star_review)));
                        $('#four_star_progress').css('width', pct(parseInt(data.four_star_review)));
                        $('#three_star_progress').css('width', pct(parseInt(data.three_star_review)));
                        $('#two_star_progress').css('width', pct(parseInt(data.two_star_review)));
                        $('#one_star_progress').css('width', pct(parseInt(data.one_star_review)));

                        // Build review list
                        var html = '';
                        if (Array.isArray(data.review_data) && data.review_data.length > 0) {
                            for (var i = 0; i < data.review_data.length; i++) {
                                var r = data.review_data[i];
                                var initial = r.user_name ? r.user_name.charAt(0).toUpperCase() : '?';
                                html += '<div class="row mb-3">';
                                html += '<div class="col-sm-1"><div class="avatar-circle bg-primary text-white">' + initial + '</div></div>';
                                html += '<div class="col-sm-11">';
                                html += '<div class="card">';
                                html += '<div class="card-header"><b>' + escapeHtml(r.user_name) + '</b></div>';
                                html += '<div class="card-body">';
                                for (var s = 1; s <= 5; s++) {
                                    var cls = (r.rating >= s) ? 'text-warning' : 'star-light';
                                    html += '<i class="fas fa-star ' + cls + ' mr-1"></i>';
                                }
                                html += '<br/><div class="mt-2">' + escapeHtml(r.user_review) + '</div>';
                                html += '</div>';
                                html += '<div class="card-footer text-right">On ' + escapeHtml(r.datetime) + '</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            }
                        } else {
                            html = '<div class="alert alert-info">No reviews yet.</div>';
                        }
                        $('#review_content').html(html);
                    },
                    error: function (xhr, status, err) {
                        console.error('AJAX error', status, err);
                        console.log('Response text:', xhr.responseText);
                        $('#review_content').html('<div class="alert alert-danger">AJAX error: ' + status + '</div>');
                    }
                });
            }

            // small helper to escape HTML
            function escapeHtml(text) {
                if (!text) return '';
                return text.replace(/&/g, "&amp;")
                           .replace(/</g, "&lt;")
                           .replace(/>/g, "&gt;")
                           .replace(/"/g, "&quot;")
                           .replace(/'/g, "&#039;");
            }

            load_rating_data();
        });
    </script>
</body>

</html>

<?php
ob_flush();
include("Foot.php");
?>
