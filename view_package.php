<?php 
if (isset($_GET['id'])) {
    $packages = $conn->query("SELECT * FROM `packages` WHERE md5(id) = '{$_GET['id']}'");
    if ($packages->num_rows > 0) {
        foreach ($packages->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
    $review = $conn->query("SELECT r.*, concat(firstname, ' ', lastname) as name FROM `rate_review` r INNER JOIN users u ON r.user_id = u.id WHERE r.package_id = '{$id}' ORDER BY unix_timestamp(r.date_created) DESC");
    $review_count = $review->num_rows;
    $rate = 0;
    $feed = array();
    while ($row = $review->fetch_assoc()) {
        $rate += $row['rate'];
        if (!empty($row['review'])) {
            $row['review'] = stripslashes(html_entity_decode($row['review']));
            $feed[] = $row;
        }
    }
    if ($rate > 0 && $review_count > 0)
        $rate = number_format($rate / $review_count, 0, "");
    $files = array();
    if (is_dir(base_app . 'uploads/package_' . $id)) {
        $ofile = scandir(base_app . 'uploads/package_' . $id);
        foreach ($ofile as $img) {
            if (in_array($img, array('.', '..')))
                continue;
            $files[] = validate_image('uploads/package_' . $id . '/' . $img);
        }
    }
}
?>
<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div id="tourCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner h-100">
                        <?php foreach ($files as $k => $img): ?>
                        <div class="carousel-item h-100 <?php echo $k == 0 ? 'active' : '' ?>">
                            <img class="d-block w-100 h-100" src="<?php echo $img ?>" alt="">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="w-100">
                    <hr class="border-warning">
                    
             
                    <div class="w-100 d-flex justify-content-between">
                        <!-- Updated "Start Now" button -->
                        <a href="<?php echo isset($url) ? $url : '#'; ?>" target="_blank">
                            <button class="btn btn-flat btn-warning" type="button" id="book">Start Now</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <h3><?php echo $title ?></h3>
                <hr class="border-warning">
                <h4>Details</h4>
                <div><?php echo stripslashes(html_entity_decode($description)) ?></div>
                <hr>
                
            </div>
        </div>
    </div>
</section>

