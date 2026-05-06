<?php
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'):
    ?>
<div class="card form-card">
    <div class="card-header">
        <h3 class="card-title">Upload Music</h3>
    </div>
    <div class="card-body">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input id="title" type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input id="author" type="text" name="author" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="file">Choose Music File:</label>
                <input type="file" name="file" class="form-control-file" accept="audio/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</div>
<?php
endif;
?>
