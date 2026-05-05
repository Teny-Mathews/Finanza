<?php session_start(); ?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>Finanza Ratings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-5"></h1>
        <div class="card">
            <div class="card-header">Rating Box</div>
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
                        <p><b>5</b> <i class="fas fa-star text-warning"></i>
                            (<span id="total_five_star_review">0</span>)
                        <div class="progress">
                            <div class="progress-bar bg-warning" id="five_star_progress"></div>
                        </div>
                        </p>
                        <p><b>4</b> <i class="fas fa-star text-warning"></i>
                            (<span id="total_four_star_review">0</span>)
                        <div class="progress">
                            <div class="progress-bar bg-warning" id="four_star_progress"></div>
                        </div>
                        </p>
                        <p><b>3</b> <i class="fas fa-star text-warning"></i>
                            (<span id="total_three_star_review">0</span>)
                        <div class="progress">
                            <div class="progress-bar bg-warning" id="three_star_progress"></div>
                        </div>
                        </p>
                        <p><b>2</b> <i class="fas fa-star text-warning"></i>
                            (<span id="total_two_star_review">0</span>)
                        <div class="progress">
                            <div class="progress-bar bg-warning" id="two_star_progress"></div>
                        </div>
                        </p>
                        <p><b>1</b> <i class="fas fa-star text-warning"></i>
                            (<span id="total_one_star_review">0</span>)
                        <div class="progress">
                            <div class="progress-bar bg-warning" id="one_star_progress"></div>
                        </div>
                        </p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h3 class="mt-4 mb-3">Write Review Here</h3>
                        <button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5" id="review_content"></div>
    </div>

    <!-- Review Modal -->
    <div id="review_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Review</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center mt-2 mb-4">
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                    </h4>
                    <div class="form-group">
                        <textarea name="user_review" id="user_review" class="form-control"
                            placeholder="Type Review Here"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            color: #e9ecef;
        }
    </style>

    <script>
        $(document).ready(function () {
            var rating_data = 0;
            const CURRENT_USER_ID = <?php echo $_SESSION['uid']; ?>;

            $('#add_review').click(function () {
                $('#review_modal').modal('show');
            });

            $(document).on('mouseenter', '.submit_star', function () {
                var rating = $(this).data('rating');
                reset_background();
                for (var count = 1; count <= rating; count++) {
                    $('#submit_star_' + count).removeClass('star-light').addClass('text-warning');
                }
            });

            function reset_background() {
                for (var count = 1; count <= 5; count++) {
                    $('#submit_star_' + count).removeClass('text-warning').addClass('star-light');
                }
            }

            $(document).on('mouseleave', '.submit_star', function () {
                reset_background();
                for (var count = 1; count <= rating_data; count++) {
                    $('#submit_star_' + count).removeClass('star-light').addClass('text-warning');
                }
            });

            $(document).on('click', '.submit_star', function () {
                rating_data = $(this).data('rating');
            });

            $('#save_review').click(function () {
                var user_review = $('#user_review').val();
                if (user_review == '') {
                    alert("Please write your review.");
                    return false;
                }
                $.ajax({
                    url: "../Assets/AjaxPages/AjaxRating.php",
                    method: "POST",
                    data: { rating_data: rating_data, user_review: user_review },
                    success: function (data) {
                        $('#review_modal').modal('hide');
                        load_rating_data();
                        alert(data);
                    }
                });
            });

            // Load rating data
            load_rating_data();
            function load_rating_data() {
                $.ajax({
                    url: "../Assets/AjaxPages/AjaxRating.php",
                    method: "POST",
                    data: { action: 'load_data' },
                    success: function (data) {
                        var data = JSON.parse(data);
                        $('#average_rating').text(data.average_rating);
                        $('#total_review').text(data.total_review);

                        var count_star = 0;
                        $('.main_star').each(function () {
                            count_star++;
                            if (Math.ceil(data.average_rating) >= count_star) {
                                $(this).removeClass('star-light').addClass('text-warning');
                            }
                        });

                        $('#total_five_star_review').text(data.five_star_review);
                        $('#total_four_star_review').text(data.four_star_review);
                        $('#total_three_star_review').text(data.three_star_review);
                        $('#total_two_star_review').text(data.two_star_review);
                        $('#total_one_star_review').text(data.one_star_review);

                        $('#five_star_progress').css('width', (data.five_star_review / data.total_review) * 100 + '%');
                        $('#four_star_progress').css('width', (data.four_star_review / data.total_review) * 100 + '%');
                        $('#three_star_progress').css('width', (data.three_star_review / data.total_review) * 100 + '%');
                        $('#two_star_progress').css('width', (data.two_star_review / data.total_review) * 100 + '%');
                        $('#one_star_progress').css('width', (data.one_star_review / data.total_review) * 100 + '%');

                        if (data.review_data.length > 0) {
                            var html = '';
                            for (var count = 0; count < data.review_data.length; count++) {
                                html += '<div class="row mb-3">';
                                html += '<div class="col-sm-1"><div class="rounded-circle bg-danger text-white pt-2 pb-2"><h3 class="text-center">' + data.review_data[count].user_name.charAt(0) + '</h3></div></div>';
                                html += '<div class="col-sm-11">';
                                html += '<div class="card">';
                                html += '<div class="card-header"><b>' + data.review_data[count].user_name + '</b>';
                                // ✅ Show delete button if review belongs to logged-in user
                                if (data.review_data[count].user_id == data.current_user) {
                                    html += '<button class="btn btn-sm btn-danger float-right delete_review" data-id="' + data.review_data[count].review_id + '">Delete</button>';
                                }
                                html += '</div>';
                                html += '<div class="card-body">';
                                for (var star = 1; star <= 5; star++) {
                                    var class_name = (data.review_data[count].rating >= star) ? 'text-warning' : 'star-light';
                                    html += '<i class="fas fa-star ' + class_name + ' mr-1"></i>';
                                }
                                html += '<br/>' + data.review_data[count].user_review;
                                html += '</div>';
                                html += '<div class="card-footer text-right">On ' + data.review_data[count].datetime + '</div>';
                                html += '</div></div></div>';
                            }
                            $('#review_content').html(html);
                        }
                    }
                })
            }

            // Delete review
            $(document).on('click', '.delete_review', function () {
                var rating_id = $(this).data('id');
                if (confirm("Are you sure you want to delete this review?")) {
                    $.ajax({
                        url: "../Assets/AjaxPages/AjaxRating.php",
                        method: "POST",
                        data: { action: 'delete_review', rating_id: rating_id },
                        success: function (data) {
                            alert(data);
                            load_rating_data();
                        }
                    })
                }
            });
        });
    </script>
</body>

</html>